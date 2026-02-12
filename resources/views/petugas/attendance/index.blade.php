@extends('layouts.petugas')

@section('content')
<div class="row mb-3">
 <div class="col-md-6">
  @if($activeBoothId)
  @php $currentBooth = $votingBooths->firstWhere('id', (int)$activeBoothId); @endphp
  <div class="alert alert-info py-2 mb-0">
   <i class="fas fa-desktop mr-2"></i> Bilik Aktif: <strong>{{ $currentBooth->nama_booth ?? 'Unknown' }}</strong>
  </div>
  @else
  <div class="alert alert-warning py-2 mb-0">
   <i class="fas fa-exclamation-triangle mr-2"></i> Bilik belum diatur.
  </div>
  @endif
 </div>
 <div class="col-md-6 text-right">
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#boothSetupModal">
   <i class="fas fa-desktop"></i> Setup Bilik Suara
  </button>
 </div>
</div>

<div class="row">
 <div class="col-md-6">
  <!-- Search Card -->
  <div class="card card-primary shadow-sm">
   <div class="card-header">
    <h3 class="card-title">Cari Mahasiswa</h3>
   </div>
   <div class="card-body">
    <div class="form-group">
     <label for="nim_search">Masukkan NIM</label>
     <div class="input-group">
      <input type="text" class="form-control form-control-lg" id="nim_search" placeholder="Contoh: 12345678" autofocus>
      <div class="input-group-append">
       <button class="btn btn-primary" type="button" id="btn_search">
        <i class="fas fa-search"></i> Cari
       </button>
      </div>
     </div>
    </div>
    <div id="search_result" class="d-none animate__animated animate__fadeIn">
     <hr>
     <h5>Hasil Pencarian:</h5>
     <div class="alert alert-light border shadow-sm">
      <h4 id="mhs_name" class="font-weight-bold text-primary mb-1"></h4>
      <p id="mhs_nim" class="mb-1 text-muted"></p>
      <p id="mhs_prodi" class="mb-0 text-muted"></p>
     </div>

     <form action="{{ route('petugas.attendance.approve') }}" method="POST">
      @csrf
      <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">

      <button type="submit" class="btn btn-success btn-block btn-lg shadow">
       <i class="fas fa-check-circle mr-2"></i> APPROVE & TERBITKAN TOKEN
      </button>
     </form>
    </div>

    @if(session('generated_token'))
    <style>
     @media print {
      body * {
       visibility: hidden;
      }

      #token_card_print,
      #token_card_print * {
       visibility: visible;
      }

      #token_card_print {
       position: absolute;
       left: 0;
       top: 0;
       width: 100%;
       border: 2px solid #000 !important;
       padding: 40px !important;
       text-align: center;
      }

      .btn-print-hide {
       display: none !important;
      }
     }

     .token-box {
      background: #f8fafc;
      border: 2px dashed #cbd5e1;
      border-radius: 12px;
      padding: 20px;
      position: relative;
     }

     .token-code {
      font-size: 3.5rem;
      font-weight: 800;
      letter-spacing: 12px;
      color: #1e293b;
      text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.05);
     }
    </style>
    <div id="token_display" class="mt-4 animate__animated animate__bounceIn">
     <hr>
     <div id="token_card_print" class="card border-success shadow-sm">
      <div class="card-body text-center py-4">
       <h6 class="text-uppercase font-weight-bold text-success mb-3"><i class="fas fa-ticket-alt mr-2"></i>TOKEN VOTING BERHASIL DITERBITKAN</h6>
       <div class="token-box mb-3">
        <div class="token-code">{{ session('generated_token') }}</div>
       </div>
       <p class="mb-3 text-muted">Berikan 6 digit kode unik di atas kepada mahasiswa.<br>Kode ini dapat digunakan di bilik suara mana saja.</p>
       <div class="btn-group">
        <button onclick="window.print()" class="btn btn-dark btn-print-hide">
         <i class="fas fa-print mr-1"></i> Cetak Token
        </button>
        <button onclick="document.getElementById('token_display').classList.add('d-none')" class="btn btn-outline-secondary btn-print-hide">
         Tutup
        </button>
       </div>
      </div>
     </div>
    </div>
    @endif

    <div id="search_error" class="alert alert-danger d-none mt-3 animate__animated animate__shakeX"></div>
   </div>
  </div>
 </div>

 <div class="col-md-6">
  <!-- Today's Attendance List -->
  <div class="card card-outline card-success shadow-sm">
   <div class="card-header">
    <h3 class="card-title">Daftar Hadir Hari Ini</h3>
    <div class="card-tools">
     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
   </div>
   <div class="card-body p-0 table-responsive" style="max-height: 500px;">
    <table class="table table-striped table-hover text-nowrap">
     <thead class="bg-light">
      <tr>
       <th>Waktu</th>
       <th>NIM</th>
       <th>Nama</th>
       <th>Token</th>
       <th>Status</th>
      </tr>
     </thead>
     <tbody>
      @forelse($attendances as $attendance)
      <tr>
       <td><small class="text-muted">{{ $attendance->created_at->format('H:i') }}</small></td>
       <td>{{ $attendance->mahasiswa->mahasiswaProfile->nim ?? '-' }}</td>
       <td><strong>{{ Str::limit($attendance->mahasiswa->name, 20) }}</strong></td>
       <td><code class="font-weight-bold text-primary">{{ $attendance->session_token ?? '-' }}</code></td>
       <td>
        @if($attendance->status == 'approved')
        <span class="badge badge-warning text-dark"><i class="fas fa-clock mr-1"></i> Waiting Vote</span>
        @elseif($attendance->status == 'voted')
        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
        @else
        <span class="badge badge-secondary">{{ $attendance->status }}</span>
        @endif
       </td>
      </tr>
      @empty
      <tr>
       <td colspan="5" class="text-center py-4 text-muted">
        <i class="fas fa-clipboard-list fa-3x mb-3 d-block opacity-20"></i>
        Belum ada data hadir hari ini.
       </td>
      </tr>
      @endforelse
     </tbody>
    </table>
   </div>
  </div>
 </div>
