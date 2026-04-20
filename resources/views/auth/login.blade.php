<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solang — Masuk ke Sistem</title>
    <meta name="description" content="Portal masuk aman sistem peminjaman Solang.">
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
            padding: 60px; /* Reduced from 80px */
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
            width: 52px; /* Reduced from 64px */
            height: 52px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .logo-box svg { width: 26px; height: 26px; color: white; }

        .brand-title {
            font-size: 3rem; /* Reduced from 4rem */
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 16px;
            background: linear-gradient(to bottom right, #ffffff 10%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-desc {
            font-size: 1rem; /* Reduced from 1.25rem */
            color: var(--text-muted);
            line-height: 1.5;
            max-width: 380px;
        }

        .brand-footer {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            gap: 20px;
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
        }

        .auth-card {
            width: 100%;
            max-width: 380px; /* Reduced from 440px */
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            margin-bottom: 30px;
        }

        .auth-header h2 {
            font-size: 1.8rem; /* Reduced from 2.5rem */
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .auth-header p {
            font-size: 0.9375rem;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 18px; /* Reduced from 24px */
        }

        .form-label {
            display: block;
            font-size: 0.75rem; /* Reduced from 0.875rem */
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px; /* Reduced from 16px */
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #1e293b;
            transition: all 0.2s;
        }

        .form-input:focus {
            background: white;
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* CAPTCHA */
        .captcha-container {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }

        .captcha-view {
            background: #ffffff;
            color: var(--primary);
            font-weight: 800;
            font-size: 1.125rem;
            padding: 6px 14px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            letter-spacing: 1px;
        }

        .captcha-hint {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }

        .error-label {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 6px;
            font-weight: 600;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .check-group {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.8125rem;
            color: #64748b;
        }

        .check-group input {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .link-helper {
            font-size: 0.8125rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .btn-action {
            width: 100%;
            padding: 14px; /* Reduced from 18px */
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-action:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .secondary-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        .secondary-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .brand-panel { display: none; }
            .form-panel { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <!-- PANEL KIRI -->
        <div class="brand-panel">
            <div class="brand-header">
                <div class="logo-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h1 class="brand-title">Portal <br>Masuk Solang</h1>
                <p class="brand-desc">Sistem terpadu pengelolaan, pelacakan, dan operasional peminjaman alat dalam satu platform profesional.</p>
            </div>

            <div class="brand-footer">
                <span>&copy; 2026 Solang Inc.</span>
                <span>Kebijakan Privasi</span>
            </div>
        </div>

        <!-- PANEL FORM -->
        <div class="form-panel">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Selamat Datang</h2>
                    <p>Masukkan kredensial Anda untuk mengakses sistem.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <div class="input-box">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="email@solang.com" required autofocus>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        @error('email') <div class="error-label">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-box">
                            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        @error('password') <div class="error-label">{{ $message }}</div> @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div class="form-group">
                        <label class="form-label">Verifikasi Keamanan</label>
                        <div class="captcha-container">
                            <div class="captcha-view">{{ $num1 }} + {{ $num2 }}</div>
                            <div class="captcha-hint">Selesaikan perhitungan di samping.</div>
                        </div>
                        <div class="input-box">
                            <input type="number" name="captcha" class="form-input" placeholder="Hasil" required>
                            <svg class="input-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        @error('captcha') <div class="error-label">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-footer">
                        <label class="check-group">
                            <input type="checkbox" name="remember">
                            <span>Ingat Sesi Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-helper">Lupa Sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-action">
                        <span>Masuk ke Akun</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

                <div class="secondary-footer">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
