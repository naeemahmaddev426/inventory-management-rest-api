<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Inventory Management</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 72px;
            --navbar-height: 64px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #6366f1;
            --sidebar-hover: #1e293b;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04);
            --shadow-lg: 0 10px 40px rgba(0,0,0,.10), 0 4px 12px rgba(0,0,0,.06);
            --radius: 12px;
            --radius-lg: 16px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ─── SIDEBAR ─────────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: width .25s ease, transform .25s ease;
            overflow: hidden;
        }

        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px;
            min-height: var(--navbar-height);
            border-bottom: 1px solid rgba(255,255,255,.06);
            text-decoration: none;
            white-space: nowrap;
        }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-icon i { color: #fff; font-size: 1.1rem; }
        .sidebar-brand .brand-text {
            font-weight: 700;
            font-size: .95rem;
            color: #fff;
            letter-spacing: -.2px;
            line-height: 1.2;
        }
        .sidebar-brand .brand-text span {
            display: block;
            font-size: .7rem;
            font-weight: 400;
            color: var(--sidebar-text);
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 0;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

        .nav-section-label {
            font-size: .65rem;
            font-weight: 600;
            color: rgba(148,163,184,.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 20px 6px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            margin: 2px 8px;
            border-radius: 10px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all .2s ease;
            white-space: nowrap;
            position: relative;
            font-size: .875rem;
            font-weight: 500;
        }
        .sidebar-link i {
            font-size: 1.1rem;
            width: 22px;
            flex-shrink: 0;
            text-align: center;
        }
        .sidebar-link .link-text { transition: opacity .2s ease; }
        .sidebar-link .badge-count {
            margin-left: auto;
            font-size: .65rem;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(99,102,241,.2);
            color: #a5b4fc;
            font-weight: 600;
            white-space: nowrap;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(99,102,241,.25), rgba(99,102,241,.08));
            color: #fff;
            border-left: 3px solid var(--primary);
            padding-left: 13px;
        }
        .sidebar-link.active i { color: #a5b4fc; }

        .sidebar.collapsed .link-text,
        .sidebar.collapsed .badge-count,
        .sidebar.collapsed .nav-section-label { opacity: 0; pointer-events: none; }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 10px;
            margin: 2px 8px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }
        .sidebar-footer .user-info:hover { background: var(--sidebar-hover); }
        .sidebar-footer .avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-footer .user-name {
            font-size: .82rem;
            font-weight: 600;
            color: #e2e8f0;
        }
        .sidebar-footer .user-role {
            font-size: .7rem;
            color: var(--sidebar-text);
        }

        /* ─── TOPBAR ─────────────────────────────────────────── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--navbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            z-index: 1030;
            transition: left .25s ease;
            box-shadow: var(--shadow-sm);
        }
        .topbar.expanded { left: var(--sidebar-collapsed-width); }

        .topbar-toggle {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border: none;
            background: var(--body-bg);
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all .2s;
            flex-shrink: 0;
        }
        .topbar-toggle:hover { background: var(--primary-light); color: var(--primary); }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }
        .topbar-breadcrumb .page-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        .topbar-breadcrumb .breadcrumb {
            margin: 0;
            font-size: .75rem;
        }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        .topbar-btn {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border: none;
            background: var(--body-bg);
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all .2s;
            position: relative;
            text-decoration: none;
        }
        .topbar-btn:hover { background: var(--primary-light); color: var(--primary); }
        .topbar-btn .notif-dot {
            width: 8px; height: 8px;
            background: var(--danger);
            border-radius: 50%;
            position: absolute;
            top: 6px; right: 6px;
            border: 2px solid #fff;
        }

        /* ─── MAIN CONTENT ───────────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 28px;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left .25s ease;
        }
        .main-content.expanded { margin-left: var(--sidebar-collapsed-width); }

        /* ─── CARDS ──────────────────────────────────────────── */
        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: var(--card-bg);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header .card-title {
            font-size: .9rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }
        .card-body { padding: 20px; }

        /* ─── STAT CARDS ─────────────────────────────────────── */
        .stat-card {
            border-radius: var(--radius-lg);
            padding: 22px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100px; height: 100px;
            border-radius: 50%;
            opacity: .06;
            transform: translate(20px, -30px);
        }
        .stat-card.indigo::before { background: var(--primary); }
        .stat-card.emerald::before { background: var(--success); }
        .stat-card.amber::before { background: var(--warning); }
        .stat-card.cyan::before { background: var(--info); }
        .stat-card.rose::before { background: var(--danger); }
        .stat-card.violet::before { background: #8b5cf6; }
        .stat-card.orange::before { background: #f97316; }
        .stat-card.teal::before { background: #14b8a6; }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 14px;
        }
        .stat-icon.indigo { background: rgba(99,102,241,.1); color: var(--primary); }
        .stat-icon.emerald { background: rgba(16,185,129,.1); color: var(--success); }
        .stat-icon.amber { background: rgba(245,158,11,.1); color: var(--warning); }
        .stat-icon.cyan { background: rgba(6,182,212,.1); color: var(--info); }
        .stat-icon.rose { background: rgba(239,68,68,.1); color: var(--danger); }
        .stat-icon.violet { background: rgba(139,92,246,.1); color: #8b5cf6; }
        .stat-icon.orange { background: rgba(249,115,22,.1); color: #f97316; }
        .stat-icon.teal { background: rgba(20,184,166,.1); color: #14b8a6; }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: .78rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ─── PAGE HEADER ────────────────────────────────────── */
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-primary);
        }
        .page-header p {
            margin: 4px 0 0;
            color: var(--text-muted);
            font-size: .875rem;
        }

        /* ─── TABLES ─────────────────────────────────────────── */
        .table { font-size: .85rem; }
        .table thead th {
            background: var(--body-bg);
            color: var(--text-muted);
            font-weight: 600;
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 14px;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-primary);
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: rgba(99,102,241,.03); }

        /* ─── BADGES ─────────────────────────────────────────── */
        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
        }
        .badge-active { background: rgba(16,185,129,.1); color: var(--success); }
        .badge-inactive { background: rgba(239,68,68,.1); color: var(--danger); }
        .badge-pending { background: rgba(245,158,11,.1); color: var(--warning); }
        .badge-paid { background: rgba(16,185,129,.1); color: var(--success); }
        .badge-partial { background: rgba(6,182,212,.1); color: var(--info); }
        .badge-unpaid { background: rgba(239,68,68,.1); color: var(--danger); }

        /* ─── BUTTONS ────────────────────────────────────────── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: .5rem 1.1rem;
            font-size: .85rem;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,.4);
            color: #fff;
        }
        .btn-sm-icon {
            width: 30px; height: 30px;
            display: inline-flex; align-items: center; justify-content: center;
            border: none;
            border-radius: 8px;
            font-size: .8rem;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-edit { background: rgba(6,182,212,.1); color: var(--info); }
        .btn-edit:hover { background: var(--info); color: #fff; }
        .btn-delete { background: rgba(239,68,68,.1); color: var(--danger); }
        .btn-delete:hover { background: var(--danger); color: #fff; }
        .btn-view { background: rgba(99,102,241,.1); color: var(--primary); }
        .btn-view:hover { background: var(--primary); color: #fff; }

        /* ─── MODAL ──────────────────────────────────────────── */
        .modal-content {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }
        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
        }
        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-footer { border-top: 1px solid var(--border-color); }
        .form-label { font-size: .82rem; font-weight: 600; color: var(--text-muted); }
        .form-control, .form-select {
            border-color: var(--border-color);
            border-radius: 10px;
            font-size: .875rem;
            padding: .55rem .85rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
            border-color: var(--primary);
        }

        /* ─── LOADING SPINNER ────────────────────────────────── */
        .loading-overlay {
            display: flex; align-items: center; justify-content: center;
            padding: 60px;
            color: var(--text-muted);
        }
        .spinner-ring {
            width: 38px; height: 38px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ─── EMPTY STATE ────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 3rem; opacity: .3; margin-bottom: 16px; display: block; }
        .empty-state p { font-size: .9rem; }

        /* ─── SEARCH BOX ─────────────────────────────────────── */
        .search-box {
            position: relative;
        }
        .search-box i {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: .85rem;
        }
        .search-box input {
            padding-left: 36px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            font-size: .85rem;
            height: 38px;
            width: 240px;
        }
        .search-box input:focus {
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
            border-color: var(--primary);
            outline: none;
        }

        /* ─── ALERTS ─────────────────────────────────────────── */
        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success-custom { background: rgba(16,185,129,.1); color: #065f46; }
        .alert-error-custom { background: rgba(239,68,68,.1); color: #991b1b; }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); width: var(--sidebar-width) !important; }
            .sidebar.mobile-open { transform: translateX(0); }
            .topbar { left: 0 !important; }
            .main-content { margin-left: 0 !important; }
            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 1039;
            }
            .sidebar-overlay.active { display: block; }
        }

        /* ─── DATATABLE OVERRIDE ─────────────────────────────── */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            color: #fff !important;
            border-radius: 8px;
            border: none !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary-light) !important;
            color: var(--primary) !important;
            border-radius: 8px;
            border: none !important;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: .82rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ─── SIDEBAR ───────────────────────────────────────── -->
<aside class="sidebar" id="sidebar">
    <a class="sidebar-brand" href="{{ route('dashboard.index') }}">
        <div class="brand-icon"><i class="bi bi-boxes"></i></div>
        <div class="brand-text">
            InvenPro
            <span>Management System</span>
        </div>
    </a>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>

        <a href="{{ route('dashboard.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span class="link-text">Dashboard</span>
        </a>

        <div class="nav-section-label">Inventory</div>

        <a href="{{ route('dashboard.products') }}" class="sidebar-link {{ request()->routeIs('dashboard.products') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span class="link-text">Products</span>
        </a>
        <a href="{{ route('dashboard.categories') }}" class="sidebar-link {{ request()->routeIs('dashboard.categories') ? 'active' : '' }}">
            <i class="bi bi-tag"></i>
            <span class="link-text">Categories</span>
        </a>
        <a href="{{ route('dashboard.brands') }}" class="sidebar-link {{ request()->routeIs('dashboard.brands') ? 'active' : '' }}">
            <i class="bi bi-award"></i>
            <span class="link-text">Brands</span>
        </a>
        <a href="{{ route('dashboard.units') }}" class="sidebar-link {{ request()->routeIs('dashboard.units') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i>
            <span class="link-text">Units</span>
        </a>
        <a href="{{ route('dashboard.taxes') }}" class="sidebar-link {{ request()->routeIs('dashboard.taxes') ? 'active' : '' }}">
            <i class="bi bi-percent"></i>
            <span class="link-text">Taxes</span>
        </a>
        <a href="{{ route('dashboard.warehouses') }}" class="sidebar-link {{ request()->routeIs('dashboard.warehouses') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span class="link-text">Warehouses</span>
        </a>

        <div class="nav-section-label">People</div>

        <a href="{{ route('dashboard.suppliers') }}" class="sidebar-link {{ request()->routeIs('dashboard.suppliers') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span class="link-text">Suppliers</span>
        </a>
        <a href="{{ route('dashboard.customers') }}" class="sidebar-link {{ request()->routeIs('dashboard.customers') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span class="link-text">Customers</span>
        </a>

        <div class="nav-section-label">Transactions</div>

        <a href="{{ route('dashboard.purchases') }}" class="sidebar-link {{ request()->routeIs('dashboard.purchases') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i>
            <span class="link-text">Purchases</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="avatar">
                {{ strtoupper(substr(session('auth_user.name') ?? (session('auth_user')['name'] ?? 'A'), 0, 1)) }}
            </div>
            <div class="link-text">
                <div class="user-name">
                    {{ session('auth_user.name') ?? (session('auth_user')['name'] ?? 'Admin') }}
                </div>
                <div class="user-role">
                    {{ session('auth_user.email') ?? (session('auth_user')['email'] ?? 'System User') }}
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- ─── TOPBAR ────────────────────────────────────────── -->
<header class="topbar" id="topbar">
    <button class="topbar-toggle" id="sidebarToggle">
        <i class="bi bi-list" style="font-size:1.2rem;"></i>
    </button>

    <div class="topbar-breadcrumb">
        <div>
            <h6 class="page-title">@yield('page_title', 'Dashboard')</h6>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-muted text-decoration-none">Home</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
    </div>

    <div class="topbar-actions">
        <!-- Refresh -->
        <button class="topbar-btn" onclick="if(typeof loadData==='function')loadData()" title="Refresh">
            <i class="bi bi-arrow-clockwise"></i>
        </button>

        <!-- Fullscreen -->
        <button class="topbar-btn" id="fullscreenBtn" title="Fullscreen">
            <i class="bi bi-fullscreen"></i>
        </button>

        <!-- User dropdown trigger -->
        <div class="dropdown">
            <button class="topbar-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    title="Account" style="border:none;background:var(--body-bg);border-radius:8px;width:auto;padding:0 10px;gap:6px;display:flex;align-items:center;">
                <span style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#818cf8);
                    color:#fff;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;">
                    {{ strtoupper(substr(session('auth_user.name', session('auth_user')['name'] ?? 'A'), 0, 1)) }}
                </span>
                <span style="font-size:.82rem;font-weight:600;color:var(--text-primary);">
                    {{ session('auth_user.name') ?? (session('auth_user')['name'] ?? 'Admin') }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,.12);border:1px solid var(--border-color);min-width:180px;">
                <li>
                    <span class="dropdown-item-text" style="font-size:.75rem;color:var(--text-muted);padding:8px 16px;">
                        {{ session('auth_user.email') ?? (session('auth_user')['email'] ?? '') }}
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('dashboard.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"
                                style="font-size:.85rem;border-radius:8px;padding:8px 16px;"
                                onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- ─── MAIN CONTENT ──────────────────────────────────── -->
<main class="main-content" id="mainContent">
    @yield('content')
</main>

<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="toastContainer"></div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    // ─── API BASE ──────────────────────────────────────────────
    const API_BASE = '/api/v1';
    // Token comes from server-side session (not localStorage)
    let AUTH_TOKEN = '{{ session("auth_token", "") }}';

    // ─── SIDEBAR TOGGLE ────────────────────────────────────────
    const sidebar     = document.getElementById('sidebar');
    const topbar      = document.getElementById('topbar');
    const mainContent = document.getElementById('mainContent');
    const overlay     = document.getElementById('sidebarOverlay');

    document.getElementById('sidebarToggle').addEventListener('click', function () {
        if (window.innerWidth <= 991) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
            topbar.classList.toggle('expanded');
            mainContent.classList.toggle('expanded');
        }
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });

    // ─── FULLSCREEN ────────────────────────────────────────────
    document.getElementById('fullscreenBtn').addEventListener('click', function () {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            this.querySelector('i').className = 'bi bi-fullscreen-exit';
        } else {
            document.exitFullscreen();
            this.querySelector('i').className = 'bi bi-fullscreen';
        }
    });

    // ─── API HELPER ────────────────────────────────────────────
    async function apiRequest(endpoint, options = {}) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        };
        if (AUTH_TOKEN) headers['Authorization'] = 'Bearer ' + AUTH_TOKEN;

        const response = await fetch(API_BASE + endpoint, {
            headers,
            ...options
        });

        const data = await response.json();
        return { ok: response.ok, status: response.status, data };
    }

    // ─── TOAST HELPER ──────────────────────────────────────────
    function showToast(message, type = 'success') {
        const icons = { success: '✓', error: '✕', warning: '⚠', info: 'ℹ' };
        const colors = {
            success: '#10b981', error: '#ef4444',
            warning: '#f59e0b', info: '#06b6d4'
        };
        const id = 'toast_' + Date.now();
        const html = `
            <div id="${id}" class="toast align-items-center border-0 mb-2" role="alert" style="min-width:280px;">
                <div class="d-flex align-items-center p-3">
                    <span style="width:24px;height:24px;border-radius:50%;background:${colors[type]};color:#fff;
                        display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0;">
                        ${icons[type]}
                    </span>
                    <span class="ms-2 flex-grow-1" style="font-size:.85rem;font-weight:500;">${message}</span>
                    <button type="button" class="btn-close ms-2 btn-close-sm" data-bs-dismiss="toast"></button>
                </div>
            </div>`;
        document.getElementById('toastContainer').insertAdjacentHTML('beforeend', html);
        const el = document.getElementById(id);
        const toast = new bootstrap.Toast(el, { delay: 3500 });
        toast.show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    // ─── FORMAT HELPERS ────────────────────────────────────────
    function formatCurrency(val) {
        return '$' + parseFloat(val || 0).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    function formatDate(dateStr) {
        if (!dateStr) return '—';
        return new Date(dateStr).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' });
    }
    function statusBadge(active, labels=['Active','Inactive']) {
        return active
            ? `<span class="badge-status badge-active">${labels[0]}</span>`
            : `<span class="badge-status badge-inactive">${labels[1]}</span>`;
    }
</script>
@stack('scripts')
</body>
</html>
