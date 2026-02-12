@extends('layouts.admin')
@section('title', 'Kelola Mahasiswa')
@section('breadcrumb_title', 'Data Mahasiswa')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Mahasiswa</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Mahasiswa
        </a>
        <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#importModal">
            <i class="fas fa-file-excel mr-2"></i>Import CSV
        </button>
        <a href="{{ route('admin.mahasiswa.export') }}" class="btn btn-info ml-2">
            <i class="fas fa-file-export mr-2"></i>Export Data
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

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Mahasiswa (Voters)</h3>
                <div class="card-tools">
                    <form action="{{ route('admin.mahasiswa.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="q" class="form-control float-right" placeholder="Cari Nama / NIM...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Status Voting</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa as $index => $m)
                        <tr>
                            <td>{{ $mahasiswa->firstItem() + $index }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->user->name ?? '-' }}</td>
                            <td>{{ $m->program_studi }}</td>
                            <td>
                                @if($m->has_voted)
                                <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Sudah Memilih</span>
                                @else
                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Belum Memilih</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @if($m->has_voted)
                                <form action="{{ route('admin.mahasiswa.toggle-voting', $m->id) }}" method="POST" class="d-inline ml-1" onsubmit="return confirm('Reset status voting mahasiswa ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-secondary" title="Reset Voting">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                @endif
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
            <!-- /.card-body -->
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
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle mr-1"></i> Gunakan template CSV berikut agar format sesuai:</small> <br>
                        <a href="{{ route('admin.mahasiswa.template') }}" class="btn btn-sm btn-outline-info mt-2">
                            <i class="fas fa-download mr-1"></i> Download Template CSV
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="file">Pilih File CSV</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".csv, .txt" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection