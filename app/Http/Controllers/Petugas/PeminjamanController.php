<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\LogAktifitas;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['peminjam', 'petugas'])
            ->latest()
            ->paginate(10);

        return view('petugas.peminjamans.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['peminjam', 'petugas', 'details.alat']);
        return view('petugas.peminjamans.show', compact('peminjaman'));
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
                    throw new \Exception("Stok alat '{$detail->alat->nama_alat}' tidak mencukupi.");
                }
                $detail->alat->decrement('stok_tersedia', $detail->jumlah);
            }

            $peminjaman->update([
                'status' => 'aktif',
                'petugas_id' => auth()->id(),
            ]);

            DB::commit();
            LogAktifitas::record('Persetujuan Peminjaman', "Petugas menyetujui peminjaman: {$peminjaman->kode_peminjaman}");

            return redirect()->route('petugas.peminjamans.index')->with('success', "Peminjaman {$peminjaman->kode_peminjaman} telah disetujui.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
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

        LogAktifitas::record('Penolakan Peminjaman', "Petugas menolak peminjaman: {$peminjaman->kode_peminjaman}");
        return redirect()->route('petugas.peminjamans.index')->with('success', "Peminjaman {$peminjaman->kode_peminjaman} telah ditolak.");
    }
}
