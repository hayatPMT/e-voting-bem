@extends('layouts.admin')

@section('content')
<div class="row mb-4">
 <div class="col-12 text-center">
  <h1 class="h3 font-weight-bold text-gray-800">Tambah Bilik Voting</h1>
  <p class="text-muted small">Buat lokasi pemungutan suara baru.</p>
 </div>
</div>

<div class="row justify-content-center">
 <div class="col-lg-6">
  <div class="card card-outline card-primary shadow-lg border-0">
   <div class="card-header border-0 bg-transparent py-4 text-center pb-0">
    <div class="mx-auto bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
     <i class="fas fa-person-booth fa-2x"></i>
    </div>
    <h5 class="font-weight-bold text-dark mb-0">Formulir Bilik Suara</h5>
   </div>

   <div class="card-body px-5 pb-5">
    <form action="{{ route('admin.voting-booths.store') }}" method="POST">
     @csrf

     @if(session('error'))
     <div class="alert alert-danger shadow-sm border-0 mb-4">
      <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
     </div>
     @endif

     <div class="form-group mb-4">
      <label for="nama_booth" class="font-weight-bold text-muted small text-uppercase mb-2">Nama Bilik</label>
      <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
       <div class="input-group-prepend">
        <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-door-open text-muted"></i></span>
       </div>
       <input type="text" name="nama_booth" id="nama_booth" class="form-control border-0 pl-2 py-4" placeholder="Contoh: Bilik 01" value="{{ old('nama_booth') }}" required autofocus>
      </div>
      @error('nama_booth')
      <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
      @enderror
     </div>

     <div class="form-group mb-4">
      <label for="lokasi" class="font-weight-bold text-muted small text-uppercase mb-2">Lokasi (Opsional)</label>
      <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
       <div class="input-group-prepend">
        <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-map-marker-alt text-muted"></i></span>
       </div>
       <input type="text" name="lokasi" id="lokasi" class="form-control border-0 pl-2 py-4" placeholder="Contoh: Gedung A, Lantai 1" value="{{ old('lokasi') }}">
      </div>
      @error('lokasi')
      <small class="text-danger font-weight-bold mt-1 d-block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
      @enderror
     </div>

     <div class="d-flex justify-content-between align-items-center mt-4">
      <a href="{{ route('admin.voting-booths.index') }}" class="btn btn-light text-muted font-weight-bold px-4 py-2 rounded-pill">
       <i class="fas fa-arrow-left mr-2"></i>Kembali
      </a>
      <button type="submit" class="btn btn-primary font-weight-bold px-5 py-3 rounded-pill shadow-lg hover-lift">
       <i class="fas fa-save mr-2"></i>Simpan Bilik
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