<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solang — Daftar Akun Baru</title>
    <meta name="description" content="Halaman pendaftaran akun baru Solang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e3a8a;
            --accent: #06b6d4;
            --bg-deep: #020617;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--bg-deep);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .auth-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ===== PANEL KIRI ===== */
        .brand-panel {
            flex: 1.2;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(160deg, #0f172a 0%, #020617 100%);
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.03) 1px, transparent 0);
            background-size: 24px 24px;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .logo-box svg { width: 26px; height: 26px; color: white; }

        .brand-title {
            font-size: 2.8rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 16px;
            background: linear-gradient(to bottom right, #ffffff 10%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-desc {
            font-size: 0.9375rem;
            color: var(--text-muted);
            line-height: 1.5;
            max-width: 380px;
        }

        /* ===== PANEL KANAN ===== */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background: #ffffff;
            color: #0f172a;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            padding: 30px 0;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header { margin-bottom: 24px; }
        .auth-header h2 { font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 8px; }
        .auth-header p { font-size: 0.875rem; color: #64748b; }

        /* FORM */
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 800; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .input-box { position: relative; display: flex; align-items: center; }
        .input-icon { position: absolute; left: 14px; color: #94a3b8; }
        .form-input { width: 100%; padding: 12px 14px 12px 42px; background: #f8fafc; border: 2px solid #f1f5f9; border-radius: 10px; font-size: 0.875rem; color: #1e293b; transition: all 0.2s; }
        .form-input:focus { background: white; border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

        .error-label { color: #ef4444; font-size: 0.75rem; margin-top: 5px; font-weight: 600; }

        .btn-action { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 10px; font-size: 0.9375rem; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-action:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .secondary-footer { margin-top: 24px; text-align: center; font-size: 0.875rem; color: #64748b; }
        .secondary-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }

        @media (max-width: 768px) { .brand-panel { display: none; } .form-panel { padding: 20px; } }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="brand-panel">
            <div class="brand-header">
                <div class="logo-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h1 class="brand-title">Bergabung <br>dengan Kami</h1>
                <p class="brand-desc">Jadilah bagian dari ekosistem manajemen alat tercanggih. Alat profesional untuk kebutuhan profesional Anda.</p>
            </div>

            <div class="brand-footer">
                <span>&copy; 2026 Solang Inc.</span>
            </div>
        </div>

        <div class="form-panel">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Buat Akun</h2>
                    <p>Daftarkan identitas Anda untuk mulai menggunakan sistem.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-box">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Nama Anda" required autofocus>
                                <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            @error('name') <div class="error-label">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Profesional</label>
                            <div class="input-box">
                                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required>
                                <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            @error('email') <div class="error-label">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <div class="input-group" style="position: relative;">
                                <div class="input-box">
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="08xxxxxxxxxx" required>
                                    <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                            </div>
                            @error('phone') <div class="error-label">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kata Sandi</label>
                            <div class="input-box">
                                <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter" required autocomplete="new-password">
                                <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            @error('password') <div class="error-label">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <div class="input-box">
                                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi sandi" required>
                                <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-action">
                        <span>Daftar Sekarang</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </form>

                <div class="secondary-footer">
                    Sudah terdaftar? <a href="{{ route('login') }}">Masuk Portal</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
