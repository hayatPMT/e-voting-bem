@extends('layouts.app')
@section('title', 'Tambah Kandidat')
@section('breadcrumb_title', 'Tambah Kandidat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kandidat.index') }}">Kandidat</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Form Tambah Kandidat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kandidat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Kandidat <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                            @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="visi">Visi <span class="text-danger">*</span></label>
                            <textarea name="visi" id="visi" rows="3" class="form-control @error('visi') is-invalid @enderror"
                                      placeholder="Visi kandidat" required>{{ old('visi') }}</textarea>
                            @error('visi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="misi">Misi</label>
                            <textarea name="misi" id="misi" rows="4" class="form-control @error('misi') is-invalid @enderror"
                                      placeholder="Misi kandidat (opsional)">{{ old('misi') }}</textarea>
                            @error('misi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <div class="custom-file">
                                <input type="file" name="foto" id="foto" class="custom-file-input @error('foto') is-invalid @enderror"
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                                <label class="custom-file-label" for="foto">Pilih file (JPG/PNG, max 2MB)</label>
                            </div>
                            @error('foto')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan</button>
                        <a href="{{ route('admin.kandidat.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Pilih file');
    });
</script>
@endpush
