<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal E-Voting BEM {{ $kampus->nama }}">
    <title>E-Voting BEM | {{ $kampus->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $kampus->primary_color ?? '#667eea' }};
            --secondary-color: {{ $kampus->secondary_color ?? '#764ba2' }};
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --dark-color: #1f2937;
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.08) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% { transform: translate(0,0) rotate(0deg); }
            33% { transform: translate(30px,-50px) rotate(120deg); }
            66% { transform: translate(-20px,20px) rotate(240deg); }
        }

        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes pulseFade {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        /* Page Loader */
        #page-loader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; z-index: 9999;
            display: flex; justify-content: center; align-items: center;
            transition: opacity 0.5s ease-out, visibility 0.5s;
        }
        .loader-content { text-align: center; animation: pulseFade 1.5s ease-in-out infinite; }
        .loader-icon { font-size: 3.5rem; color: var(--primary-color); margin-bottom: 1rem; }

        .portal-wrapper {
            position: relative; z-index: 1;
            width: 100%; max-width: 960px;
            animation: slideUpFade 0.8s cubic-bezier(0.16,1,0.3,1) both;
        }

        .portal-card {
            background: var(--white);
            border-radius: 32px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.25);
            overflow: hidden;
            position: relative;
        }

        .portal-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
            background-size: 200% 100%;
            animation: shimmer 4s linear infinite;
            z-index: 2;
        }

        /* Campus Header Banner */
        .campus-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 3.5rem 3rem 2.5rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .campus-logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .campus-logo-img {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            object-fit: contain;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.3);
            padding: 8px;
        }

        .campus-logo-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            animation: pulse 3s ease-in-out infinite;
        }

        .campus-logo-icon i {
            font-size: 2.25rem;
            color: white;
        }

        .evoting-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .campus-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
            letter-spacing: -0.5px;
        }

        .campus-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Portal Body */
        .portal-body {
            padding: 3.5rem 3rem;
        }

        /* Alert Box */
        .alert-inactive {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border-left: 5px solid var(--warning-color);
            padding: 1.75rem;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(245,158,11,0.1);
        }
        .alert-inactive h3 {
            color: #92400e;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .alert-inactive p { color: #78350f; margin: 0; font-size: 0.9375rem; line-height: 1.6; }

        /* Mode Grid */
        .mode-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .mode-card {
            background: var(--white);
            border: 2.5px solid #f3f4f6;
            border-radius: 24px;
            padding: 2.75rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.45s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
            width: 100%;
            display: flex; flex-direction: column; align-items: center;
            outline: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .mode-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.45s ease;
            z-index: 0;
        }

        .mode-card > * { position: relative; z-index: 1; transition: all 0.4s ease; }

        .mode-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 55px rgba(0,0,0,0.15);
            border-color: transparent;
        }

        .mode-card:hover::before { opacity: 1; }
        .mode-card:hover .mode-icon-wrap { background: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.3); transform: scale(1.08); }
        .mode-card:hover .mode-icon-wrap i { color: white; -webkit-text-fill-color: white; }
        .mode-card:hover .mode-title, .mode-card:hover .mode-desc { color: white; }

        .mode-icon-wrap {
            width: 96px; height: 96px;
            background: #f9fafb;
            border: 2.5px solid #f3f4f6;
            border-radius: 26px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1.75rem;
            transition: all 0.4s ease;
        }

        .mode-icon-wrap i {
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mode-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.875rem;
            color: var(--dark-color);
            letter-spacing: -0.5px;
        }

        .mode-desc {
            font-size: 0.9375rem;
            color: #6b7280;
            line-height: 1.65;
        }

        /* Footer Links */
        .portal-footer {
            padding: 1.75rem 3rem 2rem;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .footer-link {
            color: #6b7280;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex; align-items: center; gap: 0.5rem;
        }

        .footer-link i { color: var(--primary-color); }
        .footer-link:hover { color: var(--primary-color); transform: translateY(-2px); }

        /* Responsive */
        @media (max-width: 768px) {
            .campus-header { padding: 2.5rem 1.5rem 2rem; }
            .campus-title { font-size: 1.75rem; }
            .portal-body { padding: 2.5rem 1.5rem; }
            .mode-grid { grid-template-columns: 1fr; gap: 1.25rem; }
            .mode-card { padding: 2rem 1.5rem; }
            .portal-footer { padding: 1.5rem 1.5rem; gap: 1.25rem; }
        }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-icon"><i class="fas fa-vote-yea fa-spin"></i></div>
            <h5 style="color: var(--dark-color); font-weight: 800; letter-spacing: -0.5px;">E-Voting BEM</h5>
            <small style="color: #6b7280;">{{ $kampus->nama }}</small>
        </div>
    </div>

    <div class="portal-wrapper">
        <div class="portal-card">

            <!-- Campus Header -->
            <div class="campus-header">
                <div class="evoting-badge">
                    <i class="fas fa-shield-check"></i>
                    E-Voting BEM Resmi
                </div>
                <div class="campus-logo-wrapper">
                    @if ($kampus->logo)
                        <img src="{{ asset('storage/' . $kampus->logo) }}" alt="{{ $kampus->nama }}" class="campus-logo-img">
                    @else
                        <div class="campus-logo-icon">
                            <i class="fas fa-university"></i>
                        </div>
                    @endif
                </div>
                <h1 class="campus-title">{{ $kampus->nama }}</h1>
                <p class="campus-subtitle">
                    @if($kampus->kota) {{ $kampus->kota }} &bull; @endif
                    Sistem E-Voting BEM
                </p>
            </div>

            <!-- Portal Body -->
            <div class="portal-body">

                @if (!$tahapanActive)
                    <!-- Inactive Tahapan -->
                    <div class="alert-inactive">
                        <h3><i class="fas fa-exclamation-triangle"></i> {{ $message }}</h3>
                        @if (isset($tahapan))
                            <p>
                                <strong>Tahapan:</strong> {{ $tahapan->nama_tahapan }}<br>
                                <strong>Waktu:</strong>
                                {{ $tahapan->waktu_mulai->format('d M Y H:i') }} —
                                {{ $tahapan->waktu_selesai->format('d M Y H:i') }}
                            </p>
                        @else
                            <p>Silakan hubungi administrator kampus untuk informasi lebih lanjut.</p>
                        @endif
                    </div>
                @else
                    <!-- Mode Selection Form -->
                    <p class="text-center text-muted mb-4" style="font-size:1.05rem; font-weight:500;">
                        Pilih mode voting Anda untuk mulai berpartisipasi
                    </p>
                    <form action="{{ route('campus.select-mode', $kampus->slug) }}" method="POST">
                        @csrf
                        <div class="mode-grid">
                            <!-- Online Mode -->
                            <button type="submit" name="mode" value="online" class="mode-card">
                                <div class="mode-icon-wrap">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                <div class="mode-title">Mode Online</div>
                                <div class="mode-desc">
                                    Voting dari mana saja menggunakan NIM dan password Anda
                                </div>
                            </button>

                            <!-- Offline Mode -->
                            <button type="submit" name="mode" value="offline" class="mode-card">
                                <div class="mode-icon-wrap">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="mode-title">Mode Offline</div>
                                <div class="mode-desc">
                                    Voting di lokasi kampus dengan bantuan petugas daftar hadir
                                </div>
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Portal Footer -->
            <div class="portal-footer">
                <a href="{{ route('campus.chart', $kampus->slug) }}" class="footer-link">
                    <i class="fas fa-chart-line"></i> Hasil Real-time
                </a>
                <a href="{{ route('campus.login', $kampus->slug) }}" class="footer-link">
                    <i class="fas fa-user-shield"></i> Login Admin
                </a>
                <a href="{{ route('landing') }}" class="footer-link" style="color: #9ca3af;">
                    <i class="fas fa-arrow-left"></i> Pilih Kampus Lain
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('page-loader');
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.visibility = 'hidden'; }, 500);
        });
        window.addEventListener('beforeunload', function () {
            const loader = document.getElementById('page-loader');
            loader.style.visibility = 'visible';
            loader.style.opacity = '1';
        });
    </script>
</body>

</html>
