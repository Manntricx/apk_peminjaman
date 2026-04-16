<x-admin-layout>
    <x-slot name="pageTitle">Riwayat Pengembalian</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Pengembalian</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Pengembalian</div>
                <div class="card-subtitle">Riwayat alat yang sudah dikembalikan oleh peminjam</div>
            </div>
            <a href="{{ route('admin.pengembalians.create') }}" class="card-action" style="background: #16a34a; color: #fff;">+ Proses Pengembalian</a>
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
                        <th>Kode Peminjaman</th>
                        <th>Peminjam</th>
                        <th>Tgl Kembali</th>
                        <th>Kondisi Akhir</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pg)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($pengembalians->currentPage() - 1) * $pengembalians->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 700; color: #475569;">{{ $pg->peminjaman->kode_peminjaman }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a;">{{ $pg->peminjaman->peminjam->name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Diterima: {{ $pg->petugas->name }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; color: #16a34a; font-weight: 600;">
                                {{ \Carbon\Carbon::parse($pg->tgl_pengembalian)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            @php
                                $kondisiClass = match($pg->kondisi) {
                                    'baik'      => 'badge-success',
                                    'rusak'     => 'badge-danger',
                                    'perbaikan' => 'badge-warning',
                                    default     => 'badge-info',
                                };
                            @endphp
                            <span class="badge {{ $kondisiClass }}">{{ ucfirst($pg->kondisi) }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.pengembalians.show', $pg) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #f1f5f9; color: #475569;" title="Lihat Detail">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada riwayat pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $pengembalians->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
