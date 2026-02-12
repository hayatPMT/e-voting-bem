<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | E-Voting BEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 0.5rem !important;
            }

            .card {
                margin-bottom: 1rem;
            }

            .small-box {
                margin-bottom: 1rem;
            }

            .small-box .inner h3 {
                font-size: 1.5rem;
            }

            .small-box .inner p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.25rem !important;
            }

            .main-header .navbar-nav .nav-link {
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
    @stack('scripts')
</body>

</html>