@extends('layout.index')
@section('meta_desc' , ''. $course->title.' | Smart Teacher AI')
@section('title' , ''. $course->title.' | Smart Teacher AI')

@section('style_additional')

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    body {
      background-color: #f5f6fa;
      font-family: "Segoe UI", sans-serif;
    }
    .training-header {
      background-color: #0d47a1; /* Biru tua khas Canva header */
      color: white;
      border-radius: 12px;
      overflow: hidden;
      padding: 1rem 1.5rem;
    }
    .training-header h3 {
      font-weight: 700;
    }
    .training-header p {
      margin-bottom: 0.5rem;
    }
    .rating i {
      color: #ffca28;
    }
    .info-text {
      font-size: 0.9rem;
      opacity: 0.9;
    }
    .btn-feedback {
      background-color: #fff;
      color: #0d47a1;
      font-weight: 500;
      border: none;
      border-radius: 20px;
      padding: 5px 15px;
      transition: all 0.3s ease;
    }
    .btn-feedback:hover {
      background-color: #e3f2fd;
      color: #0d47a1;
    }
</style>

<style>
.icon-circle {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}
</style>


@stop

@section('content')

<div class="container my-4">
    @if(Session::has('message_pretest'))
    <div class="row">
        <div class="col-md-12">
            <p class="alert {{ Session::get('class') }}">{{ Session::get('message_pretest') }}</p>
        </div>
    </div>
    @endif
    <div class="training-header">
        <div class="row align-items-center">
            <!-- Kolom Kiri (Video) -->
            <div class="col-md-5 mb-3 mb-md-0">
                <div class="ratio ratio-16x9">
                  @php
                      use Illuminate\Support\Str;

                      // Gunakan method ->get() agar tidak error "Undefined array key" jika index kosong
                      $videoItem = $course->course_videos->get(\Request::get('level', 0));
                      $videoCode = optional($videoItem)->video_code;

                      $type = null;
                      $src  = null;

                      if ($videoCode) {

                          // Jika URL Zoom
                          if (Str::contains($videoCode, 'zoom.us/j/')) {
                              $type = 'zoom';
                              $src  = $videoCode;

                          // Jika URL penuh (YouTube, Vimeo, dll)
                          } elseif (Str::startsWith($videoCode, ['http://', 'https://'])) {
                              $type = 'iframe';
                              $src  = $videoCode;

                          // Jika hanya kode YouTube
                          } else {
                              $type = 'iframe';
                              $src  = "https://www.youtube.com/embed/" . $videoCode;
                          }
                      }
                  @endphp

                  {{-- ZOOM --}}
                  @if($type === 'zoom')
                      <div class="d-flex justify-content-center align-items-center w-100 bg-dark text-white">
                          <div class="text-center">
                              <h5 class="mb-3">Live Class via Zoom</h5>
                              <a href="{{ $src }}"
                                 target="_blank"
                                 class="btn btn-success btn-lg">
                                 Join Zoom Meeting
                              </a>
                          </div>
                      </div>

                  {{-- VIDEO IFRAME --}}
                  @elseif($type === 'iframe' && $src)
                      <iframe
                          src="{{ $src }}"
                          allow="camera; microphone; fullscreen; clipboard-read; clipboard-write"
                          allowfullscreen>
                      </iframe>

                  @else
                      <p>Tidak ada video untuk level ini.</p>
                  @endif
                </div>

            </div>

            <!-- Kolom Kanan (Informasi Pelatihan) -->
            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h3>{{ $course->title }}</h3>
                </div>
                {{-- <p class="mb-2">Memahami dan mengidentifikasi fungsi dan manfaat Canva dalam kegiatan pembelajaran</p> --}}
                <p class="mb-1">{{ $course->user->name }}</p>
                <!-- Rating -->
                <div class="rating mb-2">
                    <span class="fw-semibold">4.5</span>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-1">
                        @if($get_exam_attemp != null)
                        <span class="icon-circle bg-success text-white">
                            <i class="bi bi-check"></i>
                        </span>
                        @else
                        <span class="icon-circle bg-secondary text-white">
                            <i class="bi bi-x"></i>
                        </span>
                        @endif
                        <span class="fw-semibold">Pretest</span>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        @if($get_exam_attemp_pretest != null)
                        <span class="icon-circle bg-success text-white">
                            <i class="bi bi-check"></i>
                        </span>
                        @else
                        <span class="icon-circle bg-secondary text-white">
                            <i class="bi bi-x"></i>
                        </span>
                        @endif
                        <span class="fw-semibold">Postest</span>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        @if($has_feedback)
                        <span class="icon-circle bg-success text-white">
                            <i class="bi bi-check"></i>
                        </span>
                        @else
                        <span class="icon-circle bg-secondary text-white">
                            <i class="bi bi-x"></i>
                        </span>
                        @endif
                        <span class="fw-semibold">Feedback</span>
                    </div>

                    <div class="d-flex align-items-center gap-1">

                        @if($get_exam_attemp_pretest != null && $has_feedback)
                        <span class="icon-circle bg-success text-white">
                            <i class="bi bi-check"></i>
                        </span>
                        @else
                        <span class="icon-circle bg-secondary text-white">
                            <i class="bi bi-x"></i>
                        </span>
                        @endif
                        <span class="fw-semibold">Sertifikat</span>
                    </div>
                </div>
                <br>
                <!-- Info tambahan -->
                <div class="d-flex flex-wrap gap-3 info-text">
                    <div><i class="bi bi-clock-history"></i> Pembaruan Terakhir: 10/2025</div>
                    <div><i class="bi bi-translate"></i> Bahasa: Indonesia</div>
                </div>
                <div class="d-flex justify-content-end align-items-start mb-2">
                    <button class="btn btn-feedback" data-bs-toggle="modal" data-bs-target="#feedback">Feedback</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container my-4">
    <div class="row g-4">
      <!-- KIRI: Video + Modul Pelatihan -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Modul Pelatihan</h5>
            <ul class="list-group list-group-flush mb-3">
              @foreach($course->course_videos as $key => $cv_list)
                <li class="list-group-item @if(\Request::get('level') == $key) active @endif">
                  <a href="{{ route('my_course' , ['id' => $course->slug] ) }}?level={{ $key }}" @if(\Request::get('level') == $key) style="color:white;" @endif> <i class="bi bi-camera-reels me-2"></i> {{ $cv_list->name }} </a>
                </li>
              @endforeach
            </ul>
            <div class="d-grid gap-2">

              <div class="d-flex justify-content-between mb-3">
                @if($exam_opt != null)
                @if(\Request::get('level') == 0 && $get_exam_attemp == null)
                <button class="btn btn-outline-primary w-50 me-2" data-bs-toggle="modal" data-bs-target="#pretest">Pretest</button>
                @endif
                @endif
                @if($get_exam_attemp_pretest == null && $get_exam_attemp != null)
                <button class="btn btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#posttest">Posttest</button>
                @endif
              </div>

              @if(!empty($check_course_review))

              @else
                  @if(\Request::get('level') == 0 && $get_exam_attemp == null)
                  <button class="btn btn-outline-success w-100" onclick="alert('Lengkapi Pretest terlebih dahulu')" >Upload Hasil Pelatihan</button>
                  @elseif($get_exam_attemp_pretest == null && $get_exam_attemp != null)
                  <button class="btn btn-outline-success w-100" onclick="alert('Lengkapi Posttest terlebih dahulu')" >Upload Hasil Pelatihan</button>
                  @else
                  <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#upload-pembelajaran">Upload Hasil Pelatihan</button>
                  @endif
              @endif

            </div>
          </div>
        </div>
      </div>

      <!-- KANAN: Deskripsi Pelatihan -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            {!! $course->description !!}
          </div>
        </div>
      </div>
    </div>
  </div>

    @if($exam_opt != null)
    <div id="pretest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upload-pembelajaranLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="upload-pembelajaranLabel">Pretest</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                  </div>
                  <div class="modal-body">
                    <div class="quiz-container">

                        <center>
                          <h6>Question <span id="current-number">1</span> of {{ count($exam_opt) }}</h6>
                          <p>{{ $get_exam->title }}</p>
                          {!! $get_exam->description !!}
                        </center>
                        
                        <hr>

                        {{-- Loop pertanyaan jadi slide --}}
                        @php $no = 1; @endphp
                        <form method="POST" action="{{ route('submit_pretest' , ['id' => $get_exam->id]) }}">
                          {{ csrf_field() }}
                        @foreach($exam_opt as $index => $val_exam_opt)
                            <div class="question-slide" data-index="{{ $index }}" style="{{ $index == 0 ? '' : 'display:none;' }}">

                                <p>{{ $no }}. {!! strip_tags($val_exam_opt->question_text) !!}</p>
                                

                                    @foreach($val_exam_opt->options as $opt_ans)
                                        <div class="form-check" style="padding-left: 3em;">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="answer[{{ $val_exam_opt->id }}]"   
                                                   id="option_{{ $opt_ans->id }}" 
                                                   value="{{ $opt_ans->id }}"
                                                   required 
                                                   >
                                            <label class="form-check-label" for="option_{{ $opt_ans->id }}">
                                                {{ $opt_ans->option_text }}
                                            </label>
                                        </div>
                                        <br>
                                    @endforeach

                            </div>
                          @php $no++; @endphp
                        @endforeach

                        {{-- Arrow navigation --}}
                        <div class="nav-arrows d-flex justify-content-center mt-3">
                            <span class="arrow me-4" id="prevBtn" style="font-size:28px; cursor:pointer;">&larr;</span>
                            <span class="arrow" id="nextBtn" style="font-size:28px; cursor:pointer;">&rarr;</span>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                      {{-- muncul di loop terakhir  --}}
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
              </div><!-- /.modal-content -->
      </div>
    </div>
    @endif

    @if($exam_opt_pretest != null)
    <div id="posttest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upload-pembelajaranLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="upload-pembelajaranLabel">Posttest</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                  </div>
                  <div class="modal-body">
                    <div class="quiz-container">

                        <center>
                          <h6>Question <span id="current-number-pretest">1</span> of {{ count($exam_opt_pretest) }}</h6>

                          <p>{{ $get_exam_pretest->title }}</p>
                          {!! $get_exam_pretest->description !!}
                        </center>

                        <hr>

                        {{-- Loop pertanyaan jadi slide --}}
                        @php $no_pretest = 1; @endphp
                        <form method="POST" action="{{ route('submit_posttest' , ['id' => $get_exam_pretest->id]) }}">
                          {{ csrf_field() }}
                        @foreach($exam_opt_pretest as $index_pretest => $val_exam_opt_pretest)
                            <div class="question-slide-pretest" data-index="{{ $index_pretest }}" style="{{ $index_pretest == 0 ? '' : 'display:none;' }}">

                                <p>{{ $no_pretest }}. {!! strip_tags($val_exam_opt_pretest->question_text) !!}</p>

                                
                                

                                    @foreach($val_exam_opt_pretest->options as $opt_ans_pretest)
                                        <div class="form-check" style="padding-left: 3em;">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="answer[{{ $val_exam_opt_pretest->id }}]"   
                                                   id="option_{{ $opt_ans_pretest->id }}" 
                                                   value="{{ $opt_ans_pretest->id }}"
                                                   required 
                                                   >
                                            <label class="form-check-label" for="option_{{ $opt_ans_pretest->id }}">
                                                {{ $opt_ans_pretest->option_text }}
                                            </label>
                                        </div>
                                        <br>
                                    @endforeach
                                

                            </div>
                          @php $no_pretest++; @endphp
                        @endforeach

                        {{-- Arrow navigation --}}
                        <div class="nav-arrows d-flex justify-content-center mt-3">
                            <span class="arrow me-4" id="prevBtn_pretest" style="font-size:28px; cursor:pointer;">&larr;</span>
                            <span class="arrow" id="nextBtn_pretest" style="font-size:28px; cursor:pointer;">&rarr;</span>
                        </div>


                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                      {{-- muncul di loop terakhir  --}}
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
              </div><!-- /.modal-content -->
      </div>
    </div>
    @endif

    <div id="upload-pembelajaran" class="modal fade" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title">Upload hasil pembelajaran</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <form 
              action="{{ route('upload_pelatihan') }}"
              method="POST"
              class="dropzone border rounded p-3"
              id="my-dropzone"
              enctype="multipart/form-data"
            >
              {{ csrf_field() }}
              <input type="hidden" name="course_id" value="{{ $course->id }}">
              <div class="dz-message text-muted">
                <i class="bi bi-cloud-upload fs-1 d-block mb-2"></i>
                Seret & lepas file di sini atau klik untuk memilih file
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" id="submit-dropzone" class="btn btn-primary">
              Submit
            </button>
          </div>

        </div>
      </div>
    </div>

    
    <div id="feedback"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="upload-pembelajaranLabel"
     aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h4 class="modal-title" id="upload-pembelajaranLabel">
                        Isi feedback anda mengenai pembelajaran ini
                    </h4>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    {{-- PETUNJUK --}}
                    <div class="card shadow-sm mb-3" style="font-size: 0.9rem;">
                        <div class="card-body py-2">
                            <h6 class="fw-bold mb-2">Petunjuk:</h6>
                            <p class="mb-2">
                                Beri tanda <span class="fw-bold text-success">✓</span>
                                pada kolom yang sesuai dengan pendapat Anda.
                            </p>

                            <ul class="list-group list-group-horizontal flex-wrap justify-content-between small"
                                style="gap: 0.5rem;">
                                <li class="list-group-item flex-fill text-center py-1 border-0 bg-transparent">
                                    1 = <span class="fw-semibold text-danger">Sangat Tidak Setuju</span>
                                </li>
                                <li class="list-group-item flex-fill text-center py-1 border-0 bg-transparent">
                                    2 = <span class="fw-semibold text-warning">Tidak Setuju</span>
                                </li>
                                <li class="list-group-item flex-fill text-center py-1 border-0 bg-transparent">
                                    3 = <span class="fw-semibold text-secondary">Netral</span>
                                </li>
                                <li class="list-group-item flex-fill text-center py-1 border-0 bg-transparent">
                                    4 = <span class="fw-semibold text-primary">Setuju</span>
                                </li>
                                <li class="list-group-item flex-fill text-center py-1 border-0 bg-transparent">
                                    5 = <span class="fw-semibold text-success">Sangat Setuju</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- FORM --}}
                    <div class="container mt-2">
                        <form method="POST" action="{{ route('submit_feedback') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <h4 class="mb-3">Feedback dari Peserta</h4>

                            @php
                                $totalUserFeedback = count($feedbackUser);
                            @endphp

                            @foreach ($feedbackUser as $index => $item)
                                <div class="mb-4">
                                    <p>
                                        <strong>{{ $index + 1 }}.</strong>
                                        {{ $item['name'] }}
                                    </p>

                                    @if ($index + 1 == $totalUserFeedback)
                                        {{-- Jika data terakhir → textarea --}}
                                        <div class="ms-3">
                                            <textarea name="feedback_user_{{ $item['id'] }}"
                                                      class="form-control"
                                                      rows="5"
                                                      placeholder="Tulis pendapat atau saran Anda di sini..."></textarea>
                                        </div>

                                    @else
                                        {{-- Selain terakhir → radio 1–5 --}}
                                        <div class="d-flex gap-3 mt-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="form-check form-check-inline {{ $i == 1 ? 'ms-3' : '' }}">
                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="feedback_user_{{ $item['id'] }}"
                                                           id="feedback_user_{{ $item['id'] }}_{{ $i }}"
                                                           value="{{ $i }}"
                                                           required>
                                                    <label class="form-check-label"
                                                           for="feedback_user_{{ $item['id'] }}_{{ $i }}">
                                                        {{ $i }}
                                                    </label>
                                                </div>
                                            @endfor

                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            {{-- FOOTER --}}
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-light"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit"
                                        class="btn btn-primary">
                                    Submit feedback
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>



    {{-- modal intro --}}
    <!-- Modal -->
    
    @if(Session::has('message'))
    <div class="modal fade" id="posttestModal" tabindex="-1" aria-labelledby="posttestModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-semibold" id="posttestModalLabel">Posttest</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <p class="text-muted mb-4">
              {{ Session::get('message') }}
            </p>

            <div class="d-flex justify-content-center mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center {{ Session::get('status_lulus') == 'Lulus' ? 'bg-success' : 'bg-danger' }}" style="width:160px; height:160px;">
                <span class="fs-1 fw-bold text-white">{{ Session::get('nilai') }}</span>
              </div>
            </div>

            <h4 class="fw-bold mb-1">{{ Session::get('status_lulus') }}</h4>
            <p class="text-secondary">{{ date('d-m-Y') }}</p>
          </div>

          <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
            @if(Session::get('status_lulus') == 'Lulus')
            <a type="button" href="{{ route('certificate') }}" class="btn btn-primary px-4">Sertifikat</a>
            @else
            <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Retest</button>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endif

    @if(Session::has('message_pretest_modal'))
    <div class="modal fade" id="pretestModal" tabindex="-1" aria-labelledby="pretestModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-semibold" id="pretestModalLabel">Pretest</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <p class="text-muted mb-4">
              {{ Session::get('message_pretest_modal') }}
            </p>

            <div class="d-flex justify-content-center mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center bg-info" style="width:160px; height:160px;">
                <span class="fs-1 fw-bold text-white">{{ Session::get('nilai_pretest') }}</span>
              </div>
            </div>

            <h4 class="fw-bold mb-1">{{ Session::get('status_pretest') }}</h4>
            <p class="text-secondary">{{ date('d-m-Y') }}</p>
          </div>

          <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    @endif

