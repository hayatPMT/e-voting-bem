@extends('layouts.admin')

@section('title', 'Rekapitulasi & Hasil Voting')

@section('content')
    <style>
        /* ====================================================
               REKAP - PREMIUM INFOGRAPHIC STYLES
            ==================================================== */

        /* Hero Banner */
        .rekap-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 60%, #7c3aed 100%);
            border-radius: 22px;
            padding: 2.5rem 2.5rem 3.5rem;
            color: white;
            margin-bottom: -1.5rem;
            position: relative;
            overflow: hidden;
        }

        .rekap-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .rekap-hero::after {
            content: '';
            position: absolute;
            top: -100px;
            right: -80px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent 70%);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 14px;
            backdrop-filter: blur(4px);
        }

        .hero-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ade80;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 900;
            margin-bottom: 8px;
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .hero-sub {
            font-size: 1rem;
            opacity: 0.75;
            font-weight: 400;
            margin-bottom: 1.5rem;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            border-radius: 11px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .hero-btn-white {
            background: white;
            color: #4f46e5;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .hero-btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            color: #4f46e5;
            text-decoration: none;
        }

        .hero-btn-ghost {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(4px);
        }

        .hero-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
        }

        /* ============ KPI STATS ROW ============ */
        .kpi-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
            position: relative;
            z-index: 10;
        }

        .kpi-card {
            background: white;
            border-radius: 18px;
            padding: 22px 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            transition: all 0.25s;
        }

        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .kpi-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .kpi-trend {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 8px;
        }

        .kpi-trend.up {
            color: #16a34a;
            background: #dcfce7;
        }

        .kpi-trend.neutral {
            color: #64748b;
            background: #f1f5f9;
        }

        .kpi-value {
            font-size: 2.4rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
            letter-spacing: -1.5px;
            margin-bottom: 4px;
        }

        .kpi-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        /* Participation ring */
        .partisipasi-card {
            background: white;
            border-radius: 18px;
            padding: 22px 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .ring-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 12px;
        }

        .ring-canvas {
            transform: rotate(-90deg);
        }

        .ring-text {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .ring-pct {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
        }

        .ring-sub {
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
        }

        .ring-legend {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 8px;
        }

        .ring-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #334155;
        }

        .ring-dot {
            width: 9px;
            height: 9px;
            border-radius: 3px;
        }

        /* Mode split bar */
        .mode-split-bar {
            height: 12px;
            border-radius: 6px;
            background: #e2e8f0;
            overflow: hidden;
            display: flex;
            margin: 10px 0;
        }

        .mode-online-fill {
            background: linear-gradient(90deg, #4f46e5, #818cf8);
            transition: width 1s ease;
        }

        .mode-offline-fill {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
            transition: width 1s ease;
        }

        .mode-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* ============ CHARTS GRID ============ */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .chart-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .chart-card-full {
            grid-column: 1 / -1;
        }

        .chart-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .chart-card-title {
            font-size: 0.9rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .chart-card-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 500;
            margin: 0;
        }

        .chart-body {
            padding: 20px;
        }

        .chart-body-compact {
            padding: 14px 18px;
        }

        /* ============ TABLE ============ */
        .rekap-table-panel {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .rekap-table-header {
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .rekap-table-title {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .rt {
            width: 100%;
            border-collapse: collapse;
        }

        .rt thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .rt thead th {
            padding: 12px 18px;
            font-size: 0.69rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            white-space: nowrap;
        }

        .rt tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .rt tbody tr:hover {
            background: #f8fafc;
        }

        .rt tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            color: #0f172a;
        }

        .rt tbody tr.winner-row {
            background: linear-gradient(90deg, #ecfdf5, #d1fae5) !important;
            border-left: 4px solid #10b981;
        }

        .rt tbody tr.winner-row td:first-child {
            padding-left: 14px;
        }

        .rt tfoot tr {
            background: linear-gradient(90deg, #fef9c3, #fef08a);
            border-top: 2px solid #facc15;
        }

        .rt tfoot td {
            padding: 14px 18px;
            font-weight: 800;
            color: #713f12;
            font-size: 0.95rem;
        }

        .rekap-footer-bar {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 12px 22px;
            font-size: 0.78rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .kandidat-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .kandidat-foto {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            flex-shrink: 0;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 1.2rem;
        }

        .kandidat-no {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .kandidat-nama {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
        }

        .vote-bar-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vote-bar-bg {
            flex: 1;
            height: 9px;
            background: #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
            min-width: 80px;
        }

        .vote-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #4f46e5, #818cf8);
            border-radius: 5px;
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0;
        }

        .vote-bar-fill.winner-fill {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .vote-count-val {
            font-size: 1rem;
            font-weight: 900;
            color: #0f172a;
            min-width: 36px;
            text-align: right;
        }

        .rank-no {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1rem;
            color: #475569;
        }

        .rank-no.rank-1 {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        }

        .rank-no.rank-2 {
            background: linear-gradient(135deg, #94a3b8, #cbd5e1);
            color: white;
        }

        .rank-no.rank-3 {
            background: linear-gradient(135deg, #cd7c2f, #e8a455);
            color: white;
        }

        .status-winner {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 3px 8px rgba(245, 158, 11, 0.25);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 900px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .chart-card-full {
                grid-column: auto;
            }
        }

        @media (max-width: 768px) {
            .rekap-hero {
                padding: 2rem 1.5rem 2.5rem;
            }

            .hero-title {
                font-size: 1.6rem;
            }

            .kpi-row {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .kpi-value {
                font-size: 1.875rem;
            }

            .kandidat-foto {
                width: 40px;
                height: 40px;
            }

            .rt thead th,
            .rt tbody td {
                padding: 12px 12px;
            }
        }

        @media (max-width: 480px) {
            .kpi-row {
                grid-template-columns: 1fr;
            }
        }

        @media print {

            .rekap-hero .hero-actions,
            .btn {
                display: none !important;
            }

            .kpi-card,
            .chart-card,
            .rekap-table-panel {
                page-break-inside: avoid;
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }
    </style>

    <!-- ============================================================
             HERO SECTION
        ============================================================ -->
    <div class="rekap-hero mb-4">
        <div style="position: relative; z-index: 2;">
            <div class="hero-badge">
                <div class="hero-dot"></div>
                Real-Time · Update Otomatis
            </div>
            <h1 class="hero-title">Hasil & Rekapitulasi<br>Pemilihan BEM</h1>
            <p class="hero-sub">Perolehan suara, tingkat partisipasi, dan tren voting langsung diperbaharui secara
                real-time.</p>
            <div class="hero-actions">
                <button class="hero-btn hero-btn-white" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh Data
                </button>
                <button class="hero-btn hero-btn-ghost" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    @php
        $totalVotes = $data->sum('votes_count') + $data->sum('total_votes');
        $maxVotes = $data->max(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0));
        $totalMhs = $stats['total_mahasiswa'];
        $sudahVoting = $stats['sudah_voting'];
        $belumVoting = $stats['belum_voting'];
        $pctPartisipasi = $stats['partisipasi_persen'];
        $onlineV = $stats['online_voters'];
        $offlineV = $stats['offline_voters'];
        $onlinePct = $onlineV + $offlineV > 0 ? round(($onlineV / ($onlineV + $offlineV)) * 100, 1) : 0;
        $offlinePct = $onlineV + $offlineV > 0 ? round(($offlineV / ($onlineV + $offlineV)) * 100, 1) : 0;
    @endphp

    <!-- ============================================================
             KPI STATS
        ============================================================ -->
    <div class="kpi-row">

        <!-- Total Mahasiswa DPT -->
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:#ede9fe; color:#7c3aed;"><i class="fas fa-users"></i></div>
                <span class="kpi-trend neutral"><i class="fas fa-database"></i> DPT</span>
            </div>
            <div class="kpi-value">{{ number_format($totalMhs) }}</div>
            <div class="kpi-label">Total Pemilih Terdaftar</div>
        </div>

        <!-- Sudah Voting -->
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-vote-yea"></i></div>
                <span class="kpi-trend up"><i class="fas fa-arrow-up"></i> Voting</span>
            </div>
            <div class="kpi-value" style="color:#16a34a;">{{ number_format($sudahVoting) }}</div>
            <div class="kpi-label">Suara Masuk</div>
        </div>

        <!-- Belum Voting -->
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:#fef3c7; color:#d97706;"><i class="fas fa-hourglass-half"></i></div>
                <span class="kpi-trend neutral">Belum</span>
            </div>
            <div class="kpi-value" style="color:#d97706;">{{ number_format($belumVoting) }}</div>
            <div class="kpi-label">Belum Memilih</div>
        </div>

        <!-- Suara Abstain -->
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:#f3f4f6; color:#6b7280;"><i class="fas fa-user-slash"></i></div>
                <span class="kpi-trend neutral"><i class="fas fa-ban"></i> Abstain</span>
            </div>
            <div class="kpi-value" style="color:#6b7280;">{{ number_format($stats['abstain_votes'] ?? 0) }}</div>
            <div class="kpi-label">Suara Abstain</div>
        </div>

        <!-- Partisipasi % KPI Card with Ring -->
        <div class="kpi-card"
            style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color:white; border-color: transparent;">
            <div class="kpi-top">
                <div class="kpi-icon" style="background:rgba(255,255,255,0.15); color:white;"><i
                        class="fas fa-chart-pie"></i></div>
                <span class="kpi-trend" style="background:rgba(255,255,255,0.15); color:white;">Partisipasi</span>
            </div>
            <div class="kpi-value" style="color:white; font-size: 2.8rem;">{{ $pctPartisipasi }}%</div>
            <div class="kpi-label" style="color:rgba(255,255,255,0.7);">Tingkat Partisipasi</div>
            <div style="margin-top:12px;">
                <div style="height:8px; background: rgba(255,255,255,0.15); border-radius:4px; overflow:hidden;">
                    <div
                        style="height:100%; width:{{ $pctPartisipasi }}%; background: rgba(255,255,255,0.7); border-radius:4px; transition: width 1.5s ease;">
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.68rem; margin-top:5px; opacity:0.7;">
                    <span>0%</span><span>100%</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================
             CHARTS SECTION
        ============================================================ -->
    <div class="charts-grid">

        <!-- Doughnut Partisipasi -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-icon" style="background:#ede9fe; color:#7c3aed;"><i class="fas fa-circle-notch"></i></div>
                <div>
                    <h4 class="chart-card-title">Tingkat Partisipasi</h4>
                    <p class="chart-card-sub">Perbandingan pemilih yang sudah & belum</p>
                </div>
            </div>
            <div class="chart-body" style="display:flex; flex-direction:column; align-items:center;">
                <div style="position:relative; height: 220px; width: 220px; margin: 0 auto 16px;">
                    <canvas id="chartPartisipasi"></canvas>
                    <div
                        style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                        <div style="font-size:1.8rem; font-weight:900; color:#0f172a; line-height:1;">{{ $pctPartisipasi }}%
                        </div>
                        <div
                            style="font-size:0.7rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            Hadir</div>
                    </div>
                </div>
                <div style="display:flex; gap:20px;">
                    <div
                        style="display:flex; align-items:center; gap:7px; font-size:0.82rem; font-weight:700; color:#334155;">
                        <div
                            style="width:12px; height:12px; border-radius:3px; background: linear-gradient(135deg,#4f46e5,#818cf8);">
                        </div>
                        Sudah Voting ({{ number_format($sudahVoting) }})
                    </div>
                    <div
                        style="display:flex; align-items:center; gap:7px; font-size:0.82rem; font-weight:700; color:#334155;">
                        <div
                            style="width:12px; height:12px; border-radius:3px; background: linear-gradient(135deg,#e2e8f0,#cbd5e1);">
                        </div>
                        Belum ({{ number_format($belumVoting) }})
                    </div>
                </div>
            </div>
        </div>

        <!-- Mode Split Chart -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-icon" style="background:#fef3c7; color:#d97706;"><i class="fas fa-random"></i></div>
                <div>
                    <h4 class="chart-card-title">Metode Pemilihan</h4>
                    <p class="chart-card-sub">Distribusi online vs offline</p>
                </div>
            </div>
            <div class="chart-body" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Online -->
                <div style="background: #f5f3ff; border-radius: 14px; padding: 18px 20px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom: 10px;">
                        <div>
                            <div
                                style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#7c3aed; margin-bottom:3px;">
                                <i class="fas fa-wifi mr-1"></i> Online
                            </div>
                            <div style="font-size:1.875rem; font-weight:900; color:#0f172a; line-height:1;">
                                {{ number_format($onlineV) }}</div>
                        </div>
                        <div style="font-size:1.75rem; font-weight:900; color:#7c3aed;">{{ $onlinePct }}%</div>
                    </div>
                    <div style="height: 10px; background:#e2e8f0; border-radius:5px; overflow:hidden;">
                        <div
                            style="height:100%; width: {{ $onlinePct }}%; background: linear-gradient(90deg,#4f46e5,#818cf8); border-radius:5px; transition: width 1.2s ease;">
                        </div>
                    </div>
                </div>
                <!-- Offline -->
                <div style="background: #fffbeb; border-radius: 14px; padding: 18px 20px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom: 10px;">
                        <div>
                            <div
                                style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#d97706; margin-bottom:3px;">
                                <i class="fas fa-building mr-1"></i> Offline
                            </div>
                            <div style="font-size:1.875rem; font-weight:900; color:#0f172a; line-height:1;">
                                {{ number_format($offlineV) }}</div>
                        </div>
                        <div style="font-size:1.75rem; font-weight:900; color:#d97706;">{{ $offlinePct }}%</div>
                    </div>
                    <div style="height:10px; background:#e2e8f0; border-radius:5px; overflow:hidden;">
                        <div
                            style="height:100%; width: {{ $offlinePct }}%; background: linear-gradient(90deg,#f59e0b,#fbbf24); border-radius:5px; transition: width 1.2s ease;">
                        </div>
                    </div>
                </div>
                <div style="text-align:center; font-size:0.78rem; color:#94a3b8; font-weight:500;">
                    Total {{ number_format($onlineV + $offlineV) }} pemilih telah tercatat
                </div>
            </div>
        </div>

        <!-- Bar Chart Perolehan Suara -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-icon" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-chart-bar"></i></div>
                <div>
                    <h4 class="chart-card-title">Perolehan Suara per Kandidat</h4>
                    <p class="chart-card-sub">Perbandingan suara setiap kandidat</p>
                </div>
            </div>
            <div class="chart-body">
                <div style="position:relative; height: 280px;"><canvas id="chartPerolehan"></canvas></div>
            </div>
        </div>

        <!-- Hourly Trend -->
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-icon" style="background:#e0f2fe; color:#0369a1;"><i class="fas fa-chart-area"></i>
                </div>
                <div>
                    <h4 class="chart-card-title">Tren Pemilihan Hari Ini</h4>
                    <p class="chart-card-sub">Jumlah suara per jam ({{ now()->format('d/m/Y') }})</p>
                </div>
            </div>
            <div class="chart-body">
                <div style="position:relative; height: 280px;"><canvas id="chartTren"></canvas></div>
            </div>
        </div>

    </div>

    <!-- ============================================================
             LEADERBOARD TABLE
        ============================================================ -->
    <div class="rekap-table-panel">
        <div class="rekap-table-header">
            <h3 class="rekap-table-title">
                <div class="chart-icon" style="background:#ede9fe; color:#7c3aed;"><i class="fas fa-list-ol"></i></div>
                Leaderboard Kandidat
            </h3>
            <div style="font-size:0.78rem; color:#94a3b8; font-weight:600;">
                <i class="fas fa-clock mr-1"></i> {{ now()->format('H:i:s') }}
            </div>
        </div>
        <div class="table-responsive">
            <table class="rt">
                <thead>
                    <tr>
                        <th style="width:5%;">Rank</th>
                        <th style="width:32%;">Kandidat</th>
                        <th style="width:33%;">Perolehan Suara</th>
                        <th style="width:15%; text-align:center;">%</th>
                        <th style="width:15%; text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sorted = $data->sortByDesc(fn($k) => ($k->votes_count??0)+($k->total_votes??0))->values(); @endphp
                    @forelse($sorted as $i => $kandidat)
                        @php
                            $kTotal = ($kandidat->votes_count ?? 0) + ($kandidat->total_votes ?? 0);
                            $pct = $totalVotes > 0 ? round(($kTotal / $totalVotes) * 100, 1) : 0;
                        @endphp
                        <tr class="{{ $kTotal == $maxVotes && $maxVotes > 0 ? 'winner-row' : '' }}">
                            <td>
                                <div class="rank-no rank-{{ $i + 1 <= 3 ? $i + 1 : '' }}">{{ $i + 1 }}</div>
                            </td>
                            <td>
                                <div class="kandidat-cell">
                                    @if ($kandidat->foto)
                                        <img src="{{ asset('storage/' . $kandidat->foto) }}" class="kandidat-foto"
                                            alt="{{ $kandidat->nama }}">
                                    @else
                                        <div class="kandidat-foto"><i class="fas fa-user-circle"></i></div>
                                    @endif
                                    <div>
                                        <div class="kandidat-no">No. Urut {{ $kandidat->no_urut ?? $i + 1 }}</div>
                                        <div class="kandidat-nama">{{ $kandidat->nama }}</div>
                                        @if ($kTotal == $maxVotes && $maxVotes > 0)
                                            <div
                                                style="font-size:0.72rem; color:#16a34a; font-weight:700; margin-top:2px;">
                                                <i class="fas fa-fire mr-1"></i>Unggul sementara
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="vote-bar-wrap">
                                    <div class="vote-count-val">{{ number_format($kTotal) }}</div>
                                    <div class="vote-bar-bg">
                                        <div class="vote-bar-fill {{ $kTotal == $maxVotes && $maxVotes > 0 ? 'winner-fill' : '' }}"
                                            data-width="{{ $pct }}"></div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span
                                    style="font-size:1.2rem; font-weight:900; color: {{ $kTotal == $maxVotes && $maxVotes > 0 ? '#16a34a' : '#475569' }};">{{ $pct }}%</span>
                            </td>
                            <td style="text-align:center;">
                                @if ($kTotal == $maxVotes && $maxVotes > 0)
                                    <span class="status-winner"><i class="fas fa-crown"></i> Terdepan</span>
                                @elseif($kTotal == 0)
                                    <span style="font-size:0.75rem; color:#94a3b8; font-weight:600;">0 Suara</span>
                                @else
                                    <span style="font-size:0.75rem; color:#64748b; font-weight:700;">{{ $pct }}%
                                        dari total</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:60px 20px;">
                                <div style="font-size:3.5rem; opacity:0.12; margin-bottom:14px;"><i
                                        class="fas fa-inbox"></i></div>
                                <div style="font-size:1rem; font-weight:700; color:#64748b;">Belum ada data kandidat</div>
                                <div style="font-size:0.875rem; color:#94a3b8; margin-top:4px;">Tambahkan kandidat melalui
                                    menu Data Kandidat</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($data->count() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="2"><i class="fas fa-sigma mr-2"></i> TOTAL SUARA VALID MASUK</td>
                            <td><span
                                    style="font-size:1.5rem; font-weight:900; color:#713f12;">{{ number_format($totalVotes) }}
                                    Suara</span></td>
                            <td style="text-align:center; font-size:1.1rem;">100%</td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
        <div class="rekap-footer-bar">
            <span><i class="fas fa-info-circle mr-1"></i>{{ $data->count() }} kandidat terdaftar ·
                {{ number_format($totalVotes) }} suara masuk · Partisipasi {{ $pctPartisipasi }}%</span>
            <span>Diperbarui: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>

    <!-- Hidden data for JS -->
    <div id="rekap-data" data-labels="{{ json_encode($sorted->map(fn($k) => $k->nama)->toArray()) }}"
        data-values="{{ json_encode($sorted->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))->toArray()) }}"
        data-partisipasi="{{ $sudahVoting }}" data-belum="{{ $belumVoting }}"
        data-trend-labels="{{ json_encode($stats['trend_labels']) }}"
        data-trend-data="{{ json_encode($stats['trend_data']) }}" style="display:none;"></div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Animate progress bars
            document.querySelectorAll('.vote-bar-fill').forEach(el => {
                const w = el.dataset.width || 0;
                setTimeout(() => {
                    el.style.width = w + '%';
                }, 300);
            });

            const el = document.getElementById('rekap-data');
            if (!el) return;

            const labels = JSON.parse(el.dataset.labels || '[]');
            const values = JSON.parse(el.dataset.values || '[]');
            const sudah = parseInt(el.dataset.partisipasi || 0);
            const belum = parseInt(el.dataset.belum || 0);
            const trendLbls = JSON.parse(el.dataset.trendLabels || '[]');
            const trendVals = JSON.parse(el.dataset.trendData || '[]');

            const PALETTE = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6', '#ec4899', '#f97316',
                '#14b8a6'
            ];

            const tooltipDefaults = {
                backgroundColor: 'rgba(15,23,42,0.92)',
                padding: 14,
                cornerRadius: 12,
                titleFont: {
                    family: "'Inter',sans-serif",
                    size: 13,
                    weight: '700'
                },
                bodyFont: {
                    family: "'Inter',sans-serif",
                    size: 13
                },
            };

            // ── 1. Partisipasi Doughnut ──────────────────────────────────
            const pCtx = document.getElementById('chartPartisipasi');
            if (pCtx) {
                new Chart(pCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sudah Memilih', 'Belum Memilih'],
                        datasets: [{
                            data: [sudah, belum],
                            backgroundColor: ['#4f46e5', '#e2e8f0'],
                            borderWidth: 4,
                            borderColor: '#fff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tooltipDefaults,
                                callbacks: {
                                    label: ctx => {
                                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(
                                            1) : 0;
                                        return '  ' + ctx.label + ': ' + ctx.parsed.toLocaleString() +
                                            ' (' + pct + '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 1400,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // ── 2. Perolehan Suara Bar ───────────────────────────────────
            const bCtx = document.getElementById('chartPerolehan');
            if (bCtx && labels.length) {
                new Chart(bCtx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Suara',
                            data: values,
                            backgroundColor: PALETTE.slice(0, labels.length).map(c => c + 'cc'),
                            borderColor: PALETTE.slice(0, labels.length),
                            borderWidth: 2,
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
                                ...tooltipDefaults,
                                callbacks: {
                                    label: ctx => '  ' + ctx.parsed.y + ' suara'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9',
                                    drawBorder: false,
                                    borderDash: [4, 4]
                                },
                                ticks: {
                                    font: {
                                        weight: '600'
                                    },
                                    color: '#94a3b8',
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: '700',
                                        size: 11
                                    },
                                    color: '#475569',
                                    maxRotation: 25
                                }
                            }
                        },
                        animation: {
                            duration: 1400,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // ── 3. Hourly Trend Line ─────────────────────────────────────
            const tCtx = document.getElementById('chartTren');
            if (tCtx) {
                new Chart(tCtx, {
                    type: 'line',
                    data: {
                        labels: trendLbls,
                        datasets: [{
                            label: 'Suara / Jam',
                            data: trendVals,
                            borderColor: '#4f46e5',
                            backgroundColor: function(ctx2) {
                                const g = ctx2.chart.ctx.createLinearGradient(0, 0, 0, 280);
                                g.addColorStop(0, 'rgba(79,70,229,0.25)');
                                g.addColorStop(1, 'rgba(79,70,229,0)');
                                return g;
                            },
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            fill: true,
                            tension: 0.45
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
                                ...tooltipDefaults,
                                callbacks: {
                                    label: ctx => '  ' + ctx.parsed.y + ' suara pada jam ini'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9',
                                    borderDash: [4, 4],
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        weight: '600'
                                    },
                                    color: '#94a3b8',
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: '700',
                                        size: 11
                                    },
                                    color: '#475569'
                                }
                            }
                        },
                        animation: {
                            duration: 1600,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }
        });
    </script>
@endpush
