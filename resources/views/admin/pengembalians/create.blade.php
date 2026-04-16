<x-admin-layout>
    <x-slot name="pageTitle">Proses Pengembalian</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Pengembalian / Baru</x-slot>

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Form Pengembalian</div>
                    <div class="card-subtitle">Selesaikan transaksi peminjaman dan kembalikan stok alat</div>
                </div>
                <a href="{{ route('admin.pengembalians.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Batal</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengembalians.store') }}" method="POST">
                    @csrf
                    
                    {{-- Loan Selection --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Pilih Peminjaman Aktif</label>
                        <select name="peminjaman_id" id="loanSelect" required onchange="this.form.action='{{ route('admin.pengembalians.create') }}'; this.form.method='GET'; this.form.submit();"
                            style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                            <option value="">-- Pilih Kode Peminjaman --</option>
                            @foreach($activeLoans as $loan)
                                <option value="{{ $loan->id }}" {{ ($peminjaman && $peminjaman->id == $loan->id) ? 'selected' : '' }}>
                                    {{ $loan->kode_peminjaman }} - {{ $loan->peminjam->name }} ({{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('peminjaman_id') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    @if($peminjaman)
                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                            <h4 style="font-size: 0.85rem; font-weight: 700; color: #0369a1; margin-bottom: 12px; border-bottom: 1px solid #bae6fd; padding-bottom: 8px;">Detail Barang yang Harus Kembali:</h4>
                            <table style="width: 100%; font-size: 0.82rem;">
                                <thead>
                                    <tr style="text-align: left; color: #0369a1;">
                                        <th style="padding: 4px 0;">Alat</th>
                                        <th style="padding: 4px 0; text-align: center;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman->details as $detail)
                                    <tr>
                                        <td style="padding: 6px 0; font-weight: 600; color: #0f172a;">{{ $detail->alat->nama_alat }}</td>
                                        <td style="padding: 6px 0; text-align: center; color: #0369a1; font-weight: 800;">{{ $detail->jumlah }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Return Details --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tanggal Kembali Aktual</label>
                                <input type="date" name="tgl_pengembalian" value="{{ date('Y-m-d') }}" required
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kondisi Akhir Alat</label>
                                <select name="kondisi" required 
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                    <option value="baik">Semua Kondisi Baik</option>
                                    <option value="rusak">Ada yang Rusak/Hilang</option>
                                    <option value="perbaikan">Perlu Perbaikan</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Masukan catatan jika ditemukan kerusakan dsb."
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">{{ old('catatan') }}</textarea>
                        </div>

                        <div>
                            <button type="submit" style="width: 100%; background: #16a34a; color: #fff; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'"
                                onclick="this.form.action='{{ route('admin.pengembalians.store') }}'; this.form.method='POST';">
                                Konfirmasi Pengembalian Selesai
                            </button>
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px; background: #f8fafc; border-radius: 12px; border: 2px dashed #e2e8f0;">
                            <p style="color: #94a3b8; font-size: 0.85rem;">Silakan pilih kode peminjaman di atas untuk melanjutkan proses.</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
