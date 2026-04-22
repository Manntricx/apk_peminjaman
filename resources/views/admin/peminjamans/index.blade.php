<x-admin-layout>
    <x-slot name="pageTitle">Manajemen Peminjaman</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Transaksi / Peminjaman</x-slot>

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
            width: 100%; max-width: 660px;
            border-radius: 20px;
            transform: scale(0.92) translateY(24px);
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), opacity 0.25s ease;
            opacity: 0;
            max-height: 92vh; display: flex; flex-direction: column; overflow: hidden;
        }
        .modal-overlay.active .modal-panel { transform: scale(1) translateY(0); opacity: 1; }

        .modal-accent { height: 3px; flex-shrink: 0; border-radius: 20px 20px 0 0; }
        .accent-blue   { background: linear-gradient(90deg, #1d4ed8, #3b82f6, #60a5fa); }
        .accent-indigo { background: linear-gradient(90deg, #4f46e5, #6366f1, #818cf8); }
        .accent-red    { background: linear-gradient(90deg, #b91c1c, #dc2626, #f87171); }

        .modal-header {
            padding: 20px 24px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 14px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(29,78,216,0.18) 0%, rgba(15,23,42,0.1) 100%);
        }
        .modal-icon {
            width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-icon svg { width: 20px; height: 20px; color: #fff; }
        .icon-blue   { background: linear-gradient(135deg, #2563eb, #1d4ed8); box-shadow: 0 4px 12px rgba(37,99,235,0.4); }
        .icon-red    { background: linear-gradient(135deg, #dc2626, #b91c1c); box-shadow: 0 4px 12px rgba(220,38,38,0.4); }

        .modal-header-text { flex: 1; min-width: 0; }
        .modal-title   { font-size: 0.98rem; font-weight: 700; color: #f1f5f9; }
        .modal-subtitle{ font-size: 0.74rem; color: #475569; margin-top: 2px; }

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
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 540px) { .form-grid-2 { grid-template-columns: 1fr; } }
        .form-group { margin-bottom: 0; }
        .form-row    { margin-bottom: 14px; }

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
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .form-control:focus { border-color: #3b82f6; background: rgba(255,255,255,0.08); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .form-control::placeholder { color: #334155; }
        .form-control:disabled { opacity: 0.6; cursor: not-allowed; }

        select.form-control option { background: #0d1e3b; color: #f1f5f9; }

        /* Custom buttons in modal */
        .btn-modal {
            padding: 9px 18px; border-radius: 8px; font-size: 0.83rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
            border: none; display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-modal-primary { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .btn-modal-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(37,99,235,0.45); }
        
        .btn-modal-secondary { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; }
        .btn-modal-secondary:hover { background: rgba(255,255,255,0.12); color: #f1f5f9; }

        .btn-danger-modal { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }
        .btn-danger-modal:hover { background: rgba(239,68,68,0.2); transform: translateY(-1px); }

        .alat-item-row {
            background: rgba(59,130,246,0.05); border: 1px solid rgba(59,130,246,0.12);
            border-radius: 12px; padding: 14px; margin-bottom: 12px;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Peminjaman</div>
                <div class="card-subtitle">Pantau status peminjaman alat oleh pengguna</div>
            </div>
            @if(Auth::user()->role === 'admin')
            <button onclick="openModal('createModal')" class="card-action" style="border:none;cursor:pointer;">
                + Buat Peminjaman
            </button>
            @endif
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
                                <form action="{{ route(Auth::user()->role . '.peminjamans.approve', $pj) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(16,185,129,0.1); color: #34d399; border: none; cursor: pointer;" title="Setujui Peminjaman">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route(Auth::user()->role . '.peminjamans.reject', $pj) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(239,68,68,0.1); color: #f87171; border: none; cursor: pointer;" title="Tolak Peminjaman">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route(Auth::user()->role . '.peminjamans.show', $pj) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(59,130,246,0.1); color: #60a5fa;" title="Detail">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                
                                @if($pj->status != 'aktif' && Auth::user()->role === 'admin')
                                <button type="button" 
                                    onclick="openDeleteModal(this)"
                                    data-url="{{ route('admin.peminjamans.destroy', $pj) }}"
                                    data-nama="{{ $pj->kode_peminjaman }}"
                                    class="topbar-icon-btn" style="width: 32px; height: 32px; background: rgba(239,68,68,0.1); color: #f87171; border:none; cursor:pointer;" title="Hapus">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
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

    {{-- MODAL CREATE --}}
    <div id="createModal" class="modal-overlay">
        <div class="modal-panel">
            <div class="modal-accent accent-blue"></div>
            <div class="modal-header">
                <div class="modal-icon icon-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Buat Peminjaman Baru</div>
                    <div class="modal-subtitle">Isi data peminjaman alat untuk anggota</div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('createModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.peminjamans.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Kode Peminjaman</label>
                            <input type="text" name="kode_peminjaman" value="{{ $kode }}" readonly class="form-control" style="background: rgba(255,255,255,0.02); color: #60a5fa; font-weight: 700;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Peminjam (User) <span class="form-req">*</span></label>
                            <select name="peminjam_id" required class="form-control">
                                <option value="" disabled selected>Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pinjam <span class="form-req">*</span></label>
                            <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Batas Kembali <span class="form-req">*</span></label>
                            <input type="date" name="tgl_kembali_rencana" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Alat yang Dipinjam <span class="form-req">*</span></label>
                        <div class="alat-item-row">
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" style="font-size: 0.7rem;">Pilih Alat</label>
                                    <select name="alat_id[]" required class="form-control">
                                        <option value="" disabled selected>Cari Alat...</option>
                                        @foreach($alats as $alat)
                                            <option value="{{ $alat->id }}">[{{ $alat->kategori->nama_kategori }}] {{ $alat->nama_alat }} ({{ $alat->stok_tersedia }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" style="font-size: 0.7rem;">Jumlah</label>
                                    <input type="number" name="jumlah[]" value="1" min="1" required class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan / Tujuan <span class="form-opt">(Opsional)</span></label>
                        <textarea name="keterangan" rows="2" class="form-control" placeholder="Contoh: Keperluan praktek di Lab 1"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-modal-secondary" onclick="closeModal('createModal')">Batal</button>
                    <button type="submit" class="btn-modal btn-modal-primary">Simpan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-panel" style="max-width: 440px;">
            <div class="modal-accent accent-red"></div>
            <div class="modal-header">
                <div class="modal-icon icon-red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Hapus Peminjaman</div>
                    <div class="modal-subtitle">Tindakan ini tidak bisa dibatalkan</div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6;">
                    Apakah Anda yakin ingin menghapus data peminjaman dengan kode <strong id="deleteItemName" style="color: #f1f5f9;"></strong>?
                </p>
                <div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 12px; padding: 14px; margin-top: 18px; color: #f87171; font-size: 0.77rem; display: flex; gap: 10px;">
                    <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Pastikan peminjaman ini tidak sedang aktif agar stok alat tetap akurat.</span>
                </div>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-modal btn-modal-secondary" onclick="closeModal('deleteModal')">Batal</button>
                    <button type="submit" class="btn-modal btn-danger-modal" style="background: #dc2626; color: #fff;">Hapus Permanen</button>
                </form>
            </div>
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
        }
        function openDeleteModal(btn) {
            document.getElementById('deleteForm').action          = btn.dataset.url;
            document.getElementById('deleteItemName').textContent = btn.dataset.nama;
            openModal('deleteModal');
        }
        document.querySelectorAll('.modal-overlay').forEach(function(el){
            el.addEventListener('click',function(e){ if(e.target===this) closeModal(this.id); });
        });
        document.addEventListener('keydown',function(e){
            if(e.key==='Escape') document.querySelectorAll('.modal-overlay.active').forEach(function(m){ closeModal(m.id); });
        });

        // Auto-open modal on validation errors
        @if($errors->any())
            openModal('createModal');
        @endif
    </script>
</x-admin-layout>
