<x-peminjam-layout>
    <x-slot name="pageTitle">Beranda</x-slot>

    <style>
        .hero-card {
            background: linear-gradient(to right, #ffffff, #f1f5f9);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .hero-content {
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .hero-text { max-width: 640px; }
        .hero-decoration { display: none; flex-shrink: 0; color: var(--primary); opacity: 0.1; }
        @media (min-width: 1024px) {
            .hero-decoration { display: block; }
        }
    </style>

    {{-- WELCOME SECTION --}}
    <div class="card hero-card">
        <div class="card-body hero-content">
            <div class="hero-text">
                <div style="display: flex; align-items: center; gap: 8px; color: var(--primary); font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"/></svg> 
                    Sistem Peminjaman Solang
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 800; color: #0f172a; margin-bottom: 12px; letter-spacing: -1px;">
                    Halo, {{ Auth::user()->name }}! 
                </h1>
                <p style="color: #64748b; font-size: 1.125rem; line-height: 1.6;">
                    Selamat datang di portal peminjaman alat. Di sini Anda dapat mencari alat yang tersedia, mengajukan pinjaman baru, dan memantau status peminjaman Anda secara real-time.
                </p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 16px; align-items: flex-end;">
                <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Pinjam Alat Sekarang
                    </a>
                    <a href="{{ route('peminjam.alats') }}" class="btn btn-outline" style="background: white;">
                        Lihat Katalog Alat
                    </a>
                </div>
                <div class="hero-decoration">
                    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div class="stat-info">
                <div class="value">{{ $alatTersedia }}</div>
                <div class="label">Alat Tersedia</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="value">{{ $pinjamanPending }}</div>
                <div class="label">Menunggu Persetujuan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="stat-info">
                <div class="value">{{ $pinjamanAktif }}</div>
                <div class="label">Sedang Dipinjam</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="value">{{ $totalKembali }}</div>
                <div class="label">Telah Dikembalikan</div>
            </div>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Aktivitas Peminjaman Terkini</h2>
                <p style="font-size: 0.875rem; color: #64748b; margin-top: 4px;">Pantau status 5 pengajuan terakhir Anda.</p>
            </div>
            <a href="{{ route('peminjam.peminjamans.index') }}" class="btn btn-outline btn-sm">
                Lihat Semua Riwayat
            </a>
        </div>
        <div class="card-body">
            @if($riwayatTerbaru->isEmpty())
                <div style="text-align: center; padding: 48px 24px;">
                    <div class="icon-circle" style="background: #f1f5f9; color: #94a3b8; margin: 0 auto 16px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 8px;">Belum Ada Riwayat Peminjaman</h3>
                    <p style="color: #64748b; margin-bottom: 24px;">Anda belum melakukan peminjaman alat apapun saat ini.</p>
                    <a href="{{ route('peminjam.peminjamans.create') }}" class="btn btn-primary btn-sm">Mulai Pinjam Alat</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Ref ID</th>
                                <th>Alat & Kuantitas</th>
                                <th>Tgl Pengajuan</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatTerbaru as $pj)
                            <tr>
                                <td style="font-family: monospace; font-weight: 700; color: var(--primary);">#{{ $pj->kode_peminjaman }}</td>
                                <td>
                                    @foreach($pj->details->take(2) as $d)
                                        <div style="font-weight: 600; font-size: 0.875rem;">{{ $d->alat->nama_alat }} <span style="font-weight: 400; color: #94a3b8;">(x{{ $d->jumlah }})</span></div>
                                    @endforeach
                                    @if($pj->details->count() > 2)
                                        <div style="font-size: 0.75rem; color: #94a3b8; font-style: italic;">+{{ $pj->details->count() - 2 }} item lainnya</div>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-peminjam-layout>
