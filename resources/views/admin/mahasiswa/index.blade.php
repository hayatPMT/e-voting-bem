@extends('layouts.admin')

@section('title', 'Kelola Mahasiswa')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Mahasiswa</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary shadow-sm mr-2 mb-2">
            <i class="fas fa-plus-circle mr-2"></i>Tambah Mahasiswa
        </a>
        <button type="button" class="btn btn-success shadow-sm mr-2 mb-2" id="openImportModal">
            <i class="fas fa-file-import mr-2"></i>Import Mahasiswa
        </button>
        <a href="{{ route('admin.mahasiswa.export') }}" class="btn btn-info shadow-sm mb-2">
            <i class="fas fa-download mr-2"></i>Export Data
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if(session('import_errors'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Peringatan Import!</strong> Beberapa data gagal diimport:
            <ul class="mb-0 mt-2">
                @foreach(session('import_errors') as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card card-outline card-primary shadow-lg border-0">
            <div class="card-header border-0 bg-transparent py-3">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-user-graduate mr-2"></i>Daftar Pemilih Terdaftar
                </h3>
                <div class="card-tools">
                    <form action="{{ route('admin.mahasiswa.index') }}" method="GET" class="input-group input-group-sm" style="width: 280px;">
                        <input type="text" name="q" class="form-control form-control-border" placeholder="Cari Nama atau NIM..." value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-borderless">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th>Identitas Mahasiswa</th>
                            <th>Program Studi</th>
                            <th class="text-center">Status Voting</th>
                            <th class="text-center" style="width: 150px;">Opsi Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa as $index => $m)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $mahasiswa->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold text-dark">{{ $m->user->name ?? 'Mahasiswa' }}</span>
                                    <span class="text-muted small"><i class="fas fa-id-card mr-1"></i>{{ $m->nim }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary font-weight-medium">{{ $m->program_studi }}</span>
                            </td>
                            <td class="text-center">
                                @if($m->has_voted)
                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Telah Memilih</span>
                                @else
                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Belum Memilih</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @if($m->has_voted)
                                    <form action="{{ route('admin.mahasiswa.toggle-voting', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reset status voting? Mahasiswa dapat memilih kembali.')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Reset Voting">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $mahasiswa->appends(request()->input())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0">
                        <small><i class="fas fa-info-circle mr-1"></i> Gunakan template Excel berikut agar format sesuai:</small> <br>
                        <a href="{{ route('admin.mahasiswa.template') }}" class="btn btn-sm btn-outline-info mt-2">
                            <i class="fas fa-file-excel mr-1"></i> Download Template Excel
                        </a>
                    </div>

                    <div class="form-group mt-3">
                        <label for="file" class="font-weight-bold">Pilih File Excel (.xlsx)</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Import Data Mahasiswa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        console.log('Mahasiswa Page Initialized');
        $('#openImportModal').on('click', function(e) {
            e.preventDefault();
            console.log('Triggering modal...');
            $('#importModal').modal('show');
        });
    });
</script>
@endpush