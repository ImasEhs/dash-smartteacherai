@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Buat Soal')

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

      <h5 class="fw-bold text-center">Buat Soal</h5>
      <p class="text-muted text-center small mb-4">
        Buat soal pilihan ganda untuk ujian, kuis, atau tes berbasikan materi belajar
      </p>

    
    <form id="form-evaluasi" enctype="multipart/form-data">
        @csrf
        
        <div class="container">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="bentuk_soal" class="form-label">Bentuk Soal:*</label>
                        <select id="bentuk_soal" name="bentuk_soal" class="form-control" required>
                            <option selected disabled value="" hidden>Pilih Bentuk Soal</option>
                            <option value="Pilihan Ganda">Pilihan Ganda</option>
                            <option value="Essai">Essai</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang Sekolah:*</label>
                        <select id="jenjang" name="jenjang" class="form-control" required>
                            <option selected disabled value="" hidden>Pilih Jenjang Sekolah</option>
                            <option value="SD">SD</option>
                            <option value="SMP/MTS">SMP/MTS</option>
                            <option value="SMA/MA">SMA/MA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mapel" class="form-label">Mapel:*</label>
                        <input type="text" id="mapel" name="mapel" class="form-control" placeholder="Contoh: Matematika" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah_soal" class="form-label">Jumlah Soal:*</label>
                        <select id="jumlah_soal" name="jumlah_soal" class="form-control" required>
                            <option selected disabled value="" hidden>Pilih Jumlah</option>
                            @for($number = 1; $number <= 20; $number++)
                            <option value="{{ $number }}">{{ $number }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="row" id="opsi_jawaban_container">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="opsi_jawaban" class="form-label">Opsi Jawaban:*</label>
                        <select id="opsi_jawaban" name="opsi_jawaban" class="form-control">
                            <option selected disabled value="" hidden>Pilih Opsi Jawaban</option>
                            <option value="3 opsi (A, B, C)">3 Opsi (A, B, C)</option>
                            <option value="4 opsi (A, B, C, D)">4 Opsi (A, B, C, D)</option>
                            <option value="5 opsi (A, B, C, D, E)">5 Opsi (A, B, C, D, E)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                      <label for="assessment" class="form-label fw-bold">
                        Topik, Standar, Teks, atau Deskripsi Penilaian (harus spesifik):*
                      </label>
                      <div class="position-relative">
                        <!-- Textarea -->
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="8" style="padding-left: 2.5rem;"></textarea>

                        <!-- Tombol Upload (ikon clip) -->
                        <label for="fileUpload" 
                               class="position-absolute top-0 start-0 p-2"
                               style="cursor:pointer;">
                          <i class="bi bi-paperclip"></i>
                        </label>
                        <input type="file" name="image" id="fileUpload" class="d-none">
                      </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div id="drop-area" class="border rounded p-3 bg-light d-flex align-items-center justify-content-between" style="cursor:pointer; border: 2px dashed #ccc;">
                    <!-- Bagian kiri (icon + teks) -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cloud-upload fs-2 text-primary me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">Drag and drop file here</p>
                            <p class="mb-0 text-muted small">Size file Maks <5MB </p>
                        </div>
                    </div>

                    <!-- Bagian kanan (tombol) -->
                    <button type="button" class="btn btn-primary-custom" onclick="document.getElementById('fileInput').click();">
                        Browse File
                    </button>
                    <input type="file" name="image" id="fileInput" class="d-none">
                </div>

                <div id="preview" class="mt-3"></div>
            </div> --}}


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
      <h5 class="fw-bold mb-3"> Buat soal pilihan ganda untuk ujian, kuis, atau tes berbasikan materi belajar</h5>

      <!-- Card dengan border hitam tebal -->
      <div class="card shadow-sm" style="border: 2px solid gray;padding: 10px;border-radius: 15px;">
        <div class="card-body">
            <div id="output"></div>
        </div>
      </div>

      <div class="mb-3 d-flex justify-content-end gap-2">
        <form action="{{ route('download_pdf_exam') }}" method="POST" target="_blank" class="d-inline">
            @csrf
            <input type="hidden" name="html_content" id="pdf_html_content">
            <input type="hidden" name="mapel" id="pdf_mapel">
            <input type="hidden" name="jenjang" id="pdf_jenjang">
            <button class="btn btn-outline-danger btn-lg" type="submit" title="Download PDF">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </button>
        </form>
        
        <form action="{{ route('download_docx_exam') }}" method="POST" target="_blank" class="d-inline">
            @csrf
            <input type="hidden" name="html_content" id="docx_html_content">
            <input type="hidden" name="mapel" id="docx_mapel">
            <input type="hidden" name="jenjang" id="docx_jenjang">
            <button class="btn btn-outline-primary btn-lg" type="submit" title="Download DOCX">
                <i class="bi bi-file-earmark-word"></i> DOCX
            </button>
        </form>

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

    $('#bentuk_soal').on('change', function(){
        if($(this).val() === 'Pilihan Ganda'){
            $('#opsi_jawaban_container').removeClass('d-none');
            $('#opsi_jawaban').prop('required', true);
        } else {
            $('#opsi_jawaban_container').addClass('d-none');
            $('#opsi_jawaban').prop('required', false).val('');
        }
    });

    // ajax submit
    $('#form-evaluasi').on('submit', function(e){
        e.preventDefault();

        $('#send-btn').prop('disabled', true).text('Generate');
        $('#form-evaluasi').addClass('d-none');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('submit_make_exam') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#output').text('Sedang membuat soal...');
                $('#hasil').removeClass('d-none');
                $('#findagain').addClass('d-none');
            },
            success: function(res){
                if(res.success){
                    {{-- $('#output').text(res.message); --}}

                    // parse markdown -> HTML
                    let htmlContent = marked.parse(res.message, {breaks: true});

                    // Set untuk PDF & DOCX
                    $('#pdf_html_content').val(htmlContent);
                    $('#pdf_mapel').val($('#mapel').val());
                    $('#pdf_jenjang').val($('#jenjang').val());
                    $('#docx_html_content').val(htmlContent);
                    $('#docx_mapel').val($('#mapel').val());
                    $('#docx_jenjang').val($('#jenjang').val());

                    // jalankan efek typewriter
                    typeWriterEffect(htmlContent, 1);

                    $('#send-btn').prop('disabled', false).text('Generate');
                    $('#findagain').removeClass('d-none');

                } else {
                    $('#output').text('Gagal evaluasi.');
                    $('#send-btn').prop('disabled', false).text('Generate');
                    $('#findagain').removeClass('d-none');
                }
            },
            error: function(xhr){
                $('#output').text('Terjadi error! silahkan coba kembali');
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

function typeWriterEffect(html, speed = 1) {
    let tempDiv = document.createElement("div");
    tempDiv.innerHTML = html;

    let target = document.getElementById("output");
    target.innerHTML = ""; // kosongkan dulu

    function processNode(node, parentEl, callback) {
        if (node.nodeType === Node.TEXT_NODE) {
            let text = node.nodeValue;
            let i = 0;
            let span = document.createElement("span");
            parentEl.appendChild(span);
            let interval = setInterval(() => {
                if (i < text.length) {
                    let chunk = text.substr(i, 4);
                    span.textContent += chunk;
                    $("#output").scrollTop($("#output")[0].scrollHeight);
                    i += 4;
                } else {
                    clearInterval(interval);
                    callback();
                }
            }, speed);
        } else if (node.nodeType === Node.ELEMENT_NODE) {
            let el = document.createElement(node.tagName);
            // copy attributes
            for (let attr of node.attributes) {
                el.setAttribute(attr.name, attr.value);
            }
            parentEl.appendChild(el);

            let children = Array.from(node.childNodes);
            let idx = 0;
            function nextChild() {
                if (idx < children.length) {
                    let child = children[idx];
                    idx++;
                    processNode(child, el, nextChild);
                } else {
                    callback();
                }
            }
            nextChild();
        } else {
            callback();
        }
    }

    let nodes = Array.from(tempDiv.childNodes);
    let idx = 0;
    function nextNode() {
        if (idx < nodes.length) {
            let node = nodes[idx];
            idx++;
            processNode(node, target, nextNode);
        } else {
            $('#send-btn').prop('disabled', false).text('Generate');
        }
    }
    nextNode();
}


</script>

@stop


