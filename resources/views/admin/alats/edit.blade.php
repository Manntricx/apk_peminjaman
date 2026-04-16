<x-admin-layout>
    <x-slot name="pageTitle">Edit Alat</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat / Edit</x-slot>

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Edit Alat: {{ $alat->nama_alat }}</div>
                    <div class="card-subtitle">Perbarui informasi, stok, atau kondisi alat</div>
                </div>
                <a href="{{ route('admin.alats.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.alats.update', $alat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Nama Alat --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Alat</label>
                            <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('nama_alat') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kategori</label>
                            <select name="kategori_id" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id', $alat->kategori_id) == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Stok --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Jumlah Stok (Total)</label>
                            <input type="number" name="stok_total" value="{{ old('stok_total', $alat->stok_total) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 4px;">Tersedia saat ini: {{ $alat->stok_tersedia }}</p>
                            @error('stok_total') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kondisi --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kondisi Alat</label>
                            <select name="kondisi" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                <option value="baik" {{ old('kondisi', $alat->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ old('kondisi', $alat->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ old('kondisi', $alat->kondisi) == 'perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                            </select>
                            @error('kondisi') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Deskripsi Alat (Opsional)</label>
                        <textarea name="deskripsi" rows="3" 
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; resize: vertical;">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                    </div>

                    {{-- Foto --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Foto Alat</label>
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            @if($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}" alt="Pratinjau" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @endif
                            <div style="flex: 1;">
                                <input type="file" name="foto" accept="image/*"
                                    style="width: 100%; padding: 8px; border-radius: 8px; border: 1px dashed #cbd5e1; font-size: 0.85rem; background: #f8fafc;">
                                <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 6px;">Biarkan kosong jika tidak ingin mengubah foto. Format JPG, PNG, Max 2MB.</p>
                            </div>
                        </div>
                        @error('foto') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <button type="submit" style="width: 100%; background: #2563eb; color: #fff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
