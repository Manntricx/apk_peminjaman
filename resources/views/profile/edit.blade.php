<x-admin-layout>
    <x-slot name="pageTitle">Pengaturan Profil</x-slot>
    <x-slot name="pageBreadcrumb">User / Profil</x-slot>

    <div style="max-width: 900px; margin: 0 auto;">
        
        {{-- Profile Header Card --}}
        <div class="card" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: #fff; margin-bottom: 28px; border: none;">
            <div style="padding: 40px; display: flex; align-items: center; gap: 28px;">
                <div style="width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.2); border: 4px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 4px;">{{ Auth::user()->name }}</h1>
                    <div style="display: flex; align-items: center; gap: 12px; opacity: 0.9; font-size: 0.9rem;">
                        <span style="background: rgba(255,255,255,0.2); padding: 2px 12px; border-radius: 99px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">{{ Auth::user()->role }}</span>
                        <span>•</span>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 28px;">
            
            {{-- Update Info --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informasi Pribadi</div>
                        <div class="card-subtitle">Perbarui nama, email, dan nomor telepon akun Anda</div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            </div>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nomor Telepon/WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.85rem;">
                                Simpan Perubahan
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span style="color: #16a34a; font-size: 0.8rem; font-weight: 600;">Berhasil disimpan.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Keamanan Akun</div>
                        <div class="card-subtitle">Ganti password secara berkala untuk menjaga keamanan akun</div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            @if($errors->updatePassword->get('current_password'))
                                <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $errors->updatePassword->get('current_password')[0] }}</div>
                            @endif
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Password Baru</label>
                                <input type="password" name="password" required
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                                @if($errors->updatePassword->get('password'))
                                    <div style="color: #be123c; font-size: 0.75rem; margin-top: 4px;">{{ $errors->updatePassword->get('password')[0] }}</div>
                                @endif
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required
                                    style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none;">
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <button type="submit" style="background: #0f172a; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.85rem;">
                                Update Password
                            </button>
                            @if (session('status') === 'password-updated')
                                <span style="color: #16a34a; font-size: 0.8rem; font-weight: 600;">Password berhasil diganti.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card" style="border-color: #fecdd3; background: #fff1f2;">
                <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">Hapus Akun</div>
                        <div style="font-size: 0.8rem; color: #b91c1c; margin-top: 2px;">Tindakan ini permanen dan tidak dapat dibatalkan.</div>
                    </div>
                    <button onclick="document.getElementById('deleteModal').style.display='flex'" style="background: #be123c; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.75rem;">
                        Hapus Akun Saya
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Tiny Modal for Delete --}}
    <div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
        <div class="card" style="max-width: 450px; width: 100%;">
            <div style="padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #991b1b; margin-bottom: 12px;">Konfirmasi Penghapusan</h3>
                <p style="font-size: 0.85rem; color: #475569; margin-bottom: 24px; line-height: 1.6;">Masukkan password Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.</p>
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <input type="password" name="password" placeholder="Password Anda" required
                        style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem; outline: none; margin-bottom: 20px;">
                    
                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                        <button type="button" onclick="document.getElementById('deleteModal').style.display='none'" style="background: none; border: none; color: #64748b; font-weight: 600; cursor: pointer; font-size: 0.85rem;">Batal</button>
                        <button type="submit" style="background: #be123c; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.85rem;">Hapus Selamanya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>
