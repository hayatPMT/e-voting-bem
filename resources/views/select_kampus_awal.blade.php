<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Voting BEM - Pilih Portal Kampus Anda">
    <title>Pilih Kampus | E-Voting BEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --dark-color: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            z-index: 0;
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

        .selection-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .selection-card {
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
            padding: 4rem 3rem;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .selection-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .system-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.4rem 1.25rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .main-title {
            font-size: 2.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 3.5rem;
            font-size: 1.075rem;
            font-weight: 500;
        }

        .kampus-card {
            border: 2.5px solid #f3f4f6;
            border-radius: 24px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            display: block;
            height: 100%;
            position: relative;
            overflow: hidden;
            background: white;
        }

        .kampus-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--k-primary, #667eea), var(--k-secondary, #764ba2));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .kampus-card>* {
            position: relative;
            z-index: 1;
            transition: all 0.35s ease;
        }

        .kampus-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            border-color: transparent;
            text-decoration: none;
        }

        .kampus-card:hover::before {
            opacity: 1;
        }

        .kampus-card:hover .kampus-name,
        .kampus-card:hover .kampus-code,
        .kampus-card:hover .portal-link-text {
            color: white !important;
        }

        .kampus-card:hover .logo-placeholder {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .logo-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin: 0 auto 1.25rem;
            display: block;
            border-radius: 12px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            color: #667eea;
            font-size: 2rem;
            transition: all 0.35s ease;
        }

        .kampus-name {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-size: 1.125rem;
            transition: color 0.3s ease;
        }

        .kampus-code {
            color: #6b7280;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
        }

        .portal-link-text {
            font-size: 0.8125rem;
            color: #9ca3af;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-link {
            text-align: center;
            margin-top: 3rem;
        }

        .footer-link a {
            color: #6b7280;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .footer-link a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .selection-card {
                padding: 2.5rem 1.5rem;
                border-radius: 24px;
            }

            .main-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="selection-wrapper">
        <div class="selection-card">
            <div class="text-center mb-2">
                <span class="system-badge"><i class="fas fa-vote-yea me-1"></i> Sistem E-Voting BEM</span>
            </div>
            <h1 class="main-title text-center">Pilih Portal Kampus</h1>
            <p class="subtitle">Klik kampus Anda untuk langsung mengakses portal e-voting</p>

            <div class="row g-4 justify-content-center">
                @forelse($kampuses as $kampus)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('campus.portal', $kampus->slug) }}" class="kampus-card"
                            style="--k-primary: {{ $kampus->primary_color ?? '#667eea' }}; --k-secondary: {{ $kampus->secondary_color ?? '#764ba2' }};">
                            @if ($kampus->logo)
                                <img src="{{ asset('storage/' . $kampus->logo) }}" alt="{{ $kampus->nama }}"
                                    class="logo-img">
                            @else
                                <div class="logo-placeholder">
                                    <i class="fas fa-university"></i>
                                </div>
                            @endif
                            <div class="kampus-name">{{ $kampus->nama }}</div>
                            <div class="kampus-code">{{ $kampus->kode }}</div>
                            @if ($kampus->slug)
                                <div class="portal-link-text">
                                    <i class="fas fa-link me-1"></i>
                                    /{{ $kampus->slug }}
                                </div>
                            @endif
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fas fa-university fa-3x mb-3 opacity-25"></i>
                        <p class="fw-semibold">Belum ada kampus yang terdaftar.</p>
                        <p class="small">Silakan hubungi Super Admin untuk mendaftarkan kampus Anda.</p>
                    </div>
                @endforelse
            </div>

            <div class="footer-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-user-shield"></i> Login Super Admin
                </a>
            </div>
        </div>
    </div>
</body>

</html>
