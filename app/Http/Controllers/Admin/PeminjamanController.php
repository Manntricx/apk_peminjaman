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
        $peminjamans = Peminjaman::with(['peminjam', 'petugas'])->latest()->paginate(10);
        return view('admin.peminjamans.index', compact('peminjamans'));
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
        $request->validate([
            'kode_peminjaman' => 'required|unique:peminjaman,kode_peminjaman',
            'peminjam_id' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'exists:alat,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $request->kode_peminjaman,
                'peminjam_id' => $request->peminjam_id,
                'petugas_id' => auth()->id(),
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
                'status' => 'aktif',
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
            return back()->with('error', 'Peminjaman aktif tidak dapat dihapus. Silakan lakukan pengembalian terlebih dahulu.');
        }

        $peminjaman->delete();
        return redirect()->route('admin.peminjamans.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
