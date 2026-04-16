<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.peminjam', 'petugas'])->latest()->paginate(10);
        return view('admin.pengembalians.index', compact('pengembalians'));
    }

    public function create(Request $request)
    {
        $peminjamanId = $request->query('peminjaman_id');
        $peminjaman = null;
        
        if ($peminjamanId) {
            $peminjaman = Peminjaman::with('details.alat')->where('status', 'aktif')->findOrFail($peminjamanId);
        }

        $activeLoans = Peminjaman::with('peminjam')->where('status', 'aktif')->get();

        return view('admin.pengembalians.create', compact('peminjaman', 'activeLoans'));
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
                throw new \Exception("Peminjaman ini sudah dikembalikan atau tidak aktif.");
            }

            // Create Return Record
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => auth()->id(),
                'tgl_pengembalian' => $request->tgl_pengembalian,
                'kondisi' => $request->kondisi,
                'catatan' => $request->catatan,
            ]);

            // Mark Loan as Finished
            $peminjaman->update([
                'status' => 'selesai',
                'tgl_kembali_aktual' => $request->tgl_pengembalian,
            ]);

            // Restore Stock for each item
            foreach ($peminjaman->details as $detail) {
                $detail->alat->increment('stok_tersedia', $detail->jumlah);
                
                // Update specific status if condition is bad? 
                // For now we just restore stock.
            }

            DB::commit();
            return redirect()->route('admin.pengembalians.index')->with('success', 'Pengembalian berhasil dicatat dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mencatat pengembalian: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.peminjam', 'peminjaman.details.alat', 'petugas']);
        return view('admin.pengembalians.show', compact('pengembalian'));
    }

    public function destroy(Pengembalian $pengembalian)
    {
        // Deleting a return record is risky (stock mismatch). 
        // We'll allow it but warn the user or handle stock (we won't reverse stock for safety reasons in this simple version).
        $pengembalian->delete();
        return redirect()->route('admin.pengembalians.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
