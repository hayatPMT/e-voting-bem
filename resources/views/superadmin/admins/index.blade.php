@extends('layouts.superadmin')

@section('title', 'Admin Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item active">Admin Kampus</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-shield mr-2 text-info"></i>
                Daftar Admin Kampus
            </h5>
            <a href="{{ route('superadmin.admins.create') }}" class="btn btn-info">
                <i class="fas fa-plus mr-1"></i> Tambah Admin Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>Kampus</th>
                            <th>Departemen/Posisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $i => $admin)
                            <tr>
                                <td class="text-muted">{{ $admins->firstItem() + $i }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $admin->name }}</div>
                                    <div class="small text-muted"><i
                                            class="fas fa-phone mr-1"></i>{{ $admin->adminProfile->phone ?? '-' }}</div>
                                </td>
                                <td><a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a></td>
                                <td>
                                    @if ($admin->kampus)
                                        <div class="mb-1"><span
                                                class="badge badge-primary py-1 px-2 border">{{ $admin->kampus->nama }}</span>
                                        </div>
                                        @if ($admin->kampus->slug)
                                            <a href="{{ route('campus.portal', $admin->kampus->slug) }}" target="_blank"
                                                class="small text-muted text-decoration-none"
                                                title="Buka Portal Utama Kampus">
                                                <i class="fas fa-external-link-alt mr-1"></i>/{{ $admin->kampus->slug }}
                                            </a>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary py-1 px-2 border">Belum Ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $admin->adminProfile->department ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $admin->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1" style="gap:4px;">
                                        <a href="{{ route('superadmin.admins.edit', $admin->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('superadmin.admins.toggle-status', $admin->id) }}"
                                            class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm {{ $admin->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                title="{{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $admin->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('superadmin.admins.destroy', $admin->id) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus admin {{ $admin->name }}? Aksi ini tidak dapat dibatalkan.')">
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
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-3x mb-3 d-block opacity-50"></i>
                                    Belum ada admin kampus yang terdaftar. <a
                                        href="{{ route('superadmin.admins.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($admins->hasPages())
            <div class="card-footer">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
@endsection
