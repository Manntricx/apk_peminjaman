<x-admin-layout>
    <x-slot name="pageTitle">Dashboard {{ ucfirst(Auth::user()->role) }}</x-slot>
    <x-slot name="pageBreadcrumb">SiPinjam / Main / Dashboard</x-slot>

    {{-- ===== KPI STATS ===== --}}
    <div class="stats-grid">
        @if(Auth::user()->role === 'admin')
            <!-- Total User -->
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\User::count() }}</div>
                    <div class="stat-label">Total User</div>
                    <div class="stat-trend neutral">Aktif dalam sistem</div>
                </div>
            </div>
            <!-- Total Alat -->
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Alat::count() }}</div>
                    <div class="stat-label">Total Alat</div>
                    <div class="stat-trend neutral">Inventaris master</div>
                </div>
            </div>
            <!-- Total Kategori -->
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Category::count() }}</div>
                    <div class="stat-label">Kategori</div>
                    <div class="stat-trend neutral">Master alat</div>
                </div>
            </div>
            <!-- Logs Count -->
            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\LogAktifitas::count() }}</div>
                    <div class="stat-label">Total Log</div>
                    <div class="stat-trend neutral">Audit trail</div>
                </div>
            </div>
        @else
            <!-- Petugas View -->
            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Peminjaman::where('status', 'aktif')->count() }}</div>
                    <div class="stat-label">Pinjam Aktif</div>
                    <div class="stat-trend orange">Memerlukan pantauan</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Peminjaman::where('status', 'aktif')->where('tgl_kembali_rencana', '<', date('Y-m-d'))->count() }}</div>
                    <div class="stat-label">Terlambat</div>
                    <div class="stat-trend red">Perlu ditindak</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Pengembalian::count() }}</div>
                    <div class="stat-label">Total Selesai</div>
                    <div class="stat-trend up">Sudah kembali</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ \App\Models\Alat::where('stok_tersedia', '>', 0)->count() }}</div>
                    <div class="stat-label">Alat Siap Pinjam</div>
                    <div class="stat-trend blue">Ready in stock</div>
                </div>
            </div>
        @endif
    </div>

    {{-- ===== CONTENT GRID ===== --}}
    <div class="content-grid">

        {{-- Peminjaman Terbaru --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Peminjaman Terbaru</div>
                    <div class="card-subtitle">Transaksi terakhir di sistem</div>
                </div>
                @if(Auth::user()->role === 'petugas')
                    <a href="{{ route('admin.peminjamans.index') }}" class="card-action">Lihat Semua →</a>
                @endif
            </div>
            <div class="card-body">
                @php $pinjaman = \App\Models\Peminjaman::with('peminjam')->latest()->take(5)->get(); @endphp
                @if($pinjaman->isEmpty())
                    <div style="text-align:center; padding: 40px 0; color: #94a3b8;">
                        <svg style="width:40px;height:40px;margin:0 auto 10px;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p style="font-size:0.85rem;">Belum ada data peminjaman</p>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Peminjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjaman as $item)
                            <tr>
                                <td style="font-weight:600; color:#1d4ed8;">{{ $item->kode_peminjaman }}</td>
                                <td>{{ optional($item->peminjam)->name }}</td>
                                <td>
                                    @php
                                        $statusClass = match($item->status) {
                                            'aktif'      => 'badge-info',
                                            'selesai'    => 'badge-success',
                                            'terlambat'  => 'badge-danger',
                                            default      => 'badge-warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Aksi Cepat</div>
                </div>
                <div class="card-body">
                    <div class="quick-grid">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.users.create') }}" class="quick-btn blue">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                <span class="quick-btn-label">User Baru</span>
                            </a>
                            <a href="{{ route('admin.alats.create') }}" class="quick-btn green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span class="quick-btn-label">Alat Baru</span>
                            </a>
                            <a href="{{ route('admin.peminjamans.create') }}" class="quick-btn orange">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span class="quick-btn-label">Peminjaman</span>
                            </a>
                            <a href="{{ route('admin.pengembalians.create') }}" class="quick-btn teal">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span class="quick-btn-label">Pengembalian</span>
                            </a>
                            <a href="{{ route('admin.logs.index') }}" class="quick-btn red">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="quick-btn-label">Log</span>
                            </a>
                        @else
                            <a href="{{ route('admin.peminjamans.create') }}" class="quick-btn orange">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span class="quick-btn-label">Persetujuan</span>
                            </a>
                            <a href="{{ route('admin.pengembalians.create') }}" class="quick-btn teal">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span class="quick-btn-label">Pengembalian</span>
                            </a>
                            <a href="#" class="quick-btn blue">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                <span class="quick-btn-label">Cetak Laporan</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Log Aktifitas / Last Actions --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informasi Sistem</div>
                </div>
                <div class="card-body">
                    <div style="font-size:0.8rem; color:#475569; line-height:1.6;">
                        Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>.<br>
                        Gunakan menu di sidebar untuk mengelola sistem sesuai hak akses Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
