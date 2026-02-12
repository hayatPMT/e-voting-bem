<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem E-Voting BEM - Platform Pemilihan Digital yang Aman dan Transparan">
    <title>E-Voting BEM | Sistem Pemilihan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --white: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.2);
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

        .container {
            position: relative;
            z-index: 1;
        }

        .landing-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .landing-card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            padding: 3.5rem 3rem;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .landing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 3.5rem;
            position: relative;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .logo-icon i {
            font-size: 2rem;
            color: var(--white);
        }

        .main-title {
            font-size: 2.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .main-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
            font-weight: 500;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Role Cards Grid */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.75rem;
            margin-bottom: 3rem;
        }

        .role-card {
            background: var(--white);
            border: 2px solid #e5e7eb;
            border-radius: 20px;
            padding: 2.25rem 1.75rem;
            text-align: center;
            text-decoration: none;
            color: var(--dark-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .role-card>* {
            position: relative;
            z-index: 1;
        }

        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .role-card:hover::before {
            opacity: 1;
        }

        .role-card:hover .role-title,
        .role-card:hover .role-desc {
            color: var(--white);
        }

        .role-card:hover .icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .role-card:hover .icon-wrapper i {
            color: var(--white);
            transform: scale(1.1);
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border: 3px solid #e5e7eb;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.4s ease;
        }

        .icon-wrapper i {
            font-size: 2.25rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.4s ease;
        }

        .role-title {
            font-size: 1.375rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            transition: color 0.4s ease;
            letter-spacing: -0.3px;
        }

        .role-desc {
            font-size: 0.9375rem;
            color: #6b7280;
            line-height: 1.6;
            transition: color 0.4s ease;
        }

        /* Badge for specific cards */
        .role-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            z-index: 2;
        }

        /* Footer Section */
        .footer-section {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .footer-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .badge-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #4b5563;
        }

        .badge-item i {
            color: var(--primary-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .landing-card {
                padding: 3rem 2rem;
            }

            .main-title {
                font-size: 2.25rem;
            }

            .roles-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }

            .landing-card {
                padding: 2.5rem 1.5rem;
                border-radius: 20px;
            }

            .header-section {
                margin-bottom: 2.5rem;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
                border-radius: 16px;
            }

            .logo-icon i {
                font-size: 1.75rem;
            }

            .main-title {
                font-size: 2rem;
            }

            .main-subtitle {
                font-size: 1rem;
            }

            .role-card {
                padding: 2rem 1.5rem;
            }

            .icon-wrapper {
                width: 75px;
                height: 75px;
            }

            .icon-wrapper i {
                font-size: 2rem;
            }

            .role-title {
                font-size: 1.25rem;
            }

            .role-desc {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .landing-card {
                padding: 2rem 1.25rem;
            }

            .main-title {
                font-size: 1.75rem;
            }

            .main-subtitle {
                font-size: 0.9375rem;
            }

            .roles-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .role-card {
                padding: 1.75rem 1.25rem;
            }

            .icon-wrapper {
                width: 70px;
                height: 70px;
                margin-bottom: 1.25rem;
            }

            .footer-badges {
                gap: 0.75rem;
            }

            .badge-item {
                font-size: 0.75rem;
                padding: 0.4rem 0.85rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <div class="container px-3">
        <div class="landing-wrapper">
            <div class="landing-card">
                <!-- Header Section -->
                <div class="header-section">
                    <div class="logo-icon">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <h1 class="main-title">E-Voting BEM</h1>
                    <p class="main-subtitle">Platform Pemilihan Digital yang Aman, Transparan, dan Real-time untuk BEM Kampus</p>
                </div>

                <!-- Roles Grid -->
                <div class="roles-grid">
                    <!-- Admin Card -->
                    <a href="{{ route('login') }}" class="role-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="role-title">Administrator</div>
                        <div class="role-desc">Kelola kandidat, mahasiswa, monitoring suara, dan akses ke dashboard lengkap sistem</div>
                    </a>

                    <!-- Mahasiswa Card -->
                    <a href="{{ route('verifikasi') }}" class="role-card">
                        <span class="role-badge">
                            <i class="fas fa-star"></i> Populer
                        </span>
                        <div class="icon-wrapper">
                            <i class="fas fa-vote-yea"></i>
                        </div>
                        <div class="role-title">Mahasiswa</div>
                        <div class="role-desc">Login dengan NIM untuk memberikan hak suara Anda dalam pemilihan BEM</div>
                    </a>

                    <!-- Public Viewer Card -->
                    <a href="{{ route('public.chart') }}" class="role-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="role-title">Hasil Real-time</div>
                        <div class="role-desc">Pantau hasil perolehan suara sementara secara langsung dan transparan</div>
                    </a>
                </div>

                <!-- Footer Section -->
                <div class="footer-section">
                    <div class="footer-badges">
                        <div class="badge-item">
                            <i class="fas fa-shield-alt"></i>
                            Aman & Terenkripsi
                        </div>
                        <div class="badge-item">
                            <i class="fas fa-check-circle"></i>
                            Transparan
                        </div>
                        <div class="badge-item">
                            <i class="fas fa-clock"></i>
                            Real-time
                        </div>
                    </div>
                    <p class="footer-text mt-3">&copy; {{ date('Y') }} Sistem E-Voting BEM. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>