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
   --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.2);
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
   padding: 2rem 0;
  }

  .login-card {
   background: var(--white);
   border-radius: 24px;
   box-shadow: var(--shadow-xl);
   padding: 3rem 2.5rem;
   max-width: 450px;
   width: 100%;
   position: relative;
   overflow: hidden;
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

  .login-header {
   text-align: center;
   margin-bottom: 2.5rem;
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
  }

  .logo-icon i {
   font-size: 2rem;
   color: var(--white);
  }

  .login-title {
   font-size: 1.75rem;
   font-weight: 800;
   color: var(--dark-color);
   margin-bottom: 0.5rem;
  }

  .login-subtitle {
   font-size: 1rem;
   color: #6b7280;
   font-weight: 500;
  }

  .form-group {
   margin-bottom: 1.5rem;
  }

  .form-label {
   font-weight: 600;
   color: var(--dark-color);
   margin-bottom: 0.5rem;
   font-size: 0.9375rem;
  }

  .form-control {
   border: 2px solid #e5e7eb;
   border-radius: 12px;
   padding: 0.875rem 1rem;
   font-size: 1rem;
   transition: all 0.3s ease;
  }

  .form-control:focus {
   border-color: var(--primary-color);
   box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  .input-group {
   position: relative;
  }

  .input-group i {
   position: absolute;
   left: 1rem;
   top: 50%;
   transform: translateY(-50%);
   color: #9ca3af;
   z-index: 10;
  }

  .input-group .form-control {
   padding-left: 3rem;
  }

  .btn-login {
   width: 100%;
   padding: 1rem;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   border: none;
   border-radius: 12px;
   color: var(--white);
   font-weight: 700;
   font-size: 1rem;
   transition: all 0.3s ease;
   margin-top: 1rem;
  }

  .btn-login:hover {
   transform: translateY(-2px);
   box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
  }

  .alert {
   border-radius: 12px;
   border: none;
   padding: 1rem 1.25rem;
   margin-bottom: 1.5rem;
  }

  .back-link {
   text-align: center;
   margin-top: 1.5rem;
   padding-top: 1.5rem;
   border-top: 1px solid #e5e7eb;
  }

  .back-link a {
   color: var(--primary-color);
   text-decoration: none;
   font-weight: 600;
   transition: color 0.3s ease;
  }

  .back-link a:hover {
   color: var(--secondary-color);
  }

  @media (max-width: 576px) {
   .login-card {
    padding: 2rem 1.5rem;
   }

   .login-title {
    font-size: 1.5rem;
   }
  }
 </style>
</head>

<body>

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
     <label for="email" class="form-label">Email</label>
     <div class="input-group">
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
     <div class="input-group">
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
     <i class="fas fa-sign-in-alt me-2"></i>
     Login
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
</body>

</html>