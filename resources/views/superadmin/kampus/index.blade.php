@extends('layouts.superadmin')

@section('title', 'Manajemen Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kampus</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-university mr-2" style="color:#c026d3;"></i>
                Daftar Kampus
            </h5>
            <a href="{{ route('superadmin.kampus.create') }}" class="btn btn-superadmin">
                <i class="fas fa-plus mr-1"></i> Tambah Kampus
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kampus</th>
                            <th>Kode</th>
                            <th>Admin</th>
                            <th>Mahasiswa</th>
                            <th>Warna Tema</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kampusList as $i => $kampus)
                            <tr>
                                <td class="text-muted">{{ $kampusList->firstItem() + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($kampus->logo)
                                            <img src="{{ asset('storage/' . $kampus->logo) }}" alt="Logo"
                                                style="width:36px;height:36px;border-radius:10px;object-fit:cover;"
                                                class="mr-2">
                                        @else
                                            <div class="mr-2 d-flex align-items-center justify-content-center"
                                                style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,{{ $kampus->primary_color }},{{ $kampus->secondary_color }});flex-shrink:0;">
                                                <i class="fas fa-university text-white" style="font-size:0.8rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $kampus->nama }}</div>
                                            <div class="text-muted" style="font-size:0.78rem;">
                                                {{ $kampus->alamat ?? $kampus->kota }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $kampus->kode }}</code></td>
                                <td><span class="badge badge-primary">{{ $kampus->admins_count }} admin</span></td>
                                <td><span class="badge"
                                        style="background:#e9d8fd;color:#553c9a;">{{ $kampus->mahasiswa_count }} mhs</span>
                                </td>
                                <td>
                                    <span class="color-swatch" style="background:{{ $kampus->primary_color }};"
                                        title="{{ $kampus->primary_color }}"></span>
                                    <span class="color-swatch ml-1" style="background:{{ $kampus->secondary_color }};"
                                        title="{{ $kampus->secondary_color }}"></span>
                                </td>
                                <td>
                                    <span class="badge {{ $kampus->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $kampus->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1" style="gap:4px;">
                                        <a href="{{ route('superadmin.kampus.show', $kampus) }}"
                                            class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.kampus.edit', $kampus) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('superadmin.kampus.toggle-status', $kampus) }}"
                                            class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm {{ $kampus->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                title="{{ $kampus->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $kampus->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('superadmin.kampus.destroy', $kampus) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus kampus {{ $kampus->nama }}? Semua data terkait tidak dapat dikembalikan.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-university fa-3x mb-3 d-block opacity-50"></i>
                                    Belum ada kampus. <a href="{{ route('superadmin.kampus.create') }}">Tambah kampus
                                        pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($kampusList->hasPages())
            <div class="card-footer">
                {{ $kampusList->links() }}
            </div>
        @endif
    </div>
@endsection
