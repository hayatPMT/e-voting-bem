@extends('layouts.voting')
@section('title', 'Bilik Suara')

@section('content')

<div class="container-fluid px-3 px-md-4" style="max-width: 1400px;">
 <!-- Circular Countdown Timer -->
 <div class="row mb-5 justify-content-center">
  <div class="col-lg-10">
   <div id="countdown-widget" class="text-center position-relative overflow-hidden pt-4 pb-5 pl-4 pr-4"
    style="background: white; border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.1);">

    <h3 id="countdown-title" class="font-weight-bold mb-5" style="color: #1f2937; font-size: 1.8rem; letter-spacing: -0.5px;">Sisa Waktu Voting</h3>

    <div id="timer-container" class="d-flex flex-wrap justify-content-center align-items-center" style="gap: 2rem;">
     <!-- Status Message -->
     <div id="timer-message" class="d-none w-100 text-center py-2">
      <h4 class="font-weight-bold mb-0"></h4>
     </div>

     <!-- Days -->
     <div class="timer-circle-container">
      <svg class="timer-svg" viewBox="0 0 100 100">
       <circle class="timer-bg-ring" cx="50" cy="50" r="45"></circle>
       <circle class="timer-progress-ring" id="p-days" cx="50" cy="50" r="45" pathLength="283"></circle>
      </svg>
      <div class="timer-text-content">
       <div class="timer-number" id="c-days">00</div>
       <div class="timer-label">HARI</div>
      </div>
     </div>

     <!-- Hours -->
     <div class="timer-circle-container">
      <svg class="timer-svg" viewBox="0 0 100 100">
       <circle class="timer-bg-ring" cx="50" cy="50" r="45"></circle>
       <circle class="timer-progress-ring" id="p-hours" cx="50" cy="50" r="45" pathLength="283"></circle>
      </svg>
      <div class="timer-text-content">
       <div class="timer-number" id="c-hours">00</div>
       <div class="timer-label">JAM</div>
      </div>
     </div>

     <!-- Minutes -->
     <div class="timer-circle-container">
      <svg class="timer-svg" viewBox="0 0 100 100">
       <circle class="timer-bg-ring" cx="50" cy="50" r="45"></circle>
       <circle class="timer-progress-ring" id="p-minutes" cx="50" cy="50" r="45" pathLength="283"></circle>
      </svg>
      <div class="timer-text-content">
       <div class="timer-number" id="c-minutes">00</div>
       <div class="timer-label">MENIT</div>
      </div>
     </div>

     <!-- Seconds -->
     <div class="timer-circle-container">
      <svg class="timer-svg" viewBox="0 0 100 100">
       <circle class="timer-bg-ring" cx="50" cy="50" r="45"></circle>
       <circle class="timer-progress-ring" id="p-seconds" cx="50" cy="50" r="45" pathLength="283"></circle>
      </svg>
      <div class="timer-text-content">
       <div class="timer-number" id="c-seconds">00</div>
       <div class="timer-label">DETIK</div>
      </div>
     </div>
    </div>

    <div class="mt-5 pt-3 border-top d-flex justify-content-center align-items-center flex-wrap" style="gap: 1.5rem; color: #6b7280; font-size: 0.9rem;">
     <span class="d-flex align-items-center">
      <i class="fas fa-play-circle mr-2" style="color: #10b981;"></i>
      Mulai: <span class="font-weight-bold ml-1 text-dark">{{ $setting?->voting_start?->translatedFormat('d M H:i') ?? '-' }}</span>
     </span>
     <span class="d-none d-sm-inline text-muted">|</span>
     <span class="d-flex align-items-center">
      <i class="fas fa-stop-circle mr-2" style="color: #ef4444;"></i>
      Selesai: <span class="font-weight-bold ml-1 text-dark">{{ $setting?->voting_end?->translatedFormat('d M H:i') ?? '-' }}</span>
     </span>
    </div>
   </div>
  </div>
 </div>


 <!-- Candidates Grid -->
 <div class="row align-items-center mb-4">
  <div class="col-md-8">
   <h2 class="font-weight-bold text-dark mb-1">Pilih Kandidat Anda</h2>
   <p class="text-muted mb-0" style="font-size: 1.05rem;">
    Silakan pilih salah satu kandidat di bawah ini. Pilihan bersifat <strong>final</strong>.
   </p>
  </div>
  <div class="col-md-4 text-md-right mt-3 mt-md-0">
   <div class="badge badge-primary px-3 py-2 rounded-pill" style="font-size: 0.9rem;">
    <i class="fas fa-user-check mr-2"></i>Mahasiswa: {{ $attendance->mahasiswa->name }}
   </div>
  </div>
 </div>

 <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4 justify-content-center">
  @forelse ($kandidat as $k)
  <div class="col mb-4">
   <div class="card candidate-card h-100 border-0" style="border-radius: 20px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
    <!-- Candidate Header/Image -->
    <div class="position-relative" style="height: 280px; background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);">
     @if ($k->foto)
     <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
      class="w-100 h-100" style="object-fit: cover; object-position: top;">
     @else
     <div class="d-flex align-items-center justify-content-center h-100">
      <i class="fas fa-user" style="font-size: 5rem; opacity: 0.3; color: #9ca3af;"></i>
     </div>
     @endif
     <!-- Candidate Number Badge -->
     <div class="position-absolute" style="top: 1rem; left: 1rem;">
      <div style="background: linear-gradient(135deg, #667eea, #764ba2); 
                                            color: white; 
                                            width: 45px; 
                                            height: 45px; 
                                            border-radius: 12px; 
                                            display: flex; 
                                            align-items: center; 
                                            justify-content: center;
                                            font-weight: 800;
                                            font-size: 1.25rem;
                                            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
       {{ $loop->iteration }}
      </div>
     </div>
    </div>

    <!-- Candidate Body -->
    <div class="card-body d-flex flex-column p-4" style="background: white;">
     <h5 class="candidate-name mb-3" style="font-weight: 700; font-size: 1.25rem; color: #1f2937; line-height: 1.3;">
      {{ $k->nama }}
     </h5>

     <div class="candidate-vision flex-grow-1 mb-3"
      style="background: #f9fafb; 
                                        padding: 1rem; 
                                        border-radius: 12px; 
                                        border-left: 4px solid #667eea;">
      <small class="d-block mb-2" style="color: #667eea; font-weight: 700; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">
       <i class="fas fa-lightbulb mr-1"></i> Visi
      </small>
      <p class="mb-0" style="font-size: 0.9rem; color: #4b5563; line-height: 1.6;">
       {{ Str::limit($k->visi, 120) }}
      </p>
     </div>

     <!-- Preview Button -->
     <button type="button"
      class="btn btn-block btn-outline-primary mb-3"
      data-toggle="modal"
      data-target="#previewModal{{ $k->id }}"
      style="border: 2px solid #667eea; 
                                           color: #667eea; 
                                           border-radius: 12px; 
                                           padding: 0.75rem;
                                           font-weight: 600;
                                           font-size: 0.9rem;
                                           transition: all 0.3s ease;">
      <i class="fas fa-eye mr-2"></i>Lihat Detail Visi & Misi
     </button>

     <!-- Vote Button -->
     <div class="mt-auto">
      <form action="{{ route('voting-booth.vote', $attendance->session_token) }}" method="POST">
       @csrf
       <input type="hidden" name="kandidat_id" value="{{ $k->id }}">
       <button type="submit" class="btn btn-block btn-vote shadow-sm"
        onclick="return confirm('Apakah Anda yakin memilih {{ $k->nama }}?\n\nPilihan Anda bersifat FINAL.')"
        style="background: linear-gradient(135deg, #667eea, #764ba2); 
                                                  color: white; 
                                                  border: none; 
                                                  border-radius: 12px; 
                                                  padding: 0.875rem;
                                                  font-weight: 700;
                                                  font-size: 0.95rem;
                                                  transition: all 0.3s ease;">
        <i class="fas fa-check-circle mr-2"></i>Pilih Kandidat
       </button>
      </form>
     </div>
    </div>
   </div>
  </div>
  @empty
  <div class="col-12 text-center py-5">
   <h5 class="text-muted">Belum ada kandidat.</h5>
  </div>
  @endforelse
 </div>
