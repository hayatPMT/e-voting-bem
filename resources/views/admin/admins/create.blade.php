@extends('layouts.admin')

@section('title', 'Tambah Administrator')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrator</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
 <div class="col-md-8">
  <div class="card card-primary">
   <div class="card-header">
    <h3 class="card-title">Form Admin Baru</h3>
   </div>
   <form action="{{ route('admin.admins.store') }}" method="POST">
    @csrf
    <div class="card-body">
     <div class="row">
      <div class="col-md-6 text-center mb-4">
       <div class="mb-3">
        <i class="fas fa-user-shield fa-5x text-primary"></i>
       </div>
       <p class="text-muted">Pastikan data yang diinput sudah sesuai dengan identitas administrator.</p>
      </div>
      <div class="col-md-6">
       <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
        @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
       <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email@example.com" value="{{ old('email') }}" required>
        @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
      </div>
     </div>

     <hr>

     <div class="row">
      <div class="col-md-6">
       <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Minimal 8 karakter" required>
        @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
       <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Ulangi password" required>
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">
        <label for="department">Departemen / Divisi</label>
        <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" id="department" placeholder="Contoh: KPU / IT" value="{{ old('department') }}">
        @error('department')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
       <div class="form-group">
        <label for="phone">No. Telepon</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}">
       </div>
      </div>
     </div>
    </div>
    <div class="card-footer">
     <button type="submit" class="btn btn-primary">Simpan Admin</button>
     <a href="{{ route('admin.admins.index') }}" class="btn btn-default">Batal</a>
    </div>
   </form>
  </div>
 </div>
</div>
@endsection