@stop

@section('js')

<script type="text/javascript">
  $(window).on('load',function(){
    $('#posttestModal').modal('show');
    $('#pretestModal').modal('show');
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".question-slide");
    let currentIndex = 0;
    let totalSlides = slides.length;
    let currentNumber = document.getElementById("current-number");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
        currentNumber.innerText = index + 1;
    }

    document.getElementById("prevBtn").addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    });

    document.getElementById("nextBtn").addEventListener("click", function () {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
            showSlide(currentIndex);
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".question-slide-pretest");
    let currentIndex = 0;
    let totalSlides = slides.length;
    let currentNumber = document.getElementById("current-number-pretest");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
        currentNumber.innerText = index + 1;
    }

    document.getElementById("prevBtn_pretest").addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    });

    document.getElementById("nextBtn_pretest").addEventListener("click", function () {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
            showSlide(currentIndex);
        }
    });
});
</script>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
Dropzone.autoDiscover = false;

const myDropzone = new Dropzone("#my-dropzone", {
    url: "{{ route('upload_pelatihan') }}",
    paramName: "file", 
    maxFiles: 1,
    maxFilesize: 25, 
    acceptedFiles: ".pdf,.doc,.docx,.jpg,.png",
    autoProcessQueue: false,
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictFileTooBig: "Ukuran file maksimal 25 MB"
});

