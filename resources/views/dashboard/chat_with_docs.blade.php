@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Chat Dengan Dokumen')

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

      <h5 class="fw-bold text-center">Chat Dengan Dokumen</h5>
      <p class="text-muted text-center small mb-4">
        Unggah dokumen dan chat dengan AI berdasarkan sumber dokumen
      </p>

    
    <form id="form-evaluasi" enctype="multipart/form-data">
        @csrf
        
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                      <label for="assessment" class="form-label fw-bold">
                        Tempel teks atau Unggah dokumen untuk Percakapan: <span class="text-danger">*</span>
                      </label>
                      <div class="position-relative">
                        <!-- Textarea -->
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" style="padding-left: 2.5rem;" placeholder="Salin, tempel teks dokumen, atau unggah dokumen PDF/Gambar menggunakan ikon penjepit kertas." required></textarea>

                        <!-- Tombol Upload (ikon clip) -->
                        <label for="fileUpload" 
                               class="position-absolute top-0 start-0 p-2 text-primary"
                               style="cursor:pointer;" title="Unggah Dokumen (PDF, TXT, Gambar)">
                          <i class="bi bi-paperclip fs-5"></i>
                        </label>
                        <input type="file" name="document" id="fileUpload" accept=".pdf, .txt, image/*" class="d-none">
                      </div>
                      <div id="file-preview-container" class="mt-2 d-none">
                          <span class="badge bg-secondary d-inline-flex align-items-center py-2 px-3">
                              <i class="bi bi-file-earmark-text me-2"></i>
                              <span id="file-name" class="me-2">nama_file.pdf</span>
                              <button type="button" class="btn-close btn-close-white" style="font-size: 0.65em;" id="remove-file-btn" aria-label="Close"></button>
                          </span>
                      </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                      <label for="assessment" class="form-label fw-bold">
                        Unggah dokumen kedua untuk Percakapan (Optional) :
                      </label>
                      <div class="position-relative">
                        <!-- Textarea -->
                        <textarea id="deskripsi2" name="deskripsi2" class="form-control" rows="3" style="padding-left: 2.5rem;" placeholder="Salin, tempel dokumen, atau unggah dokumen menggunakan ikon penjepit kertas yang ingin Anda ajak percakapan."></textarea>

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
            </div> --}}

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
      <h5 class="fw-bold mb-3"> Hasil Chat Dengan Dokumen </h5>

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

    // handle file upload preview
    $('#fileUpload').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#file-name').text(file.name);
            $('#file-preview-container').removeClass('d-none');
        } else {
            $('#file-preview-container').addClass('d-none');
        }
    });

    // handle remove file
    $('#remove-file-btn').on('click', function() {
        $('#fileUpload').val('');
        $('#file-preview-container').addClass('d-none');
    });

    // ajax submit
    $('#form-evaluasi').on('submit', function(e){
        e.preventDefault();

        $('#send-btn').prop('disabled', true).text('Generate');
        $('#form-evaluasi').addClass('d-none');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('submit_chat_with_docs') }}",
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
                    typeWriterEffect(htmlContent, 5);

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
                    let chunk = text.substr(i, 6);
                    span.textContent += chunk;
                    $("#output").scrollTop($("#output")[0].scrollHeight);
                    i += 6;
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


