@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body box-profile">
                <div class="text-center mb-4">
                    <img class="profile-user-img img-fluid img-circle"
                         src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->user->name ?? 'M') }}&background=667eea&color=fff&size=200"
                         alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <h3 class="profile-username text-center font-weight-bold">{{ $mahasiswa->user->name }}</h3>
                <p class="text-muted text-center">{{ $mahasiswa->nim }} - {{ $mahasiswa->program_studi }}</p>

                <ul class="list-group list-group-unbordered mb-3 mt-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Email</b> 
                        <span class="text-secondary">{{ $mahasiswa->user->email ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>No. Telepon</b> 
                        <span class="text-secondary">{{ $mahasiswa->phone ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Angkatan</b> 
                        <span class="text-secondary">{{ $mahasiswa->angkatan ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Semester</b> 
                        <span class="text-secondary">{{ $mahasiswa->semester ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Status Voting</b> 
                        <span>
                            @if($mahasiswa->has_voted)
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Sudah Memilih</span>
                            @else
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Belum Memilih</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Status Profil</b> 
                        <span>
                            @if($mahasiswa->status == 'active')
                                <span class="badge badge-primary px-2 py-1">Aktif</span>
                            @elseif($mahasiswa->status == 'graduated')
                                <span class="badge badge-success px-2 py-1">Lulus</span>
                            @elseif($mahasiswa->status == 'suspended')
                                <span class="badge badge-warning px-2 py-1">Suspend</span>
                            @else
                                <span class="badge badge-secondary px-2 py-1">Tidak Aktif</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Waktu Memilih</b> 
                        <span class="text-secondary">{{ $mahasiswa->voted_at ? \Carbon\Carbon::parse($mahasiswa->voted_at)->format('d M Y H:i:s') : 'Belum memilih' }}</span>
                    </li>
                </ul>

                <div class="mt-4">
                    <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-info btn-block"><b><i class="fas fa-edit mr-1"></i> Edit Data</b></a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-default btn-block"><b><i class="fas fa-arrow-left mr-1"></i> Kembali</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
