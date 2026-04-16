<x-admin-layout>
    <x-slot name="pageTitle">Data Peminjaman</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Peminjaman</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Peminjaman</div>
                <div class="card-subtitle">Pantau status peminjaman alat oleh pengguna</div>
            </div>
            <a href="{{ route('admin.peminjamans.create') }}" class="card-action">+ Buat Peminjaman</a>
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
                        <th>Kode / Tgl</th>
                        <th>Peminjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pj)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($peminjamans->currentPage() - 1) * $peminjamans->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 700; color: #2563eb;">{{ $pj->kode_peminjaman }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a;">{{ optional($pj->peminjam)->name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Oleh: {{ optional($pj->petugas)->name }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; color: #475569;">
                                {{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}
                            </div>
                            @if($pj->status == 'aktif' && \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->isPast())
                                <span style="font-size: 0.65rem; color: #be123c; font-weight: 700;">(Terlambat)</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = match($pj->status) {
                                    'aktif'      => 'badge-info',
                                    'selesai'    => 'badge-success',
                                    'terlambat'  => 'badge-danger',
                                    default      => 'badge-warning',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($pj->status) }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.peminjamans.show', $pj) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #eff6ff; color: #2563eb;" title="Detail">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if($pj->status != 'aktif')
                                <form action="{{ route('admin.peminjamans.destroy', $pj) }}" method="POST" onsubmit="return confirm('Hapus data peminjaman?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #fff1f2; color: #be123c;" title="Hapus">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $peminjamans->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
