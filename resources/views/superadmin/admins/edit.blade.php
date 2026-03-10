@extends('layouts.superadmin')

@section('title', 'Edit Admin Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('superadmin.admins.index') }}">Admin Kampus</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-warning card-outline shadow-sm" style="border-radius:12px;">
                <div class="card-header border-0 bg-white pt-3 pb-2">
                    <h3 class="card-title font-weight-bold" style="color:#d97706;">
                        <i class="fas fa-edit mr-2"></i> Edit Data Admin: {{ $admin->name }}
                    </h3>
                </div>
                <form method="POST" action="{{ route('superadmin.admins.update', $admin->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $admin->name) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $admin->email) }}" required>
                                <small class="text-muted">Email digunakan untuk login admin.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Kampus Penugasan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="kampus_id" class="form-control" required style="border:1px solid #c026d3;">
                                    <option value="" disabled>-- Pilih Kampus --</option>
                                    @foreach ($kampusList as $kampus)
                                        <option value="{{ $kampus->id }}"
                                            {{ old('kampus_id', $admin->kampus_id) == $kampus->id ? 'selected' : '' }}>
                                            {{ $kampus->kode }} - {{ $kampus->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="mt-4 mb-3 border-light">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Status Akun</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control">
                                    <option value="active"
                                        {{ old('status', $admin->adminProfile->status ?? 'active') == 'active' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="suspended"
                                        {{ old('status', $admin->adminProfile->status ?? 'active') == 'suspended' ? 'selected' : '' }}>
                                        Suspended</option>
                                    <option value="inactive"
                                        {{ old('status', $admin->adminProfile->status ?? 'active') == 'inactive' ? 'selected' : '' }}>
                                        Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">No. Telepon / WA</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $admin->adminProfile->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label font-weight-bold">Departemen</label>
                            <div class="col-sm-9">
                                <input type="text" name="department" class="form-control"
                                    value="{{ old('department', $admin->adminProfile->department ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 py-3" style="border-radius:0 0 12px 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('superadmin.admins.index') }}" class="btn btn-default shadow-sm border"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning shadow-sm font-weight-bold text-dark"><i
                                    class="fas fa-save mr-1"></i> Perbarui Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
