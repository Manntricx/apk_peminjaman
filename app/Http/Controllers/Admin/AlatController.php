<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alats.index', compact('alats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.alats.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'kondisi' => 'required|string|in:baik,rusak,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['stok_tersedia'] = $request->stok_total;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alats', 'public');
        }

        Alat::create($data);

        return redirect()->route('admin.alats.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        $categories = Category::all();
        return view('admin.alats.edit', compact('alat', 'categories'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'kondisi' => 'required|string|in:baik,rusak,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        // Logic check for available stock if total stock decreases?
        // For simplicity, we just update it.
        $diff = $request->stok_total - $alat->stok_total;
        $data['stok_tersedia'] = $alat->stok_tersedia + $diff;

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $data['foto'] = $request->file('foto')->store('alats', 'public');
        }

        $alat->update($data);

        return redirect()->route('admin.alats.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        // Check if item has loan history
        if ($alat->peminjamanDetails()->exists()) {
            return back()->with('error', 'Gagal menghapus! Alat ini memiliki riwayat peminjaman. Anda bisa mengubah kondisi alat menjadi rusak atau tidak tersedia sebagai gantinya.');
        }
        
        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();
        return redirect()->route('admin.alats.index')->with('success', 'Alat berhasil dihapus.');
    }
}
