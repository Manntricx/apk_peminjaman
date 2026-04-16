<x-admin-layout>
    <x-slot name="pageTitle">Kategori Alat</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat / Kategori</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Kategori</div>
                <div class="card-subtitle">Pengelompokan alat berdasarkan jenis atau fungsinya</div>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="card-action">+ Tambah Kategori</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background: #dcfce7; color: #15803d; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fee2e2; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500;">
                    {{ session('error') }}
                </div>
            @endif

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Alat</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;"></div>
                                {{ $category->nama_kategori }}
                            </div>
                        </td>
                        <td style="max-width: 400px; color: #475569; font-size: 0.825rem;">
                            {{ $category->deskripsi ?: '-' }}
                        </td>
                        <td>
                            <span style="background: #f1f5f9; padding: 2px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 600; color: #475569;">
                                {{ $category->alats()->count() }} Alat
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #eff6ff; color: #2563eb;" title="Edit">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #fff1f2; color: #be123c;" title="Hapus">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
