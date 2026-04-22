<x-peminjam-layout>
    <x-slot name="pageTitle">Pengembalian Alat</x-slot>

    <style>
        .page-hdr { margin-bottom: 24px; }
        .page-hdr h1 { font-size: 1.4rem; font-weight: 800; color: #e8eeff; letter-spacing: -0.5px; }
        .page-hdr p  { font-size: 0.82rem; color: #4e6080; margin-top: 3px; }

        /* Return Form Card */
        .return-card { border-top: 3px solid #34d399; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; }
        .form-submit { display: flex; justify-content: flex-end; margin-top: 20px; }

        /* All-Clear Card */
        .clear-card {
            background: rgba(16,185,129,0.06);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 16px; padding: 28px 24px;
            display: flex; align-items: center; gap: 18px;
            margin-bottom: 24px;
        }
        .clear-icon {
            width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
            background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.2);
            display: flex; align-items: center; justify-content: center; color: #34d399;
        }
        .clear-icon svg { width: 24px; height: 24px; }
        .clear-info { flex: 1; }
        .clear-info h3 { font-size: 0.95rem; font-weight: 700; color: #e8eeff; margin-bottom: 4px; }
        .clear-info p  { font-size: 0.82rem; color: #4e6080; }

        /* History Table */
        .ref-mono { font-family: 'Courier New', monospace; font-weight: 700; color: #60a5fa; font-size: 0.8rem; }
        .item-name { font-weight: 600; color: #e8eeff; font-size: 0.855rem; }
        .item-more { font-size: 0.72rem; color: #3d5270; font-style: italic; margin-top: 2px; }
        .date-green { color: #34d399; font-weight: 600; font-size: 0.82rem; }
        .note-cell  { font-size: 0.8rem; color: #4e6080; max-width: 200px; }
        .pagi-wrap  { padding: 16px 22px; border-top: 1px solid rgba(59,130,246,0.08); }

        .empty-simple { text-align: center; padding: 48px 24px; color: #3d5270; }
        .empty-simple svg { width: 42px; height: 42px; margin: 0 auto 12px; opacity: 0.35; display: block; }
        .empty-simple p { font-size: 0.85rem; }

        /* Kondisi Badges */
        .badge-baik      { background: rgba(16,185,129,0.14); color: #34d399; border: 1px solid rgba(16,185,129,0.28); }
        .badge-perbaikan { background: rgba(245,158,11,0.14); color: #fbbf24; border: 1px solid rgba(245,158,11,0.28); }
        .badge-rusak     { background: rgba(239,68,68,0.14);  color: #f87171;  border: 1px solid rgba(239,68,68,0.28); }

        /* Dark Mode Select Options Fix */
        select.form-control {
            background-color: rgba(15, 23, 42, 0.4);
            color: #f1f5f9;
        }
        select.form-control option {
            background-color: #0d1e3b;
            color: #f1f5f9;
            padding: 12px;
        }

        .form-control:focus {
            border-color: #34d399;
            background-color: rgba(15, 23, 42, 0.6);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .form-label {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>

    {{-- Page Header --}}
    <div class="page-hdr">
        <h1>Pengembalian Alat</h1>
        <p>Proses pengembalian peralatan yang telah Anda pinjam dan lihat riwayat pengembalian.</p>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ═══ FORM / ALL-CLEAR ══════════════════════════ --}}
    @if($pinjamanAktif->isNotEmpty())
        <div class="card return-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Proses Pengembalian Baru</div>
                    <div class="card-subtitle">Pilih peminjaman aktif yang ingin Anda kembalikan</div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('peminjam.pengembalians.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="peminjaman_id">Pilih Peminjaman Aktif</label>
                        <select name="peminjaman_id" id="peminjaman_id" required class="form-control">
                            <option value="" disabled selected>Pilih referensi peminjaman Anda…</option>
                            @foreach($pinjamanAktif as $pj)
                            <option value="{{ $pj->id }}">
                                {{ $pj->kode_peminjaman }} —
                                @foreach($pj->details as $d){{ $d->alat->nama_alat }} ({{ $d->jumlah }})@if(!$loop->last), @endif @endforeach
                                — Batas: {{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="tgl_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ date('Y-m-d') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kondisi">Kondisi Alat Dikembalikan</label>
                            <select name="kondisi" id="kondisi" required class="form-control">
                                <option value="baik">Sangat Baik (Tanpa Masalah)</option>
                                <option value="perbaikan">Perlu Perbaikan (Ada Masalah Kecil)</option>
                                <option value="rusak">Rusak / Tidak Berfungsi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="catatan">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3" placeholder="Contoh: Alat berfungsi dengan baik, tidak ada kendala." class="form-control" style="resize: vertical;"></textarea>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Konfirmasi: Anda yakin ingin memproses pengembalian ini?')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Konfirmasi Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="clear-card">
            <div class="clear-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="clear-info">
                <h3>Semua Alat Telah Dikembalikan ✓</h3>
                <p>Anda tidak memiliki peminjaman aktif saat ini. Terima kasih!</p>
            </div>
            <a href="{{ route('peminjam.alats') }}" class="btn btn-primary btn-sm">Pinjam Alat Baru</a>
        </div>
    @endif

    {{-- ═══ HISTORY ════════════════════════════════════ --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Riwayat Pengembalian</div>
                <div class="card-subtitle">Semua pengembalian yang telah diproses</div>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($pengembalians->isEmpty())
                <div class="empty-simple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <p>Belum ada riwayat pengembalian.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Ref Peminjaman</th>
                                <th>Item Dikembalikan</th>
                                <th>Tgl Kembali</th>
                                <th>Kondisi</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengembalians as $pg)
                            <tr>
                                <td><span class="ref-mono">{{ $pg->peminjaman->kode_peminjaman }}</span></td>
                                <td>
                                    @foreach($pg->peminjaman->details->take(2) as $d)
                                        <div class="item-name">{{ $d->alat->nama_alat }}</div>
                                    @endforeach
                                    @if($pg->peminjaman->details->count() > 2)
                                        <div class="item-more">+{{ $pg->peminjaman->details->count() - 2 }} lainnya</div>
                                    @endif
                                </td>
                                <td><span class="date-green">{{ \Carbon\Carbon::parse($pg->tgl_pengembalian)->format('d M Y') }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $pg->kondisi }}">{{ ucfirst($pg->kondisi) }}</span>
                                </td>
                                <td class="note-cell">{{ $pg->catatan ?: '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pengembalians->total() > $pengembalians->perPage())
                    <div class="pagi-wrap">{{ $pengembalians->links() }}</div>
                @endif
            @endif
        </div>
    </div>

</x-peminjam-layout>
