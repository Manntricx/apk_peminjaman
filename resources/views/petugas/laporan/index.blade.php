<x-admin-layout>
    <x-slot name="pageTitle">Laporan Peminjaman (Petugas)</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Laporan</x-slot>

    <style>
        @media print {
            .navbar, .sidebar, .filter-card, .btn-print-group { display: none !important; }
            .main-wrapper { margin: 0 !important; padding: 0 !important; }
            .card { border: none !important; box-shadow: none !important; background: white !important; color: black !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; color: black !important; }
            .report-stat-item { border: 1px solid #ccc !important; color: black !important; }
            .report-stat-value, .report-stat-label { color: black !important; }
            .badge { border: 1px solid #333 !important; color: black !important; background: none !important; }
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid #ccc !important; color: black !important; padding: 8px !important; }
            div[style*="color: #f1f5f9"], div[style*="color: #60a5fa"] { color: black !important; }
        }
        .print-header { display: none; }
        
        .report-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; }
        .report-stat-item {
            background: rgba(255,255,255,0.03); padding: 20px; border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.06); text-align: center; transition: all 0.3s;
        }
        .report-stat-item:hover { background: rgba(255,255,255,0.05); transform: translateY(-2px); }
        .report-stat-label { font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px; }
        .report-stat-value { font-size: 1.6rem; font-weight: 800; color: #f1f5f9; }
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
            <button onclick="window.print()" class="card-action" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; border:none; cursor:pointer; padding: 10px 18px; border-radius: 8px; font-weight: 600;">
                <svg style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak PDF / Print
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('petugas.laporan.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; align-items: flex-end;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #f1f5f9; padding: 10px; border-radius: 8px; width: 100%;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #f1f5f9; padding: 10px; border-radius: 8px; width: 100%;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">Status</label>
                    <select name="status" class="form-control" style="background: #0d1e3b; border: 1px solid rgba(255,255,255,0.1); color: #f1f5f9; padding: 10px; border-radius: 8px; width: 100%;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="card-action" style="flex: 2; padding: 12px; text-align: center; border: none; cursor: pointer; background: #3b82f6; color: white;">Filter</button>
                    <a href="{{ route('petugas.laporan.index') }}" class="card-action" style="flex: 1; background: rgba(255,255,255,0.08); color: #94a3b8; padding: 12px; text-align: center;">Reset</a>
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
        <div class="report-stat-item" style="border-bottom: 3px solid #3b82f6;">
            <div class="report-stat-label">Sedang Dipinjam</div>
            <div class="report-stat-value" style="color: #60a5fa;">{{ $totalAktif }}</div>
        </div>
        <div class="report-stat-item" style="border-bottom: 3px solid #10b981;">
            <div class="report-stat-label">Telah Kembali</div>
            <div class="report-stat-value" style="color: #34d399;">{{ $totalSelesai }}</div>
        </div>
        <div class="report-stat-item" style="border-bottom: 3px solid #f59e0b;">
            <div class="report-stat-label">Pending Approval</div>
            <div class="report-stat-value" style="color: #fbbf24;">{{ $totalPending }}</div>
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
                        <th>Status</th>
                        <th style="padding-right: 20px;">Detail Alat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pj)
                    <tr>
                        <td style="padding: 15px 20px; color: #94a3b8;">{{ $loop->iteration }}</td>
                        <td style="font-weight: 700; color: #60a5fa;">{{ $pj->kode_peminjaman }}</td>
                        <td>
                            <div style="font-weight: 600; color: #f1f5f9;">{{ $pj->peminjam->name }}</div>
                            <div style="font-size: 0.7rem; color: #8ca0c4;">{{ $pj->peminjam->email }}</div>
                        </td>
                        <td style="color: #e2e8f0;">{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d/m/Y') }}</td>
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
                                <div style="font-size: 0.75rem; color: #8ca0c4;">• {{ $d->alat->nama_alat }} <span style="color: #60a5fa; font-weight: 600;">({{ $d->jumlah }})</span></div>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Tidak ada data peminjaman untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 50px; text-align: right; display: none; @media print { display: block; }">
        <div style="display: inline-block; text-align: center; width: 220px; border-top: 1px solid #334155; padding-top: 12px; margin-top: 60px;">
            <p style="font-size: 12px; font-weight: 700; color: black;">Petugas Lapangan</p>
            <br><br><br>
            <p style="font-size: 12px; color: black;">( {{ Auth::user()->name }} )</p>
        </div>
    </div>

</x-admin-layout>
