<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Mahasiswa | E-Voting BEM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -50px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        @keyframes bounceIcon {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .container {
            position: relative;
            z-index: 1;
            padding: 1rem;
        }

        .verify-card {
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 480px;
            margin: 0 auto;
            position: relative;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .verify-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
            background-size: 200% 100%;
            animation: shimmer 5s linear infinite;
            z-index: 2;
        }

        /* Header Section */
        .verify-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .verify-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: bounceIcon 3s ease-in-out infinite;
        }

        .verify-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .verify-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .verify-header p {
            font-size: 1rem;
            opacity: 0.95;
            margin: 0;
            font-weight: 500;
        }

        /* Body Section */
        .verify-body {
            padding: 1.75rem 2rem;
        }

        .info-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: start;
            gap: 0.75rem;
        }

        .info-box i {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-size: 0.9375rem;
        }

        .info-box-text {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.4s;
        }

        .form-group label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 1rem;
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
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
            outline: none;
            background: white;
            padding-left: 1.25rem;
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
            background: #fef2f2;
        }

        /* Button */
        .btn-verify {
            width: 100%;
            height: 56px;
            background: linear-gradient(135deg, var(--success-color), #059669, var(--success-color));
            background-size: 200% 100%;
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 0.5rem;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            animation-delay: 0.5s;
        }

        .btn-verify:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
            background-position: 100% 0;
            color: white;
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .btn-verify i {
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

        /* Divider */
        .divider {
            position: relative;
            margin: 1.25rem 0;
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
        .btn-back {
            width: 100%;
            height: 48px;
            background: white;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            color: var(--gray-600);
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-700);
            text-decoration: none;
        }

        /* Footer */
        .verify-footer {
            text-align: center;
            padding: 1rem 2rem;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
        }

        .help-text {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .help-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .help-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
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

            .verify-card {
                border-radius: 20px;
            }

            .verify-header {
                padding: 2.5rem 1.5rem 2rem;
            }

            .verify-icon {
                width: 70px;
                height: 70px;
                border-radius: 18px;
            }

            .verify-icon i {
                font-size: 2rem;
            }

            .verify-header h1 {
                font-size: 1.75rem;
            }

            .verify-header p {
                font-size: 0.9375rem;
            }

            .verify-body {
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
            .verify-header {
                padding: 2rem 1.25rem 1.75rem;
            }

            .verify-icon {
                width: 65px;
                height: 65px;
                margin-bottom: 1.25rem;
            }

            .verify-header h1 {
                font-size: 1.5rem;
            }

            .verify-body {
                padding: 1.75rem 1.25rem;
            }

            .form-control,
            .btn-verify {
                height: 48px;
                font-size: 0.9375rem;
            }

            .verify-footer {
                padding: 1.25rem 1.25rem;
            }

            .info-box {
                padding: 0.875rem 1rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
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
            font-size: 3.5rem;
            color: var(--primary-color);
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
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-icon">
                <i class="fas fa-vote-yea fa-spin"></i>
            </div>
            <h5 class="font-weight-bold" style="color: var(--dark-color); font-weight: 800; letter-spacing: -1px;">E-Voting BEM</h5>
        </div>
    </div>
    <div class="back-link">
        <a href="{{ url('/') }}">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="verify-card">
                    <div class="verify-header">
                        <div class="verify-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h1>Verifikasi Mahasiswa</h1>
                        <p>Login dengan NIM untuk memilih</p>
                    </div>

                    <div class="verify-body">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        @endif

                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <div class="info-box-content">
                                <div class="info-box-title">Informasi Login</div>
                                <p class="info-box-text">Masukkan NIM dan password Anda untuk mengakses halaman voting. Pastikan data yang Anda masukkan benar.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ url('/verifikasi') }}">
                            @csrf
                            <input type="hidden" name="kandidat_id" value="{{ $kandidat_id ?? '' }}">

                            <div class="form-group">
                                <label for="nim">
                                    <i class="fas fa-id-card"></i>
                                    Nomor Induk Mahasiswa (NIM)
                                </label>
                                <input type="text"
                                    id="nim"
                                    name="nim"
                                    class="form-control"
                                    placeholder="Contoh: 19081234001"
                                    value="{{ old('nim') }}"
                                    required
                                    autofocus
                                    maxlength="20">
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i>
                                    Password
                                </label>
                                <input type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Masukkan password Anda"
                                    required>
                            </div>

                            <button type="submit" class="btn-verify">
                                <i class="fas fa-check-circle"></i>
                                Verifikasi & Lanjutkan
                            </button>
                        </form>

                        <div class="divider">
                            <span>ATAU</span>
                        </div>

                        <a href="{{ url('/login') }}" class="btn-back">
                            <i class="fas fa-user-shield"></i>
                            Login sebagai Admin
                        </a>
                    </div>

                    <div class="verify-footer">
                        <p class="help-text">
                            Belum punya akses? Hubungi <a href="#" class="help-link">panitia pemilihan</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>

</html>