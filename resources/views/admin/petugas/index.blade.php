@extends('layouts.admin')

@section('content')
<div class="row mb-4">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <div>
   <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Petugas</h1>
   <p class="text-muted small mb-0">Kelola akun petugas daftar hadir pemilihan</p>
  </div>
  <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary shadow-sm">
   <i class="fas fa-user-plus mr-2"></i>Tambah Petugas Baru
  </a>
 </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
 <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
 <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="row">
 <div class="col-12">
  <div class="card card-outline card-primary shadow-lg border-0">
   <div class="card-header border-0 bg-transparent py-3">
    <h3 class="card-title text-primary font-weight-bold">
     <i class="fas fa-user-tie mr-2"></i>Daftar Petugas Terdaftar
    </h3>
   </div>
   <div class="card-body p-0 table-responsive">
    <table class="table table-hover table-borderless mb-0">
     <thead class="bg-light">
      <tr>
       <th class="text-center" style="width: 60px;">#</th>
       <th>Identitas Petugas</th>
       <th>Email Petugas</th>
       <th class="text-center">Status Akun</th>
       <th class="text-center" style="width: 150px;">Opsi Kelola</th>
      </tr>
     </thead>
     <tbody>
      @forelse($petugas as $p)
      <tr>
       <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
       <td class="align-middle">
        <div class="d-flex align-items-center">
         <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="fas fa-user"></i>
         </div>
         <div>
          <span class="d-block font-weight-bold text-dark">{{ $p->name }}</span>
          <span class="text-muted small">ID: {{ $p->id }}</span>
         </div>
        </div>
       </td>
       <td class="align-middle">
        <a href="mailto:{{ $p->email }}" class="text-secondary text-decoration-none">
         <i class="far fa-envelope mr-1 text-muted"></i> {{ $p->email }}
        </a>
       </td>
       <td class="align-middle text-center">
        @if($p->is_active)
        <span class="badge badge-success px-3 py-2 shadow-sm"><i class="fas fa-check-circle mr-1"></i>Aktif</span>
        @else
        <span class="badge badge-danger px-3 py-2 shadow-sm"><i class="fas fa-ban mr-1"></i>Non-Aktif</span>
        @endif
       </td>
       <td class="align-middle text-center">
        <div class="btn-group shadow-sm border rounded-lg overflow-hidden">
         <form action="{{ route('admin.petugas.toggle-status', $p->id) }}" method="POST" class="d-inline">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-sm btn-white text-{{ $p->is_active ? 'secondary' : 'success' }} px-2"
           title="{{ $p->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
           <i class="fas {{ $p->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
          </button>
         </form>
         <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn btn-sm btn-white text-info px-2" title="Edit Profil">
          <i class="fas fa-edit"></i>
         </a>
         <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-white text-danger px-2"
           onclick="return confirm('Hapus petugas ini? Tindakan ini tidak dapat dibatalkan.')" title="Hapus Permanen">
           <i class="fas fa-trash-alt"></i>
          </button>
         </form>
        </div>
       </td>
      </tr>
      @empty
      <tr>
       <td colspan="5" class="text-center py-5 text-muted">
        <div class="mb-3">
         <i class="fas fa-user-slash fa-3x text-gray-300"></i>
        </div>
        <h6 class="font-weight-bold">Belum ada data petugas</h6>
        <p class="small text-muted mb-0">Silakan tambahkan petugas baru untuk memulai manajemen absensi.</p>
       </td>
      </tr>
      @endforelse
     </tbody>
    </table>
   </div>
   @if($petugas->hasPages())
   <div class="card-footer bg-white border-top-0 py-3">
    {{ $petugas->links() }}
   </div>
   @endif
  </div>
 </div>
</div>
@endsection