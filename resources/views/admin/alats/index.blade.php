<x-admin-layout>
    <x-slot name="pageTitle">Daftar Alat</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data Alat</x-slot>

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
            width: 100%; max-width: 680px;
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
        .icon-indigo { background: linear-gradient(135deg, #4f46e5, #4338ca); box-shadow: 0 4px 12px rgba(79,70,229,0.4); }
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
        .form-opt { color: #475569; font-weight: 400; }

        .form-control {
            width: 100%; padding: 10px 14px; border-radius: 9px;
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: #e2e8f0; font-size: 0.875rem; outline: none;
            font-family: inherit;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .form-control::placeholder { color: #334155; }
        .form-control:focus {
            border-color: #3b82f6;
            background: rgba(59,130,246,0.08);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.14);
            color: #f1f5f9;
        }
        select.form-control { cursor: pointer; }
        select.form-control option { background: #1e293b; color: #e2e8f0; }
        textarea.form-control { resize: vertical; }

        .form-error { color: #f87171; font-size: 0.73rem; margin-top: 5px; }
        .form-hint  { color: #334155; font-size: 0.7rem; margin-top: 4px; }

        /* File upload */
        .file-upload-box {
            border: 1.5px dashed rgba(99,102,241,0.3); border-radius: 9px; padding: 12px 14px;
            background: rgba(255,255,255,0.03); transition: border-color 0.2s;
        }
        .file-upload-box:hover { border-color: rgba(99,102,241,0.5); }
        .file-upload-box input[type="file"] { width:100%; font-size:0.82rem; color:#475569; cursor:pointer; }

        /* Foto preview */
        .foto-preview-img {
            width: 64px; height: 64px; border-radius: 10px; object-fit: cover;
            border: 2px solid rgba(59,130,246,0.3);
        }
        .foto-placeholder-box {
            width: 64px; height: 64px; border-radius: 10px; flex-shrink: 0;
            background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center; color: #334155;
        }

        /* Info chip (stok tersedia) */
        .info-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
            color: #93c5fd; font-size: 0.7rem; font-weight: 600;
            padding: 3px 9px; border-radius: 99px; margin-top: 5px;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff;
            border: none; padding: 10px 20px; border-radius: 9px;
            font-weight: 600; font-size: 0.83rem; cursor: pointer;
            transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,0.45); }
        .btn-secondary {
            background: rgba(255,255,255,0.07); color: #94a3b8;
            border: 1px solid rgba(255,255,255,0.1); padding: 10px 18px;
            border-radius: 9px; font-weight: 600; font-size: 0.83rem; cursor: pointer; transition: all 0.2s;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: #cbd5e1; }
        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c); color: #fff;
            border: none; padding: 10px 20px; border-radius: 9px;
            font-weight: 600; font-size: 0.83rem; cursor: pointer; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(220,38,38,0.45); }

        .delete-warning-box {
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2);
            border-radius: 12px; padding: 18px;
            display: flex; gap: 14px; align-items: flex-start;
        }
        .delete-warning-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.25);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .delete-warning-title { font-size: 0.875rem; font-weight: 600; color: #f1f5f9; margin-bottom: 5px; }
        .delete-warning-sub   { font-size: 0.77rem; color: #475569; line-height: 1.5; }
    </style>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Inventaris Alat</div>
                <div class="card-subtitle">Kelola stok, kondisi, dan informasi alat peminjaman</div>
            </div>
            <button onclick="openModal('createModal')" class="card-action" style="border:none;cursor:pointer;">
                + Tambah Alat
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background:rgba(22,163,74,0.1);color:#4ade80;border:1px solid rgba(22,163,74,0.25);padding:11px 16px;border-radius:10px;margin-bottom:20px;font-size:0.84rem;font-weight:500;display:flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fee2e2;color:#b91c1c;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:0.84rem;font-weight:500;">
                    {{ session('error') }}
                </div>
            @endif

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Foto</th>
                        <th>Nama Alat / Kategori</th>
                        <th>Stok (Tersedia/Total)</th>
                        <th>Kondisi</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $alat)
                        <tr>
                            <td style="color:#94a3b8;font-weight:500;">
                                {{ ($alats->currentPage()-1)*$alats->perPage()+$loop->iteration }}
                            </td>
                            <td>
                                @if($alat->foto)
                                    <img src="{{ asset('storage/'.$alat->foto) }}" alt="{{ $alat->nama_alat }}"
                                        style="width:48px;height:48px;border-radius:8px;object-fit:cover;border:1px solid #e2e8f0;">
                                @else
                                    <div style="width:48px;height:48px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:600;color:#f1f5f9;">{{ $alat->nama_alat }}</div>
                                <div style="font-size:0.75rem;color:#3b82f6;font-weight:500;">
                                    {{ optional($alat->kategori)->nama_kategori ?? 'Tanpa Kategori' }}
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="font-weight:700;color:#f1f5f9;">{{ $alat->stok_tersedia }}</span>
                                    <span style="color:#94a3b8;font-size:0.8rem;">/ {{ $alat->stok_total }}</span>
                                    @if($alat->stok_tersedia == 0)
                                        <span class="badge badge-danger" style="font-size:0.6rem;padding:1px 6px;">Kosong</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php $kondisiClass=match($alat->kondisi){'baik'=>'badge-success','rusak'=>'badge-danger','perbaikan'=>'badge-warning',default=>'badge-info'}; @endphp
                                <span class="badge {{ $kondisiClass }}">{{ ucfirst($alat->kondisi) }}</span>
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;justify-content:flex-end;gap:8px;">
                                    <button class="topbar-icon-btn"
                                        style="width:32px;height:32px;background:#eff6ff;color:#2563eb;"
                                        title="Edit" onclick="openEditAlatModal(this)"
                                        data-id="{{ $alat->id }}"
                                        data-url="{{ route('admin.alats.update', $alat) }}"
                                        data-nama="{{ $alat->nama_alat }}"
                                        data-kategori="{{ $alat->kategori_id }}"
                                        data-stok="{{ $alat->stok_total }}"
                                        data-tersedia="{{ $alat->stok_tersedia }}"
                                        data-kondisi="{{ $alat->kondisi }}"
                                        data-deskripsi="{{ $alat->deskripsi ?? '' }}"
                                        data-foto="{{ $alat->foto ? asset('storage/'.$alat->foto) : '' }}">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="topbar-icon-btn"
                                        style="width:32px;height:32px;background:#fff1f2;color:#be123c;"
                                        title="Hapus" onclick="openDeleteModal(this)"
                                        data-url="{{ route('admin.alats.destroy', $alat) }}"
                                        data-nama="{{ $alat->nama_alat }}">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada data alat.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top:24px;">{{ $alats->links() }}</div>
        </div>
    </div>

    {{-- ===== CREATE MODAL ===== --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal-panel">
            <div class="modal-accent accent-blue"></div>
            <div class="modal-header">
                <div class="modal-icon icon-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah Alat Baru</div>
                    <div class="modal-subtitle">Daftarkan alat inventaris baru ke dalam sistem</div>
                </div>
                <button class="modal-close" type="button" onclick="closeModal('createModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.alats.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_modal" value="createModal">
                <div class="modal-body">
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Alat <span class="form-req">*</span></label>
                            <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" required
                                placeholder="Contoh: Proyektor Epson X10" class="form-control">
                            @error('nama_alat') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="form-req">*</span></label>
                            <select name="kategori_id" required class="form-control">
                                <option value="" disabled {{ old('kategori_id')?'':'selected' }}>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('kategori_id')==$cat->id?'selected':'' }}>{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Jumlah Stok (Total) <span class="form-req">*</span></label>
                            <input type="number" name="stok_total" value="{{ old('stok_total',0) }}" min="0" required class="form-control">
                            @error('stok_total') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kondisi Alat <span class="form-req">*</span></label>
                            <select name="kondisi" required class="form-control">
                                <option value="baik"      {{ old('kondisi')=='baik'?'selected':'' }}>Baik</option>
                                <option value="rusak"     {{ old('kondisi')=='rusak'?'selected':'' }}>Rusak</option>
                                <option value="perbaikan" {{ old('kondisi')=='perbaikan'?'selected':'' }}>Dalam Perbaikan</option>
                            </select>
                            @error('kondisi') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label class="form-label">Deskripsi <span class="form-opt">(Opsional)</span></label>
                        <textarea name="deskripsi" rows="2" placeholder="Keterangan mengenai spesifikasi atau detail alat..."
                            class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto Alat <span class="form-opt">(Opsional)</span></label>
                        <div class="file-upload-box">
                            <input type="file" name="foto" accept="image/*" onchange="previewImg(this,'createPrev','createPrevImg')">
                        </div>
                        <div class="form-hint">Format JPG, PNG, WebP – Maks. 2MB</div>
                        <div id="createPrev" style="margin-top:10px;display:none;">
                            <img id="createPrevImg" class="foto-preview-img" src="" alt="Preview">
                        </div>
                        @error('foto') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Batal</button>
                    <button type="submit" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Alat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== EDIT MODAL ===== --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal-panel">
            <div class="modal-accent accent-indigo"></div>
            <div class="modal-header" style="background:linear-gradient(135deg,rgba(79,70,229,0.18) 0%,rgba(15,23,42,0.1) 100%);">
                <div class="modal-icon icon-indigo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Edit Alat</div>
                    <div class="modal-subtitle">Perbarui informasi, stok, atau kondisi alat</div>
                </div>
                <button class="modal-close" type="button" onclick="closeModal('editModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="editAlatForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="_modal" value="editModal">
                <input type="hidden" name="_edit_id" id="editAlatId" value="{{ old('_edit_id') }}">
                <div class="modal-body">
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Alat <span class="form-req">*</span></label>
                            <input type="text" name="nama_alat" id="editNamaAlat" value="{{ old('nama_alat') }}" required class="form-control">
                            @error('nama_alat') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="form-req">*</span></label>
                            <select name="kategori_id" id="editKategoriId" required class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('kategori_id')==$cat->id?'selected':'' }}>{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Jumlah Stok (Total) <span class="form-req">*</span></label>
                            <input type="number" name="stok_total" id="editStokTotal" value="{{ old('stok_total') }}" min="0" required class="form-control">
                            <div class="info-chip" id="editStokInfo">
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Tersedia: <span id="editStokTersedia"></span>
                            </div>
                            @error('stok_total') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kondisi Alat <span class="form-req">*</span></label>
                            <select name="kondisi" id="editKondisi" required class="form-control">
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                                <option value="perbaikan">Dalam Perbaikan</option>
                            </select>
                            @error('kondisi') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label class="form-label">Deskripsi <span class="form-opt">(Opsional)</span></label>
                        <textarea name="deskripsi" id="editDeskripsi" rows="2" class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto Alat <span class="form-opt">(Opsional – kosongkan jika tidak diubah)</span></label>
                        <div style="display:flex;gap:14px;align-items:flex-start;margin-bottom:10px;">
                            <div id="editFotoWrap">
                                <div class="foto-placeholder-box" id="editFotoPlaceholder">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <img id="editFotoImg" class="foto-preview-img" src="" style="display:none;" alt="Foto saat ini">
                            </div>
                            <div style="flex:1;">
                                <div class="file-upload-box">
                                    <input type="file" name="foto" accept="image/*" onchange="previewImg(this,'editNewPrev','editNewPrevImg')">
                                </div>
                                <div id="editNewPrev" style="margin-top:8px;display:none;">
                                    <img id="editNewPrevImg" style="width:56px;height:56px;border-radius:8px;object-fit:cover;border:2px solid rgba(99,102,241,0.5);" alt="Preview baru">
                                </div>
                            </div>
                        </div>
                        @error('foto') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== DELETE MODAL ===== --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-panel" style="max-width:440px;">
            <div class="modal-accent accent-red"></div>
            <div class="modal-header" style="background:linear-gradient(135deg,rgba(220,38,38,0.15) 0%,rgba(15,23,42,0.1) 100%);">
                <div class="modal-icon icon-red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title" style="color:#fca5a5;">Hapus Alat</div>
                    <div class="modal-subtitle">Tindakan ini tidak dapat dibatalkan</div>
                </div>
                <button class="modal-close" type="button" onclick="closeModal('deleteModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="delete-warning-box">
                    <div class="delete-warning-icon">
                        <svg width="22" height="22" fill="none" stroke="#f87171" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="delete-warning-title">
                            Hapus alat <span id="deleteItemName" style="color:#fca5a5;"></span>?
                        </div>
                        <div class="delete-warning-sub">Pastikan tidak ada transaksi peminjaman aktif yang menggunakan alat ini sebelum menghapus.</div>
                    </div>
                </div>
            </div>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                    <button type="submit" class="btn-danger">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Ya, Hapus Alat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var alatBaseUrl = '{{ url('admin/alats') }}';

        function openModal(id)  { document.getElementById(id).classList.add('active');    document.body.style.overflow='hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }

        function openEditAlatModal(btn) {
            var foto = btn.dataset.foto;
            document.getElementById('editAlatForm').action       = btn.dataset.url;
            document.getElementById('editAlatId').value          = btn.dataset.id;
            document.getElementById('editNamaAlat').value        = btn.dataset.nama;
            document.getElementById('editStokTotal').value       = btn.dataset.stok;
            document.getElementById('editStokTersedia').textContent = btn.dataset.tersedia;
            document.getElementById('editDeskripsi').value       = btn.dataset.deskripsi;

            // kategori select
            var ks = document.getElementById('editKategoriId');
            for(var i=0;i<ks.options.length;i++) ks.options[i].selected=(ks.options[i].value==btn.dataset.kategori);

            // kondisi select
            var ko = document.getElementById('editKondisi');
            for(var i=0;i<ko.options.length;i++) ko.options[i].selected=(ko.options[i].value===btn.dataset.kondisi);

            // foto preview
            var img = document.getElementById('editFotoImg');
            var ph  = document.getElementById('editFotoPlaceholder');
            if(foto){ img.src=foto; img.style.display='block'; ph.style.display='none'; }
            else    { img.src='';  img.style.display='none';  ph.style.display='flex'; }
            document.getElementById('editNewPrev').style.display='none';

            openModal('editModal');
        }

        function openDeleteModal(btn) {
            document.getElementById('deleteForm').action          = btn.dataset.url;
            document.getElementById('deleteItemName').textContent = btn.dataset.nama;
            openModal('deleteModal');
        }

        function previewImg(input, wrapId, imgId) {
            if(input.files&&input.files[0]){
                var r=new FileReader();
                r.onload=function(e){ document.getElementById(imgId).src=e.target.result; document.getElementById(wrapId).style.display='block'; };
                r.readAsDataURL(input.files[0]);
            }
        }

        document.querySelectorAll('.modal-overlay').forEach(function(el){
            el.addEventListener('click',function(e){ if(e.target===this) closeModal(this.id); });
        });
        document.addEventListener('keydown',function(e){
            if(e.key==='Escape') document.querySelectorAll('.modal-overlay.active').forEach(function(m){ closeModal(m.id); });
        });

        @if($errors->any())
            (function(){
                var modal=@json(old('_modal','createModal')); var editId=@json(old('_edit_id',''));
                if(modal==='editModal'&&editId){
                    document.getElementById('editAlatForm').action=alatBaseUrl+'/'+editId;
                    document.getElementById('editAlatId').value=editId;
                    var ok=@json(old('kondisi','')); if(ok){var s=document.getElementById('editKondisi');for(var i=0;i<s.options.length;i++) s.options[i].selected=(s.options[i].value===ok);}
                    var okt=@json(old('kategori_id','')); if(okt){var s2=document.getElementById('editKategoriId');for(var i=0;i<s2.options.length;i++) s2.options[i].selected=(s2.options[i].value==okt);}
                }
                openModal(modal);
            })();
        @endif
    </script>
</x-admin-layout>