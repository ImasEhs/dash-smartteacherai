@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Buat Materi Presentasi')

@section('style_additional')
<style>
/* Bubble Chat */
.chat-bubble {
  max-width: 90%;
  padding: 10px 14px;
  border-radius: 18px;
  margin-bottom: 10px;
  display: inline-block;
  word-wrap: break-word;
}

.chat-user {
  background-color: #263245;
  color: white;
  border-bottom-right-radius: 4px;
  margin-left: auto;
  text-align: right;
}

.chat-ai {
  background-color: #263245;
  color: white;
  border-bottom-left-radius: 4px;
  margin-right: auto;
  text-align: left;
}

.btn-generate {
    background-color: #0d6efd;
    border-radius: 50px;
    font-weight: 600;
    padding: 12px;
    font-size: 16px;
    color: white;
}

.btn-generate:hover {
    background-color: #808080;
    border-color: #0b326b;
    color:white;
  }

.btn-primary-custom {
    background-color: #6b7c98;
    border-color: #0d3f85;
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    color:white;
  }

  .btn-primary-custom:hover {
    background-color: #6b7c98;
    border-color: #0b326b;
    color:white;
  }
</style>

@stop

@section('content')

<div class="container py-4">

    <!-- Back -->
    <div class="mb-3">
      <a href="{{ route('ask_ai') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <!-- Card -->
    <div class="card chat-card p-4">
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-3">
          <a href="#" class="text-decoration-none" id="clear-chat">
            <i class="bi bi-arrow-counterclockwise"></i> Hapus Input
          </a>
          <a href="{{ route('history_chat_ai') }}" class="text-decoration-none">
            <i class="bi bi-clock-history"></i> History
          </a>
        </div>
      </div>

      <h5 class="fw-bold text-center">Buat Materi Presentasi</h5>
      <p class="text-muted text-center small mb-4">
        Buat slide yang dapat diekspor berdasarkan topik, teks, video YouTube
      </p>

    
    <form id="form-evaluasi" enctype="multipart/form-data">
        @csrf
        
        <div class="container">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Fase/Kelas : *</label>
                        <input type="text" name="kelas" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jumlah Slide : *</label>
                        <select id="jumlah_soal" name="jumlah_slide" class="form-control">
                            <option selected disabled value="" hidden>Pilih Jumlah</option>
                            @for($number = 1; $number < 100; $number++) <option value="{{ $number }}">{{ $number }}</option>
                                @endfor
                        </select>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                      <label for="assessment" class="form-label fw-bold">
                        Topik, Standar, Isi, atau Tujuan :*
                      </label>
                      <div class="position-relative">
                        <!-- Textarea -->
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" style="padding-left: 2.5rem;" placeholder="Tambahkan topik, standar, atau deskripsi yang lebih panjang tentang apa yang Anda ajarkan. Anda juga dapat menggunakan ikon penjepit kertas di sebelah kiri untuk melampirkan konten sebagai dasar presentasi Anda."></textarea>

                        <!-- Tombol Upload (ikon clip) -->
                        <label for="fileUpload1" class="position-absolute top-0 start-0 p-2 text-primary" style="cursor:pointer;" title="Unggah Dokumen (PDF, TXT, Gambar)">
                            <i class="bi bi-paperclip fs-5"></i>
                        </label>
                        <input type="file" name="dokumen" id="fileUpload1" accept=".pdf, .txt, image/*" class="d-none">
                      </div>
                      <div id="file-preview-container-1" class="mt-2 d-none">
                          <span class="badge bg-secondary d-inline-flex align-items-center py-2 px-3">
                              <i class="bi bi-file-earmark-text me-2"></i>
                              <span id="file-name-1" class="me-2">nama_file.pdf</span>
                              <button type="button" class="btn-close btn-close-white" style="font-size: 0.65em;" id="remove-file-btn-1" aria-label="Close"></button>
                          </span>
                      </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                      <label for="assessment" class="form-label fw-bold">
                        Kriteria Tambahan :*
                      </label>
                      <div class="position-relative">
                        <!-- Textarea -->
                        <textarea id="deskripsi_tambahan" name="deskripsi_tambahan" class="form-control" rows="3" style="padding-left: 2.5rem;" placeholder="Salin, tempel dokumen, atau unggah dokumen menggunakan ikon penjepit kertas yang ingin Anda ajak percakapan."></textarea>

                        <!-- Tombol Upload (ikon clip) -->
                        <label for="fileUpload2" class="position-absolute top-0 start-0 p-2 text-primary" style="cursor:pointer;" title="Unggah Dokumen (PDF, TXT, Gambar)">
                            <i class="bi bi-paperclip fs-5"></i>
                        </label>
                        <input type="file" name="dokumen_tambahan" id="fileUpload2" accept=".pdf, .txt, image/*" class="d-none">
                      </div>
                      <div id="file-preview-container-2" class="mt-2 d-none">
                          <span class="badge bg-secondary d-inline-flex align-items-center py-2 px-3">
                              <i class="bi bi-file-earmark-text me-2"></i>
                              <span id="file-name-2" class="me-2">nama_file.pdf</span>
                              <button type="button" class="btn-close btn-close-white" style="font-size: 0.65em;" id="remove-file-btn-2" aria-label="Close"></button>
                          </span>
                      </div>
                    </div>
                </div>
            </div>

        </div>

        <button class="btn rounded-pill w-100 btn-generate" type="submit" id="send-btn">Generate</button>
    </form>
    

    {{-- <div id="hasil" class="card mt-4 d-none">
        <div class="card-header">Hasil Evaluasi</div>
        <div class="card-body">
            <p id="output"></p>
        </div>
    </div> --}}

    <div class="container d-none" id="hasil">

      <!-- Judul di luar card -->
      <h5 class="fw-bold mb-3"> Hasil Buat Materi Presentasi </h5>

      <!-- Card dengan border hitam tebal -->
      <div class="card shadow-sm" style="border: 2px solid gray;padding: 10px;border-radius: 15px;">
        <div class="card-body">
            <div id="output"></div>
        </div>
      </div>

      <div class="mb-3 d-flex justify-content-end">
        <button class="btn btn-outline-default btn-lg" id="copy-chat">
          <i class="mdi mdi-content-copy"></i>
        </button>
        <button class="btn btn-outline-default btn-lg" id="share-chat">
          <i class="mdi mdi-share-variant"></i>
        </button>
      </div>

      <button class="btn rounded-pill w-100 btn-generate" onclick="research_again()" id="findagain">Mulai Ulang</button>

    </div>


    </div>

    <!-- Footer -->
    <div class="text-center text-muted small mt-3">
      <strong>Tanya AI</strong> can make mistakes. Check important info.
    </div>

