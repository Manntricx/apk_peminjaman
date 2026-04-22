<x-admin-layout>
    <x-slot name="pageTitle">Riwayat Pengembalian (Petugas)</x-slot>
    <x-slot name="pageBreadcrumb">Petugas Panel / Transaksi / Pengembalian</x-slot>

    <style>
        /* ============================================================
           MODAL SYSTEM — Dark Blue Navy Premium Theme
        ============================================================ */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(7, 11, 22, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            opacity: 0; pointer-events: none;
            transition: opacity 0.25s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }

        .modal-panel {
            background: linear-gradient(160deg, #0d1e3b 0%, #0a1628 45%, #06101e 100%);
            border: 1px solid rgba(59,130,246,0.22);
            box-shadow:
                0 40px 100px rgba(0,0,0,0.75),
                0 0 0 1px rgba(59,130,246,0.08),
                inset 0 1px 0 rgba(255,255,255,0.06),
                inset 0 -1px 0 rgba(0,0,0,0.3);
            width: 100%; max-width: 600px;
            border-radius: 20px;
            transform: scale(0.92) translateY(24px);
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), opacity 0.25s ease;
            opacity: 0;
            max-height: 92vh; display: flex; flex-direction: column; overflow: hidden;
        }
        .modal-overlay.active .modal-panel { transform: scale(1) translateY(0); opacity: 1; }

        .modal-accent { height: 3px; flex-shrink: 0; border-radius: 20px 20px 0 0; }
        .accent-green  { background: linear-gradient(90deg, #059669, #10b981, #34d399); }

        .modal-header {
            padding: 20px 24px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 14px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(16,185,129,0.18) 0%, rgba(15,23,42,0.1) 100%);
        }
        .modal-icon {
            width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-icon svg { width: 20px; height: 20px; color: #fff; }
        .icon-green { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 12px rgba(16,185,129,0.4); }

        .modal-header-text { flex: 1; min-width: 0; }
        .modal-title   { font-size: 0.98rem; font-weight: 700; color: #f1f5f9; }
        .modal-subtitle{ font-size: 0.74rem; color: #94a3b8; margin-top: 2px; }

        .modal-close {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            color: #64748b; transition: all 0.2s; flex-shrink: 0; margin-left: auto;
        }
        .modal-close:hover { background: rgba(239,68,68,0.2); border-color: rgba(239,68,68,0.3); color: #f87171; }
        .modal-close svg { width: 14px; height: 14px; }

        .modal-body   { padding: 22px 24px; overflow-y: auto; flex: 1; }
        .modal-footer {
            padding: 14px 24px; flex-shrink: 0;
            background: rgba(0,0,0,0.22);
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; gap: 10px; justify-content: flex-end;
        }

        /* ===== FORM ELEMENTS (dark) ===== */
        .form-row { margin-bottom: 16px; }
        .form-label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: #94a3b8; margin-bottom: 7px; letter-spacing: 0.2px;
        }
        .form-req { color: #ef4444; }
        .form-control {
            width: 100%; padding: 10px 14px; border-radius: 9px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: #e2e8f0; font-size: 0.875rem; outline: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        .form-control:focus { border-color: #10b981; background: rgba(255,255,255,0.08); box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
        select.form-control option { background: #0d1e3b; color: #f1f5f9; }

        .btn-modal {
            padding: 9px 18px; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
            border: none; display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-modal-success { background: linear-gradient(135deg, #059669, #10b981); color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .btn-modal-success:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(16,185,129,0.45); }
        .btn-modal-secondary { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; }
        
        .info-box {
            background: rgba(16,185,129,0.06); border: 1px solid rgba(16,185,129,0.15);
            border-radius: 12px; padding: 16px; margin-bottom: 20px;
        }
        .info-title { font-size: 0.8rem; font-weight: 700; color: #34d399; margin-bottom: 10px; border-bottom: 1px solid rgba(16,185,129,0.15); padding-bottom: 6px; }

        .denda-preview { 
            margin-top: 15px; padding: 12px; border-radius: 10px;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2);
            color: #f87171; display: none;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Pengembalian</div>
                <div class="card-subtitle">Riwayat alat yang sudah dikembalikan oleh peminjam</div>
            </div>
            <button onclick="openModal('createModal')" class="card-action" style="background: #16a34a; color: #fff; border:none; cursor:pointer;">
                + Proses Pengembalian
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background:rgba(16,185,129,0.1);color:#34d399;border:1px solid rgba(16,185,129,0.25);padding:11px 16px;border-radius:10px;margin-bottom:20px;font-size:0.84rem;font-weight:500;display:flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                        <th>Denda</th>
                        <th>Kondisi Akhir</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pg)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($pengembalians->currentPage() - 1) * $pengembalians->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 700; color: #8ca0c4;">{{ $pg->peminjaman->kode_peminjaman }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #f1f5f9;">{{ $pg->peminjaman->peminjam->name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Oleh: {{ $pg->petugas ? $pg->petugas->name : 'Mandiri (Peminjam)' }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; color: #34d399; font-weight: 600;">
                                {{ \Carbon\Carbon::parse($pg->tgl_pengembalian)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            @if($pg->denda > 0)
                                <div style="color: #f87171; font-weight: 700;">Rp {{ number_format($pg->denda, 0, ',', '.') }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8;">Terlambat {{ $pg->hari_terlambat }} hari</div>
                            @else
                                <div style="color: #34d399; font-weight: 600; font-size: 0.8rem;">Tidak Ada</div>
                            @endif
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
                                <a href="{{ route('petugas.pengembalians.show', $pg) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); color: #94a3b8;" title="Lihat Detail">
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

    {{-- MODAL CREATE --}}
    <div id="createModal" class="modal-overlay">
        <div class="modal-panel">
            <div class="modal-accent accent-green"></div>
            <div class="modal-header">
                <div class="modal-icon icon-green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Proses Pengembalian Alat</div>
                    <div class="modal-subtitle">Selesaikan transaksi peminjaman aktif</div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('createModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('petugas.pengembalians.store') }}" method="POST" id="pengembalianForm">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <label class="form-label">Pilih Peminjaman Aktif <span class="form-req">*</span></label>
                        <select name="peminjaman_id" id="loanSelect" required class="form-control" onchange="reloadPeminjaman(this.value)">
                            <option value="">-- Pilih Kode Peminjaman --</option>
                            @foreach($activeLoans as $loan)
                                <option value="{{ $loan->id }}" 
                                    data-rencana="{{ $loan->tgl_kembali_rencana }}"
                                    {{ ($peminjaman && $peminjaman->id == $loan->id) ? 'selected' : '' }}>
                                    {{ $loan->kode_peminjaman }} - {{ $loan->peminjam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($peminjaman)
                        <div class="info-box">
                            <div class="info-title">Detail Barang:</div>
                            <table style="width: 100%; font-size: 0.8rem; color: #e2e8f0;">
                                @foreach($peminjaman->details as $detail)
                                <tr>
                                    <td style="padding: 4px 0;">• {{ $detail->alat->nama_alat }}</td>
                                    <td style="text-align: right; font-weight: 700; color: #34d399;">{{ $detail->jumlah }} Unit</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;" class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tanggal Kembali <span class="form-req">*</span></label>
                                <input type="date" name="tgl_pengembalian" value="{{ date('Y-m-d') }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kondisi Alat <span class="form-req">*</span></label>
                                <select name="kondisi" required class="form-control">
                                    <option value="baik">Semua Kondisi Baik</option>
                                    <option value="rusak">Ada yang Rusak/Hilang</option>
                                    <option value="perbaikan">Perlu Perbaikan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan <span class="form-opt">(Opsional)</span></label>
                            <textarea name="catatan" rows="2" class="form-control" placeholder="Contoh: Barang lengkap & mulus."></textarea>
                        </div>

                        <div id="dendaPreview" class="denda-preview">
                            <div style="font-size: 0.75rem; font-weight: 700; margin-bottom: 4px;">Peringatan Terlambat!</div>
                            <div style="font-size: 0.85rem;" id="dendaText"></div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-modal-secondary" onclick="closeModal('createModal')">Batal</button>
                    @if($peminjaman)
                        <button type="submit" class="btn-modal btn-modal-success">Simpan Pengembalian</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = 'auto';
            if(window.location.search.includes('peminjaman_id')) {
                window.location.href = window.location.pathname;
            }
        }
        function reloadPeminjaman(id) {
            if(!id) return;
            const url = new URL(window.location.href);
            url.searchParams.set('peminjaman_id', id);
            window.location.href = url.toString();
        }

        function updateDenda() {
            const select = document.getElementById('loanSelect');
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || !selectedOption.dataset.rencana) return;

            const tglRencana = new Date(selectedOption.dataset.rencana);
            const tglKembali = new Date(document.querySelector('input[name="tgl_pengembalian"]').value);
            const previewBox = document.getElementById('dendaPreview');
            const textEl = document.getElementById('dendaText');

            if (!previewBox) return;

            tglRencana.setHours(0,0,0,0);
            tglKembali.setHours(0,0,0,0);

            if (tglKembali > tglRencana) {
                const diffTime = Math.abs(tglKembali - tglRencana);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const fine = diffDays * 5000;
                
                textEl.innerHTML = `Terlambat <strong>${diffDays} hari</strong>. Denda yang dikenakan: <strong>Rp ${fine.toLocaleString('id-ID')}</strong>`;
                previewBox.style.display = 'block';
            } else {
                previewBox.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('input[name="tgl_pengembalian"]');
            if (dateInput) {
                dateInput.addEventListener('change', updateDenda);
                updateDenda();
            }
        });

        @if(request()->query('peminjaman_id') || $errors->any())
            openModal('createModal');
        @endif

        document.querySelectorAll('.modal-overlay').forEach(function(el){
            el.addEventListener('click',function(e){ if(e.target===this) closeModal(this.id); });
        });
        document.addEventListener('keydown',function(e){
            if(e.key==='Escape') document.querySelectorAll('.modal-overlay.active').forEach(function(m){ closeModal(m.id); });
        });
    </script>
</x-admin-layout>
