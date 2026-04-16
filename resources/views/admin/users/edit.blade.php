<x-admin-layout>
    <x-slot name="pageTitle">Edit User</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data User / Edit</x-slot>

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Edit: {{ $user->name }}</div>
                    <div class="card-subtitle">Perbarui informasi pengguna atau ubah hak akses</div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="card-action" style="background: #f1f5f9; color: #64748b;">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Nama --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('name') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('email') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        {{-- Phone --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nomor WhatsApp/Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789"
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('phone') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>

                        {{-- Role --}}
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Role / Peran</label>
                            <select name="role" required 
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; background: #fff;">
                                <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div style="margin-top: 10px; padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; margin-bottom: 24px;">
                        <div style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Ganti Password (Opsional)</div>
                        <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 16px;">Biarkan kosong jika tidak ingin mengubah password.</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.78rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Password Baru</label>
                                <input type="password" name="password" 
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;"
                                    onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                                @error('password') <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.78rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" 
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;"
                                    onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" style="width: 100%; background: #2563eb; color: #fff; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
