@extends('layouts.superadmin')

@section('title', 'Dashboard Super Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-university"></i></div>
                <div>
                    <div class="stat-number">{{ $totalKampus }}</div>
                    <div class="stat-label">Total Kampus</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon gold"><i class="fas fa-user-shield"></i></div>
                <div>
                    <div class="stat-number">{{ $totalAdmins }}</div>
                    <div class="stat-label">Total Admin</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <div class="stat-number">{{ number_format($totalMahasiswa) }}</div>
                    <div class="stat-label">Total Mahasiswa</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-vote-yea"></i></div>
                <div>
                    <div class="stat-number">{{ number_format($totalVotes) }}</div>
                    <div class="stat-label">Total Suara</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campus Overview Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-university mr-2" style="color:#c026d3;"></i>
                Ringkasan Semua Kampus
            </h5>
            <a href="{{ route('superadmin.kampus.create') }}" class="btn btn-superadmin btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Kampus
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kampus</th>
                            <th>Kode</th>
                            <th>Warna Tema</th>
                            <th>Jumlah Admin</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Pemilihan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kampusList as $kampus)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($kampus->logo)
                                            <img src="{{ asset('storage/' . $kampus->logo) }}" alt="Logo" class="mr-2"
                                                style="width:32px;height:32px;border-radius:8px;object-fit:cover;">
                                        @else
                                            <div class="mr-2 d-flex align-items-center justify-content-center"
                                                style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,{{ $kampus->primary_color }},{{ $kampus->secondary_color }});">
                                                <i class="fas fa-university text-white" style="font-size:0.75rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-bold text-dark" style="font-size:0.88rem;">
                                                {{ $kampus->nama }}</div>
                                            <div class="text-muted" style="font-size:0.75rem;">{{ $kampus->kota }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><code style="font-size:0.8rem;">{{ $kampus->kode }}</code></td>
                                <td>
                                    <span class="color-swatch" style="background:{{ $kampus->primary_color }};"></span>
                                    <span class="color-swatch ml-1"
                                        style="background:{{ $kampus->secondary_color }};"></span>
                                </td>
                                <td>
                                    <span class="badge badge-primary"
                                        style="font-size:0.8rem;">{{ $kampus->admins_count ?? 0 }} admin</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary"
                                        style="font-size:0.8rem;">{{ $kampus->mahasiswa_count ?? 0 }} mhs</span>
                                </td>
                                <td>
                                    @if ($kampus->settings->first())
                                        <div style="font-size:0.78rem;" class="text-muted">
                                            {{ $kampus->settings->first()->election_name ?? '-' }}</div>
                                    @else
                                        <span class="text-muted" style="font-size:0.78rem;">Belum dikonfigurasi</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($kampus->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('superadmin.kampus.show', $kampus) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('superadmin.kampus.monitor', $kampus) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-superadmin btn-sm" title="Pantau Panel Admin">
                                            <i class="fas fa-desktop"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('superadmin.kampus.edit', $kampus) }}" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-university fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada kampus terdaftar. <a href="{{ route('superadmin.kampus.create') }}">Tambah
                                        sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
