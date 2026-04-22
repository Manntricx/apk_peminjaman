<x-admin-layout>
    <x-slot name="pageTitle">Daftar Peminjaman (Petugas)</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Transaksi / Peminjaman</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Peminjaman</div>
                <div class="card-subtitle">Pantau status peminjaman alat oleh pengguna</div>
            </div>
            {{-- Tombol Tambah hanya untuk Admin di versi terpisah ini --}}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background:rgba(22,163,74,0.1);color:#4ade80;border:1px solid rgba(22,163,74,0.25);padding:11px 16px;border-radius:10px;margin-bottom:20px;font-size:0.84rem;font-weight:500;display:flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.2);padding:11px 16px;border-radius:10px;margin-bottom:20px;font-size:0.84rem;font-weight:500;">
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
                            <div style="font-weight: 700; color: #60a5fa;">{{ $pj->kode_peminjaman }}</div>
                            <div style="font-size: 0.75rem; color: #8ca0c4;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #f1f5f9;">{{ optional($pj->peminjam)->name }}</div>
                            <div style="font-size: 0.75rem; color: #8ca0c4;">Oleh: {{ optional($pj->petugas)->name }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; color: #e8eeff;">
                                {{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}
                            </div>
                            @if($pj->status == 'aktif' && \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->startOfDay()->isPast())
                                @php
                                    $tglRencana = \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->startOfDay();
                                    $tglSkrg = now()->startOfDay();
                                    $hariTerlambat = $tglSkrg->diffInDays($tglRencana);
                                    if ($tglSkrg->gt($tglRencana) && $hariTerlambat == 0) $hariTerlambat = 1;
                                @endphp
                                <div style="font-size: 0.65rem; color: #f87171; font-weight: 700;">
                                    (Terlambat {{ $hariTerlambat }} Hari)
                                </div>
                                <div style="font-size: 0.65rem; color: #fca5a5; font-weight: 600;">Est. Denda: Rp {{ number_format($hariTerlambat * 5000, 0, ',', '.') }}</div>
                            @elseif($pj->status == 'selesai' && $pj->pengembalian && $pj->pengembalian->denda > 0)
                                <div style="font-size: 0.65rem; color: #f87171; font-weight: 700;">Denda: Rp {{ number_format($pj->pengembalian->denda, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = match($pj->status) {
                                    'aktif'      => 'badge-info',
                                    'selesai'    => 'badge-success',
                                    'ditolak'    => 'badge-danger',
                                    'terlambat'  => 'badge-danger',
                                    default      => 'badge-warning',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($pj->status) }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                @if($pj->status == 'pending')
                                <form action="{{ route('petugas.peminjamans.approve', $pj) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(16,185,129,0.1); color: #34d399; border: none; cursor: pointer;" title="Setujui">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('petugas.peminjamans.reject', $pj) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(239,68,68,0.1); color: #f87171; border: none; cursor: pointer;" title="Tolak">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('petugas.peminjamans.show', $pj) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(59,130,246,0.1); color: #60a5fa;" title="Detail">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
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
