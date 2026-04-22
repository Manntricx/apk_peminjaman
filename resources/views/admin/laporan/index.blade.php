<x-admin-layout>
    <x-slot name="pageTitle">Laporan Peminjaman</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Laporan</x-slot>

    <style>
        @media print {
            .navbar, .sidebar, .filter-card, .btn-print-group {
                display: none !important;
            }
            .main-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #333;
                padding-bottom: 20px;
            }
        }
        .print-header { display: none; }
        
        .report-stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 24px;
        }
        .report-stat-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .report-stat-label { font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
        .report-stat-value { font-size: 1.5rem; font-weight: 800; color: #0f172a; }
    </style>

    <div class="print-header">
        <h1 style="font-size: 24px;">LAPORAN PEMINJAMAN ALAT - SOLANG</h1>
        <p style="font-size: 14px;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p style="font-size: 12px; margin-top: 5px;">Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ Auth::user()->name }}</p>
    </div>

    {{-- FILTER CARD --}}
    <div class="card filter-card">
        <div class="card-header">
            <div class="card-title">Filter Laporan</div>
            <button onclick="window.print()" class="card-action" style="background: #0f172a; color: white;">
                <svg style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('petugas.laporan.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; align-items: flex-end;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control" style="padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; width: 100%;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control" style="padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; width: 100%;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Status</label>
                    <select name="status" class="form-control" style="padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; width: 100%; background: white;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="card-action" style="flex: 1; padding: 12px; text-align: center; border: none; cursor: pointer;">Terapkan Filter</button>
                    <a href="{{ route('petugas.laporan.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b; padding: 12px;">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="report-stats">
        <div class="report-stat-item">
            <div class="report-stat-label">Total Transaksi</div>
            <div class="report-stat-value">{{ $totalPinjaman }}</div>
        </div>
        <div class="report-stat-item" style="border-left: 4px solid #3b82f6;">
            <div class="report-stat-label">Sedang Dipinjam</div>
            <div class="report-stat-value">{{ $totalAktif }}</div>
        </div>
        <div class="report-stat-item" style="border-left: 4px solid #10b981;">
            <div class="report-stat-label">Telah Kembali</div>
            <div class="report-stat-value">{{ $totalSelesai }}</div>
        </div>
        <div class="report-stat-item" style="border-left: 4px solid #f59e0b;">
            <div class="report-stat-label">Menunggu Persetujuan</div>
            <div class="report-stat-value">{{ $totalPending }}</div>
        </div>
        <div class="report-stat-item" style="border-left: 4px solid #ef4444;">
            <div class="report-stat-label">Total Denda</div>
            <div class="report-stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- REPORT TABLE --}}
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding: 12px 20px;">No</th>
                        <th>Kode</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th style="padding-right: 20px;">Alat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pj)
                    <tr>
                        <td style="padding: 15px 20px; color: #94a3b8;">{{ $loop->iteration }}</td>
                        <td style="font-weight: 700;">{{ $pj->kode_peminjaman }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $pj->peminjam->name }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $pj->peminjam->email }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d/m/Y') }}</td>
                        <td>
                            @if($pj->pengembalian && $pj->pengembalian->denda > 0)
                                <div style="color: #ef4444; font-weight: 700;">Rp {{ number_format($pj->pengembalian->denda, 0, ',', '.') }}</div>
                                <div style="font-size: 0.65rem; color: #94a3b8;">{{ $pj->pengembalian->hari_terlambat }} Hari</div>
                            @elseif($pj->status == 'selesai')
                                <div style="color: #10b981; font-size: 0.8rem;">-</div>
                            @else
                                <div style="color: #94a3b8; font-size: 0.8rem;">N/A</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = match($pj->status) {
                                    'aktif'      => 'badge-info',
                                    'selesai'    => 'badge-success',
                                    'ditolak'    => 'badge-danger',
                                    default      => 'badge-warning',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($pj->status) }}</span>
                        </td>
                        <td style="padding-right: 20px;">
                            @foreach($pj->details as $d)
                                <div style="font-size: 0.75rem;">• {{ $d->alat->nama_alat }} ({{ $d->jumlah }})</div>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">Tidak ada data peminjaman untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right; display: none; @media print { display: block; }">
        <div style="display: inline-block; text-align: center; width: 200px; border-top: 1px solid #334155; padding-top: 10px; margin-top: 50px;">
            <p style="font-size: 12px; font-weight: 700;">Petugas Lapangan</p>
            <br><br><br>
            <p style="font-size: 12px;">( {{ Auth::user()->name }} )</p>
        </div>
    </div>

</x-admin-layout>
