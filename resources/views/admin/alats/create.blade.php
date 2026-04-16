<x-admin-layout>
    <x-slot name="pageTitle">Tambah Alat</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat / Tambah</x-slot>

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Tambah Alat Baru</div>
                    <div class="card-subtitle">Daftarkan alat inventaris baru ke dalam sistem</div>
                </div>
                <a href="{{ route('admin.alats.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.alats.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Nama Alat --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Alat</label>
                            <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" required placeholder="Contoh: Proyektor Epson X10"
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('nama_alat') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kategori</label>
                            <select name="kategori_id" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Stok --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Jumlah Stok (Total)</label>
                            <input type="number" name="stok_total" value="{{ old('stok_total', 0) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            @error('stok_total') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kondisi --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kondisi Alat</label>
                            <select name="kondisi" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ old('kondisi') == 'perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                            </select>
                            @error('kondisi') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Deskripsi Alat (Opsional)</label>
                        <textarea name="deskripsi" rows="3" placeholder="Keterangan mengenai spesifikasi atau detail alat..."
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; resize: vertical;">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Foto --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Foto Alat</label>
                        <input type="file" name="foto" accept="image/*"
                            style="width: 100%; padding: 8px; border-radius: 8px; border: 1px dashed #cbd5e1; font-size: 0.85rem; background: #f8fafc;">
                        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 6px;">Format JPG, PNG, Max 2MB.</p>
                        @error('foto') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <button type="submit" style="width: 100%; background: #2563eb; color: #fff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            Simpan Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
