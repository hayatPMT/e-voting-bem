@extends('layouts.admin')

@section('content')
<div class="row mb-4">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <div>
   <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Kelola Bilik Voting</h1>
   <p class="text-muted small mb-0">Manajemen lokasi dan status bilik suara fisik</p>
  </div>
  <a href="{{ route('admin.voting-booths.create') }}" class="btn btn-primary shadow-sm">
   <i class="fas fa-plus-circle mr-2"></i>Tambah Bilik Baru
  </a>
 </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
 {{ session('success') }}
 <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="card card-outline card-primary shadow-lg border-0">
 <div class="card-header border-0 bg-transparent py-3">
  <h3 class="card-title text-primary font-weight-bold">
   <i class="fas fa-person-booth mr-2"></i>Daftar Bilik Suara
  </h3>
 </div>
 <div class="card-body p-0 table-responsive">
  <table class="table table-hover table-borderless mb-0">
   <thead class="bg-light">
    <tr>
     <th class="text-center" style="width: 60px;">#</th>
     <th>Nama Bilik</th>
     <th>Lokasi Fisik</th>
     <th class="text-center">Status Operasional</th>
     <th class="text-center">Aktivitas Voting</th>
     <th class="text-center" style="width: 180px;">Opsi Kelola</th>
    </tr>
   </thead>
   <tbody>
   <tbody>
    @forelse($booths as $b)
    <tr>
     <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
     <td class="align-middle">
      <span class="d-block font-weight-bold text-dark h6 mb-0">{{ $b->nama_booth }}</span>
      <span class="text-muted small">ID: {{ $b->id }}</span>
     </td>
     <td class="align-middle">
      <span class="text-secondary"><i class="fas fa-map-marker-alt mr-1"></i> {{ $b->lokasi ?? 'Belum diset' }}</span>
     </td>
     <td class="align-middle text-center">
      <span class="badge badge-{{ $b->is_active ? 'success' : 'danger' }} px-3 py-2 shadow-sm">
       <i class="fas fa-circle mr-1 small"></i> {{ $b->is_active ? 'Online' : 'Offline' }}
      </span>
     </td>
     <td class="align-middle text-center">
      <span class="font-weight-bold text-primary">{{ $b->attendance_approvals_count ?? 0 }}</span> <span class="text-muted small">pemilih</span>
     </td>
     <td class="align-middle text-center">
      <div class="btn-group shadow-sm border rounded-lg overflow-hidden">
       <form action="{{ route('admin.voting-booths.toggle-status', $b->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm btn-white text-{{ $b->is_active ? 'secondary' : 'success' }} px-2"
         onclick="return confirm('Ubah status bilik?')" title="{{ $b->is_active ? 'Matikan Bilik' : 'Hidupkan Bilik' }}">
         <i class="fas fa-power-off"></i>
        </button>
       </form>
       <a href="{{ route('voting-booth.standby', $b->id) }}" target="_blank" class="btn btn-sm btn-white text-info px-2" title="Buka Portal Standby">
        <i class="fas fa-tv"></i>
       </a>
       <a href="{{ route('admin.voting-booths.edit', $b->id) }}" class="btn btn-sm btn-white text-warning px-2" title="Edit Data">
        <i class="fas fa-edit"></i>
       </a>
       <form action="{{ route('admin.voting-booths.destroy', $b->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-white text-danger px-2" onclick="return confirm('Hapus bilik ini? Data terkait mungkin akan hilang.')" title="Hapus Permanen">
         <i class="fas fa-trash-alt"></i>
        </button>
       </form>
      </div>
     </td>
    </tr>
    @empty
    <tr>
     <td colspan="6" class="text-center">Belum ada data bilik.</td>
    </tr>
    @endforelse
   </tbody>
  </table>
 </div>
</div>
@endsection