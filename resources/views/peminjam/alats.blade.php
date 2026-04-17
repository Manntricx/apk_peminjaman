<x-peminjam-layout>
    <x-slot name="pageTitle">Katalog Alat</x-slot>

    <div class="page-header" style="display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 24px;">
        <div>
            <h1>Katalog Alat Tersedia</h1>
            <p>Daftar seluruh peralatan yang siap untuk dipinjam saat ini.</p>
        </div>
        {{-- SEARCH --}}
        <form method="GET" action="{{ route('peminjam.alats') }}" style="width: 100%; max-width: 400px;">
            <div style="position: relative;">
                <svg style="position:absolute; left:16px; top:50%; transform:translateY(-50%); width:18px; height:18px; color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama alat..." class="form-control" style="padding-left: 48px; border-radius: 99px;">
                @if($search)
                    <a href="{{ route('peminjam.alats') }}" style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size: 0.75rem; font-weight: 700; text-decoration: none;">RESET</a>
                @endif
            </div>
        </form>
    </div>

    @if($alats->isEmpty())
        <div class="card" style="text-align: center; padding: 64px 24px;">
            <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #cbd5e1;">
                <svg style="width: 40px; height: 40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3"/></svg>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;">Alat Tidak Ditemukan</h3>
            <p style="color: #64748b;">{{ $search ? 'Maaf, tidak ada alat yang cocok dengan kata kunci "' . $search . '".' : 'Belum ada alat yang tersedia untuk saat ini.' }}</p>
            @if($search)
                <div style="margin-top: 24px;">
                    <a href="{{ route('peminjam.alats') }}" class="btn btn-outline btn-sm">Tampilkan Semua Alat</a>
                </div>
            @endif
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px;">
            @foreach($alats as $alat)
            <div class="card" style="height: 100%; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; cursor: default;">
                <div style="height: 180px; background: white; position: relative; border-bottom: 1px solid #f1f5f9;">
                    @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" style="width: 100%; height: 100%; object-fit: contain; background: white; padding: 12px;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                            <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    @endif
                    <div style="position: absolute; top: 12px; left: 12px;">
                        <span style="background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(4px); color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                            {{ $alat->kategori->nama_kategori }}
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.125rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">{{ $alat->nama_alat }}</h3>
                    <p style="font-size: 0.875rem; color: #64748b; line-height: 1.5; margin-bottom: 20px; flex: 1;">
                        {{ $alat->deskripsi ? Str::limit($alat->deskripsi, 80) : 'Alat bantu operasional berkualitas siap pakai.' }}
                    </p>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 6px; color: #10b981; font-weight: 700; font-size: 0.875rem;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $alat->stok_tersedia }} tersedia
                        </div>
                        <a href="{{ route('peminjam.peminjamans.create') }}?alat_id={{ $alat->id }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">
                            Pinjam
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $alats->links() }}
        </div>
    @endif
</x-peminjam-layout>
