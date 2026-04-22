<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\LogAktifitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $pengembalians = Pengembalian::with(['peminjaman.peminjam', 'petugas'])
            ->latest()
            ->paginate(10);

        // Data for Create Modal (active loans only)
        $activeLoans = Peminjaman::where('status', 'aktif')->with('peminjam')->get();

        $peminjamanId = $request->query('peminjaman_id');
        $peminjaman = $peminjamanId ? Peminjaman::with('details.alat')->find($peminjamanId) : null;

        return view('petugas.pengembalians.index', compact('pengembalians', 'activeLoans', 'peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_pengembalian' => 'required|date',
            'kondisi' => 'required|string|in:baik,rusak,perbaikan',
            'catatan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::with('details.alat')->findOrFail($request->peminjaman_id);
            if ($peminjaman->status !== 'aktif') {
                throw new \Exception("Peminjaman tidak aktif.");
            }

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
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => auth()->id(),
                'tgl_pengembalian' => $request->tgl_pengembalian,
                'kondisi' => $request->kondisi,
                'denda' => $denda,
                'hari_terlambat' => $hari_terlambat,
                'catatan' => $request->catatan,
            ]);

            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_aktual' => $request->tgl_pengembalian,
            ]);

            foreach ($peminjaman->details as $detail) {
                $detail->alat->increment('stok_tersedia', $detail->jumlah);
            }

            DB::commit();
            LogAktifitas::record('Transaksi Pengembalian', "Petugas mencatat pengembalian: {$peminjaman->kode_peminjaman}");

            return redirect()->route('petugas.pengembalians.index')->with('success', 'Pengembalian berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.peminjam', 'peminjaman.details.alat', 'petugas']);
        return view('petugas.pengembalians.show', compact('pengembalian'));
    }
}
