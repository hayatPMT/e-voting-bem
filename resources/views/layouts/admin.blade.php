<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') | E-Voting BEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900;1,14..32,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* ===========================
           RESET & BASE
        =========================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #ede9fe;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --sidebar-bg: #0f172a;
            --sidebar-width: 260px;
            --sidebar-mini-width: 64px;
            --topbar-h: 64px;
            --content-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --radius: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,.06), 0 2px 6px rgba(0,0,0,.04);
            --shadow-lg: 0 10px 30px rgba(0,0,0,.08), 0 4px 12px rgba(0,0,0,.04);
            --transition: 0.25s cubic-bezier(0.4,0,0.2,1);
        }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--content-bg);
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ===========================
           LAYOUT STRUCTURE
        =========================== */
        .app-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===========================
           SIDEBAR
        =========================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: transform var(--transition), width var(--transition);
            overflow: hidden;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            height: var(--topbar-h);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            text-decoration: none;
            flex-shrink: 0;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(79,70,229,0.4);
        }

        .sidebar-brand-text {
            font-size: 1rem;
            font-weight: 800;
            color: #f1f5f9;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }

        .sidebar-brand-sub {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.08) transparent;
        }

        .sidebar-body::-webkit-scrollbar { width: 4px; }
        .sidebar-body::-webkit-scrollbar-track { background: transparent; }
        .sidebar-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            padding: 16px 20px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            margin: 2px 8px;
            border-radius: 10px;
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition);
            position: relative;
            white-space: nowrap;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: #e2e8f0;
            text-decoration: none;
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(79,70,229,0.25), rgba(129,140,248,0.15));
            color: #a5b4fc;
            font-weight: 600;
            border: 1px solid rgba(99,102,241,0.2);
        }

        .nav-item.active .nav-icon { color: #818cf8; }

        .nav-item.nav-superadmin {
            background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(217,119,6,0.1));
            color: #fbbf24;
            border: 1px solid rgba(245,158,11,0.2);
        }
        .nav-item.nav-superadmin:hover { background: linear-gradient(135deg, rgba(245,158,11,0.3), rgba(217,119,6,0.2)); }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
            color: #475569;
            transition: color var(--transition);
        }

        .nav-item:hover .nav-icon { color: #94a3b8; }

        .sidebar-footer {
            padding: 12px 8px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        /* ===========================
           MAIN CONTENT AREA
        =========================== */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
        }

        /* ===========================
           TOP BAR
        =========================== */
        .topbar {
            height: var(--topbar-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: var(--shadow-sm);
        }

        .topbar-toggle {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all var(--transition);
            flex-shrink: 0;
        }

        .topbar-toggle:hover {
            background: var(--content-bg);
            color: var(--text-primary);
        }

        .topbar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            flex: 1;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .topbar-breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color var(--transition);
        }
        .topbar-breadcrumb a:hover { color: var(--primary); }
        .topbar-breadcrumb .separator { color: #cbd5e1; }
        .topbar-breadcrumb .current { color: var(--primary); font-weight: 600; }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 10px;
            background: var(--content-bg);
            border: 1px solid var(--border);
            text-decoration: none;
            color: var(--text-primary);
            transition: all var(--transition);
        }

        .topbar-user:hover {
            background: #e8edff;
            color: var(--primary);
            border-color: var(--primary-light);
            text-decoration: none;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .user-info .user-role {
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        .btn-logout {
            padding: 6px 14px;
            background: transparent;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #dc2626;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all var(--transition);
        }

        .btn-logout:hover {
            background: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
            text-decoration: none;
        }

        /* ===========================
           CONTENT WRAPPER
        =========================== */
        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            overflow-x: hidden;
        }

        /* ===========================
           ALERTS
        =========================== */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger, .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left: 4px solid var(--warning);
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border-left: 4px solid var(--accent);
        }

        .alert-close {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: inherit;
            font-size: 1rem;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity var(--transition);
        }

        .alert-close:hover { opacity: 1; }

        /* ===========================
           MONITORING BANNER
        =========================== */
        .monitor-banner {
            background: linear-gradient(90deg, #fef3c7, #fde68a);
            border-bottom: 1px solid #fbbf24;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #92400e;
            flex-wrap: wrap;
        }

        /* ===========================
           CARDS
        =========================== */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow var(--transition), transform var(--transition);
        }

        .card:hover { box-shadow: var(--shadow-md); }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            background: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body { padding: 20px 22px; }

        .card-footer {
            padding: 12px 22px;
            border-top: 1px solid var(--border);
            background: #f8fafc;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* ===========================
           TABLES
        =========================== */
        .table-container {
            overflow-x: auto;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        table.data-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid var(--border);
        }

        table.data-table thead th {
            padding: 13px 18px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-secondary);
            white-space: nowrap;
            border: none;
        }

        table.data-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background var(--transition);
        }

        table.data-table tbody tr:hover { background: #f8fafc; }

        table.data-table tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            color: var(--text-primary);
            border: none;
        }

        table.data-table tbody tr:last-child { border-bottom: none; }

        .table-empty td {
            padding: 60px 20px !important;
            text-align: center;
            color: var(--text-secondary);
        }

        .table-empty-icon {
            font-size: 3rem;
            margin-bottom: 12px;
            opacity: 0.2;
        }

        /* ===========================
           BUTTONS
        =========================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
            line-height: 1.4;
        }

        .btn:hover { text-decoration: none; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-sm { padding: 5px 12px; font-size: 0.8rem; border-radius: 8px; }
        .btn-lg { padding: 11px 22px; font-size: 1rem; border-radius: 12px; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(79,70,229,0.2);
        }
        .btn-primary:hover { box-shadow: 0 8px 20px rgba(79,70,229,0.3); color: white; }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #34d399);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(16,185,129,0.2);
        }
        .btn-success:hover { box-shadow: 0 8px 20px rgba(16,185,129,0.3); color: white; }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #fbbf24);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(245,158,11,0.2);
        }
        .btn-warning:hover { box-shadow: 0 8px 20px rgba(245,158,11,0.3); color: white; }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #f87171);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(239,68,68,0.2);
        }
        .btn-danger:hover { box-shadow: 0 8px 20px rgba(239,68,68,0.3); color: white; }

        .btn-secondary {
            background: var(--content-bg);
            color: var(--text-secondary);
            border-color: var(--border);
        }
        .btn-secondary:hover { background: var(--border); color: var(--text-primary); }

        .btn-outline {
            background: transparent;
            border-color: var(--border);
            color: var(--text-secondary);
        }
        .btn-outline:hover { background: var(--content-bg); color: var(--text-primary); }

        /* ===========================
           BADGES
        =========================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-primary { background: #ede9fe; color: #5b21b6; }
        .badge-info { background: #e0f2fe; color: #0369a1; }
        .badge-secondary { background: #f1f5f9; color: #64748b; }

        /* ===========================
           FORMS (basic)
        =========================== */
        .form-group { margin-bottom: 18px; }

        label.form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            color: var(--text-primary);
            background: var(--card-bg);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: var(--danger);
            font-weight: 500;
            margin-top: 4px;
        }

        /* ===========================
           FOOTER
        =========================== */
        .app-footer {
            padding: 12px 24px;
            background: var(--card-bg);
            border-top: 1px solid var(--border);
            font-size: 0.78rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ===========================
           PAGE LOADER
        =========================== */
        #page-loader {
            position: fixed;
            inset: 0;
            background: #fff;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 16px;
            transition: opacity 0.4s ease, visibility 0.4s;
        }

        .loader-spinner {
            width: 44px;
            height: 44px;
            border: 3px solid #e2e8f0;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===========================
           MOBILE OVERLAY
        =========================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
            backdrop-filter: blur(4px);
        }

        /* ===========================
           RESPONSIVE
        =========================== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(calc(-1 * var(--sidebar-width)));
            }
            .sidebar.sidebar-open {
                transform: translateX(0);
                box-shadow: 0 0 60px rgba(0,0,0,0.3);
            }
            .sidebar-overlay.active { display: block; }
            .main-area { margin-left: 0; }
            .topbar-breadcrumb { display: none; }
        }

        @media (max-width: 640px) {
            .content-wrapper { padding: 16px; }
            .topbar { padding: 0 16px; }
            .user-info { display: none; }
            .topbar-title { font-size: 1rem; }
        }

        /* ===========================
           MISC UTILITIES
        =========================== */
        .text-primary-custom { color: var(--primary); }
        .text-muted { color: var(--text-secondary); }
        .fw-bold { font-weight: 700; }
        .fw-black { font-weight: 900; }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }

        /* ===========================
           BOOTSTRAP COMPATIBILITY (table, flex, etc)
        =========================== */
        .row { margin: 0 -10px; display: flex; flex-wrap: wrap; }
        .row > [class*=col] { padding: 0 10px; }
        .col-12 { flex: 0 0 100%; max-width: 100%; }
        .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
        .col-lg-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .col-xl-7 { flex: 0 0 58.333%; max-width: 58.333%; }
        .col-xl-5 { flex: 0 0 41.666%; max-width: 41.666%; }
        .col-xl-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-xl-8 { flex: 0 0 66.666%; max-width: 66.666%; }
        .mb-4 { margin-bottom: 20px !important; }
        .mb-3 { margin-bottom: 14px !important; }
        .mt-3 { margin-top: 14px !important; }
        .p-0 { padding: 0 !important; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .float-right { float: right; }
        .table-responsive { overflow-x: auto; }
        .d-none { display: none !important; }
        .d-inline { display: inline !important; }
        .d-inline-flex { display: inline-flex !important; }
        .mr-1 { margin-right: 4px; }
        .mr-2 { margin-right: 8px; }
        .ml-auto { margin-left: auto; }
        .mb-0 { margin-bottom: 0 !important; }
        .mt-1 { margin-top: 4px; }
        .py-4 { padding-top: 24px; padding-bottom: 24px; }
        .py-5 { padding-top: 32px; padding-bottom: 32px; }
        .px-3 { padding-left: 12px; padding-right: 12px; }
        .p-3 { padding: 12px; }
        .p-4 { padding: 20px; }
        .small { font-size: 0.8rem; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .opacity-50 { opacity: 0.5; }
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .border-0 { border: none; }
        .w-100 { width: 100%; }
        .h-100 { height: 100%; }
        .text-danger { color: var(--danger); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .rounded { border-radius: var(--radius); }
        .overflow-hidden { overflow: hidden; }
        .position-relative { position: relative; }
        .flex-wrap { flex-wrap: wrap; }
        .justify-content-between { justify-content: space-between; }
        .justify-content-center { justify-content: center; }
        .align-items-center { align-items: center; }
        .gap-1 { gap: 4px; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .table { width: 100%; margin-bottom: 0; }
        .table thead th {
            background: #f8fafc;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-secondary);
            padding: 12px 18px;
            border-bottom: 2px solid var(--border);
        }
        .table tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            color: var(--text-primary);
        }
        .table-hover tbody tr:hover { background: #f8fafc; }
        .table-striped tbody tr:nth-of-type(odd) { background: #f8fafc; }

        @media (max-width: 1200px) {
            .col-xl-7, .col-xl-5, .col-xl-4, .col-xl-8 { flex: 0 0 100%; max-width: 100%; }
        }
        @media (max-width: 768px) {
            .col-lg-6, .col-lg-4, .col-md-6 { flex: 0 0 100%; max-width: 100%; }
        }

        /* Quick action grid fix */
        .quick-action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 12px;
        }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div id="page-loader">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4f46e5, #818cf8); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; box-shadow: 0 8px 24px rgba(79,70,229,0.3);">
            <i class="fas fa-vote-yea" style="color: white; font-size: 1.4rem;"></i>
        </div>
        <div class="loader-spinner"></div>
        <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; margin-top: -4px;">Memuat dashboard…</div>
    </div>

    <div class="app-layout">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="appSidebar">
            <!-- Brand -->
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                @if (isset($setting) && $setting?->election_logo)
                    <img src="{{ asset('storage/' . $setting->election_logo) }}" alt="Logo" style="width:36px;height:36px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                @else
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                @endif
                <div>
                    <div class="sidebar-brand-text">{{ $setting?->election_name ?? 'E-Voting BEM' }}</div>
                    <div class="sidebar-brand-sub">Admin Portal</div>
                </div>
            </a>

            <div class="sidebar-body">
                <nav>
                    @if (auth()->user()->role === 'super_admin')
                    <a href="{{ route('superadmin.dashboard') }}" class="nav-item nav-superadmin">
                        <i class="fas fa-crown nav-icon"></i>
                        <span>Panel Super Admin</span>
                    </a>
                    @endif

                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-grip-vertical nav-icon"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="nav-section-label">Pemilihan</div>

                    <a href="{{ route('admin.tahapan.index') }}" class="nav-item {{ request()->routeIs('admin.tahapan.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group nav-icon"></i>
                        <span>Tahapan Pemilihan</span>
                    </a>

                    <a href="{{ route('admin.voting-booths.index') }}" class="nav-item {{ request()->routeIs('admin.voting-booths.*') ? 'active' : '' }}">
                        <i class="fas fa-desktop nav-icon"></i>
                        <span>Bilik Suara</span>
                    </a>

                    <div class="nav-section-label">Data</div>

                    <a href="{{ route('admin.kandidat.index') }}" class="nav-item {{ request()->routeIs('admin.kandidat.*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span>Data Kandidat</span>
                    </a>

                    <a href="{{ route('admin.mahasiswa.index') }}" class="nav-item {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate nav-icon"></i>
                        <span>Data Mahasiswa</span>
                    </a>

                    <a href="{{ route('admin.petugas.index') }}" class="nav-item {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <span>Data Petugas</span>
                    </a>

                    <a href="{{ route('admin.admins.index') }}" class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <span>Administrator</span>
                    </a>

                    <div class="nav-section-label">Laporan</div>

                    <a href="{{ route('admin.attendance.index') }}" class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check nav-icon"></i>
                        <span>Daftar Hadir</span>
                    </a>

                    <a href="{{ route('admin.rekap') }}" class="nav-item {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie nav-icon"></i>
                        <span>Rekapitulasi Suara</span>
                    </a>

                    <div class="nav-section-label">Sistem</div>

                    <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fas fa-sliders-h nav-icon"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-footer">
                <div style="display:flex; gap:8px; padding: 4px 8px; background: rgba(255,255,255,0.04); border-radius: 10px; font-size: 0.75rem;">
                    <span style="color:#4ade80; font-weight:600;"><i class="fas fa-circle" style="font-size:0.5rem; vertical-align: middle;"></i> Online</span>
                    <span style="color:#475569; margin-left: auto;">v{{ app()->version() }}</span>
                </div>
            </div>
        </aside>

        <!-- Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- MAIN AREA -->
        <div class="main-area" id="mainArea">

            <!-- MONITORING BANNER -->
            @if (auth()->user()->role === 'super_admin' && session()->has('viewing_kampus_id'))
            <div class="monitor-banner">
                <div>
                    <i class="fas fa-eye mr-2"></i>
                    <strong>Mode Monitoring:</strong> Anda sedang memantau data kampus
                    @php $viewingKampus = \App\Models\Kampus::find(session('viewing_kampus_id')); @endphp
                    <span class="badge badge-warning ml-2">{{ $viewingKampus?->nama ?? 'Kampus Terpilih' }}</span>
                    — Aktivitas write dinonaktifkan.
                </div>
                <form action="{{ route('superadmin.kampus.exit-monitor') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-secondary" style="padding: 4px 12px;">
                        <i class="fas fa-times"></i> Keluar Monitor
                    </button>
                </form>
            </div>
            @endif

            <!-- TOPBAR -->
            <header class="topbar">
                <button class="topbar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars" style="font-size: 0.9rem;"></i>
                </button>

                <div class="topbar-title d-none d-lg-block">@yield('title', 'Dashboard')</div>

                <nav class="topbar-breadcrumb d-none d-lg-flex">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Admin</a>
                    <span class="separator">/</span>
                    @yield('breadcrumb_text', '<span class="current">Dashboard</span>')
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @endif
                </nav>

                <div class="topbar-actions">
                    <div class="topbar-user">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
                        </div>
                    </div>
                    <a href="/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="d-none d-md-block">Logout</span>
                    </a>
                </div>
            </header>

            <!-- CONTENT WRAPPER -->
            <div class="content-wrapper">

                @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                @endif

                @if (session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Terdapat kesalahan input:</strong>
                        <ul style="margin: 4px 0 0 16px; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                    <button class="alert-close"
        onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @yield('content')

    </div>

    <!-- FOOTER -->
    <footer class="app-footer">
        &copy; {{ date('Y') }} <strong>&nbsp;E-Voting BEM&nbsp;</strong> — Sistem E-Voting Kampus
    </footer>
    </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Page loader
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
            }
        });

        // Sidebar toggle
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('sidebar-open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggle?.addEventListener('click', function() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
            }
        });

        overlay?.addEventListener('click', closeSidebar);

        // Read-only monitor mode
        @if (session()->has('viewing_kampus_id'))
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('form').forEach(form => {
                    if (!form.action.includes('exit-monitor')) {
                        form.querySelectorAll('input, select, textarea, button[type="submit"]').forEach(
                            el => {
                                el.disabled = true;
                            });
                        form.addEventListener('submit', e => {
                            e.preventDefault();
                            alert('Mode Read-Only aktif.');
                        });
                    }
                });
            });
        @endif
    </script>
    @stack('scripts')
    </body>

</html>
