@extends('layouts.superadmin')

@section('title', 'Edit Data Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('superadmin.kampus.index') }}">Kampus</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit mr-2" style="color:#f5a623;"></i>
                        Edit Data {{ $kampus->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('superadmin.kampus.update', $kampus) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Kampus <span class="text-danger">*</span></label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $kampus->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kode Kampus <span class="text-danger">*</span></label>
                                    <input type="text" name="kode"
                                        class="form-control @error('kode') is-invalid @enderror"
                                        value="{{ old('kode', $kampus->kode) }}" maxlength="20"
                                        style="text-transform:uppercase;" required>
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
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="font-size:0.85rem; color:#6b7280;">
                                        {{ url('/') }}/
                                    </span>
                                </div>
                                <input type="text" name="slug" id="slug-input"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $kampus->slug) }}"
                                    placeholder="kosongkan untuk generate ulang dari kode"
                                    style="text-transform:lowercase;">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Kosongkan dan simpan untuk men-generate ulang dari Kode Kampus. URL
                                portal unik untuk mengakses login admin dan halaman mahasiswa.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold">Alamat</label>
                                    <input type="text" name="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat', $kampus->alamat) }}">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kota</label>
                                    <input type="text" name="kota"
                                        class="form-control @error('kota') is-invalid @enderror"
                                        value="{{ old('kota', $kampus->kota) }}">
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $kampus->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Warna Utama</label>
                                    <div class="d-flex align-items-center">
                                        <input type="color" name="primary_color" id="primary_color"
                                            value="{{ old('primary_color', $kampus->primary_color) }}" class="mr-2"
                                            style="width:50px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                                        <input type="text" id="primary_color_text"
                                            value="{{ old('primary_color', $kampus->primary_color) }}" class="form-control"
                                            placeholder="#667eea" maxlength="7" style="max-width:120px;"
                                            oninput="document.getElementById('primary_color').value=this.value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Warna Kedua</label>
                                    <div class="d-flex align-items-center">
                                        <input type="color" name="secondary_color" id="secondary_color"
                                            value="{{ old('secondary_color', $kampus->secondary_color) }}" class="mr-2"
                                            style="width:50px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                                        <input type="text" id="secondary_color_text"
                                            value="{{ old('secondary_color', $kampus->secondary_color) }}"
                                            class="form-control" placeholder="#764ba2" maxlength="7"
                                            style="max-width:120px;"
                                            oninput="document.getElementById('secondary_color').value=this.value">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold d-block">Preview Tema</label>
                            <div id="gradient-preview"
                                style="height:50px;border-radius:12px;background:linear-gradient(135deg,{{ $kampus->primary_color }},{{ $kampus->secondary_color }});transition:all 0.4s ease;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Status Kampus</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="statusSwitch" name="is_active"
                                    value="1" {{ $kampus->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="statusSwitch">Kampus Aktif (Dapat Mengakses
                                    E-Voting)</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Logo Kampus</label>
                            <div class="mb-2">
                                @if ($kampus->logo)
                                    <img src="{{ asset('storage/' . $kampus->logo) }}" alt="Logo"
                                        style="height:80px;border-radius:12px;" class="mb-2 d-block">
                                @endif
                                <input type="file" name="logo"
                                    class="form-control-file @error('logo') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Format: JPG, PNG. Kosongkan jika tidak ingin mengubah.</small>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('superadmin.kampus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i> Perbarui Data
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
                    <h6 class="font-weight-bold mb-3" style="color:#f5a623;"><i
                            class="fas fa-info-circle mr-2"></i>Informasi Edit</h6>
                    <ul class="pl-3 small" style="color:rgba(255,255,255,0.75);">
                        <li class="mb-2">Pastikan kode kampus unik untuk menghidari conflict routing kampus.
                        </li>
                        <li class="mb-2"><strong>URL Portal Kampus</strong> dibuat dari slug yang unik mendefinisikan
                            portal voting di web browser. Anda bisa merubah link jika dibutuhkan.</li>
                        <li class="mb-2">Warna tampilan berpengaruh pada portal e-voting.</li>
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

        document.querySelector('[name="kode"]').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
@endpush
