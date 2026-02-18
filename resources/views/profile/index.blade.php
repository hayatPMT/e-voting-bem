@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.voting')

@section('title', 'Profile Saya')

@if(auth()->user()->isAdmin())
@section('breadcrumb_title', 'Profile Saya')
@section('breadcrumb')
<li class="breadcrumb-item active">Profile</li>
@endsection
@endif

@section('content')
<div class="container-fluid" style="max-width: 1200px; padding: 2rem;">
    <!-- Success/Error Messages -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #ef4444;">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <!-- Profile Header -->
                <div class="card-header border-0 text-center py-4" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $profile && $profile->avatar ? asset('storage/' . $profile->avatar) : asset('images/default-avatar.png') }}"
                            alt="Avatar"
                            class="rounded-circle border border-white"
                            style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important; box-shadow: 0 4px 16px rgba(0,0,0,0.2);">
                        <button type="button"
                            class="btn btn-sm btn-light rounded-circle position-absolute"
                            data-toggle="modal"
                            data-target="#avatarModal"
                            style="bottom: 5px; right: 5px; width: 36px; height: 36px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h4 class="text-white mt-3 mb-1 font-weight-bold">{{ $user->name }}</h4>
                    <p class="text-white mb-0" style="opacity: 0.9;">
                        <i class="fas fa-{{ $user->isAdmin() ? 'user-shield' : 'user-graduate' }} mr-1"></i>
                        {{ $user->isAdmin() ? 'Administrator' : 'Mahasiswa' }}
                    </p>
                </div>

                <!-- Profile Info -->
                <div class="card-body p-4">
                    @if($profile)
                    @if($user->isMahasiswa())
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">NIM</small>
                        <strong>{{ $profile->nim ?? '-' }}</strong>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Program Studi</small>
                        <strong>{{ $profile->program_studi ?? '-' }}</strong>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Angkatan</small>
                        <strong>{{ $profile->angkatan ?? '-' }}</strong>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Semester</small>
                        <strong>{{ $profile->semester ?? '-' }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Status Voting</small>
                        <span class="badge badge-{{ $user->vote ? 'success' : 'warning' }} px-3 py-2">
                            <i class="fas fa-{{ $user->vote ? 'check-circle' : 'clock' }} mr-1"></i>
                            {{ $user->vote ? 'Sudah Memilih' : 'Belum Memilih' }}
                        </span>

                        @if($user->vote)
                        <div class="mt-3">
                            <a href="{{ route('voting.receipt.download') }}"
                                class="btn btn-block btn-sm shadow-sm"
                                style="background: linear-gradient(135deg, #10b981, #059669); 
                                                  color: white; 
                                                  border: none; 
                                                  border-radius: 10px; 
                                                  padding: 0.75rem;
                                                  font-weight: 600;
                                                  transition: all 0.3s ease;">
                                <i class="fas fa-file-pdf mr-2"></i>Download Bukti Voting
                            </a>
                            <small class="text-muted d-block mt-2 text-center" style="font-size: 0.75rem;">
                                <i class="fas fa-info-circle mr-1"></i>Simpan sebagai bukti sah pemilihan
                            </small>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-1">Departemen</small>
                        <strong>{{ $profile->department ?? '-' }}</strong>
                    </div>
                    @if($profile->bio)
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Bio</small>
                        <p class="mb-0">{{ $profile->bio }}</p>
                    </div>
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Forms -->
        <div class="col-md-8">
            <!-- Edit Profile Form -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-header border-0 bg-white py-3">
                    <h5 class="mb-0 font-weight-bold" style="color: #1f2937;">
                        <i class="fas fa-user-edit mr-2" style="color: #667eea;"></i>Edit Informasi Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required style="border-radius: 10px;">
                            </div>
                        </div>

                        @if($user->isMahasiswa())
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control" value="{{ old('nim', $profile->nim ?? '') }}" required style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Program Studi</label>
                                <input type="text" name="program_studi" class="form-control" value="{{ old('program_studi', $profile->program_studi ?? '') }}" style="border-radius: 10px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Angkatan</label>
                                <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan', $profile->angkatan ?? '') }}" placeholder="2024" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-600">Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ old('semester', $profile->semester ?? '') }}" min="1" max="14" style="border-radius: 10px;">
                            </div>
                        </div>
                        @else
                        <div class="mb-3">
                            <label class="font-weight-600">Departemen</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $profile->department ?? '') }}" style="border-radius: 10px;">
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-600">Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? '') }}" style="border-radius: 10px;">
                            </div>
                        </div>



                        <div class="text-right">
                            <button type="submit" class="btn px-4 py-2" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 10px; font-weight: 600;">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header border-0 bg-white py-3">
                    <h5 class="mb-0 font-weight-bold" style="color: #1f2937;">
                        <i class="fas fa-lock mr-2" style="color: #f59e0b;"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="font-weight-600">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control" required style="border-radius: 10px;">
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-600">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required style="border-radius: 10px;">
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-600">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required style="border-radius: 10px;">
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-warning px-4 py-2" style="border-radius: 10px; font-weight: 600;">
                                <i class="fas fa-key mr-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-camera mr-2"></i>Upload Foto Profile
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <img id="preview"
                            src="{{ $profile && $profile->avatar ? asset('storage/' . $profile->avatar) : asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-3 border"
                            style="width: 150px; height: 150px; object-fit: cover; border-width: 3px !important;">
                    </div>
                    <div class="custom-file">
                        <input type="file" name="avatar" class="custom-file-input" id="avatarInput" accept="image/*" required>
                        <label class="custom-file-label" for="avatarInput">Pilih foto...</label>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG. Maksimal 2MB.
                    </small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Update file label
            const fileName = file.name;
            document.querySelector('.custom-file-label').textContent = fileName;
        }
    });
</script>

<style>
    .font-weight-600 {
        font-weight: 600;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endsection