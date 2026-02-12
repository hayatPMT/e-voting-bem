<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem E-Voting BEM - Panel Admin">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | E-Voting BEM Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <!-- Theme style AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Custom overlay -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .brand-link {
            border-bottom: 1px solid #4b545c;
        }

        .nav-sidebar .nav-link>.right {
            font-size: 0.75rem;
        }

        .content-header {
            padding-bottom: 0.5rem;
        }

        .card-header {
            font-weight: 600;
        }

        .small-box {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .small-box .icon {
            opacity: 0.9;
        }

        .main-sidebar {
            box-shadow: 2px 0 8px rgba(0, 0, 0, .1);
        }

        .navbar-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .navbar-primary .nav-link {
            color: rgba(255, 255, 255, .9) !important;
        }

        .navbar-primary .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .1) !important;
        }

        /* Page Transition Overlay */
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
            animation: pulseFade 1.5s ease-in-out infinite;
        }

        .loader-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        @keyframes pulseFade {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        .content-wrapper {
            animation: contentFadeIn 0.6s ease-out both;
        }

        @keyframes contentFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-icon">
                <i class="fas fa-vote-yea fa-spin"></i>
            </div>
            <h5 class="font-weight-bold text-muted">E-Voting BEM</h5>
        </div>
    </div>

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/dashboard') }}" class="nav-link">Beranda</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down ml-1 small"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            <i class="fas fa-user mr-2"></i>{{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/voting') }}" class="dropdown-item" target="_blank">
                            <i class="fas fa-external-link-alt mr-2"></i> Lihat Halaman Voting
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/logout') }}" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/dashboard') }}" class="brand-link text-center py-3">
                @if(isset($setting) && $setting->election_logo)
                <img src="{{ asset('storage/' . $setting->election_logo) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; max-height: 50px; width: auto; float: none; margin-bottom: 5px;">
                @else
                <i class="fas fa-vote-yea fa-2x text-white"></i>
                @endif
                <span class="brand-text font-weight-light d-block mt-1">{{ $setting?->election_name ?? 'E-Voting BEM' }}</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.kandidat.index') }}" class="nav-link {{ request()->is('admin/kandidat*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Kandidat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Kelola Mahasiswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Pengaturan Waktu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/voting') }}" class="nav-link {{ request()->is('voting*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-vote-yea"></i>
                                <p>Halaman Voting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/rekap') }}" class="nav-link {{ request()->is('rekap') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Rekap Suara</p>
                            </a>
                        </li>
                        <li class="nav-header">AKUN</li>
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile Saya</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/logout') }}" class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header (Breadcrumb) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('breadcrumb_title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Admin</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
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
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>E-Voting BEM</strong> &copy; {{ date('Y') }} — Sistem Voting Terpercaya
            <div class="float-right d-none d-sm-inline">Admin Panel</div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        $(function() {
            // Page Loader logic
            window.addEventListener('load', function() {
                const loader = document.getElementById('page-loader');
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.visibility = 'hidden';
                }, 500);
            });

            // Show loader on page leave
            window.addEventListener('beforeunload', function() {
                const loader = document.getElementById('page-loader');
                loader.style.visibility = 'visible';
                loader.style.opacity = '1';
            });

            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
            });
        });
    </script>
    @stack('scripts')
</body>

</html>