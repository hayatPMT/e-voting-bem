@extends('layouts.admin')

@section('content')
<div class="row mb-4">
 <div class="col-12 d-flex justify-content-between align-items-center">
  <div>
   <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Kelola Tahapan Pemilihan</h1>
   <p class="text-muted small mb-0">Atur jadwal dan status tahapan pemilihan BEM</p>
  </div>
  <a href="{{ route('admin.tahapan.create') }}" class="btn btn-primary shadow-sm">
   <i class="fas fa-plus-circle mr-2"></i>Tambah Tahapan Baru
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

<div class="card card-outline card-primary shadow-lg border-0">
 <div class="card-header border-0 bg-transparent py-3">
  <h3 class="card-title text-primary font-weight-bold">
   <i class="fas fa-calendar-alt mr-2"></i>Daftar Tahapan
  </h3>
 </div>
 <div class="card-body p-0 table-responsive">
  <table class="table table-hover table-borderless mb-0">
   <thead class="bg-light">
    <tr>
     <th class="text-center" style="width: 60px;">#</th>
     <th>Nama Tahapan</th>
     <th>Jadwal Pelaksanaan</th>
     <th class="text-center">Status Tahapan</th>
     <th class="text-center">Status Aktif</th>
     <th class="text-center" style="width: 150px;">Opsi Kelola</th>
    </tr>
   </thead>
   <tbody>
    @forelse($tahapans as $t)
    <tr>
     <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
     <td class="align-middle">
      <span class="d-block font-weight-bold text-dark h6 mb-0">{{ $t->nama_tahapan }}</span>
      @if($t->is_current)
      <span class="badge badge-success mt-1 shadow-sm"><i class="fas fa-check-circle mr-1"></i>Sedang Berlangsung</span>
      @endif
     </td>
     <td class="align-middle">
      <div class="d-flex flex-column small">
       <span class="text-primary font-weight-bold"><i class="fas fa-play-circle mr-1"></i> {{ $t->waktu_mulai->translatedFormat('d M Y H:i') }}</span>
       <span class="text-danger font-weight-bold mt-1"><i class="fas fa-stop-circle mr-1"></i> {{ $t->waktu_selesai->translatedFormat('d M Y H:i') }}</span>
      </div>
     </td>
     <td class="align-middle text-center">
      <span class="badge badge-{{ $t->status == 'active' ? 'primary' : ($t->status == 'completed' ? 'success' : 'secondary') }} px-3 py-2 shadow-sm">
       {{ ucfirst($t->status) }}
      </span>
     </td>
     <td class="align-middle text-center">
      @if(!$t->is_current)
      <form action="{{ route('admin.tahapan.set-current', $t->id) }}" method="POST" class="d-inline">
       @csrf
       <button type="submit" class="btn btn-sm btn-outline-success font-weight-bold" onclick="return confirm('Set tahapan ini sebagai aktif?')">
        <i class="fas fa-check mr-1"></i> Aktifkan
       </button>
      </form>
      @else
      <span class="text-success font-weight-bold"><i class="fas fa-check-double mr-1"></i> Terpilih</span>
      @endif
     </td>
     <td class="align-middle text-center">
      <div class="btn-group shadow-sm border rounded-lg overflow-hidden">
       <a href="{{ route('admin.tahapan.edit', $t->id) }}" class="btn btn-sm btn-white text-warning px-3" title="Edit Tahapan">
        <i class="fas fa-edit"></i>
       </a>
       <form action="{{ route('admin.tahapan.destroy', $t->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-white text-danger px-3" onclick="return confirm('Hapus tahapan ini?')" title="Hapus Permanen">
         <i class="fas fa-trash-alt"></i>
        </button>
       </form>
      </div>
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