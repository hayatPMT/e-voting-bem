@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h1 class="h3 font-weight-bold text-gray-800">Tambah Data Mahasiswa</h1>
        <p class="text-muted small">Daftarkan mahasiswa baru sebagai pemilih.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-outline card-primary shadow-lg border-0">
            <div class="card-header border-0 bg-transparent py-4 text-center pb-0">
                <div class="mx-auto bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-user-graduate fa-2x"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-0">Formulir Pendaftaran</h5>
            </div>

            <div class="card-body px-5 pb-5">
                <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                    @csrf

                    @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0 mb-4">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="name" class="font-weight-bold text-muted small text-uppercase mb-2">Nama Lengkap</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-user text-muted"></i></span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control border-0 pl-2 py-4" placeholder="Contoh: Ahmad Fauzi" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="nim" class="font-weight-bold text-muted small text-uppercase mb-2">NIM (Nomor Induk Mahasiswa)</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-id-card text-muted"></i></span>
                            </div>
                            <input type="text" name="nim" id="nim" class="form-control border-0 pl-2 py-4" placeholder="Contoh: 12345678" value="{{ old('nim') }}" required>
                        </div>
                        <small class="text-info mt-1 d-block"><i class="fas fa-info-circle mr-1"></i>NIM akan digunakan sebagai password default.</small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="font-weight-bold text-muted small text-uppercase mb-2">Alamat Email</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-envelope text-muted"></i></span>
                            </div>
                            <input type="email" name="email" id="email" class="form-control border-0 pl-2 py-4" placeholder="mahasiswa@kampus.ac.id" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="program_studi" class="font-weight-bold text-muted small text-uppercase mb-2">Program Studi</label>
                                <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-graduation-cap text-muted"></i></span>
                                    </div>
                                    <input type="text" name="program_studi" id="program_studi" class="form-control border-0 pl-2 py-4" placeholder="Contoh: Teknik Informatika" value="{{ old('program_studi') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="angkatan" class="font-weight-bold text-muted small text-uppercase mb-2">Tahun Angkatan</label>
                                <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-calendar-check text-muted"></i></span>
                                    </div>
                                    <input type="number" name="angkatan" id="angkatan" class="form-control border-0 pl-2 py-4" placeholder="Contoh: 2023" value="{{ old('angkatan') }}" min="2000" max="{{ date('Y') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-light text-muted font-weight-bold px-4 py-2 rounded-pill">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary font-weight-bold px-5 py-3 rounded-pill shadow-lg hover-lift">
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-merge:focus-within {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25) !important;
        border-color: #667eea !important;
    }

    .hover-lift {
        transition: transform 0.2s;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
    }
</style>
@endsection