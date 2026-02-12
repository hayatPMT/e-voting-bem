@extends('layouts.admin')
@section('title', 'Edit Kandidat')
@section('breadcrumb_title', 'Edit Kandidat')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.kandidat.index') }}">Kandidat</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i>Edit Kandidat — {{ $kandidat->nama }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kandidat.update', $kandidat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama">Nama Kandidat <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $kandidat->nama) }}" placeholder="Nama lengkap" required>
                        @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="visi">Visi <span class="text-danger">*</span></label>
                        <textarea name="visi" id="visi" rows="3" class="form-control @error('visi') is-invalid @enderror"
                            placeholder="Visi kandidat" required>{{ old('visi', $kandidat->visi) }}</textarea>
                        @error('visi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="misi">Misi</label>
                        <textarea name="misi" id="misi" rows="4" class="form-control @error('misi') is-invalid @enderror"
                            placeholder="Misi kandidat (opsional)">{{ old('misi', $kandidat->misi) }}</textarea>
                        @error('misi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        @if ($kandidat->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $kandidat->foto) }}" alt="{{ $kandidat->nama }}"
                                class="img-thumbnail" style="max-height: 100px;">
                            <small class="d-block text-muted">Foto saat ini</small>
                        </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="foto" id="foto" class="custom-file-input @error('foto') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/gif">
                            <label class="custom-file-label" for="foto">Ubah foto (kosongkan jika tidak ubah)</label>
                        </div>
                        @error('foto')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button>
                    <a href="{{ route('admin.kandidat.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Pilih file');
    });
</script>
@endpush