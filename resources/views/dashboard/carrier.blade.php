@extends('layout.index')
@section('meta_desc' , 'Perjalanan Karir Smarteacher AI')
@section('title' , 'Perjalanan Karir Smarteacher AI')

@section('style_additional')


<style>
                   /* Sembunyikan radio button asli */
                   .card-input-element {
                       display: none;
                   }

                   /* Styling Card */
                   .custom-radio-card {
                       cursor: pointer;
                       border-radius: 1rem !important;
                       transition: all 0.3s ease;
                       border-color: #dee2e6 !important;
                   }

                   /* Lingkaran Radio Kustom */
                   .custom-radio-icon {
                       width: 28px;
                       height: 28px;
                       border: 2px solid #adb5bd;
                       border-radius: 50%;
                       margin-top: 15px;
                       position: relative;
                       transition: all 0.2s ease;
                   }

                   /* Efek saat Radio dipilih (Checked) */
                   .card-input-element:checked + .card-body .custom-radio-icon {
                       border: 8px solid #0d6efd; /* Warna biru sesuai gambar */
                   }

                   .card-input-element:checked ~ .card-body {
                       /* Opsional: tambah border pada card jika dipilih */
                   }

                   /* Hover effect */
                   .custom-radio-card:hover {
                       border-color: #0d6efd !important;
                   }
               </style>

               <style>
    /* Sembunyikan radio button asli */
    .custom-list-radio input[type="radio"] {
        display: none;
    }

    .custom-list-radio {
        cursor: pointer;
        display: block;
    }

    /* Card Styling */
    .custom-list-radio .card {
        border-radius: 0.8rem;
        border: 1.5px solid #dee2e6;
        transition: all 0.2s ease;
    }

    /* Lingkaran Radio Kustom */
    .custom-radio-circle {
        width: 24px;
        height: 24px;
        border: 2px solid #adb5bd;
        border-radius: 50%;
        position: relative;
        transition: all 0.2s ease;
    }

    /* State saat dipilih (Checked) */
    .custom-list-radio input[type="radio"]:checked + .card {
        border-color: #0d6efd;
        border-width: 1px;
    }

    .custom-list-radio input[type="radio"]:checked + .card .custom-radio-circle {
        border: 7px solid #0d6efd; /* Memberikan efek lingkaran biru tebal */
    }

    /* Hover Effect */
    .custom-list-radio:hover .card {
        background-color: #f8f9fa;
        border-color: #adb5bd;
    }
</style>

