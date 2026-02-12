@extends('layouts.admin')

@section('content')
<div class="row mb-3">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <h1>Kelola Bilik Voting</h1>
  <a href="{{ route('admin.voting-booths.create') }}" class="btn btn-primary">
   <i class="fas fa-plus"></i> Tambah Bilik
  </a>
 </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
 {{ session('success') }}
 <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="card">
 <div class="card-body p-0 table-responsive">
  <table class="table table-striped table-hover">
   <thead>
    <tr>
     <th>No</th>
     <th>Nama Bilik</th>
     <th>Lokasi</th>
     <th>Status</th>
     <th>Total Voting</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @forelse($booths as $b)
    <tr>
     <td>{{ $loop->iteration }}</td>
     <td>{{ $b->nama_booth }}</td>
     <td>{{ $b->lokasi ?? '-' }}</td>
     <td>
      <span class="badge badge-{{ $b->is_active ? 'success' : 'danger' }}">
       {{ $b->is_active ? 'Aktif' : 'Non-Aktif' }}
      </span>
     </td>
     <td>{{ $b->attendance_approvals_count ?? 0 }}</td>
     <td>
      <form action="{{ route('admin.voting-booths.toggle-status', $b->id) }}" method="POST" class="d-inline">
       @csrf
       @method('PATCH')
       <button type="submit" class="btn btn-sm btn-{{ $b->is_active ? 'secondary' : 'success' }}"
        onclick="return confirm('Ubah status bilik?')">
        <i class="fas fa-power-off"></i> {{ $b->is_active ? 'Non-Aktifkan' : 'Aktifkan' }}
       </button>
      </form>
      <a href="{{ route('voting-booth.standby', $b->id) }}" target="_blank" class="btn btn-sm btn-info" title="Buka Mode Standby">
       <i class="fas fa-desktop"></i>
      </a>
      <a href="{{ route('admin.voting-booths.edit', $b->id) }}" class="btn btn-sm btn-warning">
       <i class="fas fa-edit"></i>
      </a>
      <form action="{{ route('admin.voting-booths.destroy', $b->id) }}" method="POST" class="d-inline">
       @csrf
       @method('DELETE')
       <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus bilik ini?')">
        <i class="fas fa-trash"></i>
       </button>
      </form>
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