// Trigger upload saat tombol Submit diklik
document.getElementById("submit-dropzone").addEventListener("click", function () {
    if (myDropzone.files.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Silakan pilih file terlebih dahulu sebelum menekan submit.'
        });
        return;
    }
    
    // Tampilkan progress
    Swal.fire({
        title: 'Mengunggah File...',
        html: 'Progress: <b>0</b>%',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    myDropzone.processQueue();
});

// Update progress bar
myDropzone.on("uploadprogress", function(file, progress, bytesSent) {
    const swalHtml = Swal.getHtmlContainer();
    if (swalHtml) {
        let p = Math.round(progress);
        if (p < 100) {
            swalHtml.innerHTML = 'Progress: <b>' + p + '</b>%';
        } else {
            swalHtml.innerHTML = '<div class="text-center"><span class="d-block mb-2">Memproses file di server peladen...</span><small class="text-muted">Mohon tunggu sebentar</small></div>';
        }
    }
});

// Optional: sukses upload
myDropzone.on("success", function (file, response) {
    console.log(response);
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Upload Pelatihan Berhasil',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        location.reload();
    });
});

// Optional: error upload
myDropzone.on("error", function (file, errorMessage) {
    console.error(errorMessage);
    let msg = errorMessage;
    if(typeof errorMessage === 'object' && errorMessage.message) {
        msg = errorMessage.message;
    }
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: msg
    });
    // Hapus file dari dropzone jika gagal agar bisa diulang
    myDropzone.removeFile(file);
});
</script>



@stop
