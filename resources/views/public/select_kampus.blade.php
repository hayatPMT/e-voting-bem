@extends('layouts.voting')

@section('title', 'Pilih Kampus | Hasil Real-time')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-5">
                <h1 style="font-size:2.5rem; font-weight:800; color:#1f2937;">Statistik Real-Time E-Voting</h1>
                <p class="text-muted" style="font-size:1.1rem;">Silakan pilih kampus untuk melihat hasil pemilihan secara
                    langsung.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            @forelse($kampuses as $kampus)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('public.chart') }}?kampus_id={{ $kampus->id }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm"
                            style="border-radius:16px; border:none; transition:all 0.3s ease; overflow:hidden;">
                            <div
                                style="height:8px; width:100%; background:linear-gradient(90deg, {{ $kampus->primary_color }}, {{ $kampus->secondary_color }});">
                            </div>
                            <div class="card-body text-center p-4">
                                @if ($kampus->logo)
                                    <img src="{{ asset('storage/' . $kampus->logo) }}" alt="{{ $kampus->kode }}"
                                        style="width:80px; height:80px; object-fit:contain; margin-bottom:1rem;">
                                @else
                                    <div class="d-inline-flex justify-content-center align-items-center mb-3"
                                        style="width:80px; height:80px; border-radius:50%; background:rgba(0,0,0,0.05);">
                                        <i class="fas fa-university fa-2x" style="color:{{ $kampus->primary_color }};"></i>
                                    </div>
                                @endif
                                <h4 class="font-weight-bold" style="color:#1f2937;">{{ $kampus->kode }}</h4>
                                <p class="text-muted small">{{ $kampus->nama }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-university fa-3x mb-3 opacity-50"></i>
                    <p>Belum ada kampus yang terdaftar.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
