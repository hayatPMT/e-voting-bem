@extends('layouts.admin')

@section('content')
<div class="row mb-3">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <h1>Kelola Tahapan Pemilihan</h1>
  <a href="{{ route('admin.tahapan.create') }}" class="btn btn-primary">
   <i class="fas fa-plus"></i> Tambah Tahapan
  </a>
 </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
 {{ session('success') }}
 <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
 {{ session('error') }}
 <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="card">
 <div class="card-body p-0 table-responsive">
  <table class="table table-striped table-hover">
   <thead>
    <tr>
     <th>No</th>
     <th>Nama Tahapan</th>
     <th>Waktu Mulai</th>
     <th>Waktu Selesai</th>
     <th>Status</th>
     <th>Status Aktif</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @forelse($tahapans as $t)
    <tr>
     <td>{{ $loop->iteration }}</td>
     <td>
      {{ $t->nama_tahapan }}
      @if($t->is_current)
      <span class="badge badge-success ml-2">Currently Active</span>
      @endif
     </td>
     <td>{{ $t->waktu_mulai->translatedFormat('d M Y H:i') }}</td>
     <td>{{ $t->waktu_selesai->translatedFormat('d M Y H:i') }}</td>
     <td>
      <span class="badge badge-{{ $t->status == 'active' ? 'primary' : ($t->status == 'completed' ? 'success' : 'secondary') }}">
       {{ ucfirst($t->status) }}
      </span>
     </td>
     <td>
      @if(!$t->is_current)
      <form action="{{ route('admin.tahapan.set-current', $t->id) }}" method="POST" class="d-inline">
       @csrf
       <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Set tahapan ini sebagai aktif?')">
        <i class="fas fa-check"></i> Set Active
       </button>
      </form>
      @else
      <span class="text-success"><i class="fas fa-check-circle"></i> Aktif</span>
      @endif
     </td>
     <td>
      <a href="{{ route('admin.tahapan.edit', $t->id) }}" class="btn btn-sm btn-warning">
       <i class="fas fa-edit"></i>
      </a>
      <form action="{{ route('admin.tahapan.destroy', $t->id) }}" method="POST" class="d-inline">
       @csrf
       @method('DELETE')
       <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tahapan ini?')">
        <i class="fas fa-trash"></i>
       </button>
      </form>
     </td>
    </tr>
    @empty
    <tr>
     <td colspan="7" class="text-center">Belum ada data tahapan.</td>
    </tr>
    @endforelse
   </tbody>
  </table>
 </div>
</div>
@endsection