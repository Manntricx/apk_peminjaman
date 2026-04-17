<x-admin-layout>
    <x-slot name="pageTitle">Detail Pengembalian</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Pengembalian / Detail</x-slot>

    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Informasi Pengembalian</div>
                    <div class="card-subtitle">Kode Transaksi: {{ $pengembalian->peminjaman->kode_peminjaman }}</div>
                </div>
                <a href="{{ route(Auth::user()->role . '.pengembalians.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                    {{-- Detail Peminjaman --}}
                    <div>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Data Peminjam</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Nama Peminjam</label>
                                <span style="font-size: 0.9rem; color: #334155; font-weight: 600;">{{ $pengembalian->peminjaman->peminjam->name }}</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Email</label>
                                <span style="font-size: 0.9rem; color: #334155;">{{ $pengembalian->peminjaman->peminjam->email }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pengembalian --}}
                    <div>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Status Kembali</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Tanggal Dikembalikan</label>
                                <span style="font-size: 0.9rem; color: #16a34a; font-weight: 700;">{{ \Carbon\Carbon::parse($pengembalian->tgl_pengembalian)->format('d F Y') }}</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Diterima Oleh Petugas</label>
                                <span style="font-size: 0.9rem; color: #334155;">{{ $pengembalian->petugas ? $pengembalian->petugas->name : 'Mandiri (Peminjam)' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Kondisi & Catatan</h3>
                    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 5px;">Kondisi Alat Saat Kembali</label>
                            @php
                                $kondisiClass = match($pengembalian->kondisi) {
                                    'baik'      => 'badge-success',
                                    'rusak'     => 'badge-danger',
                                    'perbaikan' => 'badge-warning',
                                    default     => 'badge-info',
                                };
                            @endphp
                            <span class="badge {{ $kondisiClass }}">{{ ucfirst($pengembalian->kondisi) }}</span>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 5px;">Catatan Tambahan</label>
                            <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin: 0;">
                                {{ $pengembalian->catatan ?: 'Tidak ada catatan tambahan.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Item yang Dikembalikan</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th style="text-align: center;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengembalian->peminjaman->details as $detail)
                            <tr>
                                <td style="font-weight: 600; color: #0f172a;">{{ $detail->alat->nama_alat }}</td>
                                <td>{{ $detail->alat->kategori->nama_kategori }}</td>
                                <td style="text-align: center; font-weight: 700; color: #2563eb;">{{ $detail->jumlah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