</div>

<!-- Candidate Preview Modals -->
@foreach ($kandidat as $k)
<div class="modal fade" id="previewModal{{ $k->id }}" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
   <div class="modal-header border-0 position-relative" style="background: linear-gradient(135deg, #667eea, #764ba2); padding: 2rem;">
    <div class="w-100 text-white">
     <h4 class="modal-title font-weight-bold mb-1">Detail Kandidat</h4>
     <p class="mb-0" style="opacity: 0.9;">Kandidat Nomor {{ $loop->iteration }}</p>
    </div>
    <button type="button" class="close text-white" data-dismiss="modal" style="position: absolute; right: 1.5rem; top: 1.5rem; opacity: 0.9;">
     <span aria-hidden="true" style="font-size: 2rem;">&times;</span>
    </button>
   </div>

   <div class="modal-body p-4" style="background: #f9fafb;">
    <div class="row">
     <div class="col-md-4 mb-3 mb-md-0">
      <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.12);">
       @if ($k->foto)
       <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}" class="w-100" style="height: 320px; object-fit: cover; object-position: top;">
       @else
       <div class="d-flex align-items-center justify-content-center bg-light" style="height: 320px;">
        <i class="fas fa-user" style="font-size: 5rem; opacity: 0.3; color: #9ca3af;"></i>
       </div>
       @endif
      </div>
     </div>
     <div class="col-md-8">
      <div class="bg-white p-4" style="border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); height: 100%;">
       <h3 class="font-weight-bold mb-4" style="color: #1f2937; border-bottom: 3px solid #667eea; padding-bottom: 0.75rem;">
        {{ $k->nama }}
       </h3>
       <div class="mb-4 p-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #e9ecff 100%); border-radius: 12px; border-left: 5px solid #667eea;">
        <h5 class="font-weight-bold mb-2" style="color: #667eea;">VISI</h5>
        <p class="mb-0" style="color: #4b5563; line-height: 1.8; white-space: pre-line;">{{ $k->visi }}</p>
       </div>
       <div class="p-3" style="background: linear-gradient(135deg, #fef3f0 0%, #fde8e4 100%); border-radius: 12px; border-left: 5px solid #f59e0b;">
        <h5 class="font-weight-bold mb-2" style="color: #f59e0b;">MISI</h5>
        <div style="color: #4b5563; line-height: 1.8; white-space: pre-line;">{{ $k->misi }}</div>
       </div>
      </div>
     </div>
    </div>
   </div>

   <div class="modal-footer border-0 bg-white" style="padding: 1.5rem 2rem;">
    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-dismiss="modal">Tutup</button>
    <form action="{{ route('voting-booth.vote', $attendance->session_token) }}" method="POST">
     @csrf
     <input type="hidden" name="kandidat_id" value="{{ $k->id }}">
     <button type="submit" class="btn px-4 rounded-pill text-white"
      onclick="return confirm('Apakah Anda yakin memilih {{ $k->nama }}?')"
      style="background: linear-gradient(135deg, #667eea, #764ba2); font-weight: 700;">
      <i class="fas fa-check-circle mr-2"></i>Pilih Kandidat Ini
     </button>
    </form>
   </div>
  </div>
 </div>
