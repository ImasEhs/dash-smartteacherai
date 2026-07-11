@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Dashboard')

@section('style_additional')

<style>
        .sidebar {
            background-color: #eaf5ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 20px;
        }

        .profile-img-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto 20px;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
        }

        .camera-icon {
            position: absolute;
            bottom: 10px;
            right: 5px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
            cursor: pointer;
        }

        .main-content {
            background-color: white;
            padding: 40px 60px;
            min-height: 100vh;
        }

        .section-title {
            font-weight: 700;
            color: #4a5568;
            font-size: 0.9rem;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-top: 8px;
        }

        .required-star {
            color: #e53e3e;
        }

        .form-control, .form-select {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .btn-simpan {
            background-color: #10407d;
            color: white;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
        }

        .btn-simpan:hover {
            background-color: #0a2d5a;
            color: white;
        }

        .registration-date {
            font-size: 0.85rem;
            color: #718096;
            text-align: center;
            border-top: 1px solid #d1e3f5;
            padding-top: 20px;
        }
    </style>

@stop

@section('content')

<div class="row">
   <div class="col-12">
      <div class="page-title-box">
         <div class="page-title-right">
            
         </div>
      </div>
   </div>
</div>

<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <div class="text-center">
                    <div class="profile-img-container">
                        <img src="{{ $user->avatar ? asset($user->avatar) : asset('assets/images/users/avatar-1.jpg') }}" alt="Profile" class="profile-img" id="profile-preview">
                        <div class="camera-icon" onclick="document.getElementById('avatar-input').click()">
                            <i class="bi bi-camera-fill"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                </div>

                <div class="registration-date">
                    Tanggal registrasi {{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <div class="main-content">
                <form action="{{ route('submit_profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar" id="avatar-input" class="d-none" onchange="previewImage(event)">
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- INFORMASI PERSONAL -->
                    <div class="mb-5">
                        <h6 class="section-title text-uppercase">Informasi Personal</h6>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Nama<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">No. HP<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="phone_number" value="{{ $user->phone_number }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- PROFIL PROFESIONAL/PENDIDIKAN -->
                    <div class="mb-5">
                        <h6 class="section-title text-uppercase">Profil Profesional/Pendidikan</h6>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Profesi<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="profesi" required>
                                    <option value="" disabled {{ empty($user->profesi) ? 'selected' : '' }}>Pilih Profesi</option>
                                    <option value="Guru" {{ $user->profesi == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Dosen" {{ $user->profesi == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="Mahasiswa" {{ $user->profesi == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Bidang<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="bidang" required>
                                    <option value="" disabled {{ empty($user->bidang) ? 'selected' : '' }}>Pilih Bidang</option>
                                    <option value="Pendidikan" {{ $user->bidang == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Teknologi" {{ $user->bidang == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                    <option value="Kesehatan" {{ $user->bidang == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Institusi<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="institusi" value="{{ $user->institusi }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Tingkat Pendidikan<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="tingkat_pendidikan" required>
                                    <option value="" disabled {{ empty($user->tingkat_pendidikan) ? 'selected' : '' }}>Pilih Tingkat Pendidikan</option>
                                    <option value="S1" {{ $user->tingkat_pendidikan == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ $user->tingkat_pendidikan == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="SMA/SMK" {{ $user->tingkat_pendidikan == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- TUJUAN TARGET BELAJAR -->
                    <div class="mb-5">
                        <h6 class="section-title text-uppercase">Tujuan Target Belajar</h6>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Target Karir<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="target_karir" required>
                                    <option value="" disabled {{ empty($user->target_karir) ? 'selected' : '' }}>Pilih Target Karir</option>
                                    <option value="Kembangkan karir saat ini" {{ $user->target_karir == 'Kembangkan karir saat ini' ? 'selected' : '' }}>Kembangkan karir saat ini</option>
                                    <option value="Pindah dan transisi ke karir baru" {{ $user->target_karir == 'Pindah dan transisi ke karir baru' ? 'selected' : '' }}>Pindah dan transisi ke karir baru</option>
                                    <option value="Kembangkan keahlian untuk kelola tim" {{ $user->target_karir == 'Kembangkan keahlian untuk kelola tim' ? 'selected' : '' }}>Kembangkan keahlian untuk kelola tim</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 form-label">Minat Pembelajaran<span class="required-star">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="minat_pembelajaran" value="{{ $user->minat_pembelajaran }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Button Simpan -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('js')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profile-preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@stop