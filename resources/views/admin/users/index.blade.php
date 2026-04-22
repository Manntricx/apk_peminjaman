<x-admin-layout>
    <x-slot name="pageTitle">Manajemen User</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data User</x-slot>

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

        .form-error { color: #f87171; font-size: 0.73rem; margin-top: 5px; }

        /* Password section */
        .pass-section {
            margin-top: 14px; padding: 16px 18px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
        }
        .pass-section-header { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
        .pass-section-title  { font-size: 0.8rem; font-weight: 700; color: #cbd5e1; }
        .pass-section-sub    { font-size: 0.72rem; color: #334155; margin-bottom: 14px; }

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
                <div class="card-title">Daftar User</div>
                <div class="card-subtitle">Kelola hak akses dan informasi pengguna sistem</div>
            </div>
            <button onclick="openModal('createModal')" class="card-action" style="border:none;cursor:pointer;">
                + Tambah User
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
                        <th>Status</th>
                        <th>Nama &amp; Email</th>
                        <th>WhatsApp/Telepon</th>
                        <th>Peran</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td style="color:#94a3b8;font-weight:500;">{{ ($users->currentPage()-1)*$users->perPage()+$loop->iteration }}</td>
                            <td>
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;font-size:0.78rem;font-weight:700;color:#fff;">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600;color:#f1f5f9;">{{ $user->name }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;">{{ $user->email }}</div>
                            </td>
                            <td>
                                @if($user->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','', $user->phone) }}" target="_blank"
                                        style="color:#16a34a;text-decoration:none;display:flex;align-items:center;gap:4px;font-size:0.82rem;">
                                        <svg style="width:13px;height:13px;flex-shrink:0;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.542 2.317 2.138-.542c.866.471 1.765.883 2.974.884 3.181 0 5.767-2.586 5.768-5.766 0-3.182-2.585-5.771-5.769-5.772zm3.174 7.749c-.147.405-.852.742-1.224.782-.338.038-.724.084-1.231-.083-.341-.112-1.396-.543-2.385-1.423-.815-.724-1.332-1.472-1.531-1.812-.199-.34-.022-.524.148-.694.154-.153.342-.405.512-.607.17-.203.226-.339.34-.565.114-.226.056-.424-.028-.593-.084-.17-.749-1.808-.946-2.284-.191-.462-.403-.399-.586-.409-.176-.009-.38-.011-.584-.011-.204 0-.537.077-.817.382-.28.305-1.074 1.051-1.074 2.561s1.099 2.966 1.252 3.17c.152.204 2.163 3.303 5.239 4.629.732.316 1.303.504 1.747.645.735.233 1.403.2 1.932.121.589-.088 1.807-.738 2.063-1.452.256-.714.256-1.325.18-1.452-.076-.127-.282-.203-.586-.31z"/></svg>
                                        {{ $user->phone }}
                                    </a>
                                @else
                                    <span style="color:#cbd5e1;">-</span>
                                @endif
                            </td>
                            <td>
                                @php $roleClass = match($user->role){'admin'=>'badge-danger','petugas'=>'badge-info',default=>'badge-success'}; @endphp
                                <span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex;justify-content:flex-end;gap:8px;">
                                    <button class="topbar-icon-btn"
                                        style="width:32px;height:32px;background:#eff6ff;color:#2563eb;"
                                        title="Edit" onclick="openEditUserModal(this)"
                                        data-id="{{ $user->id }}"
                                        data-url="{{ route('admin.users.update', $user) }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone ?? '' }}"
                                        data-role="{{ $user->role }}">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button class="topbar-icon-btn"
                                            style="width:32px;height:32px;background:#fff1f2;color:#be123c;"
                                            title="Hapus" onclick="openDeleteModal(this)"
                                            data-url="{{ route('admin.users.destroy', $user) }}"
                                            data-nama="{{ $user->name }}">
                                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada data user.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top:24px;">{{ $users->links() }}</div>
        </div>
    </div>

    {{-- ===== CREATE MODAL ===== --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal-panel">
            <div class="modal-accent accent-blue"></div>
            <div class="modal-header">
                <div class="modal-icon icon-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah User Baru</div>
                    <div class="modal-subtitle">Lengkapi data untuk mendaftarkan pengguna baru</div>
                </div>
                <button class="modal-close" type="button" onclick="closeModal('createModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_modal" value="createModal">
                <div class="modal-body">
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="form-req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="Nama lengkap" class="form-control">
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="form-req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="contoh@email.com" class="form-control">
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp/Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="08123456789" class="form-control">
                            @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Role / Peran <span class="form-req">*</span></label>
                            <select name="role" required class="form-control">
                                <option value="peminjam" {{ old('role')=='peminjam'?'selected':'' }}>Peminjam</option>
                                <option value="petugas"  {{ old('role')=='petugas' ?'selected':'' }}>Petugas</option>
                                <option value="admin"    {{ old('role')=='admin'   ?'selected':'' }}>Admin</option>
                            </select>
                            @error('role') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Password <span class="form-req">*</span></label>
                            <input type="password" name="password" required class="form-control">
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password <span class="form-req">*</span></label>
                            <input type="password" name="password_confirmation" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Batal</button>
                    <button type="submit" class="btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan User
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
                    <div class="modal-title">Edit User</div>
                    <div class="modal-subtitle">Perbarui informasi pengguna atau ubah hak akses</div>
                </div>
                <button class="modal-close" type="button" onclick="closeModal('editModal')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="editUserForm" action="" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="_modal" value="editModal">
                <input type="hidden" name="_edit_id" id="editUserId" value="{{ old('_edit_id') }}">
                <div class="modal-body">
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="form-req">*</span></label>
                            <input type="text" name="name" id="editUserName" value="{{ old('name') }}" required class="form-control">
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="form-req">*</span></label>
                            <input type="email" name="email" id="editUserEmail" value="{{ old('email') }}" required class="form-control">
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-grid-2 form-row">
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp/Phone</label>
                            <input type="text" name="phone" id="editUserPhone" value="{{ old('phone') }}" placeholder="08123456789" class="form-control">
                            @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Role / Peran <span class="form-req">*</span></label>
                            <select name="role" id="editUserRole" required class="form-control">
                                <option value="peminjam">Peminjam</option>
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="pass-section">
                        <div class="pass-section-header">
                            <svg width="14" height="14" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <div class="pass-section-title">Ganti Password</div>
                        </div>
                        <p class="pass-section-sub">Biarkan kosong jika tidak ingin mengubah password.</p>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control">
                                @error('password') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
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
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title" style="color:#fca5a5;">Hapus User</div>
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
                            Hapus user <span id="deleteItemName" style="color:#fca5a5;"></span>?
                        </div>
                        <div class="delete-warning-sub">Semua data transaksi milik user ini mungkin terpengaruh. Pastikan tidak ada peminjaman aktif sebelum menghapus.</div>
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
                        Ya, Hapus User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var userBaseUrl = '{{ url('admin/users') }}';

        function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }

        function openEditUserModal(btn) {
            document.getElementById('editUserForm').action  = btn.dataset.url;
            document.getElementById('editUserId').value     = btn.dataset.id;
            document.getElementById('editUserName').value   = btn.dataset.name;
            document.getElementById('editUserEmail').value  = btn.dataset.email;
            document.getElementById('editUserPhone').value  = btn.dataset.phone;
            var sel = document.getElementById('editUserRole');
            for(var i=0;i<sel.options.length;i++) sel.options[i].selected=(sel.options[i].value===btn.dataset.role);
            openModal('editModal');
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
        @if($errors->any())
            (function(){
                var modal=@json(old('_modal','createModal')); var editId=@json(old('_edit_id',''));
                if(modal==='editModal'&&editId){
                    document.getElementById('editUserForm').action=userBaseUrl+'/'+editId;
                    document.getElementById('editUserId').value=editId;
                    var oldRole=@json(old('role','')); if(oldRole){var s=document.getElementById('editUserRole');for(var i=0;i<s.options.length;i++) s.options[i].selected=(s.options[i].value===oldRole);}
                }
                openModal(modal);
            })();
        @endif
    </script>
</x-admin-layout>