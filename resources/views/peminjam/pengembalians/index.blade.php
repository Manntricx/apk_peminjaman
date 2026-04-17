<x-peminjam-layout>
    <x-slot name="pageTitle">Pengembalian Alat</x-slot>

    <div class="page-header">
        <h1>Pengembalian Alat</h1>
        <p>Proses pengembalian peralatan yang telah Anda pinjam dan lihat riwayat pengembalian Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- FORM PENGEMBALIAN --}}
    @if($pinjamanAktif->isNotEmpty())
    <div class="card" style="border-top: 4px solid var(--success);">
        <div class="card-header">
            <h2 class="card-title">Proses Pengembalian Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('peminjam.pengembalians.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="peminjaman_id">Pilih Peminjaman</label>
                    <select name="peminjaman_id" id="peminjaman_id" required class="form-control">
                        <option value="" disabled selected>Pilih referensi peminjaman Anda...</option>
                        @foreach($pinjamanAktif as $pj)
                        <option value="{{ $pj->id }}">
                            #{{ $pj->kode_peminjaman }} [ 
                            @foreach($pj->details as $d) {{ $d->alat->nama_alat }} ({{ $d->jumlah }}) @if(!$loop->last), @endif @endforeach
                            ] — Batas: {{ \Carbon\Carbon::parse($pj->tgl_kembali_rencana)->format('d M Y') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="tgl_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ date('Y-m-d') }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kondisi">Kondisi Alat</label>
                        <select name="kondisi" id="kondisi" required class="form-control">
                            <option value="baik">Sangat Baik (Tanpa Masalah)</option>
                            <option value="perbaikan">Perlu Perbaikan (Ada Masalah Kecil)</option>
                            <option value="rusak">Rusak Total / Tidak Berfungsi</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="catatan">Catatan / Kondisi Terakhir (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3" placeholder="Contoh: Alat bekerja dengan baik, tidak ada kendala." class="form-control" style="resize: vertical;"></textarea>
                </div>

                <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin melakukan pengembalian ini?')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="card" style="background: #f1f5f9; border: none;">
            <div class="card-body" style="padding: 32px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 1rem; font-weight: 700;">Semua Alat Telah Dikembalikan</h3>
                    <p style="font-size: 0.875rem; color: #64748b;">Anda tidak memiliki peminjaman aktif saat ini. Bagus!</p>
                </div>
                <a href="{{ route('peminjam.alats') }}" class="btn btn-primary btn-sm">Pinjam Alat Baru</a>
            </div>
        </div>
    @endif

    {{-- RIWAYAT PENGEMBALIAN --}}
    <div class="card" style="margin-top: 32px;">
        <div class="card-header">
            <h2 class="card-title">Riwayat Pengembalian</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($pengembalians->isEmpty())
                <div style="text-align: center; padding: 48px 24px; color: #94a3b8;">
                    <svg style="width: 48px; height: 48px; margin: 0 auto 16px; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                                <td style="font-family: monospace; font-weight: 700; color: var(--primary);">#{{ $pg->peminjaman->kode_peminjaman }}</td>
                                <td>
                                    @foreach($pg->peminjaman->details->take(2) as $d)
                                        <div style="font-weight: 600; font-size: 0.875rem;">{{ $d->alat->nama_alat }}</div>
                                    @endforeach
                                    @if($pg->peminjaman->details->count() > 2)
                                        <div style="font-size: 0.75rem; color: #94a3b8;">+{{ $pg->peminjaman->details->count() - 2 }} item lainnya</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--success);">{{ \Carbon\Carbon::parse($pg->tgl_pengembalian)->format('d M Y') }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $pg->kondisi }}">{{ ucfirst($pg->kondisi) }}</span>
                                </td>
                                <td style="font-size: 0.8125rem; color: #64748b; max-width: 250px;">
                                    {{ $pg->catatan ?: '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($pengembalians->total() > $pengembalians->perPage())
            <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9;">
                {{ $pengembalians->links() }}
            </div>
        @endif
    </div>
</x-peminjam-layout>