<style type="text/css">
  body {
    background-color: #f1f4f9;
  }

  .sidebar {
    background-color: white;
    border-radius: 12px;
    padding: 1rem;
    height: 100%;
  }

  .sidebar .nav-link {
    color: #000;
    font-weight: 500;
    border-left: 4px solid transparent;
    border-radius: 0;
    padding-left: 1rem;
    margin-bottom: 10px;
  }

  .sidebar .nav-link.active {
    border-left: 4px solid #0d3f85;
    background-color: transparent;
    font-weight: 600;
  }

  .content-card {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
  }

  .content-card img {
    max-width: 250px;
    margin-bottom: 1.5rem;
  }

  .btn-primary-custom {
    background-color: #0d3f85;
    border-color: #0d3f85;
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    color:white;
  }

  .btn-primary-custom:hover {
    background-color: #0b326b;
    border-color: #0b326b;
    color:white;
  }
  
  .custom-card {
    width: 100%;
    height: 350px;
  }

  .custom-card img {
    height: 180px;
    object-fit: cover;
  }

  .custom-card .card-body {
    padding: 1rem;
    overflow: hidden;
  }

  /* Carousel fix: pastikan tinggi tetap dan tidak lompat */
  .carousel-inner {
   /* min-height: 300px; */
  }

  .carousel-item {
    transition: transform 0.6s ease; /* smooth sliding */
  }

  @media (max-width: 768px) {
    .custom-card {
      height: auto;
    }
    .carousel-inner {
      min-height: unset;
    }
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

<div class="row">
  <div class="container">
    <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show" role="alert" style="background-color: blue !important;">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Bergabung Gratis Selama 1 bulan </strong> dan pelajari keahlian pengembangan diri, teknologi dan kreatif yang paling dibutuhkan 
    </div>
  </div>
</div>

<div class="row">
   <div class="col-sm-12">
      <!-- Profile -->
      <div class="card bg-default">
         <div class="card-body profile-user-box">
            <div class="row">
               <div class="col-sm-8">
                  <div class="row align-items-center">
                     <div class="col-auto">
                        <div class="avatar-lg" style="width: 80px; height: 80px;">
                           <img src="{{ $user->avatar ? asset($user->avatar) : asset('assets/images/users/avatar-1.jpg') }}" alt="" class="rounded-circle img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                     </div>
                     <div class="col">
                        <div>
                           <h4 class="mt-1 mb-1 text-black">Selamat datang kembali {{ $user->name }}</h4>
                           <p class="font-13 text-black-50">{{ $user->profesi ?? 'Belum diatur' }}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Tabs Utama -->
         <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
               <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                  <i class="mdi mdi-home-variant d-md-none d-block"></i>
                  <span class="d-none d-md-block">Pustaka Saya</span>
               </a>
            </li>
            <li class="nav-item">
               <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                  <i class="mdi mdi-account-circle d-md-none d-block"></i>
                  <span class="d-none d-md-block">Target Saya</span>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-xl-12 mx-auto">
      <div class="tab-content">
         <!-- Tab 1: Pustaka Saya -->
         <div class="tab-pane" id="home-b1">
            <div class="container-sm">
               <div class="row g-4">
                  <!-- Sidebar -->
                  <div class="col-md-3">
                     <div class="sidebar">
                        <nav class="nav flex-column">
                           <a class="nav-link active" href="#" data-target="proses">Dalam Proses</a>
                           <a class="nav-link" href="#" data-target="disimpan">Disimpan</a>
                           <a class="nav-link" href="#" data-target="riwayat">Riwayat Belajar</a>
                        </nav>
                     </div>
                  </div>

                  <!-- Konten -->
                  <div class="col-md-9">
                     <!-- Dalam Proses -->
                     <div class="content-card content-section" id="proses" style="display: block;">
                        @if($courses_in_progress->isEmpty())
                            <img src="{{ URL::asset('assets/images/vecteezy.png') }}" alt="Tidak ada kursus">
                            <h5><strong>Anda tidak memiliki kursus dalam progres.</strong></h5>
                            <p class="text-muted">Saat Anda memulai kursus, Anda dapat menemukannya di sini. Mulai tonton video yang Anda minati.</p>
                            <a href="{{ route('content') }}" class="btn btn-primary-custom">Tampilkan Kursus yang Direkomendasikan</a>
                        @else
                            <div class="row g-3">
                              @foreach($courses_in_progress as $cip)
                                @if($cip->course)
                                <div class="col-md-4">
                                  <div class="card h-100">
                                    <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $cip->course->image) }}"
                                         class="card-img-top img-fluid" alt="Kursus" style="object-fit: cover; height: 180px;">
                                    <div class="card-body p-2">
                                      <small class="text-muted d-block mb-1">KURSUS</small>
                                      <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => $cip->course->slug] ) }}?level=0"> {{ $cip->course->title }} </a> </h6>
                                      <small class="text-muted">Terakhir diakses: {{ $cip->updated_at->diffForHumans() }}</small>
                                    </div>
                                  </div>
                                </div>
                                @endif
                              @endforeach
                            </div>
                        @endif
                     </div>

                     <!-- Disimpan -->
                     <div class="content-card content-section" id="disimpan" style="display: none;">
                        @if(count($saved_courses) > 0)
                            <div class="row g-3">
                                @foreach($saved_courses as $save)
                                    <div class="col-md-3">
                                      <div class="card h-100">
                                        <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $save->course->image) }}"
                                             class="card-img-top img-fluid" alt="{{ $save->course->title }}" style="object-fit: cover; height: 180px;">
                                        <div class="card-body p-2">
                                          <small class="text-muted d-block mb-1">KURSUS</small>
                                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => $save->course->slug] ) }}?level=0"> {{ $save->course->title }} </a> </h6>
                                          <small class="text-muted">Disimpan pada: {{ $save->created_at->format('d M Y') }}</small>
                                        </div>
                                      </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <img src="{{ URL::asset('assets/images/vecteezy.png') }}" alt="Tidak ada kursus disimpan">
                            <h5><strong>Belum ada kursus yang disimpan.</strong></h5>
                            <p class="text-muted">Kursus yang Anda simpan akan muncul di sini untuk dipelajari nanti.</p>
                            <a href="{{ route('content') }}" class="btn btn-primary-custom">Lihat Semua Kursus</a>
                        @endif
                     </div>

                     <!-- Riwayat Belajar -->
                     <div class="content-card content-section" id="riwayat" style="display: none;">
                        
                        <!-- Header & Controls -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              
              <div class="d-flex gap-2">
                <button class="btn btn-outline-default rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px;"
                        data-bs-target="#cardCarousel" data-bs-slide="prev">
                  <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-outline-default rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px;"
                        data-bs-target="#cardCarousel" data-bs-slide="next">
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>
            </div>

            <!-- Carousel -->
            <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                  <div class="row g-3">
                    @foreach($course as $list_course)
                    <div class="col-md-4">
                      <div class="card h-100">
                        <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $list_course->course->image) }}"
                             class="card-img-top img-fluid" alt="Kursus 1" style="object-fit: cover; height: 180px;">
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS </small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => $list_course->course->slug] ) }}?level=0"> {{ $list_course->course->title }} </a> </h6>
                          <small class="text-muted">Oleh : Muliawati Shaerin</small>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    
                  </div>
                </div>

              </div>
            </div> 
            <!-- end carousel -->
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Tab 2: Target Saya -->
         <div class="tab-pane show active" id="profile-b1">
            <div class="container-sm">
                <div class="row g-4">
                    <!-- Card 1 -->
                    <div class="col-sm-6">
                        <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-1">Target karir</h5>
                                <p class="text-primary mb-4 fw-medium">{{ $user->target_karir ? ucwords(str_replace('_', ' ', $user->target_karir)) : 'Belum diatur' }}</p>
                                
                                <!-- Container Flex untuk Gambar + Teks -->
                                <div class="d-flex align-items-start">
                                    <img src="{{ asset('assets/images/bd41b799-2d90-4571-8385-993d2780c853.png') }}" style="width: 50px;" class="me-3">
                                    <div>
                                        <p class="text-muted mb-3" style="font-size: 0.95rem;">
                                            Dapatkan rekomendasi keahlian dan kursus khusus berdasarkan target Anda.
                                        </p>
                                        <button class="btn btn-sm text-white px-3" style="background-color: #0d3b82; border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#target_karir">
                                            Mulai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-sm-6">
                        <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-1">Tentukan Target Mingguan</h5>
                                <p class="text-primary mb-4 fw-medium">{{ $user->target_mingguan ? $user->target_mingguan . ' Menit' : 'Belum diatur' }}</p>
                                
                                <!-- Container Flex untuk Gambar + Teks -->
                                <div class="d-flex align-items-start">
                                    <img src="{{ asset('assets/images/8951aced-b86f-4bed-9dc6-12afe80993ce.png') }}" style="width: 50px;" class="me-3">
                                    <div>
                                        <p class="text-muted mb-3" style="font-size: 0.95rem;">
                                            Kami akan membantu melacak progres anda dan meningkatkan anda untuk terus belajar
                                        </p>
                                        <button class="btn btn-sm text-white px-3" style="background-color: #0d3b82; border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#target_mingguan">
                                            Tentukan target
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row Bawah -->
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-2" style="padding-bottom: 20px;">Mulai pelajari keahlian yang anda butuhkan untuk mencapai target akhir anda</h5>
                                <p class="text-muted mb-3" style="font-size: 0.95rem;">
                                    Kursus Smarteacher AI dipandu oleh ahli di bidangnya dan disesuaikan untuk pengembangan karir anda
                                </p>
                                <button class="btn btn-sm text-white px-3" style="background-color: #0d3b82; border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#modal_bulan_gratis">
                                    Mulai Bulan Gratis
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="target_karir" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('update_target_karir') }}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="container mt-5">
                   <h4 class="fw-bold mb-1">Target karir</h4>
                   <p class="text-muted mb-4">Apa target karier Anda dalam 6 hingga 12 bulan ke depan?</p>

                   <div class="row g-3">
                       <!-- Opsi 1 -->
                       <div class="col-md-4">
                           <label class="card h-100 shadow-sm border custom-radio-card">
                               <input type="radio" name="target_karir" value="Kembangkan_karir_saat_ini" class="card-input-element" {{ $user->target_karir == 'Kembangkan_karir_saat_ini' ? 'checked' : '' }} />
                               <div class="card-body text-center d-flex flex-column align-items-center">
                                   <div class="img-container mb-3">
                                       <img src="{{ asset('assets/images/7f0e825e-402f-45ac-8ab6-ca71c7bb3ce5.png') }}" alt="Pindah karir" class="img-fluid" style="height: 150px; background-color: #f8f9fa;">
                                   </div>
                                   <p class="card-text fw-medium px-3 flex-grow-1">Kembangkan karir saat ini</p>
                                   <div class="custom-radio-icon"></div>
                               </div>
                           </label>
                       </div>

                       <!-- Opsi 2 -->
                       <div class="col-md-4">
                           <label class="card h-100 shadow-sm border custom-radio-card">
                               <input type="radio" name="target_karir" value="Pindah_dan_transisi_ke_karir_baru" class="card-input-element" {{ $user->target_karir == 'Pindah_dan_transisi_ke_karir_baru' ? 'checked' : '' }} />
                               <div class="card-body text-center d-flex flex-column align-items-center">
                                   <div class="img-container mb-3">
                                       <img src="{{ asset('assets/images/e8485547-b529-48a3-861b-10b91a5cf72d.png') }}" alt="Pindah karir" class="img-fluid" style="height: 150px; background-color: #f8f9fa;">
                                   </div>
                                   <p class="card-text fw-medium px-3 flex-grow-1">Pindah dan transisi ke karir baru</p>
                                   <div class="custom-radio-icon"></div>
                               </div>
                           </label>
                       </div>

                       <!-- Opsi 3 -->
                       <div class="col-md-4">
                           <label class="card h-100 shadow-sm border custom-radio-card">
                               <input type="radio" name="target_karir" value="Kembangkan_keahlian_untuk_kelola_tim" class="card-input-element" {{ $user->target_karir == 'Kembangkan_keahlian_untuk_kelola_tim' ? 'checked' : '' }} />
                               <div class="card-body text-center d-flex flex-column align-items-center">
                                   <div class="img-container mb-3">
                                       <img src="{{ asset('assets/images/13641e86-8535-4289-93f4-0512b9fff824.png') }}" alt="Kelola tim" class="img-fluid" style="height: 150px; background-color: #f8f9fa;">
                                   </div>
                                   <p class="card-text fw-medium px-3 flex-grow-1">Kembangkan keahlian untuk kelola tim</p>
                                   <div class="custom-radio-icon"></div>
                               </div>
                           </label>
                       </div>
                   </div>
               </div>

               
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="target_mingguan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('update_target_mingguan') }}" method="POST">
            @csrf
            <div class="modal-body">

               <div class="container mt-1">
                   <h4 class="fw-bold mb-1">Tentukan target mingguan</h4>
                   <p class="text-muted mb-4">Kami akan membantu Anda melacak kemajuan dan mengingatkan Anda untuk terus belajar. Target bisa diubah kapan saja.</p>

                   <div class="d-flex flex-column">
                       <!-- Opsi 1 -->
                       <label class="custom-list-radio">
                           <input type="radio" name="target_waktu" value="15" {{ $user->target_mingguan == 15 ? 'checked' : '' }}>
                           <div class="card card-body d-flex flex-row align-items-center mb-2">
                               <div class="custom-radio-circle me-3"></div>
                               <div class="flex-grow-1">
                                   <span class="fw-medium">15 Menit</span>
                               </div>
                               <div class="text-muted small">Baru memulai</div>
                           </div>
                       </label>

                       <!-- Opsi 2 (Rekomendasi) -->
                       <label class="custom-list-radio">
                           <input type="radio" name="target_waktu" value="30" {{ $user->target_mingguan == 30 ? 'checked' : '' }}>
                           <div class="card card-body d-flex flex-row align-items-center mb-2">
                               <div class="custom-radio-circle me-3"></div>
                               <div class="flex-grow-1 d-flex align-items-center">
                                   <span class="fw-medium me-3">30 Menit</span>
                                   <span class="badge rounded-pill px-3 py-2" style="background-color: #6c757d; font-weight: normal; font-size: 0.75rem;">Rekomendasi</span>
                               </div>
                               <div class="text-muted small">Belajar dengan santai</div>
                           </div>
                       </label>

                       <!-- Opsi 3 -->
                       <label class="custom-list-radio">
                           <input type="radio" name="target_waktu" value="60" {{ $user->target_mingguan == 60 ? 'checked' : '' }}>
                           <div class="card card-body d-flex flex-row align-items-center mb-2">
                               <div class="custom-radio-circle me-3"></div>
                               <div class="flex-grow-1">
                                   <span class="fw-medium">60 Menit</span>
                               </div>
                               <div class="text-muted small">Menjadi Ahli</div>
                           </div>
                       </label>

                       <!-- Opsi 4 -->
                       <label class="custom-list-radio">
                           <input type="radio" name="target_waktu" value="120" {{ $user->target_mingguan == 120 ? 'checked' : '' }}>
                           <div class="card card-body d-flex flex-row align-items-center mb-2">
                               <div class="custom-radio-circle me-3"></div>
                               <div class="flex-grow-1">
                                   <span class="fw-medium">120 Menit</span>
                               </div>
                               <div class="text-muted small">Kuasai keahlian Anda</div>
                           </div>
                       </label>
                   </div>
               </div>


               
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Bulan Gratis -->
<div id="modal_bulan_gratis" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalBulanGratisLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius: 1rem; overflow: hidden; border: none;">
            <div class="modal-body p-5">
                <div class="mb-4">
                    <!-- Icon or Image Placeholder for "Bulan Gratis" -->
                    <i class="bi bi-gift-fill text-warning" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Selamat!</h4>
                <p class="text-muted mb-4" style="font-size: 1.1rem;">
                    Selamat, Anda mendapatkan akses semua pelatihan selama 1 bulan gratis.
                </p>
                <button type="button" class="btn btn-primary px-5 py-2" data-bs-dismiss="modal" style="border-radius: 0.5rem; font-weight: 600;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')

<!-- Script untuk sidebar (tab di dalam tab) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const tabContainer = document.querySelector('#home-b1'); // hanya aktif di tab "Pustaka Saya"
  if (!tabContainer) return;

  const navLinks = tabContainer.querySelectorAll(".nav-link");
  const sections = tabContainer.querySelectorAll(".content-section");

  navLinks.forEach(link => {
    link.addEventListener("click", function(e) {
      e.preventDefault();

      // Hapus semua active
      navLinks.forEach(l => l.classList.remove("active"));
      sections.forEach(section => section.style.display = "none");

      // Aktifkan link dan section yang dipilih
      this.classList.add("active");
      const targetId = this.getAttribute("data-target");
      const target = tabContainer.querySelector("#" + targetId);
      if (target) target.style.display = "block";
    });
  });
});
</script>


@stop
