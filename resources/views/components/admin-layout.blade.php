@props([
    'pageTitle' => 'Dashboard',
    'pageBreadcrumb' => 'Admin Panel',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} – {{ config('app.name', 'SiPinjam') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f0f4ff; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 260px; height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e3a8a 60%, #1d4ed8 100%);
            display: flex; flex-direction: column;
            z-index: 100; transition: transform 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.25);
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
        .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand-title { font-size: 1.35rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .sidebar-brand-title span { color: #93c5fd; }
        .sidebar-brand-sub { font-size: 0.72rem; color: rgba(255,255,255,0.45); margin-top: 2px; letter-spacing: 0.5px; }
        
        .sidebar-user {
            margin: 16px 16px 8px;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 14px 16px;
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; font-weight: 700; color: #fff;
            flex-shrink: 0; border: 2px solid rgba(255,255,255,0.3);
        }
        .sidebar-user-name { font-size: 0.85rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-role { font-size: 0.65rem; font-weight: 500; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 2px; }

        .sidebar-nav { 
            flex: 1; 
            padding: 12px; 
            overflow-y: auto; 
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .sidebar-nav::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
        .nav-section-label { font-size: 0.6rem; font-weight: 700; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1.2px; padding: 12px 12px 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px;
            border-radius: 10px; color: rgba(255,255,255,0.7); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; transition: all 0.2s ease; margin-bottom: 2px; cursor: pointer;
        }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; transform: translateX(3px); }
        .nav-item.active { background: rgba(255,255,255,0.18); color: #fff; font-weight: 600; box-shadow: inset 3px 0 0 #60a5fa; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-footer { padding: 12px; border-top: 1px solid rgba(255,255,255,0.1); }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed; top: 0; left: 260px; right: 0; height: 68px;
            background: #fff; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 90;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; }
        .topbar-breadcrumb { font-size: 0.78rem; color: #94a3b8; margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-icon-btn { width: 38px; height: 38px; border-radius: 50%; background: #f1f5f9; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.2s; }
        .topbar-icon-btn:hover { background: #e2e8f0; color: #1e40af; }
        .topbar-user { display: flex; align-items: center; gap: 10px; padding: 6px 12px; border-radius: 999px; background: #f8fafc; border: 1px solid #e2e8f0; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .topbar-user:hover { background: #eff6ff; border-color: #bfdbfe; }
        .topbar-user-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #fff; }
        .topbar-user-name { font-size: 0.8rem; font-weight: 600; color: #334155; }

        /* ===== MAIN ===== */
        .main-wrapper { margin-left: 260px; margin-top: 68px; padding: 28px; min-height: calc(100vh - 68px); }

        /* ===== KPI CARDS ===== */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: #fff; border-radius: 16px; padding: 22px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 18px; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .stat-icon { width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 26px; height: 26px; }
        .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
        .stat-icon.green  { background: #f0fdf4; color: #16a34a; }
        .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-icon.purple { background: #faf5ff; color: #9333ea; }
        .stat-value { font-size: 1.7rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .stat-label { font-size: 0.78rem; color: #94a3b8; margin-top: 4px; font-weight: 500; }
        .stat-trend { font-size: 0.72rem; margin-top: 6px; font-weight: 600; }
        .stat-trend.up { color: #16a34a; }
        .stat-trend.neutral { color: #64748b; }

        /* ===== CARDS ===== */
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; overflow: hidden; }
        .card-header { padding: 20px 24px 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; }
        .card-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; }
        .card-subtitle { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }
        .card-action { font-size: 0.78rem; color: #3b82f6; font-weight: 600; text-decoration: none; padding: 6px 12px; border-radius: 8px; background: #eff6ff; transition: all 0.2s; }
        .card-action:hover { background: #dbeafe; }
        .card-body { padding: 20px 24px; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; font-size: 0.72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; padding: 0 0 12px; border-bottom: 2px solid #f1f5f9; }
        .data-table td { padding: 12px 0; font-size: 0.82rem; color: #334155; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 0.7rem; font-weight: 600; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; }
        .badge-info    { background: #dbeafe; color: #1d4ed8; }

        /* Quick Actions */
        .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .quick-btn { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 12px; text-decoration: none; transition: all 0.2s; border: 1.5px solid transparent; }
        .quick-btn:hover { transform: translateY(-2px); }
        .quick-btn.blue   { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .quick-btn.green  { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .quick-btn.orange { background: #fff7ed; border-color: #fed7aa; color: #c2410c; }
        .quick-btn.purple { background: #faf5ff; border-color: #e9d5ff; color: #7c3aed; }
        .quick-btn.teal   { background: #f0fdfa; border-color: #99f6e4; color: #0f766e; }
        .quick-btn.red    { background: #fff1f2; border-color: #fecdd3; color: #be123c; }
        .quick-btn svg    { width: 18px; height: 18px; flex-shrink: 0; }
        .quick-btn-label  { font-size: 0.78rem; font-weight: 600; }

        /* Log */
        .log-item { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f8fafc; }
        .log-item:last-child { border-bottom: none; }
        .log-dot { width: 8px; height: 8px; border-radius: 50%; background: #3b82f6; margin-top: 6px; flex-shrink: 0; }
        .log-text { font-size: 0.8rem; color: #475569; line-height: 1.5; }
        .log-time { font-size: 0.7rem; color: #94a3b8; margin-top: 2px; }

        /* Toggle button */
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; color: #64748b; align-items: center; }

        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .content-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { left: 0; }
            .main-wrapper { margin-left: 0; }
            .sidebar-toggle { display: flex; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-title">Si<span>Pinjam</span></div>
        <div class="sidebar-brand-sub">Sistem Manajemen Peminjaman</div>
    </div>
    <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div>
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <div class="nav-section-label">Manajemen Data</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data User
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            Kategori Alat
        </a>
        <a href="{{ route('admin.alats.index') }}" class="nav-item {{ request()->routeIs('admin.alats*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data Alat
        </a>
        <div class="nav-section-label">Transaksi</div>
        <a href="{{ route('admin.peminjamans.index') }}" class="nav-item {{ request()->routeIs('admin.peminjamans*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Peminjaman
        </a>
        <a href="{{ route('admin.pengembalians.index') }}" class="nav-item {{ request()->routeIs('admin.pengembalians*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Pengembalian
        </a>
        <div class="nav-section-label">Sistem</div>
        <a href="#" class="nav-item {{ request()->routeIs('admin.log*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Log Aktifitas
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!-- TOPBAR -->
<header class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" id="sidebarToggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <div class="topbar-title">{{ $pageTitle }}</div>
            <div class="topbar-breadcrumb">{{ $pageBreadcrumb }}</div>
        </div>
    </div>
    <div class="topbar-right">
        <button class="topbar-icon-btn" title="Notifikasi">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </button>
        <a href="{{ route('profile.edit') }}" class="topbar-user">
            <div class="topbar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="topbar-user-name">{{ Auth::user()->name }}</div>
        </a>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="main-wrapper">
    {{ $slot }}
</main>

</body>
</html>
