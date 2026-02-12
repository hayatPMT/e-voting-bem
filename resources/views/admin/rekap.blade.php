@extends('layouts.admin')
@section('title', 'Rekap Suara')
@section('breadcrumb_title', 'Rekapitulasi Perolehan Suara')
@section('breadcrumb')
<li class="breadcrumb-item active">Rekap Suara</li>
@endsection

@section('content')
<style>
    .action-bar {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
        margin-bottom: 2rem;
    }

    .modern-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-header-title {
        font-size: 1.375rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .table-modern {
        margin: 0;
    }

    .table-modern thead {
        background: #f9fafb;
    }

    .table-modern thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8125rem;
        letter-spacing: 0.5px;
        color: #6b7280;
        padding: 1.25rem 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-modern tbody tr {
        transition: background 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f9fafb;
    }

    .table-modern tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .table-modern .winner-row {
        background: linear-gradient(90deg, #f0fdf4 0%, #dcfce7 100%);
        border-left: 4px solid #10b981;
    }

    .table-modern .winner-row:hover {
        background: linear-gradient(90deg, #dcfce7 0%, #bbf7d0 100%);
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-votes {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .badge-percentage {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .badge-winner {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        animation: pulse-winner 2s ease-in-out infinite;
    }

    @keyframes pulse-winner {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .badge-no-vote {
        background: #e5e7eb;
        color: #6b7280;
    }

    .total-row {
        background: linear-gradient(90deg, #fef3c7 0%, #fde68a 100%);
        font-weight: 700;
        font-size: 1rem;
        border-top: 3px solid #f59e0b;
    }

    .chart-section {
        padding: 2rem;
    }

    .chart-wrapper {
        position: relative;
        height: 400px;
        width: 100%;
    }

    .info-footer {
        background: #f9fafb;
        padding: 1rem 2rem;
        border-top: 2px solid #e5e7eb;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-bar {
            padding: 1.25rem;
        }

        .modern-card-header {
            padding: 1.25rem 1.5rem;
        }

        .card-header-title {
            font-size: 1.25rem;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 1rem 0.75rem;
            font-size: 0.875rem;
        }

        .chart-wrapper {
            height: 300px;
        }
    }

    @media print {

        .action-bar,
        .sidebar,
        .navbar,
        footer,
        .btn,
        .no-print {
            display: none !important;
        }

        .modern-card {
            box-shadow: none;
            page-break-inside: avoid;
        }
    }
</style>

<!-- Action Bar -->
<div class="action-bar">
    <div>
        <h5 style="margin: 0; font-weight: 700; color: #1f2937;">
            <i class="fas fa-chart-line mr-2" style="color: #667eea;"></i>
            Rekapitulasi Lengkap
        </h5>
    </div>
    <button type="button" class="btn-action btn-print" onclick="window.print()">
        <i class="fas fa-print"></i>
        <span>Cetak / Export</span>
    </button>
</div>

<!-- Table Card -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="card-header-title">
            <i class="fas fa-list"></i>
            <span>Daftar Kandidat & Perolehan Suara</span>
        </h3>
    </div>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 40%;">Nama Kandidat</th>
                    <th style="width: 20%; text-align: center;">Jumlah Suara</th>
                    <th style="width: 20%; text-align: center;">Persentase</th>
                    <th style="width: 15%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalVotes = $data->sum('votes_count') + $data->sum('total_votes');
                $maxVotes = $data->max(fn($k) => $k->votes_count + $k->total_votes);
                @endphp

                @forelse ($data as $index => $kandidat)
                @php $k_total = ($kandidat->votes_count ?? 0) + ($kandidat->total_votes ?? 0); @endphp
                <tr class="{{ $k_total == $maxVotes && $maxVotes > 0 ? 'winner-row' : '' }}">
                    <td style="font-weight: 700; font-size: 1.125rem; color: #667eea;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1rem; color: #1f2937; margin-bottom: 0.25rem;">
                            {{ $kandidat->nama }}
                        </div>
                        @if($k_total == $maxVotes && $maxVotes > 0)
                        <small style="color: #10b981; font-weight: 600;">
                            <i class="fas fa-trophy mr-1"></i>Kandidat Terdepan
                        </small>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge-modern badge-votes">
                            <i class="fas fa-vote-yea"></i>
                            {{ $k_total ?? 0 }} suara
                        </span>
                    </td>
                    <td class="text-center">
                        @if ($totalVotes > 0)
                        <span class="badge-modern badge-percentage">
                            <i class="fas fa-percent"></i>
                            {{ round(($k_total / $totalVotes) * 100, 2) }}%
                        </span>
                        @else
                        <span class="badge-modern badge-no-vote">0%</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($k_total == $maxVotes && $maxVotes > 0)
                        <span class="badge-modern badge-winner">
                            <i class="fas fa-crown"></i>
                            Terdepan
                        </span>
                        @elseif ($k_total == 0)
                        <span class="badge-modern badge-no-vote">
                            Belum Ada Suara
                        </span>
                        @else
                        <span style="color: #9ca3af;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div style="width: 100px; height: 100px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; color: #d1d5db;"></i>
                        </div>
                        <p style="color: #6b7280; font-weight: 600; margin: 0;">Belum ada data kandidat</p>
                    </td>
                </tr>
                @endforelse

                @if ($data->count() > 0)
                <tr class="total-row">
                    <td colspan="2" style="font-size: 1.125rem;">
                        <i class="fas fa-calculator mr-2"></i>
                        TOTAL SUARA MASUK
                    </td>
                    <td class="text-center">
                        <span class="badge-modern" style="background: #1f2937; color: white; font-size: 1rem;">
                            {{ number_format($totalVotes) }} suara
                        </span>
                    </td>
                    <td class="text-center" style="font-size: 1.125rem;">100%</td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="info-footer">
        <i class="fas fa-info-circle"></i>
        <span>Total {{ $data->count() }} kandidat terdaftar — {{ number_format($totalVotes) }} suara telah masuk</span>
    </div>
</div>

<!-- Charts Section -->
@if($data->count() > 0 && $totalVotes > 0)
<div class="row">
    <!-- Pie Chart -->
    <div class="col-lg-6 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="card-header-title">
                    <i class="fas fa-chart-pie"></i>
                    <span>Distribusi Suara (Pie)</span>
                </h3>
            </div>
            <div class="chart-section">
                <div class="chart-wrapper">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="col-lg-6 mb-4">
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="card-header-title">
                    <i class="fas fa-chart-bar"></i>
                    <span>Perbandingan Suara (Bar)</span>
                </h3>
            </div>
            <div class="chart-section">
                <div class="chart-wrapper">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Hidden div to pass data to JS --}}
<div id="chart-data-container"
    data-labels="{{ json_encode($data->map(fn($k) => $k->nama)->toArray()) }}"
    data-values="{{ json_encode($data->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))->toArray()) }}">
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const chartContainer = document.getElementById('chart-data-container');
    if (chartContainer) {
        const labels = JSON.parse(chartContainer.dataset.labels || '[]');
        const dataValues = JSON.parse(chartContainer.dataset.values || '[]');
        const hasData = labels.length > 0 && dataValues.reduce((a, b) => a + b, 0) > 0;

        if (hasData) {
            const colors = [
                '#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6',
                '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#a855f7', '#fb7185'
            ];

            // Pie Chart
            const pieCtx = document.getElementById('pieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: dataValues,
                            backgroundColor: colors.slice(0, labels.length),
                            borderWidth: 3,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: '#1f2937'
                                }
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
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(2);
                                        return ' ' + context.label + ': ' + context.parsed + ' suara (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1200,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }

            // Bar Chart
            const barCtx = document.getElementById('barChart');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Suara',
                            data: dataValues,
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
                                        weight: '600',
                                        size: 11
                                    },
                                    color: '#1f2937'
                                }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }
        }
    }
</script>
@endpush