@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Tanya AI')

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
    min-height: 400px; /* tinggi tetap untuk semua slide */
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

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
         <h4 class="page-title">Tanya AI</h4>
       </div>
     </div>
   </div>

  <div class="row">
    <div class="container py-4">
      <div class="row g-3">
        <!-- Card 1 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <!-- Icon -->
              <img src="{{ URL::asset('assets/images/chatai.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              
              <div class="flex-grow-1">
                <!-- Title -->
                <a href="{{ route('chat_ai') }}"><h5 class="fw-bold mb-1">Chat AI</h5></a>
                <!-- Description -->
                <p class="text-muted small mb-0">
                  Mulai percakapan dengan AI berdasarkan topik yang diinginkan berbasis teks
                </p>
              </div>

              <!-- Favorite Icon -->
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <img src="{{ URL::asset('assets/images/exam.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              <div class="flex-grow-1">
                <a href="{{ route('make_exam') }}"><h5 class="fw-bold mb-1">Buat Soal</h5></a>
                <p class="text-muted small mb-0">
                  Buat soal pilihan ganda untuk ujian, kuis, atau tes berbasis materi belajar
                </p>
              </div>
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <img src="{{ URL::asset('assets/images/geography.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              <div class="flex-grow-1">
                <h5 class="fw-bold mb-1"><a href="{{ route('teaching_module') }}">Buat Modul Ajar</a></h5>
                <p class="text-muted small mb-0">
                  Buat modul ajar dengan pendekatan Culturally Responsive Teaching (CRT)
                </p>
              </div>
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <img src="{{ URL::asset('assets/images/image.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              <div class="flex-grow-1">
                <h5 class="fw-bold mb-1"><a href="{{ route('image_evaluate') }}">Evaluasi Gambar</a></h5>
                <p class="text-muted small mb-0">
                  Buat penilaian hasil gambar modul berdasarkan sistem penilaian
                </p>
              </div>
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <img src="{{ URL::asset('assets/images/document.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              <div class="flex-grow-1">
                <h5 class="fw-bold mb-1"><a href="{{ route('chat_with_docs') }}">Chat Dengan Dokumen</a></h5>
                <p class="text-muted small mb-0">
                  Unggah dokumen dan chat dengan AI berdasarkan sumber dokumen
                </p>
              </div>
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 1rem;">
            <div class="card-body d-flex align-items-start">
              <img src="{{ URL::asset('assets/images/statistics.png') }}" style="width:48px;" alt="Chat AI" class="me-3">
              <div class="flex-grow-1">
                <h5 class="fw-bold mb-1"><a href="{{ route('materi_presentasi') }}">Buat Materi Presentasi</a></h5>
                <p class="text-muted small mb-0">
                  Buat slide yang dapat diekspor berdasarkan topik, teks, video YouTube
                </p>
              </div>
              <i class="bi bi-star"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>


@stop
