<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Solang' }} — Portal Peminjam</title>
    <meta name="description" content="Portal peminjaman alat online Solang — mudah, cepat, dan transparan.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* =============================================
           SOLANG — Portal Peminjam Premium Theme
           ============================================= */
        :root {
            --blue-400:  #60a5fa;
            --blue-500:  #3b82f6;
            --blue-600:  #2563eb;
            --cyan-400:  #22d3ee;
            --green-400: #34d399;
            --orange-400:#fbbf24;
            --red-400:   #f87171;

            --bg-base:    #060d1f;
            --bg-surface: #0c1628;
            --bg-card:    #111e35;
            --bg-card-h:  #162440;

            --text-primary:   #e8eeff;
            --text-secondary: #7a9cc4;
            --text-muted:     #3d5270;

            --border:        rgba(59,130,246,0.12);
            --border-strong: rgba(59,130,246,0.28);
            --glow:          rgba(59,130,246,0.22);
            --glow-sm:       rgba(59,130,246,0.14);

            --nav-h: 70px;
            --content-max: 1280px;
            --radius: 14px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ── Scrollbar ─────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(59,130,246,0.25); border-radius: 99px; }

        /* ── NAVBAR ────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 200;
            height: var(--nav-h);
            background: rgba(11,20,40,0.85);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
        .navbar-inner {
            max-width: var(--content-max);
            margin: 0 auto;
            padding: 0 28px;
            height: 100%;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px;
        }

        /* Brand */
        .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex-shrink: 0;
        }
        .brand-logo-container {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 14px var(--glow);
        }
        .brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.1);
        }
        .brand-name {
            font-size: 1.2rem; font-weight: 800;
            color: var(--text-primary); letter-spacing: -0.4px;
        }
        .brand-name span { color: var(--blue-400); }

        /* Nav Links */
        .navbar-center { display: flex; gap: 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 7px;
            padding: 9px 15px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 600;
            color: var(--text-secondary); text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .nav-link svg { width: 16px; height: 16px; }
        .nav-link:hover {
            color: var(--blue-400);
            background: rgba(59,130,246,0.08);
            border-color: var(--border);
        }
        .nav-link.active {
            color: var(--blue-400);
            background: rgba(59,130,246,0.12);
            border-color: var(--border-strong);
        }

        /* User Area */
        .navbar-end { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

        .user-pill {
            display: flex; align-items: center; gap: 9px;
            padding: 5px 12px 5px 5px;
            background: rgba(59,130,246,0.07);
            border: 1px solid var(--border);
            border-radius: 99px; text-decoration: none;
            transition: all 0.2s;
        }
        .user-pill:hover { background: rgba(59,130,246,0.14); border-color: var(--border-strong); }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-500), #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.78rem; color: #fff;
            box-shadow: 0 2px 10px var(--glow-sm);
            flex-shrink: 0;
        }
        .user-details { display: none; }
        .user-name { font-size: 0.8rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; }
        .user-role { font-size: 0.65rem; color: var(--blue-400); font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
        @media (min-width: 640px) { .user-details { display: block; } }

        .btn-logout-icon {
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: var(--red-400); cursor: pointer; transition: all 0.2s;
        }
        .btn-logout-icon:hover { background: rgba(239,68,68,0.18); border-color: rgba(239,68,68,0.35); }
        .btn-logout-icon svg { width: 17px; height: 17px; }

        /* ── HERO TOPBAR ───────────────────────── */
        .page-hero {
            background: linear-gradient(135deg, #0c1a38 0%, #091426 60%, #060d1f 100%);
            border-bottom: 1px solid var(--border);
            padding: 28px 28px 24px;
            position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute; top: -60px; right: -60px;
            width: 260px; height: 260px; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.12), transparent 70%);
            pointer-events: none;
        }
        .page-hero-inner {
            max-width: var(--content-max);
            margin: 0 auto;
            position: relative; z-index: 1;
        }
        .page-hero h1 {
            font-size: 1.6rem; font-weight: 800;
            color: var(--text-primary); letter-spacing: -0.5px; margin-bottom: 4px;
        }
        .page-hero p { font-size: 0.85rem; color: var(--text-secondary); }

        /* ── MAIN CONTAINER ────────────────────── */
        .main-container {
            max-width: var(--content-max);
            margin: 0 auto;
            padding: 28px 28px 100px;
        }

        /* ── STATS GRID ────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 18px;
            display: flex; align-items: center; gap: 16px;
            transition: all 0.25s; position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(59,130,246,0.04), transparent 65%);
            pointer-events: none;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--border-strong);
            box-shadow: 0 12px 30px rgba(0,0,0,0.35);
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.blue   { background: rgba(59,130,246,0.14); color: var(--blue-400); box-shadow: 0 4px 14px rgba(59,130,246,0.14); }
        .stat-icon.green  { background: rgba(16,185,129,0.14); color: var(--green-400); box-shadow: 0 4px 14px rgba(16,185,129,0.14); }
        .stat-icon.orange { background: rgba(245,158,11,0.14); color: var(--orange-400); box-shadow: 0 4px 14px rgba(245,158,11,0.14); }
        .stat-icon.red    { background: rgba(239,68,68,0.14);  color: var(--red-400); box-shadow: 0 4px 14px rgba(239,68,68,0.14); }
        .stat-icon.cyan   { background: rgba(6,182,212,0.14);  color: var(--cyan-400); box-shadow: 0 4px 14px rgba(6,182,212,0.14); }
        .stat-icon.purple { background: rgba(139,92,246,0.14); color: #a78bfa; box-shadow: 0 4px 14px rgba(139,92,246,0.14); }

        .stat-info .value {
            font-size: 1.55rem; font-weight: 800;
            color: var(--text-primary); line-height: 1;
        }
        .stat-info .label {
            font-size: 0.75rem; font-weight: 600;
            color: var(--text-secondary); margin-top: 4px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* ── CARD ──────────────────────────────── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius); overflow: hidden;
            margin-bottom: 20px;
        }
        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(59,130,246,0.03);
        }
        .card-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
        .card-subtitle { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }
        .card-body { padding: 22px; }

        /* Card Action / Link Button */
        .card-action, .btn-sm-link {
            font-size: 0.78rem; font-weight: 600; color: var(--blue-400);
            text-decoration: none; padding: 6px 14px;
            background: rgba(59,130,246,0.1); border: 1px solid var(--border);
            border-radius: 8px; transition: all 0.2s;
        }
        .card-action:hover, .btn-sm-link:hover { background: rgba(59,130,246,0.2); border-color: var(--border-strong); }

        /* ── TABLE ─────────────────────────────── */
        .table-responsive { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            padding: 13px 16px; text-align: left;
            font-size: 0.67rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;
            color: var(--text-muted); border-bottom: 1px solid var(--border);
            background: rgba(59,130,246,0.04);
        }
        .data-table td {
            padding: 15px 16px; font-size: 0.85rem;
            color: var(--text-primary); border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }
        .data-table tbody tr:hover td { background: rgba(59,130,246,0.04); }
        .data-table tr:last-child td { border-bottom: none; }

        /* ── BADGES ────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 99px;
            font-size: 0.66rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
        }
        .badge-pending { background: rgba(245,158,11,0.14); color: var(--orange-400); border: 1px solid rgba(245,158,11,0.28); }
        .badge-aktif   { background: rgba(59,130,246,0.14); color: var(--blue-400);   border: 1px solid rgba(59,130,246,0.28); }
        .badge-selesai { background: rgba(16,185,129,0.14); color: var(--green-400);  border: 1px solid rgba(16,185,129,0.28); }
        .badge-danger  { background: rgba(239,68,68,0.14);  color: var(--red-400);    border: 1px solid rgba(239,68,68,0.28); }
        .badge-info    { background: rgba(6,182,212,0.14);  color: var(--cyan-400);   border: 1px solid rgba(6,182,212,0.28); }

        /* ── BUTTONS ───────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 20px; border-radius: 10px;
            font-size: 0.875rem; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: all 0.2s;
            border: 1px solid transparent; text-decoration: none;
        }
        .btn svg { width: 17px; height: 17px; flex-shrink: 0; }
        .btn-primary {
            background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
            color: #fff; border-color: var(--blue-600);
            box-shadow: 0 4px 18px var(--glow);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px var(--glow); }
        .btn-outline {
            background: rgba(255,255,255,0.04); border-color: var(--border);
            color: var(--text-secondary);
        }
        .btn-outline:hover { background: rgba(255,255,255,0.08); color: var(--text-primary); border-color: var(--border-strong); }
        .btn-danger {
            background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.25);
            color: var(--red-400);
        }
        .btn-danger:hover { background: rgba(239,68,68,0.2); }
        .btn-sm { padding: 8px 14px; font-size: 0.8rem; }
        .btn-xs { padding: 5px 12px; font-size: 0.75rem; border-radius: 8px; }

        /* ── FORM CONTROLS ─────────────────────── */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 0.82rem; font-weight: 600;
            color: #a0b4d0; margin-bottom: 8px; letter-spacing: 0.2px;
        }
        .form-control {
            width: 100%; padding: 12px 16px;
            background: rgba(59,130,246,0.05) !important;
            border: 1px solid rgba(59,130,246,0.15) !important;
            color: var(--text-primary) !important;
            border-radius: 10px; font-family: inherit; font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--blue-500) !important; outline: none;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.18);
            background: rgba(59,130,246,0.08) !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-error { color: var(--red-400); font-size: 0.78rem; margin-top: 5px; }

        /* ── ALERTS ────────────────────────────── */
        .alert {
            padding: 14px 18px; border-radius: 12px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 12px;
            font-size: 0.855rem; font-weight: 600;
        }
        .alert svg { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-success { background: rgba(16,185,129,0.1); color: var(--green-400); border: 1px solid rgba(16,185,129,0.25); }
        .alert-error   { background: rgba(239,68,68,0.1);  color: var(--red-400);   border: 1px solid rgba(239,68,68,0.25); }
        .alert-info    { background: rgba(59,130,246,0.1); color: var(--blue-400);  border: 1px solid rgba(59,130,246,0.25); }
        .alert-warning { background: rgba(245,158,11,0.1); color: var(--orange-400);border: 1px solid rgba(245,158,11,0.25); }

        /* ── ICON CIRCLE ───────────────────────── */
        .icon-circle {
            width: 52px; height: 52px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .icon-circle svg { width: 24px; height: 24px; }
        .icon-circle.blue   { background: rgba(59,130,246,0.12); color: var(--blue-400); }
        .icon-circle.green  { background: rgba(16,185,129,0.12); color: var(--green-400); }
        .icon-circle.orange { background: rgba(245,158,11,0.12); color: var(--orange-400); }
        .icon-circle.red    { background: rgba(239,68,68,0.12);  color: var(--red-400); }

        /* ── PAGINATION ────────────────────────── */
        nav[role="navigation"] { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
        nav[role="navigation"] a, nav[role="navigation"] span span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 34px; height: 34px; padding: 0 8px;
            border-radius: 8px; font-size: 0.8rem; font-weight: 600;
            border: 1px solid var(--border); color: var(--text-secondary);
            background: rgba(255,255,255,0.02); text-decoration: none;
            transition: all 0.15s;
        }
        nav[role="navigation"] a:hover { background: rgba(59,130,246,0.12); color: var(--blue-400); border-color: var(--border-strong); }
        nav[role="navigation"] span[aria-current] span { background: var(--blue-600); color: #fff; border-color: var(--blue-600); }
        nav[role="navigation"] svg { width: 14px; height: 14px; }

        /* ── BOTTOM NAV (Mobile) ───────────────── */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0;
            height: 64px;
            background: rgba(11,22,45,0.95);
            border-top: 1px solid var(--border);
            backdrop-filter: blur(14px);
            display: none;
            grid-template-columns: repeat(4, 1fr);
            z-index: 500;
            padding-bottom: env(safe-area-inset-bottom);
        }
        .bnav-link {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px;
            color: var(--text-muted); text-decoration: none;
            font-size: 0.6rem; font-weight: 700; letter-spacing: 0.3px;
            transition: color 0.2s; position: relative;
        }
        .bnav-link svg { width: 22px; height: 22px; }
        .bnav-link.active { color: var(--blue-400); }
        .bnav-link.active::before {
            content: '';
            position: absolute; top: 0; left: 25%; right: 25%; height: 2px;
            background: var(--blue-500); border-radius: 0 0 3px 3px;
        }

        /* ── EMPTY STATE ───────────────────────── */
        .empty-state {
            text-align: center; padding: 52px 20px;
        }
        .empty-state-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: rgba(59,130,246,0.08); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; color: var(--text-muted);
        }
        .empty-state-icon svg { width: 30px; height: 30px; }
        .empty-state p { color: var(--text-muted); font-size: 0.875rem; }

        /* ── RESPONSIVE ────────────────────────── */
        @media (max-width: 768px) {
            .navbar-center { display: none; }
            .bottom-nav { display: grid; }
            .main-container { padding: 20px 16px 84px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .page-hero { padding: 20px 16px 18px; }
            .page-hero h1 { font-size: 1.3rem; }
        }
        @media (max-width: 480px) {
            .navbar-inner { padding: 0 16px; }
            .stats-grid { grid-template-columns: 1fr; }
            .user-name { display: none; }
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar">
        <div class="navbar-inner">
            {{-- Brand --}}
            <a href="{{ route('peminjam.dashboard') }}" class="navbar-brand">
                <div class="brand-logo-container">
                    <img src="{{ asset('image/logo s.png') }}" class="brand-logo-img" alt="Logo">
                </div>
                <span class="brand-name">So<span>lang</span></span>
            </a>

            {{-- Center Nav --}}
            <div class="navbar-center">
                <a href="{{ route('peminjam.dashboard') }}" class="nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Beranda
                </a>
                <a href="{{ route('peminjam.alats') }}" class="nav-link {{ request()->routeIs('peminjam.alats') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Daftar Alat
                </a>
                <a href="{{ route('peminjam.peminjamans.index') }}" class="nav-link {{ request()->routeIs('peminjam.peminjamans*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pinjaman Saya
                </a>
                <a href="{{ route('peminjam.pengembalians.index') }}" class="nav-link {{ request()->routeIs('peminjam.pengembalians*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Pengembalian
                </a>
            </div>

            {{-- End --}}
            <div class="navbar-end">
                <a href="{{ route('profile.edit') }}" class="user-pill">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Peminjam</div>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-icon" title="Keluar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ===== MOBILE BOTTOM NAV ===== --}}
    <nav class="bottom-nav">
        <a href="{{ route('peminjam.dashboard') }}" class="bnav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>Beranda</span>
        </a>
        <a href="{{ route('peminjam.alats') }}" class="bnav-link {{ request()->routeIs('peminjam.alats') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span>Alat</span>
        </a>
        <a href="{{ route('peminjam.peminjamans.index') }}" class="bnav-link {{ request()->routeIs('peminjam.peminjamans*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>Pinjaman</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="bnav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Profil</span>
        </a>
    </nav>

    {{-- ===== CONTENT ===== --}}
    <main class="main-container">
        {{ $slot }}
    </main>

</body>
</html>