</div>

@stop

@section('js')


<script>


$(document).ready(function(){

    // handle file upload preview 1
    $('#fileUpload1').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#file-name-1').text(file.name);
            $('#file-preview-container-1').removeClass('d-none');
        } else {
            $('#file-preview-container-1').addClass('d-none');
        }
    });

    $('#remove-file-btn-1').on('click', function() {
        $('#fileUpload1').val('');
        $('#file-preview-container-1').addClass('d-none');
    });

    // handle file upload preview 2
    $('#fileUpload2').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#file-name-2').text(file.name);
            $('#file-preview-container-2').removeClass('d-none');
        } else {
            $('#file-preview-container-2').addClass('d-none');
        }
    });

    $('#remove-file-btn-2').on('click', function() {
        $('#fileUpload2').val('');
        $('#file-preview-container-2').addClass('d-none');
    });

    // ajax submit
    $('#form-evaluasi').on('submit', function(e){
        e.preventDefault();

        // Validasi: pastikan setidaknya Topik Teks atau Dokumen diisi
        let deskripsi = $('#deskripsi').val().trim();
        let dokumen = $('#fileUpload1').val();
        if(!deskripsi && !dokumen) {
            alert("Mohon isi teks Topik, Standar, Isi, atau Tujuan ATAU unggah dokumen sebagai referensi.");
            return;
        }

        $('#send-btn').prop('disabled', true).text('Generate');
        $('#form-evaluasi').addClass('d-none');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('submit_materi_presentasi') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#output').text('Sedang menganalisa...');
                $('#hasil').removeClass('d-none');
                $('#findagain').addClass('d-none');
            },
            success: function(res){
                if(res.success){
                    {{-- $('#output').text(res.message); --}}

                    // parse markdown -> HTML
                    let htmlContent = marked.parse(res.message);

                    // jalankan efek typewriter
                    typeWriterEffect(htmlContent, 30);

                    $('#send-btn').prop('disabled', false).text('Generate');
                    $('#findagain').removeClass('d-none');

                } else {
                    console.log(res);
                    $('#output').text('Gagal evaluasi.');
                    $('#send-btn').prop('disabled', false).text('Generate');
                    $('#findagain').removeClass('d-none');
                }
            },
            error: function(xhr){
                let errorMsg = 'Terjadi error! silahkan coba kembali';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#output').text(errorMsg);
                $('#send-btn').prop('disabled', false).text('Generate');
                $('#findagain').removeClass('d-none');
            }
        });
    });
});

function research_again()
{
    $('#form-evaluasi').removeClass('d-none');
    $('#hasil').addClass('d-none');
}

async function typeWriterEffect(html, speed = 1) {
    let tempDiv = document.createElement("div");
    tempDiv.innerHTML = html;

    let target = document.getElementById("output");
    target.innerHTML = ""; // Kosongkan output awal

    // Fungsi inti untuk memproses setiap node secara asinkron
    async function processNode(node, parentEl) {
        if (node.nodeType === Node.TEXT_NODE) {
            // Jika teks, jalankan efek mengetik
            let text = node.nodeValue;
            let span = document.createElement("span");
            parentEl.appendChild(span);

            await new Promise((resolve) => {
                let i = 0;
                let interval = setInterval(() => {
                    if (i < text.length) {
                        let chunk = text.substr(i, 6);
                        span.textContent += chunk;
                        // Auto-scroll ke bawah
                        target.scrollTop = target.scrollHeight;
                        i += 6;
                    } else {
                        clearInterval(interval);
                        resolve(); // Selesai mengetik teks ini, lanjut ke node berikutnya
                    }
                }, speed);
            });

        } else if (node.nodeType === Node.ELEMENT_NODE) {
            // Jika elemen (p, li, strong, dll), buat elemennya dulu
            let el = document.createElement(node.tagName);
            
            // Copy semua atribut (seperti class atau href)
            for (let attr of node.attributes) {
                el.setAttribute(attr.name, attr.value);
            }
            parentEl.appendChild(el);

            // Proses anak-anak dari elemen ini secara berurutan
            let children = Array.from(node.childNodes);
            for (let child of children) {
                await processNode(child, el); // REKURSI AMAN karena ada 'await'
            }
        }
    }

    // Ambil semua node utama dari hasil parse markdown
    let nodes = Array.from(tempDiv.childNodes);
    for (let node of nodes) {
        await processNode(node, target);
    }

    // Setelah semua selesai mengetik
    $('#send-btn').prop('disabled', false).text('Generate');
}


</script>

@stop


