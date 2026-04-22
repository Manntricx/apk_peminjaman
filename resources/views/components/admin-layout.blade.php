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
    <title>{{ $pageTitle }} – {{ config('app.name', 'Solang') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* =============================================
           SOLANG PREMIUM BLUE THEME — Admin & Petugas
           ============================================= */
        :root {
            --sidebar-width: 265px;
            --sidebar-collapsed-width: 76px;
            --topbar-height: 68px;

            /* Blue Palette */
            --blue-50:  #eff6ff;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;

            /* Background layers */
            --bg-base:    #060d1f;   /* deepest navy */
            --bg-surface: #0d1526;   /* sidebar */
            --bg-content: #0f1a30;   /* body */
            --bg-card:    #152039;   /* card */
            --bg-card-h:  #1a2847;   /* card hover / topbar */

            /* Text */
            --text-primary: #e8eeff;
            --text-secondary: #8ca0c4;
            --text-muted:   #4e6080;

            /* Border */
            --border: rgba(59,130,246,0.12);
            --border-strong: rgba(59,130,246,0.25);

            /* Accent glow */
            --glow: rgba(59,130,246,0.2);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-content);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ─── Scrollbar ─────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(59,130,246,0.25); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(59,130,246,0.45); }

        /* ─── SIDEBAR ───────────────────────────────── */
        .sidebar {
            position: fixed; inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            z-index: 1000;
            transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 40px rgba(0,0,0,0.4);
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); overflow: hidden; }

        /* Brand Header */
        .sidebar-header {
            height: var(--topbar-height);
            padding: 0 16px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .sidebar.collapsed .sidebar-header { padding: 0; justify-content: center; }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            white-space: nowrap; overflow: hidden;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .sidebar-brand { opacity: 1; pointer-events: auto; justify-content: center; width: 100%; margin: 0; }
        .sidebar.collapsed .brand-text { display: none; }
        .brand-logo-container {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            padding: 0;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
        }
        .brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.1);
        }
        .brand-text { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; }
        .brand-text span { color: var(--blue-400); }

        .btn-minimize {
            flex-shrink: 0;
            width: 30px; height: 30px; border-radius: 8px;
            background: rgba(59,130,246,0.08);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-minimize svg { width: 16px; height: 16px; transition: transform 0.3s; }
        .btn-minimize:hover { background: rgba(59,130,246,0.18); color: var(--blue-400); border-color: var(--border-strong); }
        .sidebar.collapsed .btn-minimize svg { transform: rotate(180deg); }
        .sidebar.collapsed .btn-minimize { margin: 0 auto; }

        /* User Card */
        .sidebar-user {
            margin: 14px;
            padding: 12px 14px;
            background: rgba(59,130,246,0.06);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0; overflow: hidden;
            transition: all 0.3s;
        }
        .sidebar.collapsed .sidebar-user { padding: 10px; justify-content: center; background: transparent; border-color: transparent; }
        .s-avatar {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.85rem; color: #fff;
            box-shadow: 0 4px 12px var(--glow);
        }
        .s-user-info { overflow: hidden; transition: opacity 0.2s; white-space: nowrap; }
        .sidebar.collapsed .s-user-info { display: none; }
        .s-user-name { font-size: 0.82rem; font-weight: 700; color: var(--text-primary); }
        .s-user-role { font-size: 0.68rem; color: var(--blue-400); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 1px; }

        /* Nav */
        .sidebar-nav { flex: 1; padding: 8px 12px; overflow-y: auto; overflow-x: hidden; }
        .nav-label {
            font-size: 0.6rem; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-muted);
            padding: 16px 10px 6px; white-space: nowrap;
            transition: opacity 0.2s, height 0.2s;
        }
        .sidebar.collapsed .nav-label { opacity: 0; height: 0; padding: 0; pointer-events: none; }

        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 11px 12px; border-radius: 10px;
            color: var(--text-secondary); font-size: 0.855rem; font-weight: 500;
            text-decoration: none; margin-bottom: 2px;
            transition: all 0.18s; white-space: nowrap;
            position: relative; overflow: hidden;
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(59,130,246,0.1); color: var(--blue-400); }
        .nav-item.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.2), rgba(59,130,246,0.06));
            color: var(--blue-400);
            border: 1px solid var(--border-strong);
            font-weight: 600;
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 0 3px 3px 0;
            background: var(--blue-500);
        }
        .nav-item-label { transition: opacity 0.2s; }
        .sidebar.collapsed .nav-item { justify-content: center; padding: 11px; }
        .sidebar.collapsed .nav-item-label { display: none; }

        /* Footer / Logout */
        .sidebar-footer { padding: 12px; border-top: 1px solid var(--border); flex-shrink: 0; }
        .btn-logout {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 11px 12px; border-radius: 10px;
            background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.12);
            color: #f87171; font-size: 0.855rem; font-weight: 600;
            cursor: pointer; text-align: left; white-space: nowrap;
            transition: all 0.18s;
        }
        .btn-logout svg { width: 18px; height: 18px; flex-shrink: 0; }
        .btn-logout:hover { background: rgba(239,68,68,0.14); border-color: rgba(239,68,68,0.3); }
        .sidebar.collapsed .btn-logout { justify-content: center; padding: 11px; background: transparent; border: none; }
        .sidebar.collapsed .btn-logout-label { display: none; }

        /* ─── CONTENT AREA ──────────────────────────── */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .sidebar.collapsed ~ .content-wrapper { margin-left: var(--sidebar-collapsed-width); }

        /* ─── TOPBAR ────────────────────────────────── */
        .topbar {
            height: var(--topbar-height);
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 900;
            box-shadow: 0 2px 20px rgba(0,0,0,0.25);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-page-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .topbar-breadcrumb { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }

        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .topbar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 12px 6px 6px;
            background: rgba(59,130,246,0.06);
            border: 1px solid var(--border);
            border-radius: 99px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-user:hover { background: rgba(59,130,246,0.12); border-color: var(--border-strong); }
        .topbar-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.8rem; color: #fff;
            box-shadow: 0 2px 8px var(--glow);
        }
        .topbar-username { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }

        .btn-mobile-menu {
            display: none;
            width: 38px; height: 38px; border-radius: 10px;
            align-items: center; justify-content: center;
            background: rgba(59,130,246,0.08); border: 1px solid var(--border);
            color: var(--text-secondary); cursor: pointer;
        }
        .btn-mobile-menu svg { width: 20px; height: 20px; }

        /* ─── MAIN CONTENT ──────────────────────────── */
        .main-content { padding: 28px 32px; min-height: calc(100vh - var(--topbar-height)); }

        /* ─── OVERLAY ───────────────────────────────── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 999;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { display: block; }

        /* ─── STATS GRID ─────────────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        @media (max-width: 1280px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 20px;
            display: flex; align-items: center; gap: 18px;
            transition: all 0.25s;
            position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(59,130,246,0.04), transparent 60%);
            pointer-events: none;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-strong);
            box-shadow: 0 16px 40px rgba(0,0,0,0.35), 0 0 0 1px var(--border-strong);
        }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-icon svg { width: 24px; height: 24px; }
        .stat-icon.blue   { background: rgba(59,130,246,0.15); color: var(--blue-400); box-shadow: 0 4px 16px rgba(59,130,246,0.15); }
        .stat-icon.cyan   { background: rgba(6,182,212,0.15);  color: #22d3ee; box-shadow: 0 4px 16px rgba(6,182,212,0.15); }
        .stat-icon.indigo { background: rgba(99,102,241,0.15); color: #818cf8; box-shadow: 0 4px 16px rgba(99,102,241,0.15); }
        .stat-icon.violet { background: rgba(139,92,246,0.15); color: #a78bfa; box-shadow: 0 4px 16px rgba(139,92,246,0.15); }
        .stat-icon.green  { background: rgba(16,185,129,0.15); color: #34d399; box-shadow: 0 4px 16px rgba(16,185,129,0.15); }
        .stat-icon.orange { background: rgba(245,158,11,0.15); color: #fbbf24; box-shadow: 0 4px 16px rgba(245,158,11,0.15); }
        .stat-icon.red    { background: rgba(239,68,68,0.15);  color: #f87171; box-shadow: 0 4px 16px rgba(239,68,68,0.15); }
        .stat-icon.purple { background: rgba(139,92,246,0.15); color: #a78bfa; box-shadow: 0 4px 16px rgba(139,92,246,0.15); }
        .stat-icon.teal   { background: rgba(20,184,166,0.15); color: #2dd4bf; box-shadow: 0 4px 16px rgba(20,184,166,0.15); }

        .stat-info {}
        .stat-value { font-size: 1.7rem; font-weight: 800; color: var(--text-primary); line-height: 1.1; }
        .stat-label { font-size: 0.78rem; color: var(--text-secondary); font-weight: 500; margin-top: 3px; }
        .stat-trend { font-size: 0.7rem; margin-top: 6px; font-weight: 600; color: var(--text-muted); }
        .stat-trend.up     { color: #34d399; }
        .stat-trend.down   { color: #f87171; }
        .stat-trend.orange { color: #fbbf24; }
        .stat-trend.blue   { color: var(--blue-400); }
        .stat-trend.red    { color: #f87171; }

        /* ─── CONTENT GRID ───────────────────────────── */
        .content-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; }
        @media (max-width: 1024px) { .content-grid { grid-template-columns: 1fr; } }

        /* ─── CARD ───────────────────────────────────── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
        }
        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(59,130,246,0.03);
        }
        .card-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
        .card-subtitle { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }
        .card-action {
            font-size: 0.78rem; font-weight: 600;
            color: var(--blue-400); text-decoration: none;
            padding: 5px 12px; border-radius: 8px;
            background: rgba(59,130,246,0.1); border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .card-action:hover { background: rgba(59,130,246,0.2); border-color: var(--border-strong); }
        .card-body { padding: 22px; }

        /* ─── TABLE ──────────────────────────────────── */
        .table-responsive { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            padding: 13px 14px; text-align: left;
            font-size: 0.68rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;
            color: var(--text-muted); border-bottom: 1px solid var(--border);
            background: rgba(59,130,246,0.04);
        }
        .data-table td {
            padding: 15px 14px; font-size: 0.855rem;
            color: var(--text-primary); border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }
        .data-table tbody tr:hover td { background: rgba(59,130,246,0.04); }
        .data-table tr:last-child td { border-bottom: none; }

        /* ─── BADGES ─────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 99px;
            font-size: 0.67rem; font-weight: 700; letter-spacing: 0.4px; text-transform: uppercase;
        }
        .badge-info    { background: rgba(59,130,246,0.15);  color: var(--blue-400);  border: 1px solid rgba(59,130,246,0.3); }
        .badge-success { background: rgba(16,185,129,0.15);  color: #34d399;  border: 1px solid rgba(16,185,129,0.3); }
        .badge-danger  { background: rgba(239,68,68,0.15);   color: #f87171;  border: 1px solid rgba(239,68,68,0.3); }
        .badge-warning { background: rgba(245,158,11,0.15);  color: #fbbf24;  border: 1px solid rgba(245,158,11,0.3); }
        .badge-aktif   { background: rgba(59,130,246,0.15);  color: var(--blue-400);  border: 1px solid rgba(59,130,246,0.3); }
        .badge-selesai { background: rgba(16,185,129,0.15);  color: #34d399;  border: 1px solid rgba(16,185,129,0.3); }
        .badge-pending { background: rgba(245,158,11,0.15);  color: #fbbf24;  border: 1px solid rgba(245,158,11,0.3); }

        /* ─── ACTION ICON BUTTONS ────────────────────── */
        .topbar-icon-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 34px; height: 34px; border-radius: 9px;
            background: rgba(255,255,255,0.05); border: 1px solid var(--border);
            color: var(--text-secondary); cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-icon-btn:hover { background: rgba(255,255,255,0.1); color: var(--text-primary); border-color: var(--border-strong); }
        .topbar-icon-btn svg { width: 15px; height: 15px; }
        /* Color variants for action buttons */
        .topbar-icon-btn[style*="#2563eb"], .topbar-icon-btn[style*="#eff6ff"],
        a.topbar-icon-btn[style*="#eff6ff"] { background: rgba(59,130,246,0.1) !important; color: var(--blue-400) !important; }
        .topbar-icon-btn[style*="#be123c"], .topbar-icon-btn[style*="#fff1f2"],
        .topbar-icon-btn[style*="#fff1f2"] { background: rgba(239,68,68,0.1) !important; color: #f87171 !important; }
        .topbar-icon-btn[style*="#16a34a"], .topbar-icon-btn[style*="#dcfce7"] { background: rgba(16,185,129,0.1) !important; color: #34d399 !important; }

        /* ─── QUICK ACTION GRID ──────────────────────── */
        .quick-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .quick-btn {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 18px 12px; border-radius: 13px;
            text-decoration: none; border: 1px solid transparent;
            transition: all 0.2s;
        }
        .quick-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .quick-btn svg { width: 22px; height: 22px; margin-bottom: 8px; }
        .quick-btn-label { font-size: 0.73rem; font-weight: 700; letter-spacing: 0.2px; }
        .quick-btn.blue   { background: rgba(59,130,246,0.1);  color: var(--blue-400); border-color: rgba(59,130,246,0.15); }
        .quick-btn.blue:hover { background: rgba(59,130,246,0.2); border-color: rgba(59,130,246,0.35); }
        .quick-btn.cyan   { background: rgba(6,182,212,0.1);   color: #22d3ee; border-color: rgba(6,182,212,0.15); }
        .quick-btn.cyan:hover { background: rgba(6,182,212,0.2); border-color: rgba(6,182,212,0.35); }
        .quick-btn.green  { background: rgba(16,185,129,0.1);  color: #34d399; border-color: rgba(16,185,129,0.15); }
        .quick-btn.green:hover { background: rgba(16,185,129,0.2); border-color: rgba(16,185,129,0.35); }
        .quick-btn.orange { background: rgba(245,158,11,0.1);  color: #fbbf24; border-color: rgba(245,158,11,0.15); }
        .quick-btn.orange:hover { background: rgba(245,158,11,0.2); border-color: rgba(245,158,11,0.35); }
        .quick-btn.indigo { background: rgba(99,102,241,0.1);  color: #818cf8; border-color: rgba(99,102,241,0.15); }
        .quick-btn.indigo:hover { background: rgba(99,102,241,0.2); }
        .quick-btn.teal   { background: rgba(20,184,166,0.1);  color: #2dd4bf; border-color: rgba(20,184,166,0.15); }
        .quick-btn.red    { background: rgba(239,68,68,0.1);   color: #f87171; border-color: rgba(239,68,68,0.15); }
        .quick-btn.red:hover { background: rgba(239,68,68,0.2); }

        /* ─── FORMS ──────────────────────────────────── */
        input, select, textarea {
            background: rgba(59,130,246,0.05) !important;
            border: 1px solid rgba(59,130,246,0.15) !important;
            color: var(--text-primary) !important;
            border-radius: 10px;
            padding: 11px 14px;
            font-family: inherit;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--blue-500) !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2) !important;
            background: rgba(59,130,246,0.08) !important;
        }
        input::placeholder, textarea::placeholder { color: var(--text-muted) !important; }
        select option { background: #152039; color: var(--text-primary); }

        /* ─── LABELS ─────────────────────────────────── */
        label,
        label[style*="color"],
        div[style*="color:#334155"], div[style*="color: #334155"],
        div[style*="color:#475569"], div[style*="color: #475569"],
        div[style*="color:#0f172a"], div[style*="color: #0f172a"],
        span[style*="color:#334155"], span[style*="color: #334155"],
        span[style*="color:#475569"], span[style*="color: #475569"],
        span[style*="color:#0f172a"], span[style*="color: #0f172a"],
        p[style*="color:#475569"], p[style*="color: #475569"],
        p[style*="color:#334155"], p[style*="color: #334155"],
        td[style*="color:#0f172a"], td[style*="color: #0f172a"],
        td[style*="color:#334155"], td[style*="color: #334155"],
        td[style*="color:#0369a1"], td[style*="color: #0369a1"],
        h4[style*="color:#0369a1"], h4[style*="color: #0369a1"],
        tr[style*="color:#0369a1"], tr[style*="color: #0369a1"],
        h1[style*="color:#0f172a"], h1[style*="color: #0f172a"],
        h2[style*="color:#0f172a"], h2[style*="color: #0f172a"] { color: var(--text-primary) !important; }

        div[style*="color: #94a3b8"],
        span[style*="color: #94a3b8"],
        p[style*="color: #94a3b8"],
        td[style*="color: #94a3b8"] { color: var(--text-secondary) !important; }

        div[style*="color: #1d4ed8"],
        td[style*="color: #1d4ed8"],
        span[style*="font-weight: 600; color: #1d4ed8"] { color: var(--blue-400) !important; }

        div[style*="color: #16a34a"],
        span[style*="color: #16a34a"],
        div[style*="color: #15803d"] { color: #34d399 !important; }

        div[style*="color: #0369a1"],
        span[style*="color: #0369a1"] { color: #22d3ee !important; }

        /* ─── LIGHT BG OVERRIDES ─────────────────────── */
        div[style*="background: #dcfce7"], div[style*="background: #d1fae5"],
        span[style*="background: #dcfce7"], span[style*="background: #d1fae5"] {
            background: rgba(16,185,129,0.1) !important;
            color: #6ee7b7 !important;
            border: 1px solid rgba(16,185,129,0.2) !important;
            border-radius: 10px !important;
        }
        div[style*="background: #eff6ff"], div[style*="background: #dbeafe"],
        span[style*="background: #eff6ff"], span[style*="background: #dbeafe"] {
            background: rgba(59,130,246,0.08) !important;
            border-color: rgba(59,130,246,0.2) !important;
        }
        div[style*="background: #fef2f2"], div[style*="background: #fee2e2"],
        span[style*="background: #fef2f2"], span[style*="background: #fee2e2"] {
            background: rgba(239,68,68,0.08) !important;
            border-color: rgba(239,68,68,0.2) !important;
        }
        div[style*="background: #f0f9ff"], span[style*="background: #f0f9ff"] {
            background: rgba(59,130,246,0.06) !important;
            border-color: rgba(59,130,246,0.15) !important;
        }
        .card[style*="background: #eff6ff"] {
            background: rgba(59,130,246,0.07) !important;
            border-color: rgba(59,130,246,0.2) !important;
        }

        /* Back/cancel buttons */
        a[style*="background: #f1f5f9"], button[style*="background: #f1f5f9"] {
            background: rgba(255,255,255,0.05) !important;
            color: var(--text-secondary) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px;
        }
        a[style*="background: #f1f5f9"]:hover { background: rgba(255,255,255,0.1) !important; color: var(--text-primary) !important; }

        /* Action icon button overrides */
        .topbar-icon-btn[style*="background: #f1f5f9"],
        .topbar-icon-btn[style*="background: #eff6ff"],
        .topbar-icon-btn[style*="background: #dcfce7"],
        .topbar-icon-btn[style*="background: #fff1f2"],
        a.topbar-icon-btn[style*="background: #f1f5f9"],
        a.topbar-icon-btn[style*="background: #eff6ff"] {
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid var(--border) !important;
        }

        /* ─── PAGINATION ─────────────────────────────── */
        nav[role="navigation"] { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        nav[role="navigation"] .flex { gap: 4px; }
        nav[role="navigation"] svg { width: 14px; height: 14px; }
        nav[role="navigation"] span[aria-current] span,
        nav[role="navigation"] a {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 34px; height: 34px; padding: 0 8px;
            border-radius: 8px; font-size: 0.8rem; font-weight: 600;
            border: 1px solid var(--border);
            color: var(--text-secondary); text-decoration: none;
            background: rgba(255,255,255,0.03);
            transition: all 0.15s;
        }
        nav[role="navigation"] a:hover { background: rgba(59,130,246,0.12); color: var(--blue-400); border-color: var(--border-strong); }
        nav[role="navigation"] span[aria-current] span { background: var(--blue-600); color: #fff; border-color: var(--blue-600); }

        /* ─── MOBILE RESPONSIVE ──────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); width: var(--sidebar-width); }
            .sidebar.mobile-open .sidebar-brand { opacity: 1; }
            .sidebar.mobile-open .s-user-info,
            .sidebar.mobile-open .nav-item-label,
            .sidebar.mobile-open .btn-logout-label { display: block; opacity: 1; }
            .sidebar.mobile-open .nav-label { opacity: 1; height: auto; padding: 16px 10px 6px; }
            .content-wrapper { margin-left: 0 !important; }
            .topbar { padding: 0 18px; }
            .topbar-breadcrumb { display: none; }
            .btn-mobile-menu { display: flex; }
            .main-content { padding: 20px 16px; }
        }
        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
            .topbar-username { display: none; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    {{-- Header --}}
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-logo-container">
                <img src="{{ asset('image/logo s.png') }}" class="brand-logo-img" alt="Logo">
            </div>
            <span class="brand-text">So<span>lang</span></span>
        </div>
        <button class="btn-minimize" id="btnMinimize" title="Minimize Sidebar">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
        </button>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="s-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="s-user-info">
            <div class="s-user-name">{{ Auth::user()->name }}</div>
            <div class="s-user-role">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="nav-label">Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span class="nav-item-label">Dashboard</span>
        </a>

        @if(Auth::user()->role === 'admin')
            <div class="nav-label">Manajemen</div>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="nav-item-label">Data User</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span class="nav-item-label">Kategori Alat</span>
            </a>
            <a href="{{ route('admin.alats.index') }}" class="nav-item {{ request()->routeIs('admin.alats*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="nav-item-label">Data Alat</span>
            </a>
            <div class="nav-label">Laporan</div>
            <a href="{{ route('admin.peminjamans.index') }}" class="nav-item {{ request()->routeIs('admin.peminjamans*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="nav-item-label">Peminjaman</span>
            </a>
            <a href="{{ route('admin.pengembalians.index') }}" class="nav-item {{ request()->routeIs('admin.pengembalians*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span class="nav-item-label">Pengembalian</span>
            </a>
            <a href="{{ route('admin.logs.index') }}" class="nav-item {{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="nav-item-label">Log Aktivitas</span>
            </a>
        @endif

        @if(Auth::user()->role === 'petugas')
            <div class="nav-label">Operasional</div>
            <a href="{{ route('petugas.peminjamans.index') }}" class="nav-item {{ request()->routeIs('petugas.peminjamans*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="nav-item-label">Persetujuan</span>
            </a>
            <a href="{{ route('petugas.pengembalians.index') }}" class="nav-item {{ request()->routeIs('petugas.pengembalians*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span class="nav-item-label">Pengembalian</span>
            </a>
            <a href="{{ route('petugas.laporan.index') }}" class="nav-item {{ request()->routeIs('petugas.laporan*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span class="nav-item-label">Laporan</span>
            </a>
        @endif
    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="btn-logout-label">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- MAIN CONTENT AREA --}}
<div class="content-wrapper" id="contentWrapper">

    {{-- TOPBAR --}}
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn-mobile-menu" id="mobileMenuBtn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <div class="topbar-page-title">{{ $pageTitle }}</div>
                <div class="topbar-breadcrumb">{{ $pageBreadcrumb }}</div>
            </div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('profile.edit') }}" class="topbar-user">
                <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="topbar-username">{{ Auth::user()->name }}</span>
            </a>
        </div>
    </header>

    {{-- PAGE CONTENT --}}
    <main class="main-content">
        {{ $slot }}
    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar   = document.getElementById('sidebar');
        const overlay   = document.getElementById('sidebarOverlay');
        const btnMin    = document.getElementById('btnMinimize');
        const btnMobile = document.getElementById('mobileMenuBtn');

        // Restore collapsed state
        if (localStorage.getItem('sol-sidebar-collapsed') === '1') {
            sidebar.classList.add('collapsed');
        }

        btnMin.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sol-sidebar-collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
        });

        btnMobile.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    });
</script>

</body>
</html>