</div>


<!-- Booth Setup Modal -->
<div class="modal fade" id="boothSetupModal" tabindex="-1" aria-labelledby="boothSetupModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
   <div class="modal-header bg-info text-white" style="border-radius: 15px 15px 0 0;">
    <h5 class="modal-title font-weight-bold" id="boothSetupModalLabel"><i class="fas fa-cog mr-2"></i> Konfigurasi Bilik Suara</h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <form action="{{ route('petugas.attendance.setBooth') }}" method="POST" class="mb-4 bg-light p-3 rounded shadow-sm border">
     @csrf
     <label class="font-weight-bold mb-2">Pilih Bilik Suara Anda:</label>
     <div class="input-group">
      <select name="voting_booth_id" class="form-control" required>
       <option value="">-- Pilih Bilik --</option>
       @foreach($votingBooths as $booth)
       <option value="{{ $booth->id }}" {{ (int)$activeBoothId == $booth->id ? 'selected' : '' }}>
        {{ $booth->nama_booth }}
       </option>
       @endforeach
      </select>
      <div class="input-group-append">
       <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
     </div>
     <small class="text-muted mt-2 d-block">Bilik yang dipilih akan menjadi pilihan otomatis saat anda melakukan approval.</small>
    </form>

    <div class="divider text-center mb-3">
     <span class="bg-white px-2 text-muted small font-weight-bold">LINK DISPLAY MONITORING</span>
    </div>

    <div class="list-group">
     @foreach($votingBooths as $booth)
     <a href="{{ route('voting-booth.standby', $booth->id) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-left-info">
      <div>
       <strong class="text-dark">{{ $booth->nama_booth }}</strong>
       <br>
       <small class="text-muted">{{ $booth->lokasi ?? 'Lokasi Umum' }}</small>
      </div>
      <span class="btn btn-sm btn-outline-info rounded-pill"><i class="fas fa-external-link-alt mr-1"></i> Buka</span>
     </a>
     @endforeach
    </div>
   </div>
   <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Tutup</button>
   </div>
  </div>
 </div>
</div>

@if(session('success'))
<script>
 setTimeout(() => {
  Swal.fire({
   icon: 'success',
   title: 'Berhasil',
   text: "{{ session('success') }}",
   timer: 3000,
   showConfirmButton: false
  });
 }, 100);
</script>
@endif

@if(session('error'))
<script>
 setTimeout(() => {
  Swal.fire({
   icon: 'error',
   title: 'Gagal',
   text: "{{ session('error') }}",
  });
 }, 100);
</script>
@endif

@endsection

@push('scripts')
<script>
 $(document).ready(function() {
  $('#btn_search').click(function() {
   performSearch();
  });

  $('#nim_search').keypress(function(e) {
   if (e.which == 13) {
    performSearch();
   }
  });

  function performSearch() {
   var nim = $('#nim_search').val();
   if (!nim) return;

   $('#search_result').addClass('d-none');
   $('#search_error').addClass('d-none');
   $('#btn_search').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

   $.ajax({
    url: "{{ route('petugas.attendance.search') }}",
    method: "POST",
    data: {
     _token: "{{ csrf_token() }}",
     nim: nim
    },
    success: function(response) {
     if (response.success) {
      var mhs = response.mahasiswa;
      $('#mhs_name').text(mhs.name);
      $('#mhs_nim').text(mhs.nim);
      $('#mhs_prodi').text(mhs.prodi);
      $('#mahasiswa_id').val(mhs.id);

      $('#search_result').removeClass('d-none');
     }
    },
    error: function(xhr) {
     var msg = 'Terjadi kesalahan';
     if (xhr.responseJSON && xhr.responseJSON.message) {
      msg = xhr.responseJSON.message;
     }
     $('#search_error').text(msg).removeClass('d-none');
    },
    complete: function() {
     $('#btn_search').prop('disabled', false).html('<i class="fas fa-search"></i> Cari');
    }
   });
  }
 });
</script>
@endpush