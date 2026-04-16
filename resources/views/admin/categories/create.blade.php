<x-admin-layout>
    <x-slot name="pageTitle">Tambah Kategori</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat / Kategori / Tambah</x-slot>

    <div style="max-width: 600px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Form Kategori Baru</div>
                    <div class="card-subtitle">Masukkan nama kategori alat yang ingin ditambahkan</div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required placeholder="Contoh: Elektronik, Olahraga, dsb."
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                        @error('nama_kategori') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" rows="4" placeholder="Keterangan singkat mengenai kategori ini..."
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; transition: border-color 0.2s; resize: vertical;"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <button type="submit" style="width: 100%; background: #2563eb; color: #fff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
