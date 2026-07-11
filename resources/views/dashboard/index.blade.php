      @extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Dashboard')

@section('style_additional')
<style>
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

<style>
    .modal-content {
      border-radius: 12px;
      text-align: center;
      padding: 20px;
    }

    .hero-img {
      max-width: 180px;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #1e3a8a;
      border: none;
      padding: 10px 24px;
      border-radius: 8px;
    }

    .btn-primary:hover {
      background-color: #162d6b;
    }

    .modal-text {
      color: #555;
      max-width: 420px;
      margin: 0 auto 20px;
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
   <div class="col-xl-12 col-lg-12">
      <!--end card-->
      <div class="card cta-box overflow-hidden">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div>
                  <h2>Hai {{ $user->name }}, kembangkan keahlian Anda dan tingkatkan karier Anda dengan <strong>SMARTTEACHERAI</strong></h2>
                  <br>
                  <div class="multi-user">
                    <a href="javascript:void(0);" class="d-inline-block">
                      <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="friend">
                    </a>
                    <a href="javascript:void(0);" class="d-inline-block">
                      <img src="assets/images/users/avatar-5.jpg" class="rounded-circle avatar-xs" alt="friend">
                    </a>
                    Banyak pengguna sudah bergabung dengan SMARTTEACHER AI
                  </div>
                  <div class="flex-grow-1 ms-2"></div>
               </div>
               <img class="ms-3" src="{{ URL::asset('assets/images/dashboard_ai.png') }}" alt="Generic placeholder image" style="width: 30%;">
            </div>
         </div>
         <!-- end card-body -->
      </div>
   </div>
   
</div>

<div class="container-sm">
  <div class="row g-4">
    <div class="col-xl-12 col-lg-12 mx-auto">
      <div class="card cta-box overflow-hidden" style="border-radius: 0.5rem;">
        <div class="card-body">
          <div class="container position-relative">
            <!-- Header & Controls -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Pilihan terbaik untuk {{ $user->name }}</h5>
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
                    <div class="col-md-3">
                      <div class="card h-100">
                        <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $list_course->image) }}"
                             class="card-img-top img-fluid" alt="Kursus 1" style="object-fit: cover; height: 180px;">
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS </small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => $list_course->slug] ) }}?level=0"> {{ $list_course->title }} </a> </h6>
                          <small class="text-muted">Oleh: Tuti Alawiyah M Pd</small>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    {{-- <div class="col-md-3">
                      <div class="card h-100">
                        <img src="{{ URL::asset('assets/images/5-Contoh-E-Learning-Berbasis-Web-Terbaik-Tahun-2024.png') }}"
                             class="card-img-top img-fluid" alt="Kursus 2" style="object-fit: cover; height: 180px;">
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS</small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => 'Pembelajaran-Digital-Berbasis-Canva'] ) }}"> Pembelajaran Digital Berbasis Canva </a> </h6>
                          <small class="text-muted">Oleh: Tuti Alawiyah M Pd</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card h-100">
                        <img src="{{ URL::asset('assets/images/hq720.jpg') }}"
                             class="card-img-top img-fluid" alt="Kursus 3" style="object-fit: cover; height: 180px;">
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS</small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => 'Pembelajaran-Digital-Berbasis-Canva'] ) }}"> Pembelajaran Digital Berbasis Canva </a> </h6>
                          <small class="text-muted">Oleh: Tuti Alawiyah M Pd</small>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="card h-100">
                        <img src="{{ URL::asset('assets/images/pexels-max-fischer-5212338.jpg') }}"
                             class="card-img-top img-fluid" alt="Kursus 4" style="object-fit: cover; height: 180px;">
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS</small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => 'Pembelajaran-Digital-Berbasis-Canva'] ) }}"> Pembelajaran Digital Berbasis Canva </a> </h6>
                          <small class="text-muted">Oleh: Tuti Alawiyah M Pd</small>
                        </div>
                      </div>
                    </div> --}}
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
</div>

<div id="welcomeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="modal-body">

                  <!-- Gambar (ganti sesuai kebutuhan) -->
                  <img src="{{ URL::asset('assets/images/b47bffc6-5bf1-445a-b533-92d225343ff2.png') }}" class="hero-img" alt="Illustration">

                  <h5 class="fw-bold">
                    Hai! Selamat datang di SMART TEACHER AI
                  </h5>

                  <p class="modal-text">
                    Yuk, lengkapi profil Anda agar kami bisa memberikan rekomendasi kursus dan pembelajaran yang sesuai dengan tujuan Anda.
                  </p>

                  <a class="btn btn-primary" href="{{ route('profil') }}">
                    Lengkapi Profil
                  </a>

                </div>
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('js')
<script>
  @if($user && !$user->is_profile_completed)
  // Auto show modal saat halaman load
  window.addEventListener('load', function () {
    const myModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
    myModal.show();
  });
  @endif
</script>
@stop