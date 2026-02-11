<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Voting BEM - Halaman Voting Kandidat">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Voting') | E-Voting BEM</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --dark-color: #1f2937;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar-voting {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.375rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.3px;
        }

        .navbar-brand i {
            font-size: 1.5rem;
        }

        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.25);
            outline: none;
        }

        .navbar-toggler i {
            color: white;
            font-size: 1.25rem;
        }

        .navbar-nav .nav-item {
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            font-size: 0.9375rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.15);
        }

        .navbar-nav .nav-link i {
            font-size: 1rem;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Main Content */
        main.container {
            flex: 1;
            padding: 2rem 1rem;
        }

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .alert i {
            font-size: 1.125rem;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-dismissible .close {
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .alert-dismissible .close:hover {
            opacity: 1;
        }

        /* Footer */
        footer {
            background: white;
            border-top: 2px solid var(--gray-100);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer-text {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
        }

        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--gray-100);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .footer-badge i {
            color: var(--primary-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.25rem;
            }
            .navbar-brand i {
                font-size: 1.375rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-voting {
                padding: 0.75rem 0;
            }
            .navbar-brand {
                font-size: 1.125rem;
            }
            main.container {
                padding: 1.5rem 0.75rem;
            }
            .navbar-collapse {
                background: rgba(102, 126, 234, 0.95);
                backdrop-filter: blur(10px);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 1rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            }
            .navbar-nav .nav-item {
                margin: 0.25rem 0;
            }
            .navbar-nav .nav-link {
                width: 100%;
            }
            .user-badge {
                display: block;
                text-align: center;
                margin: 0.5rem 0;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
            }
            main.container {
                padding: 1.25rem 0.5rem;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-voting">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                @if(isset($setting) && $setting->election_logo)
                    <img src="{{ asset('storage/' . $setting->election_logo) }}" alt="Logo" style="height: 40px; width: auto;" class="mr-2 rounded-circle">
                @else
                    <i class="fas fa-vote-yea"></i>
                @endif
                <span>{{ $setting?->election_name ?? 'E-Voting BEM' }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') || Request::is('voting') ? 'active' : '' }}" 
                           href="{{ url('/') }}">
                            <i class="fas fa-th-large"></i>
                            <span>Voting</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" 
                                   href="{{ url('/dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <span class="nav-link user-badge">
                                <i class="fas fa-user"></i>
                                <span>{{ Str::limit(auth()->user()->name, 20) }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                                <i class="fas fa-user-circle"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/logout') }}">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">
                                <i class="fas fa-user-shield"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <div class="footer-badge mb-2">
                <i class="fas fa-shield-alt"></i>
                <span>Sistem yang aman & terpercaya</span>
            </div>
            <p class="footer-text">
                &copy; {{ date('Y') }} E-Voting BEM — Pemilihan Digital yang Transparan
            </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
