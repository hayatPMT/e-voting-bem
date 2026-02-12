@extends('layouts.admin')

@section('title', 'Daftar Administrator')

@section('breadcrumb')
<li class="breadcrumb-item active">Administrator</li>
@endsection

@section('content')
<div class="row mb-4">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <div>
   <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Administrator</h1>
   <p class="text-muted small mb-0">Kelola akun administrator sistem e-voting</p>
  </div>
  <a href="{{ route('admin.admins.create') }}" class="btn btn-primary shadow-sm">
   <i class="fas fa-user-plus mr-2"></i>Tambah Admin Baru
  </a>
 </div>
</div>

<div class="row">
 <div class="col-12">
  <div class="card card-outline card-primary shadow-lg border-0">
   <div class="card-header border-0 bg-transparent py-3">
    <h3 class="card-title text-primary font-weight-bold">
     <i class="fas fa-user-shield mr-2"></i>Daftar Akun Administrator
    </h3>
   </div>
   <div class="card-body p-0 table-responsive">
    <table class="table table-hover table-borderless mb-0">
     <thead class="bg-light">
      <tr>
       <th class="text-center" style="width: 60px;">#</th>
       <th>Identitas Admin</th>
       <th>Kontak Email</th>
       <th>Departemen/Divisi</th>
       <th class="text-center">Status Akun</th>
       <th class="text-center" style="width: 150px;">Opsi Kelola</th>
      </tr>
     </thead>
     <tbody>
     <tbody>
      @forelse ($admins as $index => $admin)
      <tr>
       <td class="text-center align-middle font-weight-bold text-muted">{{ $admins->firstItem() + $index }}</td>
       <td class="align-middle">
        <div class="d-flex align-items-center">
         <div class="bg-light rounded-circle p-2 mr-3 border text-secondary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
          <i class="fas fa-user"></i>
         </div>
         <div>
          <span class="d-block font-weight-bold text-dark">{{ $admin->name }}</span>
          <span class="text-muted small">ID: {{ $admin->id }}</span>
         </div>
        </div>
       </td>
       <td class="align-middle">
        <a href="mailto:{{ $admin->email }}" class="text-decoration-none text-secondary">
         <i class="far fa-envelope mr-1 text-muted"></i> {{ $admin->email }}
        </a>
       </td>
       <td class="align-middle">
        <span class="badge badge-light border text-dark">{{ $admin->adminProfile->department ?? 'Umum' }}</span>
       </td>
       <td class="align-middle text-center">
        @if($admin->is_active)
        <span class="badge badge-success px-3 py-2 shadow-sm"><i class="fas fa-check-circle mr-1"></i>Aktif</span>
        @else
        <span class="badge badge-danger px-3 py-2 shadow-sm"><i class="fas fa-ban mr-1"></i>Non-Aktif</span>
        @endif
       </td>
       <td class="align-middle text-center">
        <div class="btn-group shadow-sm border rounded-lg overflow-hidden">
         <form action="{{ route('admin.admins.toggle-status', $admin->id) }}" method="POST" class="d-inline">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-sm btn-white text-{{ $admin->is_active ? 'secondary' : 'success' }} px-2" title="{{ $admin->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
           <i class="fas {{ $admin->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
          </button>
         </form>
         <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-white text-info px-2" title="Edit Profil">
          <i class="fas fa-edit"></i>
         </a>
         <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus admin ini? Tindakan ini tidak dapat dibatalkan.')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-white text-danger px-2" title="Hapus Permanen">
           <i class="fas fa-trash-alt"></i>
          </button>
         </form>
        </div>
       </td>
      </tr>
      @empty
      <tr>
       <td colspan="6" class="text-center py-4">Belum ada admin tambahan.</td>
      </tr>
      @endforelse
     </tbody>
    </table>
   </div>
   <div class="card-footer">
    {{ $admins->links() }}
   </div>
  </div>
 </div>
</div>
@endsection