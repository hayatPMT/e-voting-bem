@extends('layouts.admin')

@section('title', 'Daftar Administrator')

@section('breadcrumb')
<li class="breadcrumb-item active">Administrator</li>
@endsection

@section('content')
<div class="row mb-3">
 <div class="col-12">
  <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
   <i class="fas fa-plus mr-1"></i> Tambah Admin
  </a>
 </div>
</div>

<div class="row">
 <div class="col-12">
  <div class="card card-outline card-primary">
   <div class="card-header">
    <h3 class="card-title">List Admin Dashboard</h3>
   </div>
   <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
     <thead>
      <tr>
       <th>No</th>
       <th>Nama</th>
       <th>Email</th>
       <th>Departemen</th>
       <th>Status Akun</th>
       <th>Aksi</th>
      </tr>
     </thead>
     <tbody>
      @forelse ($admins as $index => $admin)
      <tr>
       <td>{{ $admins->firstItem() + $index }}</td>
       <td>{{ $admin->name }}</td>
       <td>{{ $admin->email }}</td>
       <td>{{ $admin->adminProfile->department ?? '-' }}</td>
       <td>
        @if($admin->is_active)
        <span class="badge badge-success">Aktif</span>
        @else
        <span class="badge badge-danger">Non-Aktif</span>
        @endif
       </td>
       <td>
        <form action="{{ route('admin.admins.toggle-status', $admin->id) }}" method="POST" class="d-inline">
         @csrf
         @method('PATCH')
         <button type="submit" class="btn btn-sm {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $admin->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
          <i class="fas {{ $admin->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
         </button>
        </form>
        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-info">
         <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus admin ini?')">
         @csrf
         @method('DELETE')
         <button type="submit" class="btn btn-sm btn-danger">
          <i class="fas fa-trash"></i>
         </button>
        </form>
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