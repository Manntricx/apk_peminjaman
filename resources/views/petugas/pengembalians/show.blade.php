<x-admin-layout>
    <x-slot name="pageTitle">Detail Pengembalian</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Transaksi / Pengembalian / Detail</x-slot>

    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Informasi Pengembalian</div>
                    <div class="card-subtitle">Kode Transaksi: {{ $pengembalian->peminjaman->kode_peminjaman }}</div>
                </div>
                <a href="{{ route('petugas.pengembalians.index') }}" class="card-action" style="background: rgba(255,255,255,0.08); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1);">Kembali</a>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                    {{-- Detail Peminjaman --}}
                    <div>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #60a5fa; margin-bottom: 15px; border-bottom: 1px solid rgba(59,130,246,0.2); padding-bottom: 10px;">Data Peminjam</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Nama Peminjam</label>
                                <span style="font-size: 0.9rem; color: #f1f5f9; font-weight: 600;">{{ $pengembalian->peminjaman->peminjam->name }}</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Email</label>
                                <span style="font-size: 0.9rem; color: #8ca0c4;">{{ $pengembalian->peminjaman->peminjam->email }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pengembalian --}}
                    <div>
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #34d399; margin-bottom: 15px; border-bottom: 1px solid rgba(16,185,129,0.2); padding-bottom: 10px;">Status Kembali</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Tanggal Dikembalikan</label>
                                <span style="font-size: 0.9rem; color: #10b981; font-weight: 700;">{{ \Carbon\Carbon::parse($pengembalian->tgl_pengembalian)->format('d F Y') }}</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Diterima Oleh Petugas</label>
                                <span style="font-size: 0.9rem; color: #f1f5f9;">{{ $pengembalian->petugas ? $pengembalian->petugas->name : 'Mandiri (Peminjam)' }}</span>
                            </div>
                            <div style="margin-top: 5px; padding-top: 10px; border-top: 1px dashed rgba(255,255,255,0.1);">
                                <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Denda Keterlambatan</label>
                                @if($pengembalian->denda > 0)
                                    <span style="font-size: 1.1rem; color: #f87171; font-weight: 800;">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</span>
                                    <div style="font-size: 0.7rem; color: #94a3b8;">Terlambat {{ $pengembalian->hari_terlambat }} hari</div>
                                @else
                                    <span style="font-size: 0.9rem; color: #34d399; font-weight: 600;">Tidak Ada Denda</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 0.9rem; font-weight: 700; color: #f1f5f9; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">Kondisi & Catatan</h3>
                    <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
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
                            <p style="font-size: 0.9rem; color: #8ca0c4; line-height: 1.6; margin: 0;">
                                {{ $pengembalian->catatan ?: 'Tidak ada catatan tambahan.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 style="font-size: 0.9rem; font-weight: 700; color: #f1f5f9; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">Item yang Dikembalikan</h3>
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
                                <td style="font-weight: 600; color: #f1f5f9;">{{ $detail->alat->nama_alat }}</td>
                                <td style="color: #94a3b8;">{{ $detail->alat->kategori->nama_kategori }}</td>
                                <td style="text-align: center; font-weight: 700; color: #60a5fa;">{{ $detail->jumlah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
