@extends('layouts.admin')
@section('title', 'Laporan Daftar Hadir')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-clipboard-list mr-2"></i>Laporan Daftar Hadir
            </h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow-sm">
                <div class="card-body">
                    <div class="text-primary font-weight-bold text-uppercase mb-1">Total Hadir</div>
                    <div class="h3 mb-0">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow-sm">
                <div class="card-body">
                    <div class="text-info font-weight-bold text-uppercase mb-1">Online</div>
                    <div class="h3 mb-0">{{ $stats['online'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-secondary shadow-sm">
                <div class="card-body">
                    <div class="text-secondary font-weight-bold text-uppercase mb-1">Offline</div>
                    <div class="h3 mb-0">{{ $stats['offline'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow-sm">
                <div class="card-body">
                    <div class="text-success font-weight-bold text-uppercase mb-1">Sudah Voting</div>
                    <div class="h3 mb-0">{{ $stats['voted'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Data</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.attendance.index') }}" class="form-inline">
                <div class="form-group mr-3 mb-2">
                    <label for="date" class="mr-2">Tanggal:</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ request('date', today()->format('Y-m-d')) }}">
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="mode" class="mr-2">Mode:</label>
                    <select id="mode" name="mode" class="form-control">
                        <option value="">-- Semua --</option>
                        <option value="online" {{ request('mode') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ request('mode') == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="status" class="mr-2">Status:</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">-- Semua --</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="voted" {{ request('status') == 'voted' ? 'selected' : '' }}>Voted</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fas fa-search mr-1"></i>Filter
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary mb-2 ml-2">
                    <i class="fas fa-redo mr-1"></i>Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-md-12">
            <button type="button" class="btn btn-info" onclick="printTable()">
                <i class="fas fa-print mr-1"></i>Cetak
            </button>
            <a href="{{ route('admin.attendance.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-download mr-1"></i>Export CSV
            </a>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0" id="attendanceTable">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 12%">Waktu</th>
                        <th style="width: 10%">NIM</th>
                        <th style="width: 20%">Nama</th>
                        <th style="width: 15%">Program Studi</th>
                        <th style="width: 8%">Mode</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 15%">Petugas</th>
                        <th style="width: 5%">Token</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $index => $attendance)
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td><small class="text-muted">{{ $attendance->created_at->format('Y-m-d H:i') }}</small></td>
                            <td>{{ $attendance->mahasiswa->mahasiswaProfile->nim ?? '-' }}</td>
                            <td><strong>{{ $attendance->mahasiswa->name ?? '-' }}</strong></td>
                            <td>{{ $attendance->mahasiswa->mahasiswaProfile->program_studi ?? '-' }}</td>
                            <td>
                                @if($attendance->mode == 'online')
                                    <span class="badge badge-info"><i class="fas fa-globe mr-1"></i>Online</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fas fa-desktop mr-1"></i>Offline</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->status == 'approved')
                                    <span class="badge badge-warning text-dark"><i class="fas fa-clock mr-1"></i>Approved</span>
                                @elseif($attendance->status == 'voted')
                                    <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Voted</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($attendance->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $attendance->petugas?->name ?? 'Self-Register' }}</small>
                            </td>
                            <td>
                                @if($attendance->session_token)
                                    <code class="text-primary font-weight-bold">{{ $attendance->session_token }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                Tidak ada data daftar hadir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light text-muted">
            <small>Total: {{ $attendances->count() }} mahasiswa | Online: {{ $stats['online'] }} | Offline: {{ $stats['offline'] }} | Sudah Voting: {{ $stats['voted'] }}</small>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printContent,
        #printContent * {
            visibility: visible;
        }

        #printContent {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .table {
            font-size: 11px;
        }

        .btn,
        .card-header,
        .form-inline {
            display: none !important;
        }
    }

    .table-responsive {
        max-height: 500px;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
    }
</style>

<script>
    function printTable() {
        var divContents = document.getElementById("attendanceTable").outerHTML;
        var printWindow = window.open('', '', 'height=500,width=1200');
        printWindow.document.write('<html><head><title>Laporan Daftar Hadir</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">');
        printWindow.document.write('<style>body { font-family: Arial, sans-serif; } table { font-size: 12px; } .text-muted { color: #6c757d !important; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h3 class="text-center mb-3">LAPORAN DAFTAR HADIR PEMILIHAN</h3>');
        printWindow.document.write('<p class="text-center text-muted">Tanggal: ' + new Date().toLocaleDateString('id-ID') + '</p>');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endsection
