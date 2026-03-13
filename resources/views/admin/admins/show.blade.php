@extends('layouts.admin')

@section('title', 'Detail Administrator')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrator</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body box-profile">
                <div class="text-center mb-4">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ asset('images/default-avatar.png') }}"
                         alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <h3 class="profile-username text-center font-weight-bold">{{ $admin->name }}</h3>
                <p class="text-muted text-center">{{ $admin->email }}</p>

                <ul class="list-group list-group-unbordered mb-3 mt-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Departemen</b> 
                        <span class="text-secondary">{{ $admin->adminProfile->department ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>No. Telepon</b> 
                        <span class="text-secondary">{{ $admin->adminProfile->phone ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Status</b> 
                        <span>
                            @if(($admin->adminProfile->status ?? '') == 'active' && $admin->is_active)
                                <span class="badge badge-success px-2 py-1">Aktif</span>
                            @elseif(($admin->adminProfile->status ?? '') == 'suspended')
                                <span class="badge badge-warning px-2 py-1">Suspend</span>
                            @else
                                <span class="badge badge-danger px-2 py-1">Tidak Aktif</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Terdaftar pada</b> 
                        <span class="text-secondary">{{ $admin->created_at->format('d M Y H:i') }}</span>
                    </li>
                </ul>

                <br>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                <p class="text-muted mt-2">
                    {{ $admin->adminProfile->address ?? 'Belum ada alamat' }}
                </p>

                <div class="mt-4">
                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-info btn-block"><b><i class="fas fa-edit mr-1"></i> Edit Admin</b></a>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-default btn-block"><b><i class="fas fa-arrow-left mr-1"></i> Kembali</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
