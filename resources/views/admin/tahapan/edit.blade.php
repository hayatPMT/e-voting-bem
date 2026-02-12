@extends('layouts.admin')

@section('content')
<div class="card">
 <div class="card-header">
  <h3 class="card-title">Edit Tahapan</h3>
 </div>
 <form action="{{ route('admin.tahapan.update', $tahapan->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="card-body">
   @if(session('error'))
   <div class="alert alert-danger">{{ session('error') }}</div>
   @endif

   <div class="form-group">
    <label for="nama_tahapan">Nama Tahapan</label>
    <input type="text" name="nama_tahapan" id="nama_tahapan" class="form-control" value="{{ old('nama_tahapan', $tahapan->nama_tahapan) }}" required>
   </div>

   <div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $tahapan->deskripsi) }}</textarea>
   </div>

   <div class="row">
    <div class="col-md-6 form-group">
     <label for="waktu_mulai">Waktu Mulai</label>
     <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control" value="{{ old('waktu_mulai', $tahapan->waktu_mulai ? $tahapan->waktu_mulai->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div class="col-md-6 form-group">
     <label for="waktu_selesai">Waktu Selesai</label>
     <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="form-control" value="{{ old('waktu_selesai', $tahapan->waktu_selesai ? $tahapan->waktu_selesai->format('Y-m-d\TH:i') : '') }}" required>
    </div>
   </div>
  </div>
  <div class="card-footer">
   <button type="submit" class="btn btn-warning">Update Tahapan</button>
   <a href="{{ route('admin.tahapan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
 </form>
</div>
@endsection