<x-admin-layout>
    <x-slot name="pageTitle">Detail Peminjaman</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Transaksi / Peminjaman / Detail</x-slot>

    <div style="max-width: 900px; margin: 0 auto;">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('petugas.peminjamans.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            {{-- Left: Details Table --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Alat yang Dipinjam</div>
                </div>
                <div class="card-body">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th>Kondisi Awal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman->details as $detail)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #f1f5f9;">{{ $detail->alat->nama_alat }}</div>
                                    <div style="font-size: 0.72rem; color: #94a3b8;">{{ $detail->alat->kategori->nama_kategori }}</div>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 700; color: #60a5fa; background: rgba(59,130,246,0.12); padding: 4px 12px; border-radius: 99px; border: 1px solid rgba(59,130,246,0.2);">{{ $detail->jumlah }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ ucfirst($detail->kondisi_awal) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right: Info --}}
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="card">
                    <div style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.02);">
                        <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">Nomor Transaksi</div>
                        <div style="font-size: 1.2rem; font-weight: 800; color: #60a5fa; margin-top: 4px;">{{ $peminjaman->kode_peminjaman }}</div>
                    </div>
                    <div style="padding: 20px;">
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px;">Peminjam:</div>
                            <div style="font-weight: 700; color: #f1f5f9;">{{ $peminjaman->peminjam->name }}</div>
                            <div style="font-size: 0.75rem; color: #8ca0c4;">{{ $peminjaman->peminjam->email }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px;">Tanggal Pinjam:</div>
                            <div style="font-weight: 600; color: #e8eeff;">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px;">Batas Kembali:</div>
                            <div style="font-weight: 600; color: #f87171;">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d M Y') }}</div>
                        </div>
                        <div style="margin-bottom: 0;">
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px;">Status:</div>
                            <span class="badge {{ $peminjaman->status == 'aktif' ? 'badge-info' : ($peminjaman->status == 'selesai' ? 'badge-success' : 'badge-warning') }}" style="font-size: 0.8rem; padding: 6px 14px;">
                                {{ strtoupper($peminjaman->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card" style="background: rgba(59,130,246,0.05); border-color: rgba(59,130,246,0.15);">
                    <div style="padding: 20px;">
                        <div style="font-size: 0.7rem; color: #60a5fa; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Keterangan</div>
                        <p style="font-size: 0.82rem; color: #8ca0c4; line-height: 1.6;">
                            {{ $peminjaman->keterangan ?: 'Tidak ada keterangan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
