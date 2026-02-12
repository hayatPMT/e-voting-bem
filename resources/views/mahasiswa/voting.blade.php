@extends('layouts.voting')
@section('title', 'Voting')

@section('content')

<div class="container-fluid px-3 px-md-4" style="max-width: 1400px;">
    <!-- Already Voted Banner -->
    @auth
    @if(auth()->user()->mahasiswaProfile->has_voted ?? false)
    <div class="alert alert-success border-0 mb-4"
        style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
                            border-radius: 16px;
                            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
                            padding: 1.25rem 1.5rem;">
        <div class="row align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width: 48px; height: 48px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="font-weight: 700; color: #065f46;">Terima Kasih Sudah Memilih!</h5>
                        <p class="mb-0" style="color: #047857; font-size: 0.95rem;">Suara Anda telah tercatat dengan aman. Download bukti voting Anda sebagai tanda sah pemilihan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-right">
                <a href="{{ route('voting.receipt.download') }}"
                    class="btn btn-success shadow-sm"
                    style="background: #10b981;
                                      border: none;
                                      border-radius: 12px;
                                      padding: 0.75rem 1.5rem;
                                      font-weight: 700;
                                      font-size: 0.95rem;
                                      transition: all 0.3s ease;">
                    <i class="fas fa-file-pdf mr-2"></i>Download Bukti PDF
                </a>
            </div>
        </div>
    </div>
    @endif
    @endauth

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
    <p class="text-muted mb-0" style="font-size: 1.05rem; font-weight: 500;">
        Pilih salah satu kandidat di bawah ini. Pilihan Anda bersifat <strong>final</strong> dan tidak dapat diubah.
    </p>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4 justify-content-center">
        @forelse ($kandidat as $k)
        <div class="col">
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
                        @auth
                        @if (auth()->user()->vote)
                        <button class="btn btn-block disabled" disabled
                            style="background: #e5e7eb; 
                                                       color: #6b7280; 
                                                       border: none; 
                                                       border-radius: 12px; 
                                                       padding: 0.875rem;
                                                       font-weight: 600;
                                                       font-size: 0.95rem;">
                            <i class="fas fa-check-circle mr-2"></i>Sudah Memilih
                        </button>
                        @elseif(auth()->user()->role === 'mahasiswa')
                        <a href="/vote/{{ $k->id }}"
                            class="btn btn-block btn-vote"
                            onclick="return confirm('Apakah Anda yakin memilih {{ $k->nama }}?\n\nPilihan Anda bersifat FINAL dan tidak dapat diubah setelah dikonfirmasi.')"
                            style="background: linear-gradient(135deg, #667eea, #764ba2); 
                                                  color: white; 
                                                  border: none; 
                                                  border-radius: 12px; 
                                                  padding: 0.875rem;
                                                  font-weight: 700;
                                                  font-size: 0.95rem;
                                                  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
                                                  transition: all 0.3s ease;">
                            <i class="fas fa-check-circle mr-2"></i>Pilih Kandidat
                        </a>
                        @else
                        <button class="btn btn-block disabled" disabled
                            style="background: #fef3c7; 
                                                       color: #92400e; 
                                                       border: none; 
                                                       border-radius: 12px; 
                                                       padding: 0.875rem;
                                                       font-weight: 600;
                                                       font-size: 0.95rem;">
                            <i class="fas fa-user-graduate mr-2"></i>Hanya Mahasiswa
                        </button>
                        @endif
                        @else
                        <a href="{{ url('/verifikasi?kandidat=' . $k->id) }}"
                            class="btn btn-block"
                            style="background: white; 
                                              color: #667eea; 
                                              border: 2px solid #667eea; 
                                              border-radius: 12px; 
                                              padding: 0.875rem;
                                              font-weight: 600;
                                              font-size: 0.95rem;
                                              transition: all 0.3s ease;">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Memilih
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5" style="background: white; border-radius: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                <div style="width: 120px; height: 120px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                </div>
                <h5 class="mb-2" style="font-weight: 700; color: #4b5563;">Belum Ada Kandidat</h5>
                <p class="text-muted mb-0">Kandidat akan tersedia setelah admin menambahkannya</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Candidate Preview Modals -->
