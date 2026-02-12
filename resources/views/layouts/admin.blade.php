<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | E-Voting BEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.1);
            --border-radius: 16px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f6f9;
        }

        /* Card Enhancements */
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 1.25rem 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #2d3748;
        }

        .card-outline.card-primary {
            border-top: 4px solid #667eea;
        }

        /* Table Enhancements */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid #edf2f7;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            color: #718096;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            background-color: #fcfcfd;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            color: #4a5568;
            font-size: 0.9rem;
            border-top: 1px solid #edf2f7;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.03);
            cursor: pointer;
        }

        /* Badge Enhancements */
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 600;
            border-radius: 8px;
            font-size: 0.75rem;
        }

        .badge-success {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge-warning {
            background-color: #feebc8;
            color: #744210;
        }

        .badge-danger {
            background-color: #fed7d7;
            color: #822727;
        }

        .badge-info {
            background-color: #bee3f8;
            color: #2a4365;
        }

        .badge-primary {
            background-color: #e2e8f0;
            color: #2d3748;
        }

        /* Button Enhancements */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            opacity: 0.9;
        }

        /* Navbar & Sidebar */
        .main-header {
            border-bottom: 1px solid #edf2f7;
        }

        .main-sidebar {
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .nav-sidebar .nav-link.active {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Page Loader */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease-out, visibility 0.5s;
        }

        .loader-content {
            text-align: center;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-body.table-responsive {
                padding: 0 !important;
            }

            .content-wrapper {
                padding: 1rem !important;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content text-primary">
            <i class="fas fa-vote-yea fa-3x fa-spin mb-3"></i>
            <h5 class="font-weight-bold">E-Voting BEM</h5>
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="/logout" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/dashboard" class="brand-link text-center">
                @if(isset($setting) && $setting->election_logo)
                <img src="{{ asset('storage/' . $setting->election_logo) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; max-height: 33px; margin-top: -3px;">
                @endif
                <span class="brand-text font-weight-bold">{{ $setting?->election_name ?? 'E-Voting BEM' }}</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">DE-VOTING</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.tahapan.index') }}" class="nav-link {{ request()->routeIs('admin.tahapan.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-ol"></i>
                                <p>Tahapan Pemilihan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.voting-booths.index') }}" class="nav-link {{ request()->routeIs('admin.voting-booths.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-person-booth"></i>
                                <p>Bilik Suara</p>
                            </a>
                        </li>

                        <li class="nav-header">DATA MASTER</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.kandidat.index') }}" class="nav-link {{ request()->routeIs('admin.kandidat.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Kandidat</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Data Mahasiswa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.petugas.index') }}" class="nav-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>Data Petugas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Administrator</p>
                            </a>
                        </li>

                        <li class="nav-header">PENGATURAN</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Pengaturan Sistem</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rekap') }}" class="nav-link {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Rekapitulasi Suara</p>
                            </a>
                        </li>

                        <li class="nav-header">INFORMASI SISTEM</li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fab fa-laravel text-danger"></i>
                                <p>Laravel v{{ app()->version() }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fab fa-php text-primary"></i>
                                <p>PHP v{{ phpversion() }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-server text-success"></i>
                                <p>{{ config('app.env') }}</p>
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
                            <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            @yield('content')
        </div>

        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} E-Voting BEM</strong>
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

        // Show loader on page leave
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