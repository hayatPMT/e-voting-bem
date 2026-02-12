@extends('layouts.admin')

@section('title', 'Edit Administrator')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Administrator</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
 <div class="col-md-8">
  <div class="card card-info">
   <div class="card-header">
    <h3 class="card-title">Edit Data Admin: {{ $admin->name }}</h3>
   </div>
   <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
     <div class="row">
      <div class="col-md-6">
       <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $admin->name) }}" required>
        @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
       <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $admin->email) }}" required>
        @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
       </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">
        <label for="status">Status Profil</label>
        <select name="status" id="status" class="form-control">
         <option value="active" {{ (old('status', $admin->adminProfile->status ?? '') == 'active') ? 'selected' : '' }}>Aktif</option>
         <option value="inactive" {{ (old('status', $admin->adminProfile->status ?? '') == 'inactive') ? 'selected' : '' }}>Tidak Aktif</option>
         <option value="suspended" {{ (old('status', $admin->adminProfile->status ?? '') == 'suspended') ? 'selected' : '' }}>Suspend</option>
        </select>
       </div>
       <div class="form-group">
        <label for="department">Departemen</label>
        <input type="text" name="department" class="form-control" id="department" value="{{ old('department', $admin->adminProfile->department ?? '') }}">
       </div>
      </div>
     </div>

     <div class="form-group">
      <label for="address">Alamat (Opsional)</label>
      <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $admin->adminProfile->address ?? '') }}</textarea>
     </div>
    </div>
    <div class="card-footer">
     <button type="submit" class="btn btn-info">Update Data</button>
     <a href="{{ route('admin.admins.index') }}" class="btn btn-default">Batal</a>
    </div>
   </form>
  </div>
 </div>
</div>
@endsection