@extends('layouts.voting')

@section('title', 'Pilih Kampus | Portal Bilik Suara')

@section('content')
    <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-md-10 col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 font-weight-bold text-dark mb-2">Pilih Kampus</h1>
                <p class="lead text-muted">Silakan pilih kampus tempat bilik suara ini akan digunakan.</p>
            </div>

            <div class="row">
                @forelse($kampuses as $kampus)
                    <div class="col-md-6 mb-4">
                        <a href="{{ route('voting-booth.portal') }}?kampus_id={{ $kampus->id }}"
                            class="text-decoration-none">
                            <div class="card border-0 shadow-sm hover-lift h-100"
                                style="border-radius: 20px; transition: all 0.3s ease; overflow:hidden;">
                                <!-- Color line top -->
                                <div
                                    style="height: 8px; width: 100%; background: linear-gradient(90deg, {{ $kampus->primary_color }}, {{ $kampus->secondary_color }});">
                                </div>
                                <div class="card-body p-4 text-center">
                                    @if ($kampus->logo)
                                        <img src="{{ asset('storage/' . $kampus->logo) }}" alt="{{ $kampus->kode }}"
                                            style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 1rem;">
                                    @else
                                        <div class="mb-3 mx-auto d-flex align-items-center justify-content-center"
                                            style="width: 80px; height: 80px; background: rgba(0, 123, 255, 0.1); border-radius: 50%;">
                                            <i class="fas fa-university text-primary"
                                                style="font-size: 2.5rem; color: {{ $kampus->primary_color }} !important;"></i>
                                        </div>
                                    @endif
                                    <h3 class="font-weight-bold text-dark mb-1">{{ $kampus->kode }}</h3>
                                    <p class="text-muted mb-3">{{ $kampus->nama }}</p>

                                    <div class="btn btn-outline-primary btn-block py-2 font-weight-bold"
                                        style="border-radius: 12px;">
                                        LANJUT PENGATURAN BILIK <i class="fas fa-arrow-right ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-white shadow-sm rounded-lg" style="border-radius: 20px;">
                        <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                        <h4 class="font-weight-bold text-muted">Belum ada Kampus aktif</h4>
                        <p class="text-muted">Silakan hubungi Super Admin untuk mendaftarkan Kampus.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('landing') }}" class="btn btn-link text-muted">
                    <i class="fas fa-chevron-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <style>
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
            background: linear-gradient(to bottom right, #ffffff, #f0f7ff);
        }
    </style>
@endsection
