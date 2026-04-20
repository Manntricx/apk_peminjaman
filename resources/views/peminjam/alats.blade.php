<x-peminjam-layout>
    <x-slot name="pageTitle">Katalog Alat</x-slot>

    <style>
        .page-top {
            display: flex; align-items: flex-end; justify-content: space-between;
            flex-wrap: wrap; gap: 20px; margin-bottom: 28px;
        }
        .page-top h1 { font-size: 1.5rem; font-weight: 800; color: #e8eeff; letter-spacing: -0.5px; }
        .page-top p  { font-size: 0.85rem; color: #4e6080; margin-top: 4px; }

        .search-wrap { position: relative; width: 100%; max-width: 380px; }
        .search-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 17px; height: 17px; color: #3d5270; pointer-events: none; }
        .search-input {
            width: 100%; padding: 11px 44px; border-radius: 99px;
            background: rgba(59,130,246,0.06) !important;
            border: 1px solid rgba(59,130,246,0.15) !important;
            color: #e8eeff !important; font-size: 0.875rem; font-family: inherit;
        }
        .search-input:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); outline: none; }
        .search-input::placeholder { color: #3d5270 !important; }
        .search-reset {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            font-size: 0.68rem; font-weight: 700; color: #4e6080; text-decoration: none;
            letter-spacing: 0.5px;
        }
        .search-reset:hover { color: #60a5fa; }

        .alat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 18px;
        }
        .alat-card {
            background: #111e35;
            border: 1px solid rgba(59,130,246,0.1);
            border-radius: 16px; overflow: hidden;
            display: flex; flex-direction: column;
            transition: all 0.25s;
        }
        .alat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(59,130,246,0.28);
            box-shadow: 0 16px 40px rgba(0,0,0,0.35);
        }
        .alat-img {
            height: 175px;
            background: #0d1526;
            border-bottom: 1px solid rgba(59,130,246,0.08);
            position: relative;
            display: flex; align-items: center; justify-content: center;
        }
        .alat-img img { width: 100%; height: 100%; object-fit: contain; padding: 14px; }
        .alat-img-placeholder { color: rgba(59,130,246,0.15); }
        .alat-img-placeholder svg { width: 52px; height: 52px; }
        .alat-cat-badge {
            position: absolute; top: 10px; left: 10px;
            background: rgba(9,15,31,0.80); backdrop-filter: blur(6px);
            border: 1px solid rgba(59,130,246,0.2);
            color: #60a5fa; padding: 3px 10px; border-radius: 6px;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .alat-body {
            padding: 18px; flex: 1; display: flex; flex-direction: column; gap: 8px;
        }
        .alat-name { font-size: 1rem; font-weight: 800; color: #e8eeff; }
        .alat-desc { font-size: 0.82rem; color: #4e6080; line-height: 1.6; flex: 1; }
        .alat-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 14px; border-top: 1px solid rgba(59,130,246,0.08);
        }
        .alat-stock {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.8rem; font-weight: 700;
        }
        .alat-stock.ok  { color: #34d399; }
        .alat-stock.low { color: #fbbf24; }
        .alat-stock.nil { color: #f87171; }
        .alat-stock svg { width: 15px; height: 15px; }

        .empty-box {
            text-align: center; padding: 70px 24px;
            background: #111e35; border: 1px solid rgba(59,130,246,0.1);
            border-radius: 16px;
        }
        .empty-icon { width: 70px; height: 70px; border-radius: 20px;
            background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.12);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px; color: #3d5270; }
        .empty-icon svg { width: 32px; height: 32px; }
        .empty-box h3 { font-size: 1.05rem; font-weight: 700; color: #e8eeff; margin-bottom: 6px; }
        .empty-box p  { font-size: 0.85rem; color: #4e6080; margin-bottom: 20px; }

        .pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }
    </style>

    {{-- Page Header --}}
    <div class="page-top">
        <div>
            <h1>Katalog Alat Tersedia</h1>
            <p>Daftar seluruh peralatan yang siap untuk dipinjam saat ini.</p>
        </div>
        <form method="GET" action="{{ route('peminjam.alats') }}" class="search-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama alat..." class="search-input">
            @if($search)
                <a href="{{ route('peminjam.alats') }}" class="search-reset">Reset</a>
            @endif
        </form>
    </div>

    @if($alats->isEmpty())
        <div class="empty-box">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3>Alat Tidak Ditemukan</h3>
            <p>{{ $search ? 'Tidak ada alat yang cocok dengan kata kunci "' . $search . '".' : 'Belum ada alat yang tersedia untuk saat ini.' }}</p>
            @if($search)
                <a href="{{ route('peminjam.alats') }}" class="btn btn-outline btn-sm">Tampilkan Semua Alat</a>
            @endif
        </div>
    @else
        <div class="alat-grid">
            @foreach($alats as $alat)
            <div class="alat-card">
                {{-- Image --}}
                <div class="alat-img">
                    @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
                    @else
                        <div class="alat-img-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    @endif
                    <div class="alat-cat-badge">{{ optional($alat->kategori)->nama_kategori ?? 'Lainnya' }}</div>
                </div>

                {{-- Body --}}
                <div class="alat-body">
                    <div class="alat-name">{{ $alat->nama_alat }}</div>
                    <div class="alat-desc">{{ $alat->deskripsi ? Str::limit($alat->deskripsi, 80) : 'Alat operasional berkualitas, siap digunakan.' }}</div>
                    <div class="alat-footer">
                        @if($alat->stok_tersedia > 3)
                            <div class="alat-stock ok">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                {{ $alat->stok_tersedia }} tersedia
                            </div>
                        @elseif($alat->stok_tersedia > 0)
                            <div class="alat-stock low">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Sisa {{ $alat->stok_tersedia }}
                            </div>
                        @else
                            <div class="alat-stock nil">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tidak tersedia
                            </div>
                        @endif

                        @if($alat->stok_tersedia > 0)
                            <a href="{{ route('peminjam.peminjamans.create') }}?alat_id={{ $alat->id }}" class="btn btn-primary btn-xs">
                                Pinjam
                            </a>
                        @else
                            <span class="btn btn-xs" style="background:rgba(239,68,68,0.08);color:#f87171;border:1px solid rgba(239,68,68,0.15);cursor:not-allowed;">
                                Penuh
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $alats->appends(['search' => $search])->links() }}
        </div>
    @endif

</x-peminjam-layout>
