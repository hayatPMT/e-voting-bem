@extends('layouts.admin')

@section('content')
<div class="card">
 <div class="card-header">
  <h3 class="card-title">Tambah Bilik Voting Baru</h3>
 </div>
 <form action="{{ route('admin.voting-booths.store') }}" method="POST">
  @csrf
  <div class="card-body">
   @if(session('error'))
   <div class="alert alert-danger">{{ session('error') }}</div>
   @endif

   <div class="form-group">
    <label for="nama_booth">Nama Bilik</label>
    <input type="text" name="nama_booth" id="nama_booth" class="form-control @error('nama_booth') is-invalid @enderror" value="{{ old('nama_booth') }}" required placeholder="Contoh: Bilik 1 - Gedung A">
    @error('nama_booth')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
   </div>

   <div class="form-group">
    <label for="lokasi">Lokasi (Opsional)</label>
    <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Contoh: Aula Utama">
    @error('lokasi')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
   </div>
  </div>
  <div class="card-footer">
   <button type="submit" class="btn btn-primary">Simpan Bilik</button>
   <a href="{{ route('admin.voting-booths.index') }}" class="btn btn-secondary">Batal</a>
  </div>
 </form>
</div>
@endsection