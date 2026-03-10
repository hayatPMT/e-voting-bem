@extends('layouts.superadmin')

@section('title', 'Tambah Admin Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('superadmin.admins.index') }}">Admin Kampus</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-plus mr-2 text-info"></i> Tambah Admin Kampus
                        Baru</h3>
                </div>
                <form method="POST" action="{{ route('superadmin.admins.store') }}">
                    @csrf
                    <div class="card-body pb-2">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required placeholder="Nama Lengkap Admin">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required placeholder="email@kampus.ac.id">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kampus Penugasan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="kampus_id" class="form-control @error('kampus_id') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>-- Pilih Kampus --</option>
                                    @foreach ($kampusList as $kampus)
                                        <option value="{{ $kampus->id }}"
                                            {{ (request('kampus_id') ?? old('kampus_id')) == $kampus->id ? 'selected' : '' }}>
                                            {{ $kampus->kode }} - {{ $kampus->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kampus_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-3 border-light">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    placeholder="Minimal 8 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Ulangi Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" class="form-control" required
                                    placeholder="Ketik ulang password">
                            </div>
                        </div>

                        <hr class="mt-4 mb-3 border-light">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No. Telepon / WA</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    placeholder="Cth: 0812xxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label">Departemen / Bidang</label>
                            <div class="col-sm-9">
                                <input type="text" name="department"
                                    class="form-control @error('department') is-invalid @enderror"
                                    value="{{ old('department') }}" placeholder="Panitia Pemilihan Kampus A">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-footer text-right p-3 bg-white border-top align-items-center d-flex justify-content-between">
                        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-default"><i
                                class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-info font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan
                            Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
