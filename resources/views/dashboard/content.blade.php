@extends('layout.index')
@section('meta_desc' , 'Perjalanan Karir Smarteacher AI')
@section('title' , 'Perjalanan Karir Smarteacher AI')

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


  .stat-box {
      background-color: #f0f4ff;
      border-radius: 12px;
      text-align: center;
      padding: 20px 10px;
      min-width: 120px;
    }

    .stat-box h3 {
      font-size: 2rem;
      margin-bottom: 5px;
      color: #0d6efd;
    }

    .stat-box p {
      font-size: 0.85rem;
      margin: 0;
      font-weight: 500;
    }

    .course-image {
      max-width: 100%;
      border-radius: 12px;
    }

    .label-status {
      color: #0d6efd;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      margin-bottom: 5px;
    }

    .course-title {
      font-weight: bold;
      font-size: 1.1rem;
      margin-bottom: 4px;
    }

    .countdown {
      font-size: 0.9rem;
      color: #333;
    }

    @media (max-width: 768px) {
      .stat-box {
        margin-bottom: 10px;
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
                <div class="container">
                    <div class="row g-4 align-items-center">
                      <!-- Gambar Pelatihan -->
                      <div class="col-md-3">
                        @if($course_in_progress && $course_in_progress->course)
                            <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $course_in_progress->course->image) }}" alt="{{ $course_in_progress->course->title }}" class="course-image">
                        @endif
                      </div>

                      <!-- Detail Kursus -->
                      <div class="col-md-3">
                        @if($course_in_progress && $course_in_progress->course)
                            <div class="label-status">Dalam Proses</div>
                            <div class="course-title"><a href="{{ route('my_course' , ['id' => $course_in_progress->course->slug] ) }}?level=0" class="text-dark">{{ $course_in_progress->course->title }}</a></div>
                            <div class="countdown text-primary fw-bold"></div>
                        @else
                            <div class="label-status text-muted">Belum ada pelatihan yang berjalan saat ini</div>
                        @endif
                      </div>

                      <!-- Statistik -->
                      <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-3 justify-content-md-end justify-content-center">
                          <div class="stat-box">
                            <h3>{{ str_pad($kursus_diikuti, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p>Kursus Diikuti</p>
                          </div>
                          <div class="stat-box">
                            <h3>{{ str_pad($pengujian_hasil, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p>Pengujian Hasil</p>
                          </div>
                          <div class="stat-box">
                            <h3 id="kursus_tersimpan_count">{{ str_pad($kursus_tersimpan, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p>Kursus Tersimpan</p>
                          </div>
                          <div class="stat-box">
                            <h3>{{ str_pad($sertifikat, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p>Sertifikat</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <!-- end row -->
         </div>

         <!-- end card-body/ profile-user-box-->
      </div>
      <!--end profile/ card -->
   </div>
</div>

<div class="row">
  <div class="col-xl-11 col-lg-11 mx-auto">
    <div class="card cta-box overflow-hidden" style="border-radius: 1rem;">
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
                        <div class="position-relative">
                            <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $list_course->image) }}"
                                 class="card-img-top img-fluid" alt="Kursus 1" style="object-fit: cover; height: 180px;">
                            <button class="btn btn-light rounded-circle position-absolute btn-save-course" 
                                    style="top: 10px; right: 10px; width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"
                                    data-course-id="{{ $list_course->id }}">
                                @if(in_array($list_course->id, $saved_course_ids))
                                    <i class="bi bi-bookmark-fill text-primary" style="font-size: 1.1rem;"></i>
                                @else
                                    <i class="bi bi-bookmark text-secondary" style="font-size: 1.1rem;"></i>
                                @endif
                            </button>
                        </div>
                        <div class="card-body p-2">
                          <small class="text-muted d-block mb-1">KURSUS </small>
                          <h6 class="mb-1 text-truncate"><a href="{{ route('my_course' , ['id' => $list_course->slug] ) }}?level=0"> {{ $list_course->title }} </a> </h6>
                          <small class="text-muted">Oleh: Tuti Alawiyah M Pd</small>
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

@stop

@section('js')


<script>
$(document).ready(function() {
    // Ganti waktu target di sini (misalnya 3 jam dari sekarang)
    // Contoh: waktu berakhir 3 jam dari waktu sekarang
    const endTime = new Date().getTime() + (3 * 60 * 60 * 1000); 

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {
            $('.countdown').text('Waktu telah habis');
            clearInterval(timer);
            return;
        }

        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((distance / (1000 * 60)) % 60);
        const seconds = Math.floor((distance / 1000) % 60);

        $('.countdown').text(
            hours + ' jam ' + minutes + ' menit ' + seconds + ' detik tersisa'
        );
    }

    // Jalankan pertama kali dan setiap 1 detik
    updateCountdown();
    const timer = setInterval(updateCountdown, 1000);

    // AJAX Save Course
    $('.btn-save-course').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        var icon = btn.find('i');
        var courseId = btn.data('course-id');

        $.ajax({
            url: "{{ route('toggle_save_course') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                course_id: courseId
            },
            success: function(response) {
                if(response.status === 'saved') {
                    icon.removeClass('bi-bookmark text-secondary').addClass('bi-bookmark-fill text-primary');
                    // Update counter
                    let currentCount = parseInt($('#kursus_tersimpan_count').text(), 10);
                    $('#kursus_tersimpan_count').text((currentCount + 1).toString().padStart(2, '0'));
                } else if (response.status === 'unsaved') {
                    icon.removeClass('bi-bookmark-fill text-primary').addClass('bi-bookmark text-secondary');
                    // Update counter
                    let currentCount = parseInt($('#kursus_tersimpan_count').text(), 10);
                    $('#kursus_tersimpan_count').text(Math.max(0, currentCount - 1).toString().padStart(2, '0'));
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Gagal menyimpan kursus. Silakan coba lagi.');
            }
        });
    });
});
</script>

@stop
