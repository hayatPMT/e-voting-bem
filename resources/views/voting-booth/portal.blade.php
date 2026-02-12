@extends('layouts.voting')

@section('content')
<div class="row min-vh-100 align-items-center justify-content-center py-5">
 <div class="col-md-10 col-lg-8">
  <div class="text-center mb-5">
   <div class="mb-4">
    <i class="fas fa-desktop text-primary" style="font-size: 5rem; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));"></i>
   </div>
   <h1 class="display-4 font-weight-bold text-dark mb-2">Portal Bilik Suara</h1>
   <p class="lead text-muted">Silakan pilih bilik suara yang ingin diaktifkan pada perangkat ini.</p>
  </div>

  <div class="row">
   @forelse($booths as $booth)
   <div class="col-md-6 mb-4">
    <a href="{{ route('voting-booth.standby', $booth->id) }}" class="text-decoration-none">
     <div class="card border-0 shadow-sm hover-lift h-100" style="border-radius: 20px; transition: all 0.3s ease;">
      <div class="card-body p-4 text-center">
       <div class="booth-icon mb-3 mx-auto d-flex align-items-center justify-content-center"
        style="width: 80px; height: 80px; background: rgba(0, 123, 255, 0.1); border-radius: 20px;">
        <i class="fas fa-booth-curtain text-primary" style="font-size: 2.5rem;"></i>
       </div>
       <h3 class="font-weight-bold text-dark mb-1">{{ $booth->nama_booth }}</h3>
       <p class="text-muted mb-3"><i class="fas fa-map-marker-alt mr-2 text-danger"></i>{{ $booth->lokasi ?? 'Lokasi Umum' }}</p>

       <div class="btn btn-primary btn-block py-2 font-weight-bold" style="border-radius: 12px;">
        AKTIFKAN BILIK INI <i class="fas fa-arrow-right ml-2"></i>
       </div>
      </div>
     </div>
    </a>
   </div>
   @empty
   <div class="col-12 text-center py-5 bg-white shadow-sm rounded-lg" style="border-radius: 20px;">
    <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
    <h4 class="font-weight-bold text-muted">Belum ada bilik suara aktif</h4>
    <p class="text-muted">Silakan hubungi administrator untuk menambah atau mengaktifkan bilik suara.</p>
   </div>
   @endforelse
  </div>

  <div class="mt-5 text-center">
   <a href="{{ route('landing') }}" class="btn btn-link text-muted">
    <i class="fas fa-chevron-left mr-2"></i> Kembali ke Beranda
   </a>
  </div>
 </div>
</div>

<style>
 .hover-lift:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
  background: linear-gradient(to bottom right, #ffffff, #f0f7ff);
 }

 .booth-icon {
  transition: all 0.3s ease;
 }

 .hover-lift:hover .booth-icon {
  background: #007bff !important;
 }

 .hover-lift:hover .booth-icon i {
  color: #fff !important;
 }
</style>
@endsection