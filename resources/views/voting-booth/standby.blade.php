@extends('layouts.voting')

@section('content')
<div class="row min-vh-100 align-items-center justify-content-center">
  <div class="col-md-6 text-center">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
      <div class="card-header bg-primary py-4">
        <h3 class="text-white font-weight-bold mb-0 text-uppercase" style="letter-spacing: 2px;">{{ $booth->nama_booth }}</h3>
        <small class="text-white-50">{{ $booth->lokasi ?? 'Lokasi Umum' }}</small>
      </div>
      <div class="card-body p-5">
        <div class="mb-4">
          <i class="fas fa-ticket-alt text-primary" style="font-size: 4rem;"></i>
        </div>

        <h2 class="font-weight-bold mb-3">Masukkan Token Anda</h2>
        <p class="text-muted mb-4">Silakan masukkan 6 karakter kode token yang Anda terima dari petugas pendaftaran.</p>

        @if(session('error'))
        <div class="alert alert-danger animate__animated animate__shakeX">
          <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('voting-booth.validate') }}" method="POST">
          @csrf
          <input type="hidden" name="booth_id" value="{{ $booth->id }}">
          <div class="form-group mb-4">
            <input type="text" name="token"
              class="form-control form-control-lg text-center font-weight-bold"
              style="font-size: 2.5rem; letter-spacing: 0.5rem; height: 90px; text-transform: uppercase;"
              placeholder="______"
              maxlength="6"
              required
              autofocus
              autocomplete="off">
          </div>

          <button type="submit" class="btn btn-primary btn-block btn-lg py-3 font-weight-bold shadow-lg" style="border-radius: 12px; font-size: 1.25rem;">
            <i class="fas fa-sign-in-alt mr-2"></i> VERIFIKASI & MULAI VOTING
          </button>
        </form>
      </div>
    </div>

    <div class="mt-4 text-white">
      <div class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow spinner-grow-sm text-white mr-2" role="status"></div>
        <span class="small font-weight-bold text-uppercase" style="letter-spacing: 1px;">Sistem Siap Digunakan</span>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('input[name="token"]').on('input', function() {
      this.value = this.value.toUpperCase();
    });
  });
</script>
@endpush