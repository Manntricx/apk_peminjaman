<x-admin-layout>
    <x-slot name="pageTitle">Log Aktifitas Sistem</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Sistem / Log</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Audit Trail</div>
                <div class="card-subtitle">Semua aktifitas yang terjadi di dalam sistem terdokumentasi di sini</div>
            </div>
            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA catatan log?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #fff; border: 1.5px solid #fecdd3; color: #be123c; font-size: 0.75rem; font-weight: 700; padding: 8px 16px; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                    onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='#fff'">
                    Bersihkan Semua Log
                </button>
            </form>
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
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                        <th style="text-align: right;">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 600; color: #334155;">{{ optional($log->user)->name ?? 'Sistem' }}</div>
                        </td>
                        <td>
                            @php
                                $badgeClass = match(true) {
                                    str_contains($log->aksi, 'Tambah') => 'badge-success',
                                    str_contains($log->aksi, 'Hapus') => 'badge-danger',
                                    str_contains($log->aksi, 'Update') => 'badge-warning',
                                    str_contains($log->aksi, 'Permohonan') => 'badge-warning',
                                    str_contains($log->aksi, 'Pengembalian') => 'badge-success',
                                    str_contains($log->aksi, 'Persetujuan') => 'badge-info',
                                    str_contains($log->aksi, 'Penolakan') => 'badge-danger',
                                    str_contains($log->aksi, 'Transaksi') => 'badge-info',
                                    default => 'badge-info'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}" style="font-size: 0.65rem;">{{ $log->aksi }}</span>
                        </td>
                        <td style="color: #64748b; font-size: 0.82rem;">{{ $log->keterangan }}</td>
                        <td style="text-align: right; color: #94a3b8; font-size: 0.78rem; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($log->waktu)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px; color: #94a3b8;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <svg style="width: 48px; height: 48px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Belum ada catatan log aktifitas.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
