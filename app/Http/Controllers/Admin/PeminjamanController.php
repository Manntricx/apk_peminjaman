<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktifitas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $query = Peminjaman::with(['peminjam', 'petugas']);
        
        if (auth()->user()->role === 'peminjam') {
            $query->where('peminjam_id', auth()->id());
        }

        $peminjamans = $query->latest()->paginate(10);

        // Data for Create Modal
        $users = User::where('role', 'peminjam')->get();
        $alats = Alat::where('stok_tersedia', '>', 0)->where('kondisi', 'baik')->get();
        
        $today = date('Ymd');
        $count = Peminjaman::whereDate('created_at', today())->count() + 1;
        $kode = 'PJ-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('admin.peminjamans.index', compact('peminjamans', 'users', 'alats', 'kode'));
    }

    public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $alats = Alat::where('stok_tersedia', '>', 0)->where('kondisi', 'baik')->get();
        
        // Generate Auto Code
        $today = date('Ymd');
        $count = Peminjaman::whereDate('created_at', today())->count() + 1;
        $kode = 'PJ-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('admin.peminjamans.create', compact('users', 'alats', 'kode'));
    }

    public function store(Request $request)
    {
        $validationRules = [
            'kode_peminjaman' => 'required|unique:peminjaman,kode_peminjaman',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'exists:alat,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
            'keterangan' => 'nullable|string',
        ];

        if (auth()->user()->role !== 'peminjam') {
            $validationRules['peminjam_id'] = 'required|exists:users,id';
        }

        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            $status = (auth()->user()->role === 'peminjam') ? 'pending' : 'aktif';
            $peminjamId = (auth()->user()->role === 'peminjam') ? auth()->id() : $request->peminjam_id;

            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $request->kode_peminjaman,
                'peminjam_id' => $peminjamId,
                'petugas_id' => (auth()->user()->role === 'peminjam') ? null : auth()->id(),
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
                'status' => $status,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->alat_id as $key => $alat_id) {
                $alat = Alat::findOrFail($alat_id);
                $jumlah = $request->jumlah[$key];

                if ($alat->stok_tersedia < $jumlah) {
                    throw new \Exception("Stok alat {$alat->nama_alat} tidak mencukupi.");
                }

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alat_id,
                    'jumlah' => $jumlah,
                    'kondisi_awal' => $alat->kondisi,
                ]);

                // Decrease stock
                $alat->decrement('stok_tersedia', $jumlah);
            }

            DB::commit();

            LogAktifitas::record('Transaksi Peminjaman', "Mencatat peminjaman baru: {$peminjaman->kode_peminjaman}");

            return redirect()->route('admin.peminjamans.index')->with('success', 'Peminjaman berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mencatat peminjaman: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['peminjam', 'petugas', 'details.alat']);
        return view('admin.peminjamans.show', compact('peminjaman'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status == 'aktif') {
            return back()->with('error', 'Peminjaman aktif tidak dapat dihapus. Silakan lakukan pengembalian terlebih dahulu agar stok kembali normal.');
        }

        try {
            DB::beginTransaction();

            // Hapus detail peminjaman & pengembalian terkait (Foreign Key)
            $peminjaman->details()->delete();
            $peminjaman->pengembalian()->delete();

            $peminjaman->delete();

            DB::commit();
            return redirect()->route('admin.peminjamans.index')->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman dengan status pending yang bisa disetujui.');
        }

        try {
            DB::beginTransaction();

            $peminjaman->load('details.alat');

            foreach ($peminjaman->details as $detail) {
                if ($detail->alat->stok_tersedia < $detail->jumlah) {
                    throw new \Exception("Stok alat '{$detail->alat->nama_alat}' tidak mencukupi untuk peminjaman ini.");
                }

                // Potong stok
                $detail->alat->decrement('stok_tersedia', $detail->jumlah);
            }

            $peminjaman->update([
                'status' => 'aktif',
                'petugas_id' => auth()->id(),
            ]);

            DB::commit();

            LogAktifitas::record('Persetujuan Peminjaman', "Menyetujui peminjaman: {$peminjaman->kode_peminjaman}");

            return redirect()->route(auth()->user()->role . '.peminjamans.index')->with('success', "Peminjaman {$peminjaman->kode_peminjaman} telah disetujui.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyetujui peminjaman: ' . $e->getMessage());
        }
    }

    public function reject(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman dengan status pending yang bisa ditolak.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'petugas_id' => auth()->id(),
        ]);

        LogAktifitas::record('Penolakan Peminjaman', "Menolak peminjaman: {$peminjaman->kode_peminjaman}");

        return redirect()->route(auth()->user()->role . '.peminjamans.index')->with('success', "Peminjaman {$peminjaman->kode_peminjaman} telah ditolak.");
    }
}
