@extends('layouts.admin')

@section('content')
<div class="card">
 <div class="card-header">
  <h3 class="card-title">Tambah Tahapan Baru</h3>
 </div>
 <form action="{{ route('admin.tahapan.store') }}" method="POST">
  @csrf
  <div class="card-body">
   @if(session('error'))
   <div class="alert alert-danger">{{ session('error') }}</div>
   @endif

   <div class="form-group">
    <label for="nama_tahapan">Nama Tahapan</label>
    <input type="text" name="nama_tahapan" id="nama_tahapan" class="form-control @error('nama_tahapan') is-invalid @enderror" value="{{ old('nama_tahapan') }}" required>
    @error('nama_tahapan')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
   </div>

   <div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
   </div>

   <div class="row">
    <div class="col-md-6 form-group">
     <label for="waktu_mulai">Waktu Mulai</label>
     <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" value="{{ old('waktu_mulai') }}" required>
     @error('waktu_mulai')
     <div class="invalid-feedback">{{ $message }}</div>
     @enderror
    </div>
    <div class="col-md-6 form-group">
     <label for="waktu_selesai">Waktu Selesai</label>
     <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" value="{{ old('waktu_selesai') }}" required>
     @error('waktu_selesai')
     <div class="invalid-feedback">{{ $message }}</div>
     @enderror
    </div>
   </div>
  </div>
  <div class="card-footer">
   <button type="submit" class="btn btn-primary">Simpan Tahapan</button>
   <a href="{{ route('admin.tahapan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
 </form>
</div>
@endsection