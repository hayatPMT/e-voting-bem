<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Admin - Sistem E-Voting BEM">
    <meta name="theme-color" content="#667eea">
    <title>Login Admin | E-Voting BEM</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Pattern */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            padding: 1rem;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        /* Header Section */
        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 3rem 2rem 2.5rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .login-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 1rem;
            opacity: 0.95;
            margin: 0;
            font-weight: 500;
        }

        /* Body Section */
        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            height: 52px;
            border-radius: 12px;
            border: 2px solid var(--gray-200);
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
            background: var(--gray-50);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            background: white;
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
            background: #fef2f2;
        }

        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Button */
        .btn-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 1.125rem;
        }

        /* Alert */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert i {
            font-size: 1.125rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid var(--success-color);
        }

        .alert .close {
            margin-left: auto;
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .alert .close:hover {
            opacity: 1;
        }

        /* Divider */
        .divider {
            position: relative;
            margin: 1.5rem 0;
            text-align: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-200);
        }

        .divider span {
            position: relative;
            background: white;
            padding: 0 1rem;
            color: var(--gray-400);
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Secondary Button */
        .btn-secondary-custom {
            width: 100%;
            height: 48px;
            background: white;
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary-custom:hover {
            background: var(--gray-50);
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
        }

        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 600;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .footer-badge i {
            color: var(--primary-color);
        }

        /* Back Link */
        .back-link {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 10;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }

            .login-container {
                padding: 0.75rem;
            }

            .login-card {
                border-radius: 20px;
            }

            .login-header {
                padding: 2.5rem 1.5rem 2rem;
            }

            .login-icon {
                width: 70px;
                height: 70px;
                border-radius: 18px;
            }

            .login-icon i {
                font-size: 2rem;
            }

            .login-header h1 {
                font-size: 1.75rem;
            }

            .login-header p {
                font-size: 0.9375rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .back-link {
                top: 1rem;
                left: 1rem;
            }

            .back-link a {
                font-size: 0.875rem;
                padding: 0.4rem 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .login-header {
                padding: 2rem 1.25rem 1.75rem;
            }

            .login-icon {
                width: 65px;
                height: 65px;
                margin-bottom: 1.25rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-body {
                padding: 1.75rem 1.25rem;
            }

            .form-control,
            .btn-login {
                height: 48px;
                font-size: 0.9375rem;
            }

            .login-footer {
                padding: 1.25rem 1.25rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <div class="back-link">
        <a href="{{ url('/') }}">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1>Login Administrator</h1>
                <p>Kelola sistem E-Voting BEM</p>
            </div>

            <div class="login-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Alamat Email
                        </label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="admin@example.com" 
                                   required 
                                   autofocus 
                                   value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan password Anda" 
                                   required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Login sebagai Admin
                    </button>
                </form>

                <div class="divider">
                    <span>ATAU</span>
                </div>

                <a href="{{ url('/verifikasi') }}" class="btn-secondary-custom">
                    <i class="fas fa-user-graduate"></i>
                    Login sebagai Mahasiswa
                </a>
            </div>

            <div class="login-footer">
                <div class="footer-badge">
                    <i class="fas fa-shield-alt"></i>
                    Sistem yang aman & terpercaya
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
