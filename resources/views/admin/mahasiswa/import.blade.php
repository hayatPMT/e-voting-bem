@extends('layouts.admin')

@section('title', 'Import Data Mahasiswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
    <li class="breadcrumb-item active">Import Excel</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-lg border-0 rounded-lg">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <h3 class="card-title text-success font-weight-bold">
                        <i class="fas fa-file-excel mr-2"></i>Import Data Excel (.xlsx)
                    </h3>
                </div>

                <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body px-4 pb-4">
                        <p class="text-muted">Gunakan fitur ini untuk mendaftarkan mahasiswa secara massal ke dalam sistem
                            e-voting. Pastikan Anda telah mengisi data sesuai dengan format template yang disediakan.</p>

                        <div
                            class="alert alert-info border-0 rounded-lg d-flex align-items-center justify-content-between p-3 mb-4">
                            <div>
                                <strong><i class="fas fa-info-circle mr-1"></i> Format Diperlukan!</strong> <br>
                                <small>Sistem hanya membaca struktur kolom sesuai template resmi.</small>
                            </div>
                            <a href="{{ route('admin.mahasiswa.template') }}"
                                class="btn btn-sm btn-info font-weight-bold shadow-sm">
                                <i class="fas fa-download mr-1"></i> Download Template
                            </a>
                        </div>

                        <div class="form-group border rounded p-4 text-center bg-light"
                            style="border: 2px dashed #cbd5e1 !important;">
                            <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                            <h5 class="font-weight-bold text-dark mb-1">Pilih atau Seret File Excel</h5>
                            <p class="text-muted small mb-3">Format yang didukung: .xlsx, .xls maksimal 4MB</p>

                            <div class="custom-file text-left w-75 mx-auto d-block">
                                <input type="file" class="custom-file-input" id="file" name="file"
                                    accept=".xlsx, .xls" required>
                                <label class="custom-file-label" for="file">Pilih file excel...</label>
                            </div>
                        </div>
                    </div>

                    <div
                        class="card-footer bg-light border-top-0 rounded-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.mahasiswa.index') }}"
                            class="btn btn-outline-secondary font-weight-bold rounded-pill px-4">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success font-weight-bold rounded-pill px-4 shadow-sm"
                            id="btnUpload"
                            onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i>Mengunggah...'; this.classList.add('disabled'); this.form.submit();">
                            <i class="fas fa-upload mr-1"></i> Mulai Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Update custom-file-label to show the selected file name
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endpush
