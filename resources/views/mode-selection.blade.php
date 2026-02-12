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
   border-radius: 24px;
   box-shadow: var(--shadow-xl);
   padding: 3.5rem 3rem;
   max-width: 900px;
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
   height: 5px;
   background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
  }

  .header-section {
   text-align: center;
   margin-bottom: 3rem;
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
   font-size: 2.5rem;
   font-weight: 800;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   margin-bottom: 0.75rem;
  }

  .main-subtitle {
   font-size: 1.125rem;
   color: #6b7280;
   font-weight: 500;
  }

  @if( !$tahapanActive) .alert-box {
   background: linear-gradient(135deg, #fef3c7, #fde68a);
   border-left: 4px solid var(--warning-color);
   padding: 1.5rem;
   border-radius: 12px;
   margin-bottom: 2rem;
  }

  .alert-box h3 {
   color: #92400e;
   font-size: 1.25rem;
   font-weight: 700;
   margin-bottom: 0.5rem;
  }

  .alert-box p {
   color: #78350f;
   margin: 0;
  }

  @endif .mode-grid {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
   gap: 2rem;
   margin-bottom: 2rem;
  }

  .mode-card {
   background: var(--white);
   border: 2px solid #e5e7eb;
   border-radius: 20px;
   padding: 2.5rem 2rem;
   text-align: center;
   cursor: pointer;
   transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   position: relative;
   overflow: hidden;
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
   transition: opacity 0.4s ease;
   z-index: 0;
  }

  .mode-card>* {
   position: relative;
   z-index: 1;
  }

  .mode-card:hover {
   transform: translateY(-8px);
   box-shadow: var(--shadow-lg);
   border-color: transparent;
  }

  .mode-card:hover::before {
   opacity: 1;
  }

  .mode-card:hover .mode-icon-wrapper {
   background: rgba(255, 255, 255, 0.2);
   border-color: rgba(255, 255, 255, 0.3);
  }

  .mode-card:hover .mode-icon-wrapper i {
   color: var(--white);
  }

  .mode-card:hover .mode-title,
  .mode-card:hover .mode-desc {
   color: var(--white);
  }

  .mode-icon-wrapper {
   width: 90px;
   height: 90px;
   background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
   border: 3px solid #e5e7eb;
   border-radius: 22px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   margin-bottom: 1.5rem;
   transition: all 0.4s ease;
  }

  .mode-icon-wrapper i {
   font-size: 2.5rem;
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   background-clip: text;
   transition: all 0.4s ease;
  }

  .mode-title {
   font-size: 1.5rem;
   font-weight: 700;
   margin-bottom: 0.75rem;
   transition: color 0.4s ease;
  }

  .mode-desc {
   font-size: 1rem;
   color: #6b7280;
   line-height: 1.6;
   transition: color 0.4s ease;
  }

  .footer-links {
   text-align: center;
   padding-top: 2rem;
   border-top: 1px solid #e5e7eb;
  }

  .footer-links a {
   color: var(--primary-color);
   text-decoration: none;
   font-weight: 600;
   margin: 0 1rem;
   transition: color 0.3s ease;
  }

  .footer-links a:hover {
   color: var(--secondary-color);
  }

  @media (max-width: 768px) {
   .mode-selection-card {
    padding: 2.5rem 1.5rem;
   }

   .main-title {
    font-size: 2rem;
   }

   .mode-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
   }
  }
 </style>
</head>

<body>

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
    <a href="{{ route('old.landing') }}">
     <i class="fas fa-users"></i> Akses Lainnya
    </a>
   </div>
  </div>
 </div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>