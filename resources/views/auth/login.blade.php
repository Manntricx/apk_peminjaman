<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solang — Masuk ke Sistem</title>
    <meta name="description" content="Portal masuk aman sistem peminjaman Solang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .glow-1 {
            top: -10%;
            left: -10%;
        }

        .glow-2 {
            bottom: -10%;
            right: -10%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, transparent 70%);
        }

        @keyframes move {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(5%, 10%);
            }
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
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            perspective: 1000px;
        }

        .logo-wrapper {
            position: relative;
            width: 74px;
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            border: 1.5px solid rgba(59, 130, 246, 0.4);
            border-radius: 18px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.25);
            transition: all 0.5s;
            animation: logoFloat 6s infinite ease-in-out;
        }

        .logo-wrapper:hover {
            transform: rotateY(10deg) rotateX(10deg) scale(1.05);
            border-color: var(--primary);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6), 0 0 20px var(--primary-glow);
        }

        .main-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.15);
            z-index: 2;
        }

        .logo-glow {
            position: absolute;
            inset: -10px;
            background: var(--primary-glow);
            filter: blur(25px);
            opacity: 0.3;
            border-radius: 50%;
            z-index: 1;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

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

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-box {
            position: relative;
        }

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

        .form-input:focus+.input-icon {
            color: var(--primary);
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

        .link-helper:hover {
            text-decoration: underline;
        }

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

        .btn-submit:active {
            transform: translateY(0);
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

        .auth-footer a:hover {
            text-decoration: underline;
        }


        /* Responsive Improvements */
        @media (max-width: 768px) {
            .auth-card {
                max-width: 90%;
                padding: 32px;
            }

            .ambient-glow {
                width: 70vw;
                height: 70vw;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px;
                display: flex;
                align-items: flex-start;
                /* Better for long content on mobile */
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
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .auth-header h2 {
                font-size: 1.5rem;
            }

            .ambient-glow {
                display: none;
            }
        }

        /* reCAPTCHA centering */
        .recaptcha-center {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="logo-wrapper">
                    <img src="{{ asset('image/logo s.png') }}" class="main-logo" alt="Solang Logo">
                    <div class="logo-glow"></div>
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
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input"
                            placeholder="name@example.com" required autofocus>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    @error('email') <div class="error-label">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-box">
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    @error('password') <div class="error-label">{{ $message }}</div> @enderror
                </div>

                <!-- GOOGLE reCAPTCHA -->
                <div class="form-group">
                    <div class="recaptcha-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site') }}"
                            data-theme="dark"></div>
                    </div>
                    @error('g-recaptcha-response') <div class="error-label" style="text-align: center;">{{ $message }}
                    </div> @enderror
                </div>

                <div class="form-options">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-helper">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Akun</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

</body>

</html>