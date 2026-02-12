@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="m-0 text-dark">Pengaturan Sistem</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-2"></i>Jadwal Voting
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="election_name">Nama Pemilihan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                                </div>
                                <input type="text" class="form-control" id="election_name" name="election_name"
                                    value="{{ old('election_name', $setting?->election_name ?? 'E-Voting BEM') }}"
                                    placeholder="Contoh: Pemilihan Ketua BEM 2026">
                            </div>
                            <small class="form-text text-muted">Nama ini akan ditampilkan di halaman voting dan hasil.</small>
                        </div>

                        <div class="form-group">
                            <label for="election_logo">Logo Pemilihan</label>
                            @if($setting && $setting->election_logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->election_logo) }}"
                                    alt="Current Logo"
                                    class="img-thumbnail"
                                    style="max-height: 100px;">
                                <p class="text-muted small mt-1">Logo saat ini</p>
                            </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="election_logo" name="election_logo" accept="image/*">
                                <label class="custom-file-label" for="election_logo">Pilih logo...</label>
                            </div>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Ukuran disarankan: 200x200px.</small>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label for="voting_start">Waktu Mulai Voting</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="datetime-local" class="form-control" id="voting_start" name="voting_start"
                                    value="{{ old('voting_start', optional($setting->voting_start)->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            <small class="form-text text-muted">Mahasiswa tidak dapat memilih sebelum waktu ini.</small>
                        </div>

                        <div class="form-group">
                            <label for="voting_end">Waktu Selesai Voting</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-times"></i></span>
                                </div>
                                <input type="datetime-local" class="form-control" id="voting_end" name="voting_end"
                                    value="{{ old('voting_end', optional($setting->voting_end)->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            <small class="form-text text-muted">Voting akan otomatis ditutup setelah waktu ini.</small>
                        </div>

                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Status Saat Ini</h5>
                            @php
                            $now = now();
                            $start = $setting->voting_start ?? null;
                            $end = $setting->voting_end ?? null;
                            $status = 'Belum Diatur';
                            $class = 'warning';

                            if ($start && $end) {
                            if ($now->between($start, $end)) {
                            $status = 'Sedang Berlangsung';
                            $class = 'success';
                            } elseif ($now->gt($end)) {
                            $status = 'Selesai';
                            $class = 'danger';
                            } else {
                            $status = 'Belum Dimulai';
                            $class = 'warning';
                            }
                            }
                            @endphp
                            Status: <span class="badge badge-{{ $class }}">{{ $status }}</span>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection