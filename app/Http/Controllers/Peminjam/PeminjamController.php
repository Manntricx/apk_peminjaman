<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\LogAktifitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamController extends Controller
{
    // =====================================================
    // DASHBOARD
    // =====================================================
    public function dashboard()
    {
        $alatTersedia = Alat::where('stok_tersedia', '>', 0)->where('kondisi', 'baik')->count();
        $pinjamanAktif = Peminjaman::where('peminjam_id', Auth::id())->where('status', 'aktif')->count();
        $pinjamanPending = Peminjaman::where('peminjam_id', Auth::id())->where('status', 'pending')->count();
        $totalKembali = Pengembalian::whereHas('peminjaman', fn($q) => $q->where('peminjam_id', Auth::id()))->count();
        $riwayatTerbaru = Peminjaman::with(['details.alat'])->where('peminjam_id', Auth::id())->latest()->take(5)->get();

        return view('peminjam.dashboard', compact(
            'alatTersedia', 'pinjamanAktif', 'pinjamanPending', 'totalKembali', 'riwayatTerbaru'
        ));
    }

    // =====================================================
    // DAFTAR ALAT
    // =====================================================
    public function alats(Request $request)
    {
        $search = $request->get('search');
        $alats = Alat::with('kategori')
            ->where('stok_tersedia', '>', 0)
            ->where('kondisi', 'baik')
            ->when($search, fn($q) => $q->where('nama_alat', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12);

        return view('peminjam.alats', compact('alats', 'search'));
    }

    // =====================================================
    // PEMINJAMAN
    // =====================================================
    public function peminjamansIndex()
    {
        $peminjamans = Peminjaman::with(['details.alat'])
            ->where('peminjam_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjam.peminjamans.index', compact('peminjamans'));
    }

    public function peminjamansCreate()
    {
        $alats = Alat::with('kategori')->where('stok_tersedia', '>', 0)->where('kondisi', 'baik')->get();
        $today = date('Ymd');
        $count = Peminjaman::whereDate('created_at', today())->count() + 1;
        $kode = 'PJ-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('peminjam.peminjamans.create', compact('alats', 'kode'));
    }

    public function peminjamansStore(Request $request)
    {
        $request->validate([
            'kode_peminjaman'    => 'required|unique:peminjaman,kode_peminjaman',
            'tgl_pinjam'         => 'required|date',
            'tgl_kembali_rencana'=> 'required|date|after_or_equal:tgl_pinjam',
            'alat_id'            => 'required|array|min:1',
            'alat_id.*'          => 'exists:alat,id',
            'jumlah'             => 'required|array|min:1',
            'jumlah.*'           => 'integer|min:1',
            'keterangan'         => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::create([
                'kode_peminjaman'    => $request->kode_peminjaman,
                'peminjam_id'        => Auth::id(),
                'petugas_id'         => null,
                'tgl_pinjam'         => $request->tgl_pinjam,
                'tgl_kembali_rencana'=> $request->tgl_kembali_rencana,
                'status'             => 'pending',
                'keterangan'         => $request->keterangan,
            ]);

            foreach ($request->alat_id as $index => $alatId) {
                $jumlah = $request->jumlah[$index] ?? 1;
                $alat = Alat::findOrFail($alatId);

                if ($alat->stok_tersedia < $jumlah) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }

                $peminjaman->details()->create([
                    'alat_id'      => $alatId,
                    'jumlah'       => $jumlah,
                    'kondisi_awal' => 'baik', // Alat dalam kondisi baik saat dipinjam
                ]);
            }

            DB::commit();

            LogAktifitas::record('Permohonan Pinjam', "Mengajukan peminjaman baru: {$peminjaman->kode_peminjaman}");

            return redirect()->route('peminjam.peminjamans.index')
                ->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan petugas.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage())->withInput();
        }
    }

    // =====================================================
    // PENGEMBALIAN
    // =====================================================
    public function pengembalianIndex()
    {
        $pengembalians = Pengembalian::with(['peminjaman.details.alat'])
            ->whereHas('peminjaman', fn($q) => $q->where('peminjam_id', Auth::id()))
            ->latest()
            ->paginate(10);

        $pinjamanAktif = Peminjaman::with(['details.alat'])
            ->where('peminjam_id', Auth::id())
            ->where('status', 'aktif')
            ->get();

        return view('peminjam.pengembalians.index', compact('pengembalians', 'pinjamanAktif'));
    }

    public function pengembalianStore(Request $request)
    {
        $request->validate([
            'peminjaman_id'   => 'required|exists:peminjaman,id',
            'tgl_pengembalian'=> 'required|date',
            'kondisi'         => 'required|in:baik,rusak,perbaikan',
            'catatan'         => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::with('details.alat')
                ->where('peminjam_id', Auth::id())
                ->where('status', 'aktif')
                ->findOrFail($request->peminjaman_id);

            // Hitung Denda
            $tgl_kembali_rencana = Carbon::parse($peminjaman->tgl_kembali_rencana)->startOfDay();
            $tgl_pengembalian = Carbon::parse($request->tgl_pengembalian)->startOfDay();
            $denda = 0;
            $hari_terlambat = 0;
            $tarif_denda = 5000; // Rp 5.000 per hari

            if ($tgl_pengembalian->gt($tgl_kembali_rencana)) {
                $hari_terlambat = $tgl_pengembalian->diffInDays($tgl_kembali_rencana);
                $denda = $hari_terlambat * $tarif_denda;
            }

            Pengembalian::create([
                'peminjaman_id'   => $peminjaman->id,
                'petugas_id'      => null, // Dikembalikan mandiri oleh peminjam
                'tgl_pengembalian'=> $request->tgl_pengembalian,
                'kondisi'         => $request->kondisi,
                'catatan'         => $request->catatan,
                'denda'           => $denda,
                'hari_terlambat'  => $hari_terlambat,
            ]);

            $peminjaman->update([
                'status'            => 'selesai',
                'tgl_kembali_aktual'=> $request->tgl_pengembalian,
            ]);

            foreach ($peminjaman->details as $detail) {
                $detail->alat->increment('stok_tersedia', $detail->jumlah);
            }

            DB::commit();

            LogAktifitas::record('Pengembalian Alat', "Mengembalikan alat untuk transaksi: {$peminjaman->kode_peminjaman} (Kondisi: {$request->kondisi})");

            return redirect()->route('peminjam.pengembalians.index')
                ->with('success', 'Alat berhasil dikembalikan. Terima kasih!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mencatat pengembalian: ' . $e->getMessage());
        }
    }
}
