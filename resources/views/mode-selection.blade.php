<!DOCTYPE html>
<html lang="id">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="description" content="Sistem E-Voting BEM - Pilih Mode Voting">
 <title>E-Voting BEM | Pilih Mode Voting</title>
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

  .mode-selection-card {
   background: var(--white);
   border-radius: 32px;
   box-shadow: var(--shadow-xl);
   padding: 4rem 3rem;
   max-width: 960px;
   margin: 0 auto;
   position: relative;
   overflow: hidden;
  }

  .mode-selection-card::before {
   content: '';
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   height: 6px;
   background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
  }

  .header-section {
   text-align: center;
   margin-bottom: 3.5rem;
  }

  .logo-icon {
   width: 80px;
   height: 80px;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   border-radius: 24px;
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
   font-size: 2.25rem;
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
   letter-spacing: -1px;
  }

  .main-subtitle {
   font-size: 1.125rem;
   color: #6b7280;
   font-weight: 500;
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

  .mode-selection-card {
   animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
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

  .alert-box {
   background: linear-gradient(135deg, #fffbeb, #fef3c7);
   border-left: 5px solid var(--warning-color);
   padding: 1.5rem;
   border-radius: 16px;
   margin-bottom: 2.5rem;
   box-shadow: var(--shadow-sm);
  }

  .alert-box h3 {
   color: #92400e;
   font-size: 1.25rem;
   font-weight: 700;
   margin-bottom: 0.5rem;
   display: flex;
   align-items: center;
   gap: 0.75rem;
  }

  .alert-box p {
   color: #78350f;
   margin: 0;
   font-size: 0.95rem;
   line-height: 1.6;
  }

  .mode-grid {
   display: grid;
   grid-template-columns: repeat(2, 1fr);
   gap: 2.5rem;
   margin-bottom: 3rem;
  }

  /* Button Reset & Styling */
  .mode-card {
   background: var(--white);
   border: 2px solid #f3f4f6;
   border-radius: 24px;
   padding: 3rem 2rem;
   text-align: center;
   cursor: pointer;
   transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
   position: relative;
   overflow: hidden;
   width: 100%;
   display: flex;
   flex-direction: column;
   align-items: center;
   text-decoration: none;
   outline: none !important;
   box-shadow: var(--shadow-sm);
  }

  .mode-card::before {
   content: '';
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   opacity: 0;
   transition: opacity 0.5s ease;
   z-index: 0;
  }

  .mode-card>* {
   position: relative;
   z-index: 1;
   transition: all 0.4s ease;
  }

  .mode-card:hover {
   transform: translateY(-12px);
   box-shadow: var(--shadow-xl);
   border-color: transparent;
  }

  .mode-card:hover::before {
   opacity: 1;
  }

  .mode-card:hover .mode-icon-wrapper {
   background: rgba(255, 255, 255, 0.2);
   border-color: rgba(255, 255, 255, 0.3);
   transform: scale(1.1);
  }

  .mode-card:hover .mode-icon-wrapper i {
   color: var(--white);
   -webkit-text-fill-color: var(--white);
  }

  .mode-card:hover .mode-title,
  .mode-card:hover .mode-desc {
   color: var(--white);
  }

  .mode-icon-wrapper {
   width: 100px;
   height: 100px;
   background: #f9fafb;
   border: 3px solid #f3f4f6;
   border-radius: 28px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   margin-bottom: 2rem;
   transition: all 0.4s ease;
  }

  .mode-icon-wrapper i {
   font-size: 2.75rem;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
  }

  .mode-title {
   font-size: 1.75rem;
   font-weight: 800;
   margin-bottom: 1rem;
   color: var(--dark-color);
   letter-spacing: -0.5px;
  }

  .mode-desc {
   font-size: 1rem;
   color: #6b7280;
   line-height: 1.6;
   max-width: 280px;
  }

  .footer-links {
   text-align: center;
   padding-top: 2.5rem;
   border-top: 1px solid #f3f4f6;
   display: flex;
   justify-content: center;
   flex-wrap: wrap;
   gap: 2rem;
  }

  .footer-links a {
   color: #6b7280;
   text-decoration: none;
   font-weight: 600;
   font-size: 0.95rem;
   transition: all 0.3s ease;
   display: flex;
   align-items: center;
   gap: 0.5rem;
  }

  .footer-links a i {
   color: var(--primary-color);
   font-size: 1.1rem;
  }

  .footer-links a:hover {
   color: var(--primary-color);
   transform: translateY(-2px);
  }

  @media (max-width: 992px) {
   .mode-selection-card {
    padding: 3rem 2rem;
   }

   .mode-grid {
    gap: 1.5rem;
   }
  }

  @media (max-width: 768px) {
   .mode-selection-card {
    border-radius: 0;
    padding: 2.5rem 1.5rem;
    margin: 0;
    min-height: 100vh;
    max-width: none;
   }

   .main-title {
    font-size: 2.25rem;
   }

   .mode-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
   }

   .mode-card {
    padding: 2.5rem 1.5rem;
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
   <h5 class="font-weight-bold" style="color: var(--dark-color); font-weight: 800; letter-spacing: -0.5px;">E-Voting BEM</h5>
  </div>
 </div>

 <div class="container px-3">
  <div class="mode-selection-card">
   <!-- Header -->
   <div class="header-section">
    <div class="logo-icon">
     <i class="fas fa-vote-yea"></i>
    </div>
    <h1 class="main-title">E-Voting BEM</h1>
    <p class="main-subtitle">Pilih Mode Voting Anda</p>
   </div>

   @if(!$tahapanActive)
   <!-- Alert when no active tahapan -->
   <div class="alert-box">
    <h3><i class="fas fa-exclamation-triangle"></i> {{ $message }}</h3>
    @if(isset($tahapan))
    <p>
     <strong>Tahapan:</strong> {{ $tahapan->nama_tahapan }}<br>
     <strong>Waktu:</strong> {{ $tahapan->waktu_mulai->format('d M Y H:i') }} - {{ $tahapan->waktu_selesai->format('d M Y H:i') }}
    </p>
    @else
    <p>Silakan hubungi administrator untuk informasi lebih lanjut.</p>
    @endif
   </div>
   @else
   <!-- Mode Selection Grid -->
   <form action="{{ route('mode.select') }}" method="POST">
    @csrf
    <div class="mode-grid">
     <!-- Online Mode -->
     <button type="submit" name="mode" value="online" class="mode-card">
      <div class="mode-icon-wrapper">
       <i class="fas fa-laptop"></i>
      </div>
      <div class="mode-title">Mode Online</div>
      <div class="mode-desc">
       Voting dari mana saja dengan login menggunakan NIM dan password Anda
      </div>
     </button>

     <!-- Offline Mode -->
     <button type="submit" name="mode" value="offline" class="mode-card">
      <div class="mode-icon-wrapper">
       <i class="fas fa-building"></i>
      </div>
      <div class="mode-title">Mode Offline</div>
      <div class="mode-desc">
       Voting di lokasi dengan bantuan petugas daftar hadir
      </div>
     </button>
    </div>
   </form>
   @endif

   <!-- Footer Links -->
   <div class="footer-links">
    <a href="{{ route('public.chart') }}">
     <i class="fas fa-chart-line"></i> Lihat Hasil Real-time
    </a>
    <a href="{{ route('voting-booth.portal') }}">
     <i class="fas fa-desktop"></i> Portal Bilik
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