<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Petugas | E-Voting BEM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #667eea;
      --secondary-color: #764ba2;
      --danger-color: #ef4444;
      --dark-color: #1f2937;
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
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card {
      background: var(--white);
      border-radius: 32px;
      box-shadow: var(--shadow-xl);
      padding: 3.5rem 3rem;
      max-width: 480px;
      width: 100%;
      position: relative;
      overflow: hidden;
      animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
      background-size: 200% 100%;
      animation: shimmer 5s linear infinite;
    }

    .login-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .logo-icon {
      width: 85px;
      height: 85px;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border-radius: 26px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      box-shadow: var(--shadow-md);
      animation: bounceIcon 3s ease-in-out infinite;
    }

    .logo-icon i {
      font-size: 2.5rem;
      color: var(--white);
      text-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .login-title {
      font-size: 2.25rem;
      font-weight: 800;
      color: var(--dark-color);
      margin-bottom: 0.5rem;
      letter-spacing: -1.5px;
    }

    .login-subtitle {
      font-size: 1.1rem;
      color: #6b7280;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 1.75rem;
      animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .form-group:nth-child(1) {
      animation-delay: 0.2s;
    }

    .form-group:nth-child(2) {
      animation-delay: 0.3s;
    }

    .form-label {
      font-weight: 700;
      color: var(--dark-color);
      margin-bottom: 0.75rem;
      font-size: 0.9rem;
      display: block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: color 0.3s ease;
    }

    .input-wrapper {
      position: relative;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-wrapper i {
      position: absolute;
      left: 1.5rem;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 1.2rem;
      transition: all 0.3s ease;
      z-index: 10;
    }

    .form-control {
      border: 2px solid #f3f4f7;
      border-radius: 18px;
      padding: 1.1rem 1.25rem 1.1rem 4rem;
      font-size: 1rem;
      font-weight: 500;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      background: #f8fafc;
      width: 100%;
    }

    .form-control:focus {
      background: var(--white);
      border-color: var(--primary-color);
      box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
      outline: none;
      padding-left: 4.25rem;
    }

    .form-control:focus+i {
      color: var(--primary-color);
      transform: translateY(-50%) scale(1.15);
    }

    .form-group:focus-within .form-label {
      color: var(--primary-color);
    }

    .btn-login {
      width: 100%;
      padding: 1.25rem;
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--primary-color));
      background-size: 200% 100%;
      border: none;
      border-radius: 18px;
      color: var(--white);
      font-weight: 800;
      font-size: 1.1rem;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      margin-top: 1rem;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.75rem;
      animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
      animation-delay: 0.4s;
    }

    .btn-login:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(102, 126, 234, 0.5);
      background-position: 100% 0;
    }

    .btn-login:active {
      transform: translateY(-2px) scale(0.98);
    }

    .alert {
      border-radius: 16px;
      border: none;
      padding: 1rem 1.25rem;
      margin-bottom: 2rem;
      font-weight: 500;
    }

    .alert-danger {
      background: #fef2f2;
      color: #991b1b;
    }

    .alert-success {
      background: #f0fdf4;
      color: #166534;
    }

    .back-link {
      text-align: center;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 1px solid #f3f4f6;
    }

    .back-link a {
      color: #6b7280;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      font-size: 0.95rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .back-link a i {
      font-size: 1.1rem;
      color: var(--primary-color);
    }

    .back-link a:hover {
      color: var(--primary-color);
      transform: translateX(-5px);
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 2.5rem 1.5rem;
        border-radius: 24px;
      }

      .login-title {
        font-size: 1.75rem;
      }
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

  <div class="container px-3">
    <div class="login-card">
      <div class="login-header">
        <div class="logo-icon">
          <i class="fas fa-clipboard-check"></i>
        </div>
        <h1 class="login-title">Login Petugas</h1>
        <p class="login-subtitle">Daftar Hadir Offline Voting</p>
      </div>

      @if($errors->any())
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Error!</strong> {{ $errors->first() }}
      </div>
      @endif

      @if(session('success'))
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
      </div>
      @endif

      <form action="{{ route('petugas.login') }}" method="POST">
        @csrf

        <div class="form-group">
          <label for="email" class="form-label">Email Petugas</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="petugas@evoting.com"
              required
              autofocus>
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              class="form-control @error('password') is-invalid @enderror"
              id="password"
              name="password"
              placeholder="••••••••"
              required>
          </div>
        </div>

        <button type="submit" class="btn btn-login">
          <span>Login Sistem</span>
          <i class="fas fa-arrow-right"></i>
        </button>
      </form>

      <div class="back-link">
        <a href="{{ route('landing') }}">
          <i class="fas fa-arrow-left me-1"></i>
          Kembali ke Halaman Utama
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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