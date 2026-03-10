<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Super Admin | E-Voting BEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        :root {
            --superadmin-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --superadmin-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            --gold: #f5a623;
            --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 16px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f0f2f5;
        }

        /* Sidebar Super Admin - Dark + Gold Theme */
        .main-sidebar {
            background: var(--superadmin-dark) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        }

        .brand-link {
            background: rgba(245, 166, 35, 0.15) !important;
            border-bottom: 1px solid rgba(245, 166, 35, 0.3) !important;
        }

        .brand-text {
            color: var(--gold) !important;
            font-weight: 800 !important;
            font-size: 0.95rem !important;
        }

        .brand-link:hover {
            background: rgba(245, 166, 35, 0.2) !important;
        }

        .sidebar .nav-header {
            color: rgba(245, 166, 35, 0.6) !important;
            font-size: 0.65rem !important;
            letter-spacing: 0.12em !important;
            font-weight: 700 !important;
        }

        .nav-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            border-radius: 10px !important;
            margin: 2px 8px !important;
            transition: all 0.3s ease !important;
        }

        .nav-sidebar .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .nav-sidebar .nav-link.active {
            background: var(--superadmin-gradient) !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4) !important;
        }

        /* Super Admin Badge in Navbar */
        .superadmin-badge {
            background: var(--superadmin-gradient);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.05em;
            margin-left: 8px;
        }

        /* Card Enhancements */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 1.25rem 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: #2d3748;
        }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.purple { background: rgba(240, 147, 251, 0.15); color: #c026d3; }
        .stat-icon.gold { background: rgba(245, 166, 35, 0.15); color: #d97706; }
        .stat-icon.blue { background: rgba(102, 126, 234, 0.15); color: #4f46e5; }
        .stat-icon.green { background: rgba(72, 187, 120, 0.15); color: #059669; }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #718096;
            font-weight: 500;
            margin-top: 4px;
        }

        /* Table Enhancements */
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #edf2f7;
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 700;
            color: #718096;
            letter-spacing: 0.05em;
            padding: 0.875rem 1.25rem;
            background-color: #fcfcfd;
        }

        .table tbody td {
            padding: 0.875rem 1.25rem;
            vertical-align: middle;
            color: #4a5568;
            font-size: 0.88rem;
            border-top: 1px solid #edf2f7;
        }

        /* Badge Enhancements */
        .badge {
            padding: 0.4em 0.8em;
            font-weight: 600;
            border-radius: 8px;
            font-size: 0.72rem;
        }

        .badge-success { background-color: #c6f6d5; color: #22543d; }
        .badge-warning { background-color: #feebc8; color: #744210; }
        .badge-danger { background-color: #fed7d7; color: #822727; }
        .badge-primary { background-color: #e9d8fd; color: #553c9a; }

        /* Buttons */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
        }

        .btn-sm { padding: 0.25rem 0.75rem; border-radius: 8px; }

        .btn-superadmin {
            background: var(--superadmin-gradient);
            border: none;
            color: #fff;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
        }

        .btn-superadmin:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
            color: #fff;
        }

        /* Campus Color Swatch */
        .color-swatch {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid rgba(0,0,0,0.1);
            vertical-align: middle;
        }

        /* Navbar */
        .main-header {
            background: #fff !important;
            border-bottom: 1px solid #edf2f7;
        }

        /* Page Loader */
        #page-loader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease-out, visibility 0.5s;
        }

        .loader-content { text-align: center; }
        .loader-title { color: var(--gold); font-weight: 800; font-size: 1.2rem; margin-top: 12px; }
        .loader-subtitle { color: rgba(255,255,255,0.5); font-size: 0.75rem; }

        .loader-rings {
            position: relative;
            width: 60px;
            height: 60px;
            margin: 0 auto;
        }

        .loader-rings::before,
        .loader-rings::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 3px solid transparent;
        }

        .loader-rings::before {
            inset: 0;
            border-top-color: var(--gold);
            animation: spin 1s linear infinite;
        }

        .loader-rings::after {
            inset: 6px;
            border-top-color: #f093fb;
            animation: spin 0.7s linear infinite reverse;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .content-wrapper { padding: 1rem !important; }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-rings"></div>
            <div class="loader-title">E-Voting BEM</div>
            <div class="loader-subtitle">Super Admin Panel</div>
        </div>
    </div>

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item d-flex align-items-center pr-3">
                    <i class="fas fa-user-circle text-secondary mr-2"></i>
                    <span class="font-weight-bold text-dark" style="font-size:0.85rem;">{{ auth()->user()->name }}</span>
                    <span class="superadmin-badge">SUPER ADMIN</span>
                </li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link text-danger font-weight-semibold">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar elevation-4">
            <a href="{{ route('superadmin.dashboard') }}" class="brand-link text-center px-3">
                <i class="fas fa-crown mr-2" style="color: var(--gold);"></i>
                <span class="brand-text">Super Admin Panel</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('superadmin.dashboard') }}" class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">MANAJEMEN KAMPUS</li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.kampus.index') }}" class="nav-link {{ request()->routeIs('superadmin.kampus.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-university"></i>
                                <p>Data Kampus</p>
                            </a>
                        </li>

                        <li class="nav-header">MANAJEMEN ADMIN</li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.admins.index') }}" class="nav-link {{ request()->routeIs('superadmin.admins.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Admin Per Kampus</p>
                            </a>
                        </li>

                        <li class="nav-header">AKSES CEPAT</li>
                        
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    Monitor Kampus
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none; background: rgba(0,0,0,0.1); border-radius: 8px; margin: 0 8px;">
                                @if (isset($quickKampusList) && $quickKampusList->count() > 0)
                                    @foreach ($quickKampusList as $qk)
                                        <li class="nav-item">
                                            <form action="{{ route('superadmin.kampus.monitor', $qk) }}" method="POST" id="quick-monitor-{{ $qk->id }}" style="display:none;">
                                                @csrf
                                            </form>
                                            <a href="javascript:void(0)" onclick="document.getElementById('quick-monitor-{{ $qk->id }}').submit();" class="nav-link" style="font-size: 0.85rem;">
                                                <i class="fas fa-circle nav-icon" style="font-size: 0.6rem; color: {{ $qk->primary_color ?? '#fff' }};"></i>
                                                <p>{{ $qk->nama }}</p>
                                            </a>
                                        </li> @endforeach
@else
<li class="nav-item">
    <a href="#" class="nav-link disabled">
        <p>Tidak ada kampus aktif</p>
    </a>
    </li>
    @endif
    </ul>
    </li>

    <li class="nav-header">INFORMASI SISTEM</li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fab fa-laravel" style="color:#ff4500;"></i>
            <p>Laravel v{{ app()->version() }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fab fa-php" style="color:#7b8abd;"></i>
            <p>PHP v{{ phpversion() }}</p>
        </a>
    </li>
    </ul>
    </nav>
    </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">
        <div class="content-header p-0 mb-3">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="font-weight:800; font-size:1.5rem;">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Super Admin</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show"
                style="border-radius:12px; border:none; background:#c6f6d5; color:#22543d;">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius:12px;">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="main-footer text-center" style="background:#fff; border-top:1px solid #edf2f7;">
        <strong>&copy; {{ date('Y') }} E-Voting BEM</strong> &mdash; <span style="color:#c026d3;">Super Admin
            Panel</span>
    </footer>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(window).on('load', function() {
            $('#page-loader').css({
                'opacity': 0,
                'visibility': 'hidden'
            });
        });
        $(window).on('beforeunload', function() {
            $('#page-loader').css({
                'opacity': 1,
                'visibility': 'visible'
            });
        });
    </script>
    @stack('scripts')
    </body>

</html>
