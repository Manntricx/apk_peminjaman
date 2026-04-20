<x-peminjam-layout>
    <x-slot name="pageTitle">Beranda</x-slot>

    <style>
        /* ── Hero Section ─────────────────────── */
        .hero-section {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #0d1a38 0%, #0f1f45 50%, #091526 100%);
            border: 1px solid rgba(59,130,246,0.18);
            border-radius: 20px;
            padding: 36px 40px;
            margin-bottom: 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
        }
        .hero-section::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 360px; height: 360px; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%);
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute; bottom: -60px; left: -40px;
            width: 240px; height: 240px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.08), transparent 70%);
            pointer-events: none;
        }
        .hero-left { position: relative; z-index: 1; }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(59,130,246,0.12);
            border: 1px solid rgba(59,130,246,0.25);
            border-radius: 99px; padding: 5px 12px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;
            color: #60a5fa; margin-bottom: 16px;
        }
        .hero-tag svg { width: 13px; height: 13px; }
        .hero-title {
            font-size: 2rem; font-weight: 800; letter-spacing: -0.8px;
            color: #e8eeff; margin-bottom: 12px; line-height: 1.2;
        }
        .hero-title span { color: #60a5fa; }
        .hero-desc {
            font-size: 0.9rem; color: #7a9cc4; line-height: 1.7;
            max-width: 520px;
        }
        .hero-actions {
            position: relative; z-index: 1; flex-shrink: 0;
            display: flex; flex-direction: column; align-items: flex-end; gap: 10px;
        }
        .hero-btns { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }
        .hero-graphic {
            display: none; color: rgba(59,130,246,0.15);
        }
        @media (min-width: 900px) { .hero-graphic { display: block; } }
        @media (max-width: 640px) {
            .hero-section { flex-direction: column; padding: 28px 24px; align-items: flex-start; }
            .hero-title { font-size: 1.5rem; }
            .hero-actions { align-items: flex-start; }
            .hero-btns { justify-content: flex-start; }
        }

        /* ── Stats Strip ──────────────────────── */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px; margin-bottom: 24px;
        }
        .strip-card {
            background: #111e35;
            border: 1px solid rgba(59,130,246,0.1);
            border-radius: 14px; padding: 18px 16px;
            display: flex; align-items: center; gap: 14px;
            transition: all 0.25s; position: relative; overflow: hidden;
        }
        .strip-card::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(59,130,246,0.04), transparent 60%);
            pointer-events: none;
        }
        .strip-card:hover { transform: translateY(-3px); border-color: rgba(59,130,246,0.25); box-shadow: 0 10px 28px rgba(0,0,0,0.3); }
        .strip-icon {
            width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .strip-icon svg { width: 20px; height: 20px; }
        .strip-icon.blue   { background: rgba(59,130,246,0.15); color: #60a5fa; box-shadow: 0 4px 12px rgba(59,130,246,0.15); }
        .strip-icon.orange { background: rgba(245,158,11,0.15); color: #fbbf24; box-shadow: 0 4px 12px rgba(245,158,11,0.15); }
        .strip-icon.cyan   { background: rgba(6,182,212,0.15);  color: #22d3ee; box-shadow: 0 4px 12px rgba(6,182,212,0.15); }
        .strip-icon.green  { background: rgba(16,185,129,0.15); color: #34d399; box-shadow: 0 4px 12px rgba(16,185,129,0.15); }
        .strip-val  { font-size: 1.5rem; font-weight: 800; color: #e8eeff; line-height: 1; }
        .strip-lbl  { font-size: 0.68rem; font-weight: 700; color: #4e6080; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 3px; }

        @media (max-width: 900px) { .stats-strip { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .stats-strip { grid-template-columns: 1fr; } }

        /* ── Table Overrides for this page ─────── */
        .ref-code { font-family: 'Courier New', monospace; font-weight: 700; color: #60a5fa; font-size: 0.8rem; }
        .item-name { font-weight: 600; color: #e8eeff; font-size: 0.855rem; }
        .item-qty  { color: #4e6080; font-size: 0.8rem; }
        .more-items { font-size: 0.72rem; color: #3d5270; font-style: italic; margin-top: 2px; }
        .empty-icon-box {
            width: 64px; height: 64px; border-radius: 18px; margin: 0 auto 18px;
            background: rgba(59,130,246,0.07); border: 1px solid rgba(59,130,246,0.12);
            display: flex; align-items: center; justify-content: center; color: #3d5270;
        }
        .empty-icon-box svg { width: 28px; height: 28px; }
    </style>

    {{-- ═══ HERO ══════════════════════════════════════ --}}
    <div class="hero-section">
        <div class="hero-left">
            <div class="hero-tag">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"/></svg>
                Sistem Peminjaman Solang
            </div>
            <h1 class="hero-title">Halo, <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>! 👋</h1>
            <p class="hero-desc">
                Selamat datang di portal peminjaman alat. Cari alat yang tersedia,
                ajukan pinjaman baru, dan pantau status peminjaman Anda secara real-time.
            </p>
        </div>
        <div class="hero-actions">
            <div class="hero-btns">
                <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Pinjam Alat
                </a>
                <a href="{{ route('peminjam.alats') }}" class="btn btn-outline">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Lihat Katalog
                </a>
            </div>
            <div class="hero-graphic">
                <svg width="100" height="100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ═══ STATS STRIP ══════════════════════════════ --}}
    <div class="stats-strip">
        <div class="strip-card">
            <div class="strip-icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <div class="strip-val">{{ $alatTersedia }}</div>
                <div class="strip-lbl">Alat Tersedia</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="strip-val">{{ $pinjamanPending }}</div>
                <div class="strip-lbl">Menunggu Persetujuan</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon cyan">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <div class="strip-val">{{ $pinjamanAktif }}</div>
                <div class="strip-lbl">Sedang Dipinjam</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="strip-val">{{ $totalKembali }}</div>
                <div class="strip-lbl">Telah Dikembalikan</div>
            </div>
        </div>
    </div>

    {{-- ═══ RECENT ACTIVITY ══════════════════════════ --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Aktivitas Peminjaman Terkini</h2>
                <p class="card-subtitle">Pantau status 5 pengajuan terakhir Anda</p>
            </div>
            <a href="{{ route('peminjam.peminjamans.index') }}" class="card-action">Lihat Semua →</a>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($riwayatTerbaru->isEmpty())
                <div style="text-align: center; padding: 52px 24px;">
                    <div class="empty-icon-box">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 700; color: #e8eeff; margin-bottom: 6px;">Belum Ada Riwayat</h3>
                    <p style="color: #4e6080; font-size: 0.85rem; margin-bottom: 20px;">Mulai ajukan peminjaman alat pertama Anda.</p>
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
                                <th>Ref ID</th>
                                <th>Alat &amp; Kuantitas</th>
                                <th>Tgl Pengajuan</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatTerbaru as $pj)
                            <tr>
                                <td><span class="ref-code">{{ $pj->kode_peminjaman }}</span></td>
                                <td>
                                    @foreach($pj->details->take(2) as $d)
                                        <div>
                                            <span class="item-name">{{ $d->alat->nama_alat }}</span>
                                            <span class="item-qty"> × {{ $d->jumlah }}</span>
                                        </div>
                                    @endforeach
                                    @if($pj->details->count() > 2)
                                        <div class="more-items">+{{ $pj->details->count() - 2 }} item lainnya</div>
                                    @endif
                                </td>
                                <td style="color: #7a9cc4; font-size: 0.82rem;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d M Y') }}</td>
                                <td style="color: #7a9cc4; font-size: 0.82rem;">{{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $pj->status }}">
                                        @if($pj->status == 'pending')
                                            <svg style="width:10px;height:10px;margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @elseif($pj->status == 'aktif')
                                            <svg style="width:10px;height:10px;margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @elseif($pj->status == 'selesai')
                                            <svg style="width:10px;height:10px;margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                        {{ ucfirst($pj->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-peminjam-layout>