</div>
@endforeach

<style>
 .timer-circle-container {
  position: relative;
  width: 140px;
  height: 140px;
 }

 .timer-svg {
  transform: rotate(-90deg);
  width: 100%;
  height: 100%;
 }

 .timer-bg-ring {
  fill: none;
  stroke: #f3f4f6;
  stroke-width: 6;
 }

 .timer-progress-ring {
  fill: none;
  stroke-width: 6;
  stroke-linecap: round;
  stroke-dasharray: 283;
  stroke-dashoffset: 283;
  transition: stroke-dashoffset 0.5s ease;
 }

 #p-days {
  stroke: #667eea;
 }

 #p-hours {
  stroke: #764ba2;
 }

 #p-minutes {
  stroke: #ec4899;
 }

 #p-seconds {
  stroke: #ef4444;
 }

 .timer-text-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
 }

 .timer-number {
  font-size: 2.25rem;
  font-weight: 800;
  line-height: 1;
  color: #1f2937;
 }

 .timer-label {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 1px;
  color: #9ca3af;
  margin-top: 5px;
 }

 .candidate-card {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
 }

 .candidate-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 32px rgba(102, 126, 234, 0.2) !important;
 }

 .btn-vote:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
 }

 .btn-outline-primary:hover {
  background: linear-gradient(135deg, #667eea, #764ba2) !important;
  color: white !important;
  transform: translateY(-2px);
 }

 @media (max-width: 768px) {
  .timer-circle-container {
   width: 100px;
   height: 100px;
  }

  .timer-number {
   font-size: 1.5rem;
  }

  #timer-container {
   gap: 1rem !important;
  }
 }
