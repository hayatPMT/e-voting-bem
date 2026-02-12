@extends('layouts.admin')

@section('content')
<div class="row mb-4">
 <div class="col-12 text-center">
  <h1 class="h3 font-weight-bold text-gray-800">Tambah Tahapan Pemilihan</h1>
  <p class="text-muted small">Atur jadwal pelaksanaan setiap fase kegiatan pemilihan.</p>
 </div>
</div>

<div class="row justify-content-center">
 <div class="col-lg-8">
  <div class="card card-outline card-primary shadow-lg border-0">
   <div class="card-header border-0 bg-transparent py-4 text-center pb-0">
    <div class="mx-auto bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
     <i class="fas fa-calendar-plus fa-2x"></i>
    </div>
    <h5 class="font-weight-bold text-dark mb-0">Formulir Tahapan Baru</h5>
   </div>

   <div class="card-body px-5 pb-5">
    <form action="{{ route('admin.tahapan.store') }}" method="POST">
     @csrf

     @if(session('error'))
     <div class="alert alert-danger shadow-sm border-0 mb-4">
      <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
     </div>
     @endif

     <div class="form-group mb-4">
      <label for="nama_tahapan" class="font-weight-bold text-muted small text-uppercase mb-2">Nama Tahapan</label>
      <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
       <div class="input-group-prepend">
        <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-heading text-muted"></i></span>
       </div>
       <input type="text" name="nama_tahapan" id="nama_tahapan" class="form-control border-0 pl-2 py-4" placeholder="Contoh: Masa Kampanye" value="{{ old('nama_tahapan') }}" required autofocus>
      </div>
      @error('nama_tahapan')
      <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
      @enderror
     </div>

     <div class="form-group mb-4">
      <label for="deskripsi" class="font-weight-bold text-muted small text-uppercase mb-2">Deskripsi (Opsional)</label>
      <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
       <div class="input-group-prepend">
        <span class="input-group-text bg-white border-0 pl-3 pt-3 align-items-start"><i class="fas fa-align-left text-muted"></i></span>
       </div>
       <textarea name="deskripsi" id="deskripsi" class="form-control border-0 pl-2 py-3" rows="3" placeholder="Jelaskan detail aktivitas pada tahapan ini...">{{ old('deskripsi') }}</textarea>
      </div>
     </div>

     <div class="row">
      <div class="col-md-6">
       <div class="form-group mb-4">
        <label for="waktu_mulai" class="font-weight-bold text-muted small text-uppercase mb-2">Waktu Mulai</label>
        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
         <div class="input-group-prepend">
          <span class="input-group-text bg-white border-0 pl-3"><i class="far fa-calendar-alt text-success"></i></span>
         </div>
         <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control border-0 pl-2 py-4" value="{{ old('waktu_mulai') }}" required>
        </div>
        @error('waktu_mulai')
        <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
        @enderror
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group mb-4">
        <label for="waktu_selesai" class="font-weight-bold text-muted small text-uppercase mb-2">Waktu Selesai</label>
        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
         <div class="input-group-prepend">
          <span class="input-group-text bg-white border-0 pl-3"><i class="far fa-calendar-times text-danger"></i></span>
         </div>
         <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="form-control border-0 pl-2 py-4" value="{{ old('waktu_selesai') }}" required>
        </div>
        @error('waktu_selesai')
        <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
        @enderror
       </div>
      </div>
     </div>

     <div class="d-flex justify-content-between align-items-center mt-4">
      <a href="{{ route('admin.tahapan.index') }}" class="btn btn-light text-muted font-weight-bold px-4 py-2 rounded-pill">
       <i class="fas fa-arrow-left mr-2"></i>Kembali
      </a>
      <button type="submit" class="btn btn-primary font-weight-bold px-5 py-3 rounded-pill shadow-lg hover-lift">
       <i class="fas fa-save mr-2"></i>Simpan Tahapan
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