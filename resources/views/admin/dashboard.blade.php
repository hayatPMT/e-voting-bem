@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb_title', 'Dashboard Utama')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<style>
    /* Modern Dashboard Styling */
    .stat-card-modern {
        border-radius: 16px;
        padding: 2rem 1.5rem;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        background: white;
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-color);
        transition: height 0.3s ease;
    }

    .stat-card-modern:hover::before {
        height: 6px;
    }

    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .stat-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: var(--icon-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .stat-icon-wrapper i {
        font-size: 2rem;
        color: var(--card-color);
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
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

    .chart-card-modern {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 2px solid #f3f4f6;
    }

    .chart-header-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .chart-title-modern {
        font-size: 1.375rem;
        font-weight: 800;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chart-title-modern i {
        color: #667eea;
    }

    .refresh-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .refresh-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.25rem;
        text-decoration: none;
        color: #1f2937;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .action-btn:hover {
        border-color: #667eea;
        background: #f9fafb;
        transform: translateX(5px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.15);
        color: #667eea;
        text-decoration: none;
    }

    .action-btn i {
        font-size: 1.5rem;
        color: #667eea;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card-modern {
            padding: 1.5rem 1.25rem;
        }

        .stat-icon-wrapper {
            width: 60px;
            height: 60px;
        }

        .stat-value {
            font-size: 2rem;
        }

        .chart-card-modern {
            padding: 1.5rem;
        }

        .chart-title-modern {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .stat-icon-wrapper {
            width: 55px;
            height: 55px;
        }

        .stat-icon-wrapper i {
            font-size: 1.75rem;
        }

        .stat-value {
            font-size: 1.75rem;
        }

        .chart-card-modern {
            padding: 1.25rem;
        }
    }
</style>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Kandidat -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern" style="--card-color: #3b82f6; --icon-bg: #eff6ff;">
            <div class="stat-icon-wrapper">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total Kandidat</div>
            <div class="stat-value">{{ number_format($totalKandidat) }}</div>
        </div>
    </div>

    <!-- Total Suara -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern" style="--card-color: #10b981; --icon-bg: #f0fdf4;">
            <div class="stat-icon-wrapper">
                <i class="fas fa-vote-yea"></i>
            </div>
            <div class="stat-label">Total Suara Masuk</div>
            <div class="stat-value">{{ number_format($totalSuara) }}</div>
        </div>
    </div>

    <!-- Partisipasi -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-modern" style="--card-color: #f59e0b; --icon-bg: #fef3c7;">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-label">Partisipasi</div>
            <div class="stat-value">
                @php
                $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')->count();
                $percentage = $totalMahasiswa > 0 ? round(($totalSuara / $totalMahasiswa) * 100, 1) : 0;
                @endphp
                {{ $percentage }}%
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="chart-card-modern">
            <div class="chart-header-modern">
                <div class="chart-title-modern">
                    <i class="fas fa-chart-bar"></i>
                    <span>Grafik Perolehan Suara</span>
                </div>
                <button class="refresh-btn" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                    <span>Refresh Data</span>
                </button>
            </div>
            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <h5 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem; font-size: 1.25rem;">
            <i class="fas fa-bolt mr-2" style="color: #667eea;"></i>Aksi Cepat
        </h5>
        <div class="quick-actions">
            <a href="{{ route('admin.kandidat.index') }}" class="action-btn">
                <i class="fas fa-users"></i>
                <span>Kelola Kandidat</span>
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}" class="action-btn">
                <i class="fas fa-user-graduate"></i>
                <span>Kelola Mahasiswa</span>
            </a>
            <a href="{{ url('/rekap') }}" class="action-btn">
                <i class="fas fa-chart-line"></i>
                <span>Lihat Rekap Suara</span>
            </a>
            <a href="{{ url('/voting') }}" class="action-btn" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>Halaman Voting</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart');
        if (!ctx) return;

        const labels = <?php echo json_encode($kandidat->pluck('nama')); ?>;
        const data = <?php echo json_encode($kandidat->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))); ?>;

        const colors = [
            '#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#06b6d4'
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(31, 41, 55, 0.95)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.parsed.y + ' suara';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                weight: '600'
                            },
                            color: '#6b7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: '700',
                                size: 12
                            },
                            color: '#1f2937'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    });
</script>
@endpush