<!DOCTYPE html>
<html lang="id">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Tidak Ada Tahapan Aktif | E-Voting BEM</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
 <style>
  :root {
   --primary-color: #667eea;
   --secondary-color: #764ba2;
   --warning-color: #f59e0b;
   --white: #ffffff;
   --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.2);
  }

  body {
   font-family: 'Inter', sans-serif;
   background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
   min-height: 100vh;
   display: flex;
   align-items: center;
   justify-content: center;
   padding: 2rem;
  }

  .message-card {
   background: var(--white);
   border-radius: 24px;
   box-shadow: var(--shadow-xl);
   padding: 3rem 2.5rem;
   max-width: 500px;
   text-align: center;
  }

  .icon-wrapper {
   width: 100px;
   height: 100px;
   background: linear-gradient(135deg, #fef3c7, #fde68a);
   border-radius: 50%;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   margin-bottom: 2rem;
  }

  .icon-wrapper i {
   font-size: 3rem;
   color: var(--warning-color);
  }

  h1 {
   font-size: 1.75rem;
   font-weight: 800;
   color: #1f2937;
   margin-bottom: 1rem;
  }

  p {
   font-size: 1.125rem;
   color: #6b7280;
   line-height: 1.6;
   margin-bottom: 2rem;
  }

  .btn-primary {
   background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
   border: none;
   padding: 0.875rem 2rem;
   border-radius: 12px;
   font-weight: 700;
   color: var(--white);
   text-decoration: none;
   display: inline-block;
   transition: all 0.3s ease;
  }

  .btn-primary:hover {
   transform: translateY(-2px);
   box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
   color: var(--white);
  }
 </style>
</head>

<body>

 <div class="message-card">
  <div class="icon-wrapper">
   <i class="fas fa-exclamation-triangle"></i>
  </div>
  <h1>Tidak Ada Tahapan Aktif</h1>
  <p>Saat ini belum ada tahapan voting yang aktif. Silakan hubungi administrator untuk informasi lebih lanjut.</p>
  <a href="{{ route('landing') }}" class="btn-primary">
   <i class="fas fa-arrow-left me-2"></i>
   Kembali ke Halaman Utama
  </a>
 </div>

</body>

</html>