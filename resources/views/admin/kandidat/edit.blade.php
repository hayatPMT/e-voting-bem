@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h1 class="h3 font-weight-bold text-gray-800">Edit Kandidat</h1>
        <p class="text-muted small">Perbarui informasi dan biodata kandidat.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-outline card-warning shadow-lg border-0">
            <div class="card-header border-0 bg-transparent py-4 text-center pb-0">
                <div class="mx-auto bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-user-edit fa-2x"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-0">Edit Biodata</h5>
            </div>

            <div class="card-body px-5 pb-5">
                <form action="{{ route('admin.kandidat.update', $kandidat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0 mb-4">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group mb-4">
                        <label for="nama" class="font-weight-bold text-muted small text-uppercase mb-2">Nama Kandidat</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3"><i class="fas fa-user text-muted"></i></span>
                            </div>
                            <input type="text" name="nama" id="nama" class="form-control border-0 pl-2 py-4" placeholder="Nama Lengkap Kandidat" value="{{ old('nama', $kandidat->nama) }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="visi" class="font-weight-bold text-muted small text-uppercase mb-2">Visi</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3 pt-3 align-items-start"><i class="fas fa-eye text-muted"></i></span>
                            </div>
                            <textarea name="visi" id="visi" class="form-control border-0 pl-2 py-3" rows="3" placeholder="Visi kandidat..." required>{{ old('visi', $kandidat->visi) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="misi" class="font-weight-bold text-muted small text-uppercase mb-2">Misi</label>
                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3 pt-3 align-items-start"><i class="fas fa-list-ul text-muted"></i></span>
                            </div>
                            <textarea name="misi" id="misi" class="form-control border-0 pl-2 py-3" rows="5" placeholder="Misi kandidat (poin-poin)...">{{ old('misi', $kandidat->misi) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="foto" class="font-weight-bold text-muted small text-uppercase mb-2">Foto Kandidat</label>

                        @if ($kandidat->foto)
                        <div class="d-flex align-items-center mb-3 bg-light p-2 rounded">
                            <img src="{{ asset('storage/' . $kandidat->foto) }}" alt="{{ $kandidat->nama }}" class="img-thumbnail rounded-circle mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <small class="text-muted d-block font-weight-bold">Foto saat ini</small>
                                <small class="text-secondary">Akan diganti jika Anda mengunggah foto baru.</small>
                            </div>
                        </div>
                        @endif

                        <div class="input-group input-group-merge border rounded-lg overflow-hidden shadow-sm">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                                <label class="custom-file-label border-0 pl-3 py-3 h-auto" for="foto">Pilih Foto Baru (Opsional)</label>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">Format: JPG, PNG, GIF. Ukuran Maksimal: 2MB.</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('admin.kandidat.index') }}" class="btn btn-light text-muted font-weight-bold px-4 py-2 rounded-pill">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-white font-weight-bold px-5 py-3 rounded-pill shadow-lg hover-lift">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-merge:focus-within {
        box-shadow: 0 0 0 3px rgba(246, 173, 85, 0.4) !important;
        border-color: #f6ad55 !important;
    }

    .hover-lift {
        transition: transform 0.2s;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
    }

    .custom-file-input:focus~.custom-file-label {
        border-color: #f6ad55;
        box-shadow: none;
    }

    .custom-file-label::after {
        background-color: #f8f9fa;
        color: #6c757d;
        height: 100%;
        padding-top: 10px;
    }
</style>
@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush