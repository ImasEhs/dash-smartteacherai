@extends('layout.index')
@section('meta_desc' , 'Sertifikat')
@section('title' , 'Sertifikat')

@section('style_additional')


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
  }

  .btn-primary-custom:hover {
    background-color: #0b326b;
    border-color: #0b326b;
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
                        <div class="avatar-lg">
                           <img src="assets/images/users/avatar-2.jpg" alt="" class="rounded-circle img-thumbnail">
                        </div>
                     </div>
                     <div class="col">
                        <div>
                           <h4 class="mt-1 mb-1 text-black">Selamat datang kembali {{ $user->name }}</h4>
                           <p class="font-13 text-black-50"> Guru Sekolah Dasar</p>
                           
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col-->
               {{-- <div class="col-sm-4">
                  <div class="text-center mt-sm-0 mt-3 text-sm-end">
                     <button type="button" class="btn btn-light">
                     <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                     </button>
                  </div>
               </div> --}}
               <!-- end col-->
            </div>
            <!-- end row -->
         </div>

         <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                    <span class="d-none d-md-block">Sertifikat</span>
                </a>
            </li>
        </ul>

         <!-- end card-body/ profile-user-box-->
      </div>
      <!--end profile/ card -->
   </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="tab-content">
            <div class="tab-pane show active" id="profile-b1">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="container my-4">
                            @foreach($get_exam_atemp as $key => $list_course)
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <img src="{{ url('https://admin.smartteacherai.id/storage/courses/' . $list_course->course->image) }}" alt="Sertifikat {{ $loop->iteration }}" class="img-fluid rounded">
                                </div>

                                <div class="col-md-9">
                                    <div class="text-uppercase fw-semibold text-muted small">Kursus</div>
                                    <h5 class="mb-1">{{ $list_course->course->title }}</h5>
                                    <div class="fw-semibold">Muliawati Shaerin</div>
                                    <div class="text-muted small">Diterbitkan : Oktober 2025</div>
                                    <div class="mt-1 text-muted small">
                                        <i class="bi bi-clock"></i> 20 - 24 Oktober 2025
                                    </div>
                                    <div class="mt-3">
                                        @if(!empty($data_cert[$key]))
                                        <!-- Tombol Unduh -->
                                        <button class="btn btn-primary me-2" style="background-color: #0d3b82; border-radius: 0.5rem;" onclick="downloadCertificate('{{ $data_cert[$key] }}', 'Sertifikat-{{ Str::slug($list_course->course->title) }}.pdf')">Unduh</button>
                                        <!-- Tombol Share -->
                                        <button class="btn btn-outline-primary btn-share" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#shareModal" data-url="{{ $data_cert[$key] }}" data-title="{{ $list_course->course->title }}" data-image="{{ url('https://admin.smartteacherai.id/storage/' . $list_course->course->cert->image) }}">
                                            Share
                                        </button>
                                        @else
                                        <button class="btn btn-secondary me-2" style="border-radius: 0.5rem;" disabled>Belum Tersedia</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- Modal Share (hanya satu) -->
                            <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="shareModalLabel">Bagikan Sertifikat</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <!-- Gambar Preview Sertifikat -->
                                            <img id="sharePreviewImage" src="" alt="Preview Sertifikat" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 250px; object-fit: contain;">
                                            <p class="fw-semibold mb-3" id="shareCourseTitle">Pilih platform untuk membagikan sertifikat ini:</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <button class="btn btn-primary rounded-circle share-fb" title="Bagikan ke Facebook">
                                                    <i class="bi bi-facebook fs-4"></i>
                                                </button>
                                                <button class="btn btn-info rounded-circle share-tw" title="Bagikan ke Twitter">
                                                    <i class="bi bi-twitter fs-4"></i>
                                                </button>
                                                <button class="btn btn-danger rounded-circle share-ig" title="Bagikan ke Instagram">
                                                    <i class="bi bi-instagram fs-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')

<!-- Script Share -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  let currentShareUrl = '';
  let currentTitle = '';
  let currentImage = '';

  const titleEl = document.getElementById('shareCourseTitle');
  const previewImg = document.getElementById('sharePreviewImage');

  // Logic untuk unduh sertifikat (cors bypass download)
  window.downloadCertificate = function(url, filename) {
      // Tampilkan indikator loading (opsional) pada tombol jika diperlukan
      fetch(url)
        .then(response => response.blob())
        .then(blob => {
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(err => {
            console.error(err);
            // Fallback jika fetch terblokir CORS
            window.open(url, '_blank');
        });
  };

  // Saat tombol Share diklik
  document.querySelectorAll('.btn-share').forEach(button => {
    button.addEventListener('click', () => {
      currentShareUrl = button.dataset.url;
      currentTitle = button.dataset.title;
      currentImage = button.dataset.image;

      // Update isi modal
      titleEl.innerText = `Bagikan sertifikat: "${currentTitle}"`;
      previewImg.src = currentImage;
    });
  });

  // Facebook
  document.querySelector('.share-fb').addEventListener('click', () => {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentShareUrl)}`;
    window.open(url, '_blank', 'noopener,noreferrer,width=700,height=500');
  });

  // Twitter
  document.querySelector('.share-tw').addEventListener('click', () => {
    const text = `Lihat sertifikat saya untuk kursus "${currentTitle}" di S360 LMS!`;
    const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(currentShareUrl)}`;
    window.open(url, '_blank', 'noopener,noreferrer,width=700,height=500');
  });

  // Instagram
  document.querySelector('.share-ig').addEventListener('click', async () => {
    const shareText = `Lihat sertifikat saya untuk kursus "${currentTitle}" di S360 LMS!`;

    if (navigator.share) {
      try {
        await navigator.share({ title: currentTitle, text: shareText, url: currentShareUrl });
      } catch (err) {
        console.warn('Share dibatalkan');
      }
    } else {
      try {
        await navigator.clipboard.writeText(currentShareUrl);
        alert('Link disalin ke clipboard. Buka Instagram dan tempel link di caption atau story Anda.');
      } catch (err) {
        alert('Tidak dapat menyalin link. Silakan buka Instagram secara manual.');
        window.open('https://www.instagram.com/', '_blank');
      }
    }
  });
});
</script>


@stop

