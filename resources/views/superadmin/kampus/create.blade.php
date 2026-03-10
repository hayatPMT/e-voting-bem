@extends('layouts.superadmin')

@section('title', 'Tambah Kampus Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('superadmin.kampus.index') }}">Kampus</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-university mr-2" style="color:#c026d3;"></i>
                        Tambah Kampus Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('superadmin.kampus.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Kampus <span class="text-danger">*</span></label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        placeholder="cth: Universitas Negeri Surabaya" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kode Kampus <span class="text-danger">*</span></label>
                                    <input type="text" name="kode"
                                        class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}"
                                        placeholder="cth: UNESA" maxlength="20" style="text-transform:uppercase;" required>
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Slug / Portal URL --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                URL Portal Kampus
                                <span class="badge badge-info ml-1" style="font-size:0.7rem;">Auto-generate dari Kode</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="font-size:0.85rem; color:#6b7280;">
                                        {{ url('/') }}/
                                    </span>
                                </div>
                                <input type="text" name="slug" id="slug-input"
                                    class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                    placeholder="akan-otomatis-dibuat">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Kosongkan untuk otomatis dibuat dari Kode Kampus. Hanya huruf kecil,
                                angka, dan strip (-).</small>
                        </div>

                        <div class="row">
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat') }}" placeholder="Jl. Ketintang, Gedangan...">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Kota</label>
                        <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                            value="{{ old('kota') }}" placeholder="Surabaya">
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                    placeholder="Deskripsi singkat tentang kampus...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Warna Utama (Primary)</label>
                        <div class="d-flex align-items-center">
                            <input type="color" name="primary_color" id="primary_color"
                                value="{{ old('primary_color', '#667eea') }}" class="mr-2"
                                style="width:50px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" id="primary_color_text" value="{{ old('primary_color', '#667eea') }}"
                                class="form-control" placeholder="#667eea" maxlength="7" style="max-width:120px;"
                                oninput="document.getElementById('primary_color').value=this.value">
                        </div>
                        @error('primary_color')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Warna Kedua (Secondary)</label>
                        <div class="d-flex align-items-center">
                            <input type="color" name="secondary_color" id="secondary_color"
                                value="{{ old('secondary_color', '#764ba2') }}" class="mr-2"
                                style="width:50px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" id="secondary_color_text"
                                value="{{ old('secondary_color', '#764ba2') }}" class="form-control"
                                placeholder="#764ba2" maxlength="7" style="max-width:120px;"
                                oninput="document.getElementById('secondary_color').value=this.value">
                        </div>
                        @error('secondary_color')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Preview Gradient -->
            <div class="mb-3">
                <label class="font-weight-bold d-block">Preview Tema</label>
                <div id="gradient-preview"
                    style="height:50px;border-radius:12px;background:linear-gradient(135deg,#667eea,#764ba2);transition:all 0.4s ease;">
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Logo Kampus</label>
                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/jpg">
                <small class="text-muted">Format: JPG, PNG. Maks. 2MB</small>
                @error('logo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="{{ route('superadmin.kampus.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-superadmin">
                    <i class="fas fa-save mr-1"></i> Simpan Kampus
                </button>
            </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Info Panel -->
    <div class="col-md-4">
        <div class="card" style="background:linear-gradient(135deg,#1a1a2e,#0f3460);color:#fff;">
            <div class="card-body">
                <h6 class="font-weight-bold mb-3" style="color:#f5a623;"><i class="fas fa-info-circle mr-2"></i>Informasi
                </h6>
                <ul class="pl-3 small" style="color:rgba(255,255,255,0.75);">
                    <li class="mb-2">Setiap kampus memiliki admin, kandidat, dan penghitungan suara yang terpisah.
                    </li>
                    <li class="mb-2">Kode kampus digunakan sebagai identifier unik (cth: UNESA, UI, ITB).</li>
                    <li class="mb-2">Warna utama & kedua digunakan sebagai tema tampilan voting kampus tersebut.</li>
                    <li>Setelah kampus dibuat, Anda dapat menambahkan admin untuk kampus tersebut.</li>
                </ul>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updatePreview() {
            const p = document.getElementById('primary_color').value;
            const s = document.getElementById('secondary_color').value;
            document.getElementById('gradient-preview').style.background = `linear-gradient(135deg, ${p}, ${s})`;
            document.getElementById('primary_color_text').value = p;
            document.getElementById('secondary_color_text').value = s;
        }

        document.getElementById('primary_color').addEventListener('input', updatePreview);
        document.getElementById('secondary_color').addEventListener('input', updatePreview);

        // Auto-uppercase kode input
        document.querySelector('[name="kode"]').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
@endpush
