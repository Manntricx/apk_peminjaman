<x-peminjam-layout>
    <x-slot name="pageTitle">Riwayat Peminjaman</x-slot>

    <style>
        .page-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:16px; }
        .page-top h1 { font-size: 1.4rem; font-weight: 800; color: #e8eeff; letter-spacing: -0.5px; }
        .page-top p  { font-size: 0.82rem; color: #4e6080; margin-top: 3px; }
        .ref-mono  { font-family: 'Courier New', monospace; font-weight: 700; color: #60a5fa; font-size: 0.82rem; }
        .ref-time  { font-size: 0.68rem; color: #3d5270; margin-top: 2px; }
        .item-txt  { font-weight: 600; font-size: 0.855rem; color: #e8eeff; }
        .item-qty  { color: #4e6080; }
        .item-more { font-size: 0.72rem; color: #3d5270; font-style: italic; margin-top: 2px; }
        .late-tag  { display:inline-flex; align-items:center; gap:4px; font-size:0.68rem; color:#f87171; font-weight:700; margin-top:4px; }
        .late-tag svg { width:11px; height:11px; }
        .wait-label { font-size:0.75rem; color:#4e6080; font-style:italic; }
        .dash-label { color:#3d5270; }
        .pagi-wrap  { padding: 16px 22px; border-top: 1px solid rgba(59,130,246,0.08); }

        .empty-box { text-align:center; padding:60px 24px; }
        .empty-icon { width:64px; height:64px; border-radius:18px;
            background:rgba(59,130,246,0.07); border:1px solid rgba(59,130,246,0.12);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 16px; color:#3d5270; }
        .empty-icon svg { width:28px; height:28px; }
        .empty-box h3 { font-size:1rem; font-weight:700; color:#e8eeff; margin-bottom:6px; }
        .empty-box p  { font-size:0.85rem; color:#4e6080; margin-bottom:20px; }
    </style>

    {{-- Header --}}
    <div class="page-top">
        <div>
            <h1>Riwayat Peminjaman Saya</h1>
            <p>Kelola dan pantau status seluruh pengajuan peminjaman alat Anda.</p>
        </div>
        <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Ajukan Baru
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card">
        <div class="card-body" style="padding:0;">
            @if($peminjamans->isEmpty())
                <div class="empty-box">
                    <div class="empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3>Belum Ada Peminjaman</h3>
                    <p>Anda belum pernah mengajukan peminjaman alat apapun.</p>
                    <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary btn-sm">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Mulai Pinjam Alat
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Referensi</th>
                                <th>Item &amp; Kuantitas</th>
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
                                    <div class="ref-mono">{{ $pj->kode_peminjaman }}</div>
                                    <div class="ref-time">{{ $pj->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td>
                                    @foreach($pj->details->take(2) as $d)
                                        <div><span class="item-txt">{{ $d->alat->nama_alat }}</span> <span class="item-qty">× {{ $d->jumlah }}</span></div>
                                    @endforeach
                                    @if($pj->details->count() > 2)
                                        <div class="item-more">+{{ $pj->details->count() - 2 }} item lainnya</div>
                                    @endif
                                </td>
                                <td style="color:#7a9cc4; font-size:0.82rem;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d M Y') }}</td>
                                <td>
                                    <div style="color:#7a9cc4; font-size:0.82rem;">{{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}</div>
                                    @if($pj->status === 'aktif' && \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->isPast())
                                        <div class="late-tag">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Terlambat!
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $pj->status }}">
                                        @if($pj->status=='pending') <svg style="width:10px;height:10px;margin-right:3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @elseif($pj->status=='aktif') <svg style="width:10px;height:10px;margin-right:3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @elseif($pj->status=='selesai') <svg style="width:10px;height:10px;margin-right:3px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                        {{ ucfirst($pj->status) }}
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    @if($pj->status === 'aktif')
                                        <a href="{{ route('peminjam.pengembalians.index') }}" class="btn btn-sm" style="background:rgba(16,185,129,0.12); color:#34d399; border:1px solid rgba(16,185,129,0.25);">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Kembalikan
                                        </a>
                                    @elseif($pj->status === 'pending')
                                        <span class="wait-label">Menunggu verifikasi…</span>
                                    @else
                                        <span class="dash-label">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($peminjamans->total() > $peminjamans->perPage())
                    <div class="pagi-wrap">{{ $peminjamans->links() }}</div>
                @endif
            @endif
        </div>
    </div>

</x-peminjam-layout>
