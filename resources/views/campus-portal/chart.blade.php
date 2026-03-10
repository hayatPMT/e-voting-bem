<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Voting Real-time | {{ $kampus->nama }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900;1,14..32,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        /* ===========================================
           VARIABLES
        =========================================== */
        :root {
            --primary: {{ $kampus->primary_color ?? '#4f46e5' }};
            --secondary: {{ $kampus->secondary_color ?? '#7c3aed' }};
            --bg: #0f0e1a;
            --card: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.08);
            --text: #f1f5f9;
            --muted: rgba(255, 255, 255, 0.55);
            --success: #10b981;
            --warning: #f59e0b;
        }

        /* ===========================================
           BASE
        =========================================== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% 0%, color-mix(in srgb, var(--primary) 18%, transparent) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 100%, color-mix(in srgb, var(--secondary) 15%, transparent) 0%, transparent 60%);
        }

        /* ===========================================
           TOPBAR
        =========================================== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(16px) saturate(1.5);
            -webkit-backdrop-filter: blur(16px) saturate(1.5);
            background: rgba(15, 14, 26, 0.7);
            border-bottom: 1px solid var(--card-border);
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        .topbar-name {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .topbar-sub {
            font-size: 0.7rem;
            color: var(--muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .live-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 20px;
            padding: 5px 13px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #4ade80;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ade80;
            animation: liveblink 1.4s infinite;
        }

        @keyframes liveblink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.8);
            }
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 10px;
            border: 1px solid var(--card-border);
            background: var(--card);
            transition: all 0.2s;
        }

        .back-btn:hover {
            color: var(--text);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.15);
            text-decoration: none;
        }

        /* ===========================================
           PAGE CONTAINER
        =========================================== */
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px 48px;
        }

        /* ===========================================
           PAGE HERO
        =========================================== */
        .page-hero {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 16px;
        }

        .page-hero-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ffffff, color-mix(in srgb, var(--primary) 60%, white));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-hero-sub {
            font-size: 1rem;
            color: var(--muted);
            font-weight: 400;
        }

        /* ===========================================
           GLASS CARD
        =========================================== */
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            overflow: hidden;
            transition: border-color 0.25s;
        }

        .glass-card:hover {
            border-color: rgba(255, 255, 255, 0.12);
        }

        .glass-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .glass-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .glass-card-title {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--text);
            margin: 0;
        }

        .glass-card-sub {
            font-size: 0.7rem;
            color: var(--muted);
            margin: 0;
        }

        .glass-card-body {
            padding: 22px;
        }

        /* ===========================================
           KPI GRID
        =========================================== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 28px;
        }

        .kpi-tile {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 20px 18px;
            transition: all 0.25s;
        }

        .kpi-tile:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
        }

        .kpi-icon-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .kpi-value {
            font-size: 2.25rem;
            font-weight: 900;
            letter-spacing: -1.5px;
            line-height: 1;
            color: var(--text);
            margin-bottom: 5px;
        }

        .kpi-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
        }

        /* Special Partisipasi Tile */
        .kpi-tile-partisipasi {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
        }

        .kpi-tile-partisipasi .kpi-value,
        .kpi-tile-partisipasi .kpi-label {
            color: white;
        }

        .kpi-tile-partisipasi .kpi-label {
            opacity: 0.8;
        }

        .partisipasi-bar-outer {
            margin-top: 12px;
            height: 8px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
            overflow: hidden;
        }

        .partisipasi-bar-inner {
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 4px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===========================================
           CHARTS LAYOUT
        =========================================== */
        .charts-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 28px;
        }

        .chart-full {
            grid-column: 1 / -1;
        }

        .chart-height-300 {
            position: relative;
            height: 300px;
        }

        .chart-height-220 {
            position: relative;
            height: 220px;
        }

        .chart-height-260 {
            position: relative;
            height: 260px;
        }

        /* ===========================================
           LEADERBOARD
        =========================================== */
        .leaderboard {
            margin-bottom: 28px;
        }

        .lb-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--card-border);
            transition: background 0.2s;
        }

        .lb-item:last-child {
            border-bottom: none;
        }

        .lb-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .lb-rank {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 900;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted);
        }

        .lb-rank.rank-1 {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        }

        .lb-rank.rank-2 {
            background: linear-gradient(135deg, #94a3b8, #cbd5e1);
            color: white;
        }

        .lb-rank.rank-3 {
            background: linear-gradient(135deg, #b45309, #d97706);
            color: white;
        }

        .lb-foto {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--card-border);
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
        }

        .lb-info {
            flex: 1;
            min-width: 0;
        }

        .lb-no {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
        }

        .lb-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .lb-bar-section {
            width: 200px;
            flex-shrink: 0;
        }

        .lb-bar-bg {
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .lb-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
            transition: width 1.2s ease;
        }

        .lb-bar-fill.leader-fill {
            background: linear-gradient(90deg, var(--success), #34d399);
        }

        .lb-bar-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--muted);
        }

        .lb-count {
            text-align: right;
            flex-shrink: 0;
        }

        .lb-count-val {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
        }

        .lb-count-sub {
            font-size: 0.65rem;
            color: var(--muted);
            font-weight: 600;
        }

        .lb-winner-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 800;
            margin-top: 2px;
        }

        /* ===========================================
           MODE SPLIT
        =========================================== */
        .mode-split-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .mode-block {
            border-radius: 14px;
            padding: 18px;
        }

        .mode-value {
            font-size: 2rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 4px;
        }

        .mode-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.85;
        }

        .mode-bar-outer {
            height: 8px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 12px;
        }

        .mode-bar-inner {
            height: 100%;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.65);
            transition: width 1.2s ease;
        }

        /* ===========================================
           FOOTER TICKER
        =========================================== */
        .update-ticker {
            text-align: center;
            font-size: 0.78rem;
            color: var(--muted);
            font-weight: 600;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .update-ticker .tick-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4ade80;
            animation: liveblink 1.4s infinite;
        }

        /* ===========================================
           RESPONSIVE
        =========================================== */
        @media (max-width: 900px) {
            .charts-wrapper {
                grid-template-columns: 1fr;
            }

            .chart-full {
                grid-column: auto;
            }
        }

        @media (max-width: 640px) {
            .page-container {
                padding: 20px 16px 40px;
            }

            .kpi-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .lb-bar-section {
                display: none;
            }

            .mode-split-row {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 16px;
            }
        }

        @media (max-width: 360px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-brand">
            @if ($kampus->logo)
                <img src="{{ asset('storage/' . $kampus->logo) }}" alt="{{ $kampus->nama }}"
                    style="width:36px;height:36px;object-fit:cover;border-radius:10px;flex-shrink:0;">
            @else
                <div class="topbar-logo"><i class="fas fa-university"></i></div>
            @endif
            <div>
                <div class="topbar-name">{{ $kampus->nama }}</div>
                <div class="topbar-sub">E-Voting BEM</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="live-badge">
                <div class="live-dot"></div> Live
            </div>
            <a href="{{ route('campus.portal', $kampus->slug) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span style="display:none" class="d-sm-inline">Portal</span>
            </a>
        </div>
    </header>

    @php
        $totalVotes = $totalSuara;
        $maxVotes = $kandidat->max(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0));
        $sorted = $kandidat->sortByDesc(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))->values();
        $pct = $stats['partisipasi_persen'];
        $sudah = $stats['sudah_voting'];
        $belum = $stats['belum_voting'];
        $totalMhs = $stats['total_mahasiswa'];
        $onlineV = $stats['online_voters'];
        $offlineV = $stats['offline_voters'];
        $totalVoters = $onlineV + $offlineV;
        $onlinePct = $totalVoters > 0 ? round(($onlineV / $totalVoters) * 100, 1) : 0;
        $offlinePct = $totalVoters > 0 ? round(($offlineV / $totalVoters) * 100, 1) : 0;
    @endphp

    <!-- MAIN -->
    <div class="page-container">

        <!-- Hero -->
        <div class="page-hero">
            <div class="page-hero-eyebrow">
                <i class="fas fa-chart-bar"></i>
                Hasil Pemilihan Realtime
            </div>
            <h1 class="page-hero-title">Rekapitulasi Suara<br>{{ $kampus->nama }}</h1>
            <p class="page-hero-sub">Data diperbarui otomatis setiap 15 detik</p>
        </div>

        <!-- KPI Grid -->
        <div class="kpi-grid">

            <div class="kpi-tile">
                <div class="kpi-icon-row">
                    <div class="kpi-icon" style="background:rgba(79,70,229,0.15); color: var(--primary);"><i
                            class="fas fa-users"></i></div>
                    <span
                        style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:var(--muted);">DPT</span>
                </div>
                <div class="kpi-value" id="stat-dpt">{{ number_format($totalMhs) }}</div>
                <div class="kpi-label">Total Pemilih</div>
            </div>

            <div class="kpi-tile">
                <div class="kpi-icon-row">
                    <div class="kpi-icon" style="background:rgba(16,185,129,0.12); color: #10b981;"><i
                            class="fas fa-vote-yea"></i></div>
                    <span style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:#4ade80;">✔</span>
                </div>
                <div class="kpi-value" id="stat-voted" style="color:#4ade80;">{{ number_format($sudah) }}</div>
                <div class="kpi-label">Sudah Memilih</div>
            </div>

            <div class="kpi-tile">
                <div class="kpi-icon-row">
                    <div class="kpi-icon" style="background:rgba(245,158,11,0.12); color: #f59e0b;"><i
                            class="fas fa-hourglass-half"></i></div>
                    <span
                        style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:var(--muted);">Sisa</span>
                </div>
                <div class="kpi-value" id="stat-belum" style="color:#fbbf24;">{{ number_format($belum) }}</div>
                <div class="kpi-label">Belum Memilih</div>
            </div>

            <div class="kpi-tile">
                <div class="kpi-icon-row">
                    <div class="kpi-icon" style="background:rgba(156,163,175,0.12); color: #9ca3af;"><i
                            class="fas fa-user-slash"></i></div>
                    <span
                        style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:var(--muted);">Kosong</span>
                </div>
                <div class="kpi-value" id="stat-abstain" style="color:#9ca3af;">
                    {{ number_format($stats['abstain_votes'] ?? 0) }}</div>
                <div class="kpi-label">Suara Abstain</div>
            </div>

            <div class="kpi-tile kpi-tile-partisipasi">
                <div class="kpi-icon-row">
                    <div class="kpi-icon" style="background:rgba(255,255,255,0.15); color:white;"><i
                            class="fas fa-chart-pie"></i></div>
                    <span
                        style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:rgba(255,255,255,0.7);">Partisipasi</span>
                </div>
                <div class="kpi-value" id="stat-pct" style="color:white;">{{ $pct }}%</div>
                <div class="kpi-label" style="color:rgba(255,255,255,0.7);">Tingkat Partisipasi</div>
                <div class="partisipasi-bar-outer">
                    <div class="partisipasi-bar-inner" id="pct-bar" style="width: {{ $pct }}%;"></div>
                </div>
            </div>

        </div>

        <!-- Charts Row 1: Doughnut (Partisipasi) + Bar (Perolehan) -->
        <div class="charts-wrapper">

            <!-- Doughnut Partisipasi -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <div class="glass-card-icon" style="background:rgba(79,70,229,0.15); color:#a5b4fc;"><i
                            class="fas fa-circle-notch"></i></div>
                    <div>
                        <h4 class="glass-card-title">Tingkat Partisipasi</h4>
                        <p class="glass-card-sub">Sudah vs Belum memilih</p>
                    </div>
                </div>
                <div class="glass-card-body" style="display:flex; flex-direction:column; align-items:center; gap:16px;">
                    <div style="position:relative; height: 220px; width: 220px;">
                        <canvas id="chartPartisipasi"></canvas>
                        <div
                            style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; pointer-events:none;">
                            <div style="font-size:2rem; font-weight:900; color:white; line-height:1;" id="center-pct">
                                {{ $pct }}%</div>
                            <div
                                style="font-size:0.68rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.5px;">
                                hadir</div>
                        </div>
                    </div>
                    <!-- Mode Split Below Ring -->
                    <div class="mode-split-row" style="width:100%;">
                        <div class="mode-block"
                            style="background: rgba(79,70,229,0.12); border: 1px solid rgba(79,70,229,0.2); color: #a5b4fc;">
                            <div
                                style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.8; margin-bottom:4px;">
                                <i class="fas fa-wifi mr-1"></i> Online
                            </div>
                            <div class="mode-value" style="font-size:1.5rem; color:white;">
                                {{ number_format($onlineV) }}</div>
                            <div class="mode-bar-outer">
                                <div class="mode-bar-inner" style="width:{{ $onlinePct }}%;"></div>
                            </div>
                            <div style="font-size:0.7rem; opacity:0.7; margin-top:5px;">{{ $onlinePct }}% dari
                                pemilih</div>
                        </div>
                        <div class="mode-block"
                            style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); color: #fbbf24;">
                            <div
                                style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.8; margin-bottom:4px;">
                                <i class="fas fa-building mr-1"></i> Offline
                            </div>
                            <div class="mode-value" style="font-size:1.5rem; color:white;">
                                {{ number_format($offlineV) }}</div>
                            <div class="mode-bar-outer">
                                <div class="mode-bar-inner"
                                    style="width:{{ $offlinePct }}%; background: rgba(251,191,36,0.7);"></div>
                            </div>
                            <div style="font-size:0.7rem; opacity:0.7; margin-top:5px;">{{ $offlinePct }}% dari
                                pemilih</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Perolehan Suara Real-time -->
            <div class="glass-card">
                <div class="glass-card-header">
                    <div class="glass-card-icon" style="background:rgba(16,185,129,0.15); color:#34d399;"><i
                            class="fas fa-chart-bar"></i></div>
                    <div>
                        <h4 class="glass-card-title">Perolehan Suara </h4>
                        <p class="glass-card-sub" id="total-suara-sub">Total {{ number_format($totalVotes) }} suara
                            masuk</p>
                    </div>
                </div>
                <div class="glass-card-body">
                    <div class="chart-height-300"><canvas id="chartPerolehan"></canvas></div>
                </div>
            </div>

            <!-- Line Chart Tren per Jam – Full Width -->
            <div class="glass-card chart-full">
                <div class="glass-card-header">
                    <div class="glass-card-icon" style="background:rgba(6,182,212,0.15); color:#22d3ee;"><i
                            class="fas fa-chart-area"></i></div>
                    <div>
                        <h4 class="glass-card-title">Tren Voting Hari Ini</h4>
                        <p class="glass-card-sub">Jumlah suara per jam — {{ now()->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="glass-card-body">
                    <div class="chart-height-220"><canvas id="chartTren"></canvas></div>
                </div>
            </div>

        </div>

        <!-- Leaderboard -->
        <div class="glass-card leaderboard">
            <div class="glass-card-header">
                <div class="glass-card-icon" style="background:rgba(245,158,11,0.15); color:#fbbf24;"><i
                        class="fas fa-trophy"></i></div>
                <div>
                    <h4 class="glass-card-title">Leaderboard Kandidat</h4>
                    <p class="glass-card-sub">Urutan berdasarkan suara terbanyak</p>
                </div>
            </div>
            <div id="leaderboard-container">
                @forelse($sorted as $i => $k)
                    @php
                        $kTotal = ($k->votes_count ?? 0) + ($k->total_votes ?? 0);
                        $kPct = $totalVotes > 0 ? round(($kTotal / $totalVotes) * 100, 1) : 0;
                    @endphp
                    <div class="lb-item">
                        <div class="lb-rank rank-{{ $i + 1 <= 3 ? $i + 1 : '' }}">{{ $i + 1 }}</div>
                        @if ($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                class="lb-foto">
                        @else
                            <div class="lb-foto"><i class="fas fa-user-circle" style="font-size:1.3rem;"></i></div>
                        @endif
                        <div class="lb-info">
                            <div class="lb-no">No. Urut {{ $k->no_urut ?? $i + 1 }}</div>
                            <div class="lb-name">{{ $k->nama }}</div>
                            @if ($kTotal == $maxVotes && $maxVotes > 0)
                                <div class="lb-winner-badge"><i class="fas fa-crown"></i> Unggul</div>
                            @endif
                        </div>
                        <div class="lb-bar-section">
                            <div class="lb-bar-bg">
                                <div class="lb-bar-fill {{ $kTotal == $maxVotes && $maxVotes > 0 ? 'leader-fill' : '' }}"
                                    style="width: {{ $kPct }}%;"></div>
                            </div>
                            <div class="lb-bar-meta">
                                <span>{{ $kPct }}%</span>
                                <span>dari total</span>
                            </div>
                        </div>
                        <div class="lb-count">
                            <div class="lb-count-val">{{ number_format($kTotal) }}</div>
                            <div class="lb-count-sub">suara</div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 60px 24px; text-align:center;">
                        <div style="font-size:3rem; opacity:0.1; margin-bottom:12px;"><i class="fas fa-inbox"></i>
                        </div>
                        <div style="font-size:0.95rem; font-weight:700; color:var(--muted);">Belum ada data kandidat
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Update Ticker -->
        <div class="update-ticker">
            <div class="tick-dot"></div>
            <span id="update-timer">Memperbarui dalam 15 detik…</span>
        </div>

    </div>

    <!-- Hidden data container -->
    <div id="chart-init-data" data-labels="{{ json_encode($sorted->map(fn($k) => $k->nama)->toArray()) }}"
        data-values="{{ json_encode($sorted->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0))->toArray()) }}"
        data-sudah="{{ $sudah }}" data-belum="{{ $belum }}"
        data-abstain="{{ $stats['abstain_votes'] ?? 0 }}"
        data-trend-labels="{{ json_encode($stats['trend_labels']) }}"
        data-trend-data="{{ json_encode($stats['trend_data']) }}" data-kampus-id="{{ $kampus->id }}"
        data-primary="{{ $kampus->primary_color ?? '#4f46e5' }}"
        data-secondary="{{ $kampus->secondary_color ?? '#7c3aed' }}" style="display:none;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const init = document.getElementById('chart-init-data');
            const LABELS = JSON.parse(init.dataset.labels || '[]');
            const VALUES = JSON.parse(init.dataset.values || '[]');
            const SUDAH = parseInt(init.dataset.sudah || 0);
            const BELUM = parseInt(init.dataset.belum || 0);
            const TLABELS = JSON.parse(init.dataset.trendLabels || '[]');
            const TDATA = JSON.parse(init.dataset.trendData || '[]');
            const KAMPUS_ID = init.dataset.kampusId;
            const COL_PRIMARY = init.dataset.primary;
            const COL_SECONDARY = init.dataset.secondary;

            // Color palette for bars
            const PALETTE = [COL_PRIMARY, '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6', '#ec4899',
                '#f97316'
            ];

            const tooltipBase = {
                backgroundColor: 'rgba(15,14,26,0.92)',
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
                borderColor: 'rgba(255,255,255,0.08)',
                borderWidth: 1,
                displayColors: false,
            };

            Chart.defaults.color = 'rgba(255,255,255,0.45)';
            Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';

            // ── 1. Partisipasi Doughnut ─────────────────────────────
            const pCtx = document.getElementById('chartPartisipasi');
            let partisipasiChart;
            if (pCtx) {
                partisipasiChart = new Chart(pCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sudah Memilih', 'Belum Memilih'],
                        datasets: [{
                            data: [SUDAH, BELUM],
                            backgroundColor: [COL_PRIMARY, 'rgba(255,255,255,0.08)'],
                            borderColor: ['transparent', 'rgba(255,255,255,0.06)'],
                            borderWidth: 2,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tooltipBase,
                                callbacks: {
                                    label: ctx => {
                                        const tot = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        const p = tot > 0 ? ((ctx.parsed / tot) * 100).toFixed(1) : 0;
                                        return '  ' + ctx.label + ': ' + ctx.parsed.toLocaleString() +
                                            ' (' + p + '%)';
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

            // ── 2. Bar Perolehan ────────────────────────────────────
            const bCtx = document.getElementById('chartPerolehan');
            let perolehanChart;
            if (bCtx) {
                perolehanChart = new Chart(bCtx, {
                    type: 'bar',
                    data: {
                        labels: LABELS,
                        datasets: [{
                            label: 'Suara',
                            data: VALUES,
                            backgroundColor: PALETTE.slice(0, LABELS.length).map(c => c + 'bb'),
                            borderColor: PALETTE.slice(0, LABELS.length),
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
                                ...tooltipBase,
                                callbacks: {
                                    label: ctx => '  ' + ctx.parsed.y.toLocaleString() + ' suara'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [4, 4]
                                },
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        weight: '600'
                                    }
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
                                    maxRotation: 20
                                }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // ── 3. Trend Line ───────────────────────────────────────
            const tCtx = document.getElementById('chartTren');
            let trendChart;
            if (tCtx) {
                trendChart = new Chart(tCtx, {
                    type: 'line',
                    data: {
                        labels: TLABELS,
                        datasets: [{
                            label: 'Suara / Jam',
                            data: TDATA,
                            borderColor: COL_PRIMARY,
                            backgroundColor: ctx2 => {
                                const g = ctx2.chart.ctx.createLinearGradient(0, 0, 0, 220);
                                g.addColorStop(0, COL_PRIMARY + '44');
                                g.addColorStop(1, COL_PRIMARY + '00');
                                return g;
                            },
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: COL_PRIMARY,
                            pointBorderColor: '#0f0e1a',
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
                                ...tooltipBase,
                                callbacks: {
                                    label: ctx => '  ' + ctx.parsed.y + ' suara pada jam ini'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [4, 4]
                                },
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        weight: '600'
                                    }
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
                                    }
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

            // ── Auto Refresh (15s) ──────────────────────────────────
            let countdown = 15;
            const timerEl = document.getElementById('update-timer');

            setInterval(() => {
                countdown--;
                if (timerEl) timerEl.textContent = 'Memperbarui dalam ' + countdown + ' detik…';
                if (countdown <= 0) {
                    countdown = 15;
                    fetchUpdate();
                }
            }, 1000);

            function fetchUpdate() {
                if (timerEl) timerEl.textContent = 'Memperbarui…';
                fetch(`/api/chart?kampus_id=${KAMPUS_ID}`)
                    .then(r => r.json())
                    .then(data => {
                        // Update Bar Chart
                        if (perolehanChart) {
                            perolehanChart.data.labels = data.labels;
                            perolehanChart.data.datasets[0].data = data.values;
                            perolehanChart.update('active');
                        }

                        // Update sub text
                        const total = data.values.reduce((a, b) => a + b, 0);
                        const sub = document.getElementById('total-suara-sub');
                        if (sub) sub.textContent = 'Total ' + total.toLocaleString('id') + ' suara masuk';
                    })
                    .catch(() => {});
            }
        });
    </script>

</body>

</html>
