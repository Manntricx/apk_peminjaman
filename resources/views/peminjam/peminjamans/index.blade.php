<x-peminjam-layout>
    <x-slot name="pageTitle">Riwayat Peminjaman</x-slot>

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
        <div class="page-header" style="margin-bottom:0;">
            <h1>Riwayat Peminjaman Saya</h1>
            <p>Kelola dan pantau status seluruh pengajuan peminjaman alat Anda.</p>
        </div>
        <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan Peminjaman Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="card">
        <div class="card-body" style="padding: 0;">
            @if($peminjamans->isEmpty())
                <div style="text-align: center; padding: 64px 24px;">
                    <div class="icon-circle" style="margin: 0 auto 20px; background: #f1f5f9; color: #94a3b8;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;">Belum Ada Peminjaman</h3>
                    <p style="color: #64748b; margin-bottom: 24px;">Anda belum pernah mengajukan peminjaman alat apapun.</p>
                    <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary btn-sm">Mulai Pinjam Alat</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Referensi</th>
                                <th>Item & Kuantitas</th>
                                <th>Tgl Pinjam</th>
                                <th>Tenggat Kembali</th>
                                <th>Status</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $pj)
                            <tr>
                                <td>
                                    <div style="font-family: monospace; font-weight: 700; color: var(--primary); font-size: 0.875rem;">#{{ $pj->kode_peminjaman }}</div>
                                    <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 2px;">{{ $pj->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td>
                                    @foreach($pj->details->take(2) as $d)
                                        <div style="font-weight: 600; font-size: 0.875rem; color: #334155;">{{ $d->alat->nama_alat }} <span style="font-weight: 400; color: #94a3b8;">(x{{ $d->jumlah }})</span></div>
                                    @endforeach
                                    @if($pj->details->count() > 2)
                                        <div style="font-size: 0.75rem; color: #94a3b8; font-style: italic; margin-top: 2px;">+{{ $pj->details->count() - 2 }} item lainnya</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d M Y') }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}</div>
                                    @if($pj->status === 'aktif' && \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->isPast())
                                        <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.6875rem; color: var(--danger); font-weight: 700; margin-top: 4px;">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Terlambat
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $pj->status }}">
                                        @if($pj->status == 'pending')
                                            <svg style="width: 12px; height: 12px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @elseif($pj->status == 'aktif')
                                            <svg style="width: 12px; height: 12px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @endif
                                        {{ ucfirst($pj->status) }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    @if($pj->status === 'aktif')
                                        <a href="{{ route('peminjam.pengembalians.index') }}" class="btn btn-primary btn-sm" style="background: #10b981; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);">Kembalikan</a>
                                    @elseif($pj->status === 'pending')
                                        <span style="font-size: 0.75rem; font-weight: 600; color: #94a3b8; font-style: italic;">Verifikasi Petugas</span>
                                    @else
                                        <span style="font-size: 0.875rem; color: #cbd5e1;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($peminjamans->total() > $peminjamans->perPage())
            <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9;">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>
</x-peminjam-layout>
