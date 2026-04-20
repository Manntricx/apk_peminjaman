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
            --primary: #3b82f6;
            --primary-glow: rgba(59, 130, 246, 0.5);
            --accent: #06b6d4;
            --bg-deep: #020617;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-glass: rgba(255, 255, 255, 0.03);
            --input-bg: rgba(255, 255, 255, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            background: var(--bg-deep);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background Elements */
        .ambient-glow {
            position: fixed;
            width: 50vw;
            height: 50vw;
            border-radius: 50%;
            background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
            animation: move 20s infinite alternate ease-in-out;
        }

        .glow-1 { top: -10%; right: -10%; }
        .glow-2 { bottom: -10%; left: -10%; background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, transparent 70%); }

        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(-5%, -10%); }
        }

        .auth-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: var(--card-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 32px;
        }

        .logo-box {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .logo-box svg { width: 24px; height: 24px; color: white; }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin-bottom: 6px;
            background: linear-gradient(to bottom right, #fff 30%, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.9375rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group.full { grid-column: span 2; }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-box { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: var(--input-bg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            color: white;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-input:focus + .input-icon { color: var(--primary); }

        .error-label {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .btn-submit {
            grid-column: span 2;
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 12px;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
            filter: brightness(1.1);
        }

        .auth-footer {
            margin-top: 32px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9375rem;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .auth-card {
                max-width: 90%;
                padding: 32px;
            }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full, .btn-submit { grid-column: span 1; }
            .ambient-glow { width: 70vw; height: 70vw; }
        }

        @media (max-width: 480px) {
            body { 
                padding: 20px; 
                display: flex;
                align-items: flex-start;
            }
            .auth-card {
                max-width: 100%;
                padding: 24px;
                border: none;
                background: transparent;
                backdrop-filter: none;
                box-shadow: none;
            }
            .auth-header h2 { font-size: 1.5rem; }
            .ambient-glow { display: none; }
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="logo-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
            </div>

            <div class="auth-header">
                <h2>Bergabung Sekarang</h2>
                <p>Mulai pengalaman peminjaman alat yang lebih profesional.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-box">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Masukkan nama lengkap" required autofocus>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        @error('name') <div class="error-label">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Profesional</label>
                        <div class="input-box">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@instansi.com" required>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        @error('email') <div class="error-label">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <div class="input-box">
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="08xxxxxxxxxx" required>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
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
                        <label class="form-label">Konfirmasi Sandi</label>
                        <div class="input-box">
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi sandi" required>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Daftar Akun</span>
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk Portal</a>
            </div>
        </div>
    </div>

</body>
</html>
