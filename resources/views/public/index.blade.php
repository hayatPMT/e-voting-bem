@extends('layouts.voting')

@section('title', 'Hasil Real-time')

@section('content')
<style>
    /* Custom Styles for Public Page */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 3rem 2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        animation: float 15s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(30px, -30px) rotate(180deg); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .hero-icon i {
        font-size: 2rem;
        color: white;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        border: 2px solid #f3f4f6;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color), var(--color));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        border-color: transparent;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: var(--bg-color);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .stat-icon i {
        font-size: 1.75rem;
        color: var(--color);
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        line-height: 1;
        letter-spacing: -1px;
    }

    .chart-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 2px solid #f3f4f6;
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .chart-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chart-title i {
        color: #667eea;
    }

    .live-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        animation: pulse-badge 2s ease-in-out infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        animation: blink 1.5s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn-custom {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    }

    .btn-success-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(16, 185, 129, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            padding: 2rem 1.5rem;
            border-radius: 20px;
        }
        .hero-icon {
            width: 60px;
            height: 60px;
        }
        .stat-card {
            padding: 1.5rem 1rem;
        }
        .stat-value {
            font-size: 2rem;
        }
        .chart-card {
            padding: 1.5rem;
        }
        .chart-title {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            padding: 1.75rem 1.25rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
        }
        .stat-icon i {
            font-size: 1.5rem;
        }
        .stat-value {
            font-size: 1.75rem;
        }
        .chart-card {
            padding: 1.25rem;
        }
        .btn-custom {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4" style="max-width: 1400px;">
    <!-- Hero Section -->
    <div class="hero-section">
<div class="hero-content text-center">
            @if(isset($setting) && $setting->election_logo)
                <div class="hero-icon p-0 overflow-hidden border-0" style="background: transparent;">
                    <img src="{{ asset('storage/' . $setting->election_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @else
                <div class="hero-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            @endif
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.75rem; letter-spacing: -0.5px;">
                {{ $setting->election_name ?? 'Hasil Pemilihan Real-time' }}
            </h1>
            <p style="font-size: 1.125rem; opacity: 0.95; margin-bottom: 0; font-weight: 500; max-width: 700px; margin: 0 auto;">
                Pantau hasil perolehan suara secara langsung dan transparan
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 g-md-4 mb-4">
        <!-- Total Mahasiswa -->
        <div class="col">
            <div class="stat-card" style="--color: #3b82f6; --bg-color: #eff6ff;">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Total Mahasiswa</div>
                <div class="stat-value">{{ number_format($totalMahasiswa) }}</div>
            </div>
        </div>

        <!-- Suara Masuk -->
        <div class="col">
            <div class="stat-card" style="--color: #10b981; --bg-color: #f0fdf4;">
                <div class="stat-icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <div class="stat-label">Suara Masuk</div>
                <div class="stat-value">{{ number_format($totalSuara) }}</div>
            </div>
        </div>

        <!-- Partisipasi -->
        <div class="col">
            <div class="stat-card" style="--color: #f59e0b; --bg-color: #fef3c7;">
                <div class="stat-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="stat-label">Partisipasi</div>
                <div class="stat-value">
                    @php
                        $percentage = $totalMahasiswa > 0 ? round(($totalSuara / $totalMahasiswa) * 100, 1) : 0;
                    @endphp
                    {{ $percentage }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-card mb-4">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-bar"></i>
                <span>Perolehan Suara Kandidat</span>
            </div>
            <div class="live-badge">
                <span class="live-dot"></span>
                <span>LIVE</span>
            </div>
        </div>
        <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="publicChart"></canvas>
        </div>
        <div class="text-center mt-3" style="color: #6b7280; font-size: 0.875rem; font-weight: 500;">
            <i class="fas fa-sync-alt fa-spin mr-1"></i> Data diperbarui otomatis setiap 5 detik
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        @auth
            @if(auth()->user()->role == 'mahasiswa')
                <a href="{{ url('/voting') }}" class="btn-custom btn-success-custom">
                    <i class="fas fa-vote-yea"></i>
                    Gunakan Hak Suara
                </a>
            @elseif(auth()->user()->role == 'admin')
                <a href="{{ url('/dashboard') }}" class="btn-custom btn-primary-custom">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard Admin
                </a>
            @endif
        @else
            <a href="{{ url('/verifikasi') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-user-check"></i>
                Login Mahasiswa
            </a>
        @endauth
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('publicChart');
        if (!ctx) return;

        let chart;
        const colors = [
            '#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#06b6d4'
        ];

        function loadData() {
            fetch('/api/chart')
                .then(res => res.json())
                .then(data => {
                    if (chart) {
                        chart.data.labels = data.labels;
                        chart.data.datasets[0].data = data.values;
                        chart.data.datasets[0].backgroundColor = colors.slice(0, data.labels.length);
                        chart.update('none'); // Smooth update without animation
                    } else {
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Jumlah Suara',
                                    data: data.values,
                                    backgroundColor: colors.slice(0, data.labels.length),
                                    borderRadius: 8,
                                    borderSkipped: false
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                plugins: {
                                    legend: { 
                                        display: false 
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(31, 41, 55, 0.95)',
                                        padding: 12,
                                        titleFont: { size: 14, weight: 'bold' },
                                        bodyFont: { size: 13 },
                                        borderColor: '#e5e7eb',
                                        borderWidth: 1,
                                        cornerRadius: 8,
                                        displayColors: true,
                                        callbacks: {
                                            label: function(context) {
                                                return ' ' + context.parsed.x + ' suara';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        grid: { 
                                            color: '#f3f4f6',
                                            drawBorder: false
                                        },
                                        ticks: { 
                                            stepSize: 1,
                                            font: { weight: '600' },
                                            color: '#6b7280'
                                        }
                                    },
                                    y: {
                                        grid: { 
                                            display: false 
                                        },
                                        ticks: {
                                            font: { weight: '700', size: 13 },
                                            color: '#1f2937'
                                        }
                                    }
                                },
                                animation: {
                                    duration: 750,
                                    easing: 'easeInOutQuart'
                                }
                            }
                        });
                    }
                })
                .catch(err => console.error('Error loading chart:', err));
        }

        loadData();
        setInterval(loadData, 5000); // Update every 5 seconds
    });
</script>
@endpush
