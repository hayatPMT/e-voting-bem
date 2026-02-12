@extends('layouts.admin')

@section('content')
<div class="card">
 <div class="card-header">
  <h3 class="card-title">Edit Bilik Voting</h3>
 </div>
 <form action="{{ route('admin.voting-booths.update', $booth->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="card-body">
   @if(session('error'))
   <div class="alert alert-danger">{{ session('error') }}</div>
   @endif

   <div class="form-group">
    <label for="nama_booth">Nama Bilik</label>
    <input type="text" name="nama_booth" id="nama_booth" class="form-control" value="{{ old('nama_booth', $booth->nama_booth) }}" required>
   </div>

   <div class="form-group">
    <label for="lokasi">Lokasi (Opsional)</label>
    <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi', $booth->lokasi) }}">
   </div>
  </div>
  <div class="card-footer">
   <button type="submit" class="btn btn-warning">Update Bilik</button>
   <a href="{{ route('admin.voting-booths.index') }}" class="btn btn-secondary">Batal</a>
  </div>
 </form>
</div>
@endsection