@extends('layouts.admin')
@section('title', 'Data Kandidat')
@section('breadcrumb_title', 'Data Kandidat')
@section('breadcrumb')
<li class="breadcrumb-item active">Kandidat</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.kandidat.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle mr-2"></i>Tambah Kandidat Baru
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary shadow-lg border-0">
            <div class="card-header border-0 bg-transparent py-3">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-users-cog mr-2"></i>Manajemen Data Kandidat
                </h3>
                <div class="card-tools">
                    <span class="badge badge-primary px-3 py-2 shadow-sm">{{ $kandidat->total() }} Kandidat Terdaftar</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center" style="width: 70px;">#</th>
                                <th style="width: 100px;">Foto</th>
                                <th>Informasi Kandidat</th>
                                <th>Visi & Misi Ringkas</th>
                                <th class="text-center" style="width: 120px;">Total Suara</th>
                                <th class="text-center" style="width: 160px;">Opsi Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kandidat as $index => $k)
                            <tr>
                                <td class="text-center align-middle font-weight-bold text-muted">{{ $kandidat->firstItem() + $index }}</td>
                                <td class="align-middle text-center">
                                    @if ($k->foto)
                                    <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                        class="img-thumbnail rounded-circle shadow-sm" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #edf2f7;">
                                    @else
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 60px; height: 60px; border: 2px solid #edf2f7;">
                                        <i class="fas fa-user-tie fa-lg"></i>
                                    </div>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="d-block font-weight-bold text-dark h6 mb-0">{{ $k->nama }}</span>
                                    <span class="text-muted small">ID Kandidat: {{ $k->id }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="text-muted small pr-3" style="line-height: 1.5;">
                                        {{ Str::limit($k->visi, 80) }}
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-info p-2 px-3 shadow-sm" style="font-size: 0.9rem;">
                                        <i class="fas fa-vote-yea mr-1"></i> {{ $k->votes_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group shadow-sm border rounded-lg overflow-hidden">
                                        <a href="{{ route('admin.kandidat.edit', $k->id) }}" class="btn btn-sm btn-white text-primary px-3" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.kandidat.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kandidat {{ $k->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-white text-danger px-3" title="Hapus Permanen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
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