@foreach ($kandidat as $k)
<div class="modal fade" id="previewModal{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel{{ $k->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <!-- Modal Header with Gradient -->
            <div class="modal-header border-0 position-relative" style="background: linear-gradient(135deg, #667eea, #764ba2); padding: 2rem;">
                <div class="w-100">
                    <h4 class="modal-title font-weight-bold text-white mb-2" id="previewModalLabel{{ $k->id }}">
                        <i class="fas fa-user-circle mr-2"></i>Detail Kandidat
                    </h4>
                    <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">Kandidat Nomor {{ $loop->iteration }}</p>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 1.5rem; top: 1.5rem; opacity: 0.9;">
                    <span aria-hidden="true" style="font-size: 2rem;">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background: #f9fafb;">
                <div class="row">
                    <!-- Candidate Photo -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="position-relative" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.12);">
                            @if ($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                class="w-100" style="height: 320px; object-fit: cover; object-position: top;">
                            @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 320px;">
                                <i class="fas fa-user" style="font-size: 5rem; opacity: 0.3; color: #9ca3af;"></i>
                            </div>
                            @endif
                            <div class="position-absolute" style="top: 1rem; left: 1rem;">
                                <div style="background: linear-gradient(135deg, #667eea, #764ba2); 
                                                     color: white; 
                                                     width: 50px; 
                                                     height: 50px; 
                                                     border-radius: 12px; 
                                                     display: flex; 
                                                     align-items: center; 
                                                     justify-content: center;
                                                     font-weight: 800;
                                                     font-size: 1.5rem;
                                                     box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                    {{ $loop->iteration }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Candidate Info -->
                    <div class="col-md-8">
                        <div class="bg-white p-4" style="border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); height: 100%;">
                            <!-- Name -->
                            <h3 class="font-weight-bold mb-4" style="color: #1f2937; border-bottom: 3px solid #667eea; padding-bottom: 0.75rem;">
                                {{ $k->nama }}
                            </h3>

                            <!-- Vision -->
                            <div class="mb-4 p-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #e9ecff 100%); border-radius: 12px; border-left: 5px solid #667eea;">
                                <h5 class="font-weight-bold mb-3" style="color: #667eea;">
                                    <i class="fas fa-lightbulb mr-2"></i>VISI
                                </h5>
                                <p class="mb-0" style="color: #4b5563; line-height: 1.8; text-align: justify; white-space: pre-line;">{{ $k->visi }}</p>
                            </div>

                            <!-- Mission -->
                            <div class="p-3" style="background: linear-gradient(135deg, #fef3f0 0%, #fde8e4 100%); border-radius: 12px; border-left: 5px solid #f59e0b;">
                                <h5 class="font-weight-bold mb-3" style="color: #f59e0b;">
                                    <i class="fas fa-bullseye mr-2"></i>MISI
                                </h5>
                                <div style="color: #4b5563; line-height: 1.8; text-align: justify; white-space: pre-line;">{{ $k->misi }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 bg-white" style="padding: 1.5rem 2rem;">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-dismiss="modal" style="font-weight: 600;">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
                @auth
                @if (!auth()->user()->vote && auth()->user()->role === 'mahasiswa')
                <a href="/vote/{{ $k->id }}"
                    class="btn px-4 rounded-pill shadow-sm"
                    onclick="return confirm('Apakah Anda yakin memilih {{ $k->nama }}?\n\nPilihan Anda bersifat FINAL dan tidak dapat diubah setelah dikonfirmasi.')"
                    style="background: linear-gradient(135deg, #667eea, #764ba2); 
                                          color: white; 
                                          font-weight: 700;">
                    <i class="fas fa-check-circle mr-2"></i>Pilih Kandidat Ini
                </a>
                @endif
                @else
                <a href="{{ url('/verifikasi?kandidat=' . $k->id) }}"
                    class="btn btn-primary px-4 rounded-pill shadow-sm"
                    style="font-weight: 600;">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Memilih
                </a>
                @endauth
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
        stroke: url(#gradient);
        /* Fallback */
        stroke: #667eea;
        /* Fallback Solid */
        stroke-width: 6;
        stroke-linecap: round;
        stroke-dasharray: 283;
        /* 2 * PI * 45 */
        stroke-dashoffset: 283;
        transition: stroke-dashoffset 0.5s ease;
    }

    /* Gradient for strokes - We apply this dynamically or use solid colors for simplicity first */
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
        font-family: 'Segoe UI', sans-serif;
    }

    .timer-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #9ca3af;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .timer-circle-container {
            width: 100px;
            height: 100px;
        }

        .timer-number {
            font-size: 1.5rem;
        }

        .timer-label {
            font-size: 0.55rem;
        }

        #timer-container {
            gap: 1rem !important;
        }
    }

    @media (max-width: 576px) {
        .timer-circle-container {
            width: 80px;
            height: 80px;
        }

        .timer-number {
            font-size: 1.25rem;
        }

        .timer-bg-ring,
        .timer-progress-ring {
            stroke-width: 8;
        }
    }

    /* Candidate Cards Styling */
    .candidate-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .candidate-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.2) !important;
    }

    .candidate-card .position-relative img {
        transition: transform 0.4s ease;
    }

    .candidate-card:hover .position-relative img {
        transform: scale(1.05);
    }

    .btn-vote:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    }

    /* Preview Button Hover Effect */
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea, #764ba2) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    /* Countdown Animation */
    @keyframes pulse-countdown {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
        }
    }

    #countdown {
        animation: pulse-countdown 2s ease-in-out infinite;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        #countdown {
            font-size: 0.9rem;
            padding: 1rem 1.25rem !important;
        }

        #countdown-text {
            font-size: 0.95rem !important;
        }

        #countdown-text .badge {
            font-size: 0.75rem !important;
            padding: 0.25rem 0.5rem !important;
        }

        .candidate-card {
            margin-bottom: 1rem;
        }

        .candidate-card .position-relative {
            height: 240px !important;
        }

        .candidate-name {
            font-size: 1.15rem !important;
        }

        .candidate-vision {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        h2 {
            font-size: 1.65rem !important;
        }

        .candidate-card .position-relative {
            height: 220px !important;
        }

        .candidate-card .position-absolute div {
            width: 38px !important;
            height: 38px !important;
            font-size: 1.1rem !important;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-body .card {
            max-width: 100% !important;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-footer .btn {
            width: 100%;
            margin: 0.25rem 0 !important;
        }
    }
</style>

<!-- Session Data for JS -->
<input type="hidden" id="voted_status" value="{{ session()->has('voted_candidate') ? 'true' : 'false' }}">

<script>
    function updateCountdown() {
        // Use timestamps directly from server to avoid timezone parsing issues
        // Defaults: If not set, assume voting started 1 minute ago and ends in 24 hours (Active State)
        const serverNow = <?php echo now()->timestamp * 1000; ?>;
        const startTime = <?php echo ($setting && $setting->voting_start) ? $setting->voting_start->timestamp * 1000 : now()->subMinute()->timestamp * 1000; ?>;
        const endTime = <?php echo ($setting && $setting->voting_end) ? $setting->voting_end->timestamp * 1000 : now()->addHours(24)->timestamp * 1000; ?>;

        // Calculate offset between client clock and server clock
        const clientNow = new Date().getTime();
        const timeOffset = serverNow - clientNow;

        // Elements
        const titleElement = document.getElementById('countdown-title');
        const messageContainer = document.getElementById('timer-message');
        const messageText = messageContainer.querySelector('h4');
        const circles = document.querySelectorAll('.timer-circle-container');

        // Progress Elements
        const pDays = document.getElementById('p-days');
        const pHours = document.getElementById('p-hours');
        const pMinutes = document.getElementById('p-minutes');
        const pSeconds = document.getElementById('p-seconds');

        // Text Elements
        const tDays = document.getElementById('c-days');
        const tHours = document.getElementById('c-hours');
        const tMinutes = document.getElementById('c-minutes');
        const tSeconds = document.getElementById('c-seconds');

        // Circle Circumference (2 * PI * 45)
        const circumference = 283;

        // Initial update
        updateTimerDisplay();

        function setProgress(element, value, max) {
            if (!element) return;
            const percent = value / max;
            const offset = circumference - (percent * circumference);
            element.style.strokeDashoffset = offset;
        }

        function updateTimerDisplay() {
            // Get current time adjusted by server offset to match server time exactly
            const now = new Date().getTime() + timeOffset;

            function setStatus(message, colorClass, blockVoting) {
                circles.forEach(c => c.style.display = 'none');
                messageContainer.classList.remove('d-none');
                messageText.innerHTML = message;
                messageText.className = `font-weight-bold mb-0 ${colorClass}`;

                document.querySelectorAll('a[href*="/vote/"]').forEach(btn => {
                    if (blockVoting) {
                        btn.classList.add('disabled');
                        btn.style.pointerEvents = 'none';
                        btn.style.background = '#e5e7eb';
                        btn.style.color = '#6b7280';
                        btn.innerHTML = message.includes('Selesai') ? '<i class="fas fa-lock mr-2"></i>Ditutup' : '<i class="fas fa-clock mr-2"></i>Belum Dimulai';
                    }
                });
            }

            // Case 1: Voting hasn't started yet
            if (now < startTime) {
                circles.forEach(c => c.style.display = 'block');
                messageContainer.classList.add('d-none');

                if (titleElement) titleElement.innerText = "Voting Dimulai Dalam";

                const diff = startTime - now;
                updateTimerDigits(diff);

                // Block voting buttons
                document.querySelectorAll('a[href*="/vote/"]').forEach(btn => {
                    btn.classList.add('disabled');
                    btn.style.pointerEvents = 'none';
                    btn.style.background = '#e5e7eb';
                    btn.style.color = '#6b7280';
                    btn.innerHTML = '<i class="fas fa-clock mr-2"></i>Belum Dimulai';
                });

                return;
            }

            // Case 2: Voting has ended
            if (now > endTime) {
                setStatus('<i class="fas fa-flag-checkered mr-2"></i>Waktu Voting Telah Selesai', 'text-danger', true);
                if (titleElement) titleElement.innerText = "Voting Selesai";
                return;
            }

            // Case 3: Voting is active
            circles.forEach(c => c.style.display = 'block');
            messageContainer.classList.add('d-none');
            if (titleElement) titleElement.innerText = "Sisa Waktu Voting";

            // Enable voting buttons if they were disabled by JS (status change)
            document.querySelectorAll('a[href*="/vote/"]').forEach(btn => {
                // Only re-enable if not manually disabled (like 'Sudah Memilih' or auth check)
                if (btn.innerText.includes('Belum Dimulai')) {
                    btn.classList.remove('disabled');
                    btn.style.pointerEvents = 'auto';
                    btn.style.background = 'linear-gradient(135deg, #667eea, #764ba2)';
                    btn.style.color = 'white';
                    btn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Pilih Kandidat';
                }
            });

            const diff = endTime - now;
            updateTimerDigits(diff);
        }

        function updateTimerDigits(diff) {
            if (diff < 0) diff = 0;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            // Update text
            if (tDays) tDays.innerText = days < 10 ? '0' + days : days;
            if (tHours) tHours.innerText = hours < 10 ? '0' + hours : hours;
            if (tMinutes) tMinutes.innerText = minutes < 10 ? '0' + minutes : minutes;
            if (tSeconds) tSeconds.innerText = seconds < 10 ? '0' + seconds : seconds;

            // Update Progress Rings
            setProgress(pSeconds, seconds, 60);
            setProgress(pMinutes, minutes, 60);
            setProgress(pHours, hours, 24);
            setProgress(pDays, days > 30 ? 30 : days, 30);
        }

        setInterval(updateTimerDisplay, 1000);
    }

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        updateCountdown();

        // Check if there's a redirected 'voted' status from session
        const hasVotedStatus = $('#voted_status').val() === 'true';
        if (hasVotedStatus) {
            console.log('Vote session detected, showing modal...');

            // Use setTimeout to ensure DOM is fully loaded
            setTimeout(function() {
                $('#printModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                console.log('Modal should be visible now');
            }, 100);
        }
    });

    function printBukti() {
        var printContents = document.getElementById('print-area').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = '<div style="width: 100%; text-align: center; padding: 50px;">' + printContents + '</div>';
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

<!-- Modal Cetak Bukti -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0 px-4" id="print-area">
                <div style="font-family: 'Courier New', Courier, monospace; text-align: center; color: #000; padding: 10px;">
                    <div class="d-none d-print-block">
                        <!-- Header Struk (Only visible in print) -->
                        <h3 style="font-weight: bold; margin-bottom: 0;">{{ $setting->election_name ?? 'E-VOTING BEM' }}</h3>
                        <p style="font-size: 12px; margin-bottom: 10px;">BUKTI SAH PEMILIHAN</p>
                        <div style="border-bottom: 2px dashed #000; margin-bottom: 10px;"></div>
                    </div>

                    <!-- Tampilan Web (Icon Success) -->
                    <div class="mb-3 d-print-none">
                        <div class="icon-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fas fa-check" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold mb-2 d-print-none">Terima Kasih!</h4>
                    <p class="text-muted mb-4 d-print-none">Suara Anda telah berhasil direkam.</p>

                    <!-- Receipt Container -->
                    <div class="card shadow-none mx-auto mb-3" style="max-width: 320px; border: 2px dashed #ccc; background: #fffcf5;">
                        <div class="card-body p-3 text-left">
                            <div class="text-center mb-3">
                                <h5 class="font-weight-bold mb-0">BUKTI PILIH</h5>
                                <small class="text-muted">{{ now()->format('d F Y') }}</small>
                            </div>

                            <table class="table table-sm table-borderless mb-2" style="font-size: 0.9rem;">
                                <tr>
                                    <td class="pl-0 text-muted">Waktu</td>
                                    <td class="pr-0 text-right font-weight-bold text-dark">{{ now()->format('H:i') }} WIB</td>
                                </tr>
                            </table>

                            <div style="border-bottom: 2px dashed #ddd; margin: 10px 0;"></div>

                            <div class="text-center mt-3">
                                <small class="text-muted d-block mb-2">MEMILIH KANDIDAT:</small>
                                @if(session('voted_candidate') && session('voted_candidate')->foto)
                                <img src="{{ asset('storage/' . session('voted_candidate')->foto) }}"
                                    class="rounded-circle mb-2 border"
                                    style="width: 80px; height: 80px; object-fit: cover; border-color: #333 !important;">
                                @endif
                                <h5 class="font-weight-bold text-uppercase mb-1" style="color: #000;">{{ session('voted_candidate')->nama ?? 'Kandidat' }}</h5>
                                <span class="badge badge-success px-3 py-1">SUKSES</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pt-0">
                            <small class="text-muted" style="font-size: 0.7rem;">Simpan struk ini sebagai bukti sah.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-dismiss="modal">Tutup</button>
                <a href="{{ route('voting.receipt.download') }}" class="btn btn-success px-4 rounded-pill shadow-sm">
                    <i class="fas fa-download mr-2"></i>Simpan PDF
                </a>
                <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" onclick="printBukti()">
                    <i class="fas fa-print mr-2"></i>Cetak Bukti
                    </a>
            </div>
        </div>
    </div>
</div>
@endsection