<x-admin-layout>
    <x-slot name="pageTitle">Daftar Alat</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Inventaris Alat</div>
                <div class="card-subtitle">Kelola stok, kondisi, dan informasi alat peminjaman</div>
            </div>
            <a href="{{ route('admin.alats.create') }}" class="card-action">+ Tambah Alat</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background: #dcfce7; color: #15803d; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Foto</th>
                        <th>Nama Alat / Kategori</th>
                        <th>Stok (Tersedia/Total)</th>
                        <th>Kondisi</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $alat)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($alats->currentPage() - 1) * $alats->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @else
                                <div style="width: 48px; height: 48px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a;">{{ $alat->nama_alat }}</div>
                            <div style="font-size: 0.75rem; color: #3b82f6; font-weight: 500;">{{ optional($alat->kategori)->nama_kategori ?? 'Tanpa Kategori' }}</div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-weight: 700; color: #0f172a;">{{ $alat->stok_tersedia }}</span>
                                <span style="color: #94a3b8; font-size: 0.8rem;">/ {{ $alat->stok_total }}</span>
                                @if($alat->stok_tersedia == 0)
                                    <span class="badge badge-danger" style="font-size: 0.6rem; padding: 1px 6px;">Kosong</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $kondisiClass = match($alat->kondisi) {
                                    'baik'      => 'badge-success',
                                    'rusak'     => 'badge-danger',
                                    'perbaikan' => 'badge-warning',
                                    default     => 'badge-info',
                                };
                            @endphp
                            <span class="badge {{ $kondisiClass }}">{{ ucfirst($alat->kondisi) }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.alats.edit', $alat) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #eff6ff; color: #2563eb;" title="Edit">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.alats.destroy', $alat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
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
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data alat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $alats->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
