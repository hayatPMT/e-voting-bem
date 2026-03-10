<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi Mahasiswa - {{ $kampus->nama }}">
    <title>Verifikasi Mahasiswa | {{ $kampus->nama }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $kampus->primary_color ?? '#667eea' }};
            --secondary-color: {{ $kampus->secondary_color ?? '#764ba2' }};
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --gray-50: #f9fafb;
            --gray-200: #e5e7eb;
            --gray-700: #374151;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1rem; position: relative; overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.08) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite; z-index: 0;
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

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes pulseFade {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        #page-loader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; z-index: 9999;
            display: flex; justify-content: center; align-items: center;
            transition: opacity 0.5s ease-out, visibility 0.5s;
        }
        .loader-content { text-align: center; animation: pulseFade 1.5s ease-in-out infinite; }
        .loader-icon { font-size: 3.5rem; color: var(--primary-color); margin-bottom: 1rem; }

        .back-link {
            position: absolute; top: 1.5rem; left: 1.5rem; z-index: 10;
        }
        .back-link a {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: white; text-decoration: none; font-weight: 600;
            background: rgba(255,255,255,0.15); padding: 0.5rem 1rem;
            border-radius: 10px; backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }
        .back-link a:hover { background: rgba(255,255,255,0.25); transform: translateX(-2px); }

        .login-container {
            width: 100%; max-width: 480px; padding: 1rem;
            position: relative; z-index: 1;
        }

        .login-card {
            background: white; border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden; position: relative;
            animation: slideUpFade 0.8s cubic-bezier(0.16,1,0.3,1);
        }

        .login-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
            background-size: 200% 100%;
            animation: shimmer 5s linear infinite; z-index: 2;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 3rem 2rem 2.5rem;
            text-align: center; color: white;
        }

        .login-icon-wrap {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 22px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .login-icon-wrap i { font-size: 2.25rem; color: white; }

        .kampus-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 0.3rem 0.875rem; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .login-header h1 { font-size: 1.875rem; font-weight: 800; margin-bottom: 0.375rem; }
        .login-header p { font-size: 0.9375rem; opacity: 0.9; margin: 0; font-weight: 500; }

        .login-body { padding: 2.5rem 2rem; }

        .form-group {
            margin-bottom: 1.75rem;
            animation: slideUpFade 0.8s cubic-bezier(0.16,1,0.3,1) both;
        }
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }

        .form-group label {
            font-weight: 600; color: var(--gray-700);
            margin-bottom: 0.75rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .form-group label i { color: var(--primary-color); }

        .form-control {
            height: 52px; border-radius: 12px;
            border: 2px solid var(--gray-200);
            padding: 0.875rem 1rem; font-size: 1rem;
            transition: all 0.3s ease; font-weight: 500;
            background: var(--gray-50);
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102,126,234,0.1);
            outline: none; background: white;
        }
        .form-control.is-invalid { border-color: var(--danger-color); background: #fef2f2; }

        .invalid-feedback { display: block; color: var(--danger-color); font-size: 0.875rem; margin-top: 0.5rem; font-weight: 500; }

        .btn-login {
            width: 100%; height: 56px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--primary-color));
            background-size: 200% 100%;
            border: none; border-radius: 16px;
            color: white; font-weight: 800; font-size: 1.1rem;
            cursor: pointer; transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            margin-top: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            display: flex; align-items: center; justify-content: center; gap: 0.75rem;
        }
        .btn-login:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0,0,0,0.25); color: white; }

        .alert {
            border-radius: 12px; border: none;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            font-weight: 500; display: flex; align-items: center; gap: 0.75rem;
        }
        .alert-danger { background: #fef2f2; color: #991b1b; border-left: 4px solid var(--danger-color); }
        .alert .close { margin-left: auto; }

        .login-footer {
            text-align: center; padding: 1.5rem 2rem;
            background: var(--gray-50); border-top: 1px solid var(--gray-200);
        }
        .footer-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: #4b5563; font-size: 0.875rem; font-weight: 600;
            background: white; padding: 0.5rem 1rem;
            border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .footer-badge i { color: var(--primary-color); }
    </style>
</head>

<body>
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-icon"><i class="fas fa-user-graduate fa-spin"></i></div>
            <h5 style="color: var(--dark-color); font-weight: 800;">Verifikasi Mahasiswa</h5>
            <small style="color: #6b7280;">{{ $kampus->nama }}</small>
        </div>
    </div>

    <div class="back-link">
        <a href="{{ route('campus.portal', $kampus->slug) }}">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="kampus-badge">
                    <i class="fas fa-university"></i> {{ $kampus->kode }}
                </div>
                <br>
                <div class="login-icon-wrap">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h1>Verifikasi Mahasiswa</h1>
                <p>{{ $kampus->nama }}</p>
            </div>

            <div class="login-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div> @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST"
        action="{{ route('campus.verifikasi.process', $kampus->slug) }}">
    @csrf

    <div class="form-group">
        <label for="nim">
            <i class="fas fa-id-card"></i> Nomor Induk Mahasiswa (NIM)
        </label>
        <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror"
            placeholder="Masukkan NIM Anda" required autofocus value="{{ old('nim') }}">
        @error('nim')
            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">
            <i class="fas fa-lock"></i> Password
        </label>
        <input type="password" id="password" name="password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password Anda" required>
        @error('password')
            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn-login">
        <i class="fas fa-check-circle"></i>
        Verifikasi & Lanjutkan
    </button>
    </form>
    </div>

    <div class="login-footer">
        <div class="footer-badge">
            <i class="fas fa-shield-alt"></i>
            Portal Resmi {{ $kampus->nama }}
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
    </script>
    </body>

</html>
