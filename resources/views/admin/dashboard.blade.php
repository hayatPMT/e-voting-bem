@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
    <style>
        /* =========================================
           PREMIUM DASHBOARD STYLES
           ========================================= */
        .dashboard-container {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding-bottom: 2rem;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border-radius: 20px;
            padding: 2.5rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.2);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: 20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .welcome-title {
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .welcome-subtitle {
            font-size: 1.05rem;
            opacity: 0.85;
            margin-bottom: 0;
            font-weight: 400;
        }

        .welcome-icon {
            font-size: 6rem;
            opacity: 0.15;
            transform: rotate(-15deg) translateY(10px);
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--stat-color);
            opacity: 0.8;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            background: var(--stat-bg);
            color: var(--stat-color);
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .stat-info {
            flex-grow: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -1px;
        }

        /* Panel Base */
        .modern-panel {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.02);
            padding: 1.75rem;
            margin-bottom: 2rem;
            height: 100%;
        }

        .panel-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
            gap: 1rem;
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .panel-title .icon-wrap {
            background: #f1f5f9;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-size: 1.1rem;
        }

        /* Table & Infographics */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin: 0;
        }

        .table-modern th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
            border: none;
        }

        .table-modern th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .table-modern th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            text-align: right;
        }

        .table-modern td {
            padding: 1.25rem;
            background: white;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }

        .table-modern tr td:first-child {
            border-left: 1px solid #f1f5f9;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .table-modern tr td:last-child {
            border-right: 1px solid #f1f5f9;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            text-align: right;
        }

        .table-modern tbody tr {
            transition: all 0.2s;
        }

        .table-modern tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.03);
            z-index: 10;
            position: relative;
        }

        .kandidat-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .kandidat-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #94a3b8;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        /* Custom Progress Bar for Table */
        .vote-progress-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .vote-progress-bar {
            flex-grow: 1;
            height: 10px;
            background: #f1f5f9;
            border-radius: 5px;
            overflow: hidden;
        }

        .vote-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            border-radius: 5px;
            transition: width 1s ease-in-out;
        }

        .vote-percentage {
            font-weight: 700;
            color: #0f172a;
            min-width: 55px;
            text-align: right;
        }

        /* Buttons */
        .btn-refresh {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .btn-refresh:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .btn-action-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.5rem 1rem;
            text-align: center;
            color: #334155;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .btn-action-card:hover {
            background: white;
            border-color: #4f46e5;
            color: #4f46e5;
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.1);
            text-decoration: none;
        }

        .btn-action-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #64748b;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .btn-action-card:hover .btn-action-icon {
            color: #4f46e5;
            background: #eff6ff;
        }

        .btn-action-text {
            font-weight: 700;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
                padding: 2rem 1.5rem;
            }

            .welcome-icon {
                display: none;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.75rem;
            }

            .table-responsive {
                border: none;
            }

            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="dashboard-container">

        <!-- Welcome Banner Element -->
        <div class="welcome-banner mb-4">
            <div>
                @if (auth()->user()->isAdmin() && auth()->user()->kampus)
                    <h1 class="welcome-title">Selamat Datang, Admin Kampus {{ auth()->user()->kampus->nama }}! 👋</h1>
                @else
                    <h1 class="welcome-title">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                @endif
                <p class="welcome-subtitle">Pantau progres dan statistik pemilihan secara real-time dari dashboard terpadu
                    ini.</p>
            </div>
            <div class="welcome-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

        @php
            $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')
                ->where('kampus_id', auth()->user()->kampus_id ?? session('viewing_kampus_id'))
                ->count();
            $percentage = $totalMahasiswa > 0 ? round(($totalSuara / $totalMahasiswa) * 100, 1) : 0;
        @endphp

        <!-- Key Metrics / Statistics Cards -->
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card" style="--stat-bg: #eff6ff; --stat-color: #3b82f6;">
                    <div class="stat-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Total Kandidat</div>
                        <div class="stat-value">{{ number_format($totalKandidat) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card" style="--stat-bg: #f0fdf4; --stat-color: #10b981;">
                    <div class="stat-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Total Suara Masuk</div>
                        <div class="stat-value">{{ number_format($totalSuara) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-4">
                <div class="stat-card" style="--stat-bg: #fffbeb; --stat-color: #f59e0b;">
                    <div class="stat-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Tingkat Partisipasi</div>
                        <div class="stat-value">{{ $percentage }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row">

            <!-- Left Column: Chart -->
            <div class="col-xl-7 col-lg-12 mb-4">
                <div class="modern-panel">
                    <div class="panel-header">
                        <h3 class="panel-title">
                            <div class="icon-wrap"><i class="fas fa-chart-bar"></i></div>
                            Visualisasi Perolehan Suara
                        </h3>
                        <button class="btn-refresh" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                    <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
                        <canvas id="mainDashboardChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details & Actions -->
            <div class="col-xl-5 col-lg-12 mb-4">

                <!-- Perolehan Suara Detail Table -->
                <div class="modern-panel mb-4">
                    <div class="panel-header" style="margin-bottom: 1rem;">
                        <h3 class="panel-title">
                            <div class="icon-wrap" style="color: #10b981; background: #f0fdf4;"><i class="fas fa-medal"></i>
                            </div>
                            Detail Suara Kandidat
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Kandidat</th>
                                    <th style="text-align: right;">Perolehan Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kandidat->sortByDesc(function($k) { return ($k->votes_count ?? 0) + ($k->total_votes ?? 0); }) as $k)
                                    @php
                                        $kTotal = ($k->votes_count ?? 0) + ($k->total_votes ?? 0);
                                        $kPct = $totalSuara > 0 ? round(($kTotal / $totalSuara) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="kandidat-info">
                                                @if ($k->foto)
                                                    <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                                        class="kandidat-avatar">
                                                @else
                                                    <div class="kandidat-avatar"><i class="fas fa-user"></i></div>
                                                @endif
                                                <div>
                                                    <div style="font-size:0.75rem; color:#64748b; font-weight:700;">NO. URUT
                                                        {{ $k->no_urut }}</div>
                                                    <div style="font-size:1rem; color:#0f172a; font-weight:800;">
                                                        {{ $k->nama }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column align-items-end">
                                                <div style="font-size:1.15rem; font-weight:800; color:#0f172a;">
                                                    {{ number_format($kTotal) }} <span
                                                        style="font-size:0.8rem; color:#64748b; font-weight:600;">Suara</span>
                                                </div>
                                                <div class="text-success fw-bold" style="font-size:0.9rem;"><i
                                                        class="fas fa-caret-up mr-1"></i>{{ $kPct }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">Belum ada data kandidat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Access Menu -->
                <div class="modern-panel">
                    <div class="panel-header" style="margin-bottom: 1.25rem;">
                        <h3 class="panel-title">
                            <div class="icon-wrap" style="color: #f59e0b; background: #fffbeb;"><i
                                    class="fas fa-rocket"></i></div>
                            Akses Cepat
                        </h3>
                    </div>
                    <div class="quick-action-grid">
                        <a href="{{ route('admin.kandidat.index') }}" class="btn-action-card">
                            <div class="btn-action-icon"><i class="fas fa-users-cog"></i></div>
                            <span class="btn-action-text">Kandidat</span>
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="btn-action-card">
                            <div class="btn-action-icon"><i class="fas fa-user-check"></i></div>
                            <span class="btn-action-text">Daftar Hadir</span>
                        </a>
                        <a href="{{ route('admin.rekap') }}" class="btn-action-card">
                            <div class="btn-action-icon"><i class="fas fa-file-invoice"></i></div>
                            <span class="btn-action-text">Rekapitulasi</span>
                        </a>
                        <a href="{{ url('/') }}" class="btn-action-card" target="_blank">
                            <div class="btn-action-icon" style="color: #8b5cf6;"><i class="fas fa-external-link-alt"></i>
                            </div>
                            <span class="btn-action-text">Portal Voting</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('mainDashboardChart');
            if (!ctx) return;

            const rawLabels = <?php echo json_encode($kandidat->pluck('nama')); ?>;
            // Truncate long names for chart labels
            const labels = rawLabels.map(name => name.length > 20 ? name.substring(0, 20) + '...' : name);
            const data = <?php echo json_encode($kandidat->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))); ?>;

            const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient1.addColorStop(0, 'rgba(79, 70, 229, 0.8)');
            gradient1.addColorStop(1, 'rgba(79, 70, 229, 0.2)');

            const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient2.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
            gradient2.addColorStop(1, 'rgba(16, 185, 129, 0.2)');

            const gradient3 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient3.addColorStop(0, 'rgba(245, 158, 11, 0.8)');
            gradient3.addColorStop(1, 'rgba(245, 158, 11, 0.2)');

            const colors = [gradient1, gradient2, gradient3, '#ef4444', '#3b82f6', '#8b5cf6'];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Perolehan Suara',
                        data: data,
                        backgroundColor: colors.slice(0, labels.length),
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6
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
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 16,
                            titleFont: {
                                family: "'Inter', sans-serif",
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                family: "'Inter', sans-serif",
                                size: 14
                            },
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Suara Masuk';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.03)',
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: '600'
                                },
                                color: '#94a3b8',
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: '700',
                                    size: 12
                                },
                                color: '#475569',
                                padding: 10
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
@endpush