</style>

<script>
 function updateCountdown() {
  const serverNow = {
   {
    $serverNow
   }
  };
  const startTime = {
   {
    $startTime
   }
  };
  const endTime = {
   {
    $endTime
   }
  };

  const clientNow = new Date().getTime();
  const timeOffset = serverNow - clientNow;

  const titleElement = document.getElementById('countdown-title');
  const messageContainer = document.getElementById('timer-message');
  const messageText = messageContainer.querySelector('h4');
  const circles = document.querySelectorAll('.timer-circle-container');

  const circumference = 283;

  function setProgress(id, value, max) {
   const el = document.getElementById(id);
   if (!el) return;
   const percent = value / max;
   el.style.strokeDashoffset = circumference - (percent * circumference);
  }

  function updateTimerDisplay() {
   const now = new Date().getTime() + timeOffset;

   if (now < startTime) {
    if (titleElement) titleElement.innerText = "Voting Dimulai Dalam";
    updateTimerDigits(startTime - now);
    return;
   }

   if (now > endTime) {
    circles.forEach(c => c.style.display = 'none');
    messageContainer.classList.remove('d-none');
    messageText.innerHTML = '<i class="fas fa-flag-checkered mr-2"></i>Waktu Voting Telah Selesai';
    if (titleElement) titleElement.innerText = "Voting Selesai";
    return;
   }

   circles.forEach(c => c.style.display = 'block');
   messageContainer.classList.add('d-none');
   if (titleElement) titleElement.innerText = "Sisa Waktu Voting";
   updateTimerDigits(endTime - now);
  }

  function updateTimerDigits(diff) {
   if (diff < 0) diff = 0;
   const days = Math.floor(diff / (1000 * 60 * 60 * 24));
   const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
   const seconds = Math.floor((diff % (1000 * 60)) / 1000);

   document.getElementById('c-days').innerText = days < 10 ? '0' + days : days;
   document.getElementById('c-hours').innerText = hours < 10 ? '0' + hours : hours;
   document.getElementById('c-minutes').innerText = minutes < 10 ? '0' + minutes : minutes;
   document.getElementById('c-seconds').innerText = seconds < 10 ? '0' + seconds : seconds;

   setProgress('p-seconds', seconds, 60);
   setProgress('p-minutes', minutes, 60);
   setProgress('p-hours', hours, 24);
   setProgress('p-days', days > 30 ? 30 : days, 30);
  }

  setInterval(updateTimerDisplay, 1000);
  updateTimerDisplay();
 }

 document.addEventListener('DOMContentLoaded', updateCountdown);
</script>
@endsection