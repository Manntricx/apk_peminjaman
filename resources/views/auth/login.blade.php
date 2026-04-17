<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solang — Masuk ke Akun Anda</title>
    <meta name="description" content="Login ke portal peminjaman alat Solang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary: #64748b;
            --bg-dark: #0f172a;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ===== LEFT PANEL ===== */
        .panel-left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            color: white;
            background-image: url('/assets/images/login-bg.png');
            background-size: cover;
            background-position: center;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(37, 99, 235, 0.4) 100%);
            z-index: 1;
        }

        .brand-content {
            position: relative;
            z-index: 10;
            max-width: 480px;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .brand-logo svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .brand-name {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 16px;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-tagline {
            font-size: 1.125rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 48px;
            font-weight: 400;
        }

        .features {
            display: grid;
            gap: 24px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-icon svg {
            width: 20px;
            height: 20px;
            color: #60a5fa;
        }

        .feature-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .feature-info p {
            font-size: 0.875rem;
            opacity: 0.7;
            line-height: 1.5;
        }

        /* ===== RIGHT PANEL ===== */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--bg-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--bg-dark);
            margin-bottom: 8px;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-dark);
            transition: all 0.2s;
        }

        .form-input:focus {
            background: white;
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-input:focus + .input-icon {
            color: var(--primary);
        }

        .input-error {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ef4444;
            font-size: 0.8125rem;
            margin-top: 8px;
            font-weight: 500;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-muted);
            user-select: none;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            accent-color: var(--primary);
        }

        .forgot-password {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Role Badges */
        .role-section {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .role-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .role-badges {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .role-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 99px;
            font-size: 0.8125rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .rb-admin { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
        .rb-petugas { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
        .rb-peminjam { background: #faf5ff; color: #6b21a8; border: 1px solid #f3e8ff; }

        .register-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 0.9375rem;
            color: var(--text-muted);
        }

        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        /* Alert Styles */
        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease-out;
        }

        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #d1fae5; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .panel-left { padding: 40px; }
            .brand-name { font-size: 2.75rem; }
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .panel-left { display: none; }
            .panel-right { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="panel-left">
        <div class="brand-content">
            <div class="brand-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-3.586a1 1 0 00-.707.293l-2.707 2.707a1 1 0 01-.707.293H10.586a1 1 0 01-.707-.293L7.172 13.293a1 1 0 00-.707-.293H3"/>
                </svg>
            </div>
            <h1 class="brand-name">Solang</h1>
            <p class="brand-tagline">Solusi pengelolaan peminjaman alat yang efisien, modern, dan sepenuhnya terintegrasi untuk kebutuhan operasional Anda.</p>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div class="feature-info">
                        <h4>Inventaris Real-time</h4>
                        <p>Pantau ketersediaan seluruh alat secara akurat dalam satu dasbor pusat.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="feature-info">
                        <h4>Workflow Persetujuan</h4>
                        <p>Proses pengajuan dan approval yang cepat dan transparan antara peminjam dan petugas.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="feature-info">
                        <h4>Laporan Otomatis</h4>
                        <p>Dapatkan data statistik dan laporan riwayat peminjaman yang lengkap secara instan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
        <div class="login-card">
            <div class="login-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk mengakses Portal Solang.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-group">
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@perusahaan.com" required autofocus>
                    </div>
                    @error('email')
                        <div class="input-error">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-group">
                        <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input id="password" type="password" name="password" class="form-input" placeholder="Masukkan kata sandi" required>
                    </div>
                    @error('password')
                        <div class="input-error">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span>Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Akun</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                </button>
            </form>

            <div class="role-section">
                <p class="role-title">Akses Tersedia</p>
                <div class="role-badges">
                    <span class="role-badge rb-admin">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/></svg>
                        Admin
                    </span>
                    <span class="role-badge rb-petugas">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-3.076 9.168-7.422 10.82a1 1 0 01-.756 0c-4.346-1.652-7.422-5.874-7.422-10.82 0-.682.057-1.35.166-2.001zM9 11a1 1 0 102 0V7a1 1 0 10-2 0v4z" clip-rule="evenodd"/></svg>
                        Petugas
                    </span>
                    <span class="role-badge rb-peminjam">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                        Peminjam
                    </span>
                </div>
            </div>

            @if (Route::has('register'))
            <div class="register-footer">
                Belum memiliki akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
            @endif
        </div>
    </div>

</body>
</html>
