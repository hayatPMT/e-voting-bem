@extends('layouts.superadmin')

@section('title', 'Detail Kampus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('superadmin.kampus.index') }}">Kampus</a></li>
    <li class="breadcrumb-item active">{{ $kampus->kode }}</li>
@endsection

@section('content')
    <div class="row">
        <!-- Profil Kampus -->
        <div class="col-md-4">
            <div class="card card-widget widget-user-2 shadow-sm" style="border-radius:16px;">
                <div class="widget-user-header text-white"
                    style="background:linear-gradient(135deg,{{ $kampus->primary_color }},{{ $kampus->secondary_color }}); border-radius:16px 16px 0 0;">
                    <div class="widget-user-image">
                        @if ($kampus->logo)
                            <img class="img-circle elevation-2" src="{{ asset('storage/' . $kampus->logo) }}"
                                alt="Logo Kampus" style="background:#fff; object-fit:cover;">
                        @else
                            <div class="img-circle elevation-2 d-flex justify-content-center align-items-center"
                                style="width:65px; height:65px; background:#fff; float:left;">
                                <i class="fas fa-university text-dark fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="widget-user-username font-weight-bold" style="font-size:1.2rem; margin-top:8px;">
                        {{ $kampus->nama }}</h3>
                    <h5 class="widget-user-desc" style="font-size:0.9rem;"><code>{{ $kampus->kode }}</code></h5>
                </div>
                <div class="card-footer p-0" style="border-radius:0 0 16px 16px; overflow:hidden;">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                <i class="fas fa-map-marker-alt text-danger mr-2"></i> {{ $kampus->alamat ?? '-' }},
                                {{ $kampus->kota ?? '-' }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                Status <span
                                    class="float-right badge {{ $kampus->is_active ? 'badge-success' : 'badge-danger' }}">{{ $kampus->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                Total Suara <span
                                    class="float-right badge badge-primary">{{ number_format($totalVotes) }}</span>
                            </span>
                        </li>
                    </ul>

                    <div class="p-3">
                        <form action="{{ route('superadmin.kampus.monitor', $kampus) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius:12px;">
                                <i class="fas fa-desktop mr-2"></i> Monitor Panel Admin
                            </button>
                        </form>
                        <a href="{{ route('superadmin.kampus.edit', $kampus) }}"
                            class="btn btn-outline-info btn-block mt-2" style="border-radius:12px;">
                            <i class="fas fa-edit mr-2"></i> Edit Data Kampus
                        </a>
                    </div>
                </div>
            </div>

            {{-- Portal URL Card --}}
            <div class="card mt-3" style="border-radius:16px; border:2px solid #e2e8f0; overflow:hidden;">
                <div class="card-header border-0"
                    style="background:linear-gradient(135deg,{{ $kampus->primary_color }},{{ $kampus->secondary_color }});">
                    <h3 class="card-title text-white font-weight-bold">
                        <i class="fas fa-link mr-2"></i> Link Portal Kampus
                    </h3>
                </div>
                <div class="card-body">
                    @if ($kampus->slug)
                        <p class="text-muted small mb-2">
                            Bagikan link berikut kepada mahasiswa dan admin kampus <strong>{{ $kampus->nama }}</strong>:
                        </p>

                        {{-- Portal Voting --}}
                        <div class="mb-3">
                            <div class="text-xs text-muted font-weight-bold mb-1">
                                <i class="fas fa-vote-yea mr-1" style="color:{{ $kampus->primary_color }};"></i>
                                Portal Utama (Mahasiswa)
                            </div>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="portal-url"
                                    value="{{ route('campus.portal', $kampus->slug) }}" readonly
                                    style="background:#f8fafc; font-size:0.85rem;">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                        onclick="copyText('portal-url', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Admin Login --}}
                        <div>
                            <div class="text-xs text-muted font-weight-bold mb-1">
                                <i class="fas fa-user-shield mr-1" style="color:{{ $kampus->primary_color }};"></i>
                                Login Admin Kampus
                            </div>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="admin-login-url"
                                    value="{{ route('campus.login', $kampus->slug) }}" readonly
                                    style="background:#f8fafc; font-size:0.85rem;">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                        onclick="copyText('admin-login-url', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0 p-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Slug belum digenerate. Edit dan simpan kampus ini untuk men-generate link portal.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admins List -->
            <div class="card mt-3">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-user-shield text-info mr-2"></i> Admin Kampus
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($kampus->admins as $admin)
                            <li class="item" style="border-bottom:1px solid #edf2f7; padding:10px;">
                                <div class="product-info ml-2">
                                    <span class="product-title text-dark font-weight-bold">{{ $admin->name }}</span>
                                    <span
                                        class="badge {{ $admin->is_active ? 'badge-success' : 'badge-danger' }} float-right"
                                        style="font-size:0.7rem;">
                                        {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                    <span class="product-description" style="font-size:0.8rem; color:#718096;">
                                        <i class="fas fa-envelope mr-1"></i> {{ $admin->email }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item p-3 text-center text-muted">Belum ada admin didaftarkan.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('superadmin.admins.create') }}?kampus_id={{ $kampus->id }}"
                        class="uppercase text-sm">Tambah Admin</a>
                </div>
            </div>
        </div>

        <!-- Data Overview Kampus -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Informasi
                                E-Voting</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kandidat" data-toggle="tab">Kandidat
                                ({{ $kampus->kandidats->count() }})</a></li>
                        <li class="nav-item"><a class="nav-link" href="#booth" data-toggle="tab">Bilik Suara
                                ({{ $kampus->votingBooths->count() }})</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Tab Informasi -->
                        <div class="tab-pane active" id="info">
                            <h6 class="font-weight-bold mb-3 border-bottom pb-2">Pengaturan E-Voting Aktif</h6>
                            @if ($kampus->settings->count() > 0)
                                @php $setting = $kampus->settings->first(); @endphp
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <div class="text-muted small">Nama Pemilihan</div>
                                        <div class="font-weight-bold">{{ $setting->election_name }}</div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="text-muted small">Waktu Mulai</div>
                                        <div class="font-weight-bold text-success">
                                            {{ $setting->voting_start?->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="text-muted small">Waktu Selesai</div>
                                        <div class="font-weight-bold text-danger">
                                            {{ $setting->voting_end?->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">Pengaturan e-voting belum dikonfigurasi untuk kampus
                                    ini.</div>
                            @endif

                            <h6 class="font-weight-bold mb-3 mt-4 border-bottom pb-2">Tahapan Pemilihan</h6>
                            @if ($kampus->tahapan->count() > 0)
                                <div class="timeline mt-3">
                                    @foreach ($kampus->tahapan()->orderBy('waktu_mulai')->get() as $t)
                                        <div>
                                            <i
                                                class="fas {{ $t->is_current ? 'fa-hourglass-half bg-primary' : 'fa-check bg-success' }}"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i>
                                                    {{ $t->waktu_mulai?->format('d M') }} -
                                                    {{ $t->waktu_selesai?->format('d M') }}</span>
                                                <h3
                                                    class="timeline-header font-weight-bold {{ $t->is_current ? 'text-primary' : '' }}">
                                                    {{ $t->nama_tahapan }}</h3>
                                                <div class="timeline-body p-2" style="font-size:0.9rem;">
                                                    {{ $t->deskripsi }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">Belum ada tahapan yang dikonfigurasi.</p>
                            @endif
                        </div>

                        <!-- Tab Kandidat -->
                        <div class="tab-pane" id="kandidat">
                            <div class="row">
                                @forelse($kandidats as $kandidat)
                                    <div class="col-sm-6">
                                        <div class="alert"
                                            style="background:#f8f9fa; border:1px solid #edf2f7; color:#2d3748;">
                                            <div class="d-flex align-items-center mb-2">
                                                @if ($kandidat->foto)
                                                    <img src="{{ asset('storage/' . $kandidat->foto) }}"
                                                        class="img-circle"
                                                        style="width:50px;height:50px;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 5px rgba(0,0,0,0.1);"
                                                        alt="Foto">
                                                @else
                                                    <div class="img-circle d-flex align-items-center justify-content-center"
                                                        style="width:50px;height:50px;background:#e2e8f0;color:#718096;border:2px solid #fff;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                                <div class="ml-3">
                                                    <h6 class="font-weight-bold mb-0">{{ $kandidat->nama }}</h6>
                                                    <div class="text-muted" style="font-size:0.8rem;">
                                                        Perolehan: <strong
                                                            class="text-success">{{ number_format(($kandidat->votes_count ?? 0) + ($kandidat->total_votes ?? 0)) }}
                                                            Suara</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 py-4 text-center text-muted">Belum ada kandidat terdaftar di kampus
                                        ini.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tab Bilik Suara -->
                        <div class="tab-pane" id="booth">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Bilik</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kampus->votingBooths as $booth)
                                        <tr>
                                            <td class="font-weight-bold">{{ $booth->nama_booth }}</td>
                                            <td>{{ $booth->lokasi ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $booth->is_active ? 'badge-success' : 'badge-danger' }}">{{ $booth->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">Belum ada bilik suara
                                                terdaftar di kampus ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between text-muted" style="font-size:0.8rem;">
                    <span>Didaftarkan: {{ $kampus->created_at->format('d/m/Y H:i') }}</span>
                    <span>Terakhir Diupdate: {{ $kampus->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyText(inputId, btn) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            const icon = btn.querySelector('i');
            icon.className = 'fas fa-check text-success';
            setTimeout(() => {
                icon.className = 'fas fa-copy';
            }, 2000);
        }
    </script>
@endpush
