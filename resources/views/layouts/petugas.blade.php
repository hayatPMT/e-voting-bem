<!DOCTYPE html>
<html lang="id">

<head>
 <meta charset="UTF-8">
 <title>Petugas Dashboard | E-Voting BEM</title>
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

 <!-- AdminLTE CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

 <style>
  /* Responsive Adjustments */
  @media (max-width: 768px) {
   .content-wrapper {
    padding: 0.5rem !important;
   }

   .card {
    margin-bottom: 1rem;
   }
  }
 </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
 <div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <ul class="navbar-nav">
    <li class="nav-item">
     <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
   </ul>
   <ul class="navbar-nav ml-auto">
    <li class="nav-item">
     <a href="{{ route('petugas.logout') }}" class="nav-link text-danger">
      <i class="fas fa-sign-out-alt mr-1"></i> Logout
     </a>
    </li>
   </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="{{ route('petugas.attendance.index') }}" class="brand-link text-center">
    <span class="brand-text font-weight-bold">Petugas E-Voting</span>
   </a>

   <div class="sidebar">
    <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column">
      <li class="nav-item">
       <a href="{{ route('petugas.attendance.index') }}" class="nav-link {{ request()->routeIs('petugas.attendance.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Daftar Hadir</p>
       </a>
      </li>
     </ul>
    </nav>
   </div>
  </aside>

  <!-- Content -->
  <div class="content-wrapper p-3">
   @yield('content')
  </div>

  <footer class="main-footer text-center">
   <strong>&copy; {{ date('Y') }} E-Voting BEM</strong>
  </footer>

 </div>

 <!-- JS -->
 <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 @stack('scripts')
</body>

</html>