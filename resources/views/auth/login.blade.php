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
            overflow-y: auto;
            padding: 40px 20px;
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

        .glow-1 { top: -10%; left: -10%; }
        .glow-2 { bottom: -10%; right: -10%; background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, transparent 70%); }

        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(5%, 10%); }
        }

        .auth-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            z-index: 10;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
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

        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-box { position: relative; }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: var(--input-bg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: white;
            font-size: 0.9375rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .form-input:focus + .input-icon { color: var(--primary); }

        /* CAPTCHA Styles */
        .captcha-container {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 12px;
        }

        .captcha-view {
            background: var(--primary);
            color: white;
            font-weight: 800;
            font-size: 1.125rem;
            padding: 6px 16px;
            border-radius: 8px;
            letter-spacing: 2px;
        }

        .captcha-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .error-label {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 8px;
            font-weight: 500;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .check-group {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .check-group input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            accent-color: var(--primary);
        }

        .link-helper {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .link-helper:hover { text-decoration: underline; }

        .btn-submit {
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
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
            filter: brightness(1.1);
        }

        .btn-submit:active { transform: translateY(0); }

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

        /* Alphanumeric Captcha Styles */
        .captcha-wrapper {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 12px;
        }

        .captcha-display {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--primary);
            letter-spacing: 6px;
            user-select: none;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(59, 130, 246, 0.2);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .captcha-display::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(-5deg);
        }

        .captcha-hint {
            font-size: 0.7rem;
            color: var(--text-muted);
            line-height: 1.3;
            max-width: 140px;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .auth-card {
                max-width: 90%;
                padding: 32px;
            }
            .ambient-glow { width: 70vw; height: 70vw; }
        }

        @media (max-width: 480px) {
            body { 
                padding: 20px; 
                display: flex;
                align-items: flex-start; /* Better for long content on mobile */
            }
            .auth-card {
                max-width: 100%;
                padding: 24px;
                border: none;
                background: transparent;
                backdrop-filter: none;
                box-shadow: none;
                animation: fadeInMobile 0.5s ease;
            }
            @keyframes fadeInMobile {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
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
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
            </div>

            <div class="auth-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk melanjutkan akses.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-box">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="name@example.com" required autofocus>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    </div>
                    @error('email') <div class="error-label">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-box">
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    @error('password') <div class="error-label">{{ $message }}</div> @enderror
                </div>

                <!-- ALPHANUMERIC CAPTCHA -->
                <div class="form-group">
                    <label class="form-label">Verifikasi Keamanan</label>
                    <div class="captcha-wrapper">
                        <div class="captcha-display">{{ $captcha }}</div>
                        <div class="captcha-hint">Ketik ulang kode karakter di samping.</div>
                    </div>
                    <div class="input-box">
                        <input type="text" name="captcha" class="form-input" placeholder="Masukkan kode captcha" required autocomplete="off">
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    @error('captcha') <div class="error-label">{{ $message }}</div> @enderror
                </div>

                <div class="form-options">
                    <label class="check-group">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-helper">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Akun</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

</body>
</html>
