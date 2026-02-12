@extends('layouts.admin')
@section('title', 'Data Kandidat')
@section('breadcrumb_title', 'Data Kandidat')
@section('breadcrumb')
<li class="breadcrumb-item active">Kandidat</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.kandidat.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Kandidat
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Daftar Kandidat</h3>
                <div class="card-tools">
                    <span class="badge badge-primary">{{ $kandidat->total() }} kandidat</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 70px;">Foto</th>
                                <th>Nama</th>
                                <th>Visi</th>
                                <th class="text-center" style="width: 90px;">Suara</th>
                                <th class="text-center" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kandidat as $index => $k)
                            <tr>
                                <td class="align-middle">{{ $kandidat->firstItem() + $index }}</td>
                                <td class="align-middle">
                                    @if ($k->foto)
                                    <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                        class="img-circle elevation-1" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                    <span class="img-circle elevation-1 bg-secondary d-inline-flex align-items-center justify-content-center text-white" style="width: 45px; height: 45px;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle font-weight-bold">{{ $k->nama }}</td>
                                <td class="align-middle text-muted small">{{ Str::limit($k->visi, 45) }}</td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-info">{{ $k->votes_count ?? 0 }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.kandidat.edit', $k->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kandidat.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kandidat {{ $k->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                    <p class="mb-2">Belum ada kandidat</p>
                                    <a href="{{ route('admin.kandidat.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i>Tambah Kandidat Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($kandidat->hasPages())
            <div class="card-footer">
                {{ $kandidat->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection