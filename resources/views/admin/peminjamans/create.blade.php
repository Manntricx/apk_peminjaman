<x-admin-layout>
    <x-slot name="pageTitle">Buat Peminjaman</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Peminjaman / Baru</x-slot>

    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Form Peminjaman Baru</div>
                    <div class="card-subtitle">Input detail peminjaman alat untuk pengguna</div>
                </div>
                <a href="{{ route(Auth::user()->role . '.peminjamans.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.peminjamans.store') }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px dashed #e2e8f0;">
                        {{-- Kode --}}
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kode Peminjaman</label>
                            <input type="text" name="kode_peminjaman" value="{{ $kode }}" readonly 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; background: #f8fafc; color: #64748b; font-weight: 700;">
                        </div>

                        {{-- Peminjam --}}
                        @if(Auth::user()->role !== 'peminjam')
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Pilih Peminjam (User)</label>
                            <select name="peminjam_id" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                <option value="" disabled selected>Pilih Anggota/User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('peminjam_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Peminjam</label>
                            <div style="padding: 10px 14px; background: #f1f5f9; border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: #475569;">
                                {{ Auth::user()->name }} (Saya)
                            </div>
                            <input type="hidden" name="peminjam_id" value="{{ Auth::id() }}">
                        </div>
                        @endif
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        {{-- Tgl Pinjam --}}
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                        </div>

                        {{-- Tgl Kembali Rencana --}}
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Batas Kembali (Rencana)</label>
                            <input type="date" name="tgl_kembali_rencana" required
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                        </div>
                    </div>

                    {{-- Item Section --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3"/></svg>
                            Pilih Alat yang Dipinjam
                        </label>
                        
                        <div id="alat-container">
                            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                <div>
                                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Alat</label>
                                    <select name="alat_id[]" required 
                                        style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.8rem; outline: none; background: #fff;">
                                        <option value="" disabled selected>Cari Alat...</option>
                                        @foreach($alats as $alat)
                                            <option value="{{ $alat->id }}">[{{ $alat->kategori->nama_kategori }}] {{ $alat->nama_alat }} (Tersedia: {{ $alat->stok_tersedia }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Jumlah</label>
                                    <input type="number" name="jumlah[]" value="1" min="1" required 
                                        style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.8rem; outline: none;">
                                </div>
                            </div>
                        </div>
                        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 8px;">* Pastikan stok tersedia mencukupi jumlah yang dipinjam.</p>
                    </div>

                    {{-- Keterangan --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tujuan / Keterangan Pinjam</label>
                        <textarea name="keterangan" rows="3" placeholder="Contoh: Digunakan untuk presentasi di Aula Utama."
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; resize: vertical;">{{ old('keterangan') }}</textarea>
                    </div>

                    <div>
                        <button type="submit" style="width: 100%; background: #2563eb; color: #fff; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            Konfirmasi & Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
