@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Buat Modul Ajar')

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

/* Styling untuk hasil Markdown AI */
#output {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    color: #333;
}
#output h1, #output h2, #output h3 {
    font-weight: 700;
    color: #1a202c;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
#output h1 { font-size: 1.4rem; }
#output h2 { font-size: 1.2rem; }
#output h3 { font-size: 1.1rem; }
#output p, #output li {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #4a5568;
}
#output ul, #output ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}
#output strong {
    color: #2d3748;
}
#output table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
    font-size: 0.9rem;
}
#output table th, #output table td {
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    vertical-align: top;
}
#output table thead th {
    background-color: #f7fafc;
    font-weight: 600;
    border-bottom: 2px solid #cbd5e0;
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

      <h5 class="fw-bold text-center">Buat Modul Ajar</h5>
      <p class="text-muted text-center small mb-4">
        Buat modul ajar dengan pendekatan Cultulally Responsive Teaching (CRT)
      </p>

    
    <form id="form-evaluasi" enctype="multipart/form-data">
        @csrf
        
        <div class="container">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi:*</label>
                        <input type="text" id="instansi" name="instansi" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_penyusunan" class="form-label">Tahun Penyusunan:*</label>
                        <select id="tahun_penyusunan" name="tahun_penyusunan" class="form-control">
                            <option selected disabled value="" hidden>Pilih Tahun</option>
                            @for($year = 1990; $year < 2026; $year++)

                            <option value="{{ $year }}">{{ $year }}</option>

                            @endfor
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran:*</label>
                        <input type="text" id="mata_pelajaran" name="mata_pelajaran" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Fase/Kelas:*</label>
                        <select id="kelas" name="kelas" class="form-control">
                            <option selected disabled value="" hidden>Pilih Kelas</option>
                            @for($year = 1; $year < 13; $year++)

                            <option value="{{ $year }}">{{ $year }}</option>

                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="topik" class="form-label">Topik:*</label>
                        <input type="text" id="topik" name="topik" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Alokasi Waktu:*</label>
                        <input type="text" id="waktu" name="waktu" class="form-control">
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
      <h5 class="fw-bold mb-3">Modul Ajar Dengan Pendekatan Cultulally Responsive Teaching (CRT)</h5>

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

    // ajax submit
    $('#form-evaluasi').on('submit', function(e){
        e.preventDefault();

        $('#send-btn').prop('disabled', true).text('Generate');
        $('#form-evaluasi').addClass('d-none');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('submit_teaching_module') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#output').text('Sedang menganalisis gambar...');
                $('#hasil').removeClass('d-none');
                $('#findagain').addClass('d-none');
            },
            success: function(res){
                if(res.success){
                    {{-- $('#output').text(res.message); --}}

                    // parse markdown -> HTML
                    let htmlContent = marked.parse(res.message, {breaks: true});

                    // jalankan efek typewriter
                    typeWriterEffect(htmlContent, 5);
                    

                    {{-- fileInput.value = ""; // reset input file --}}
                    {{-- preview.innerHTML = ""; // hapus preview --}}

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

    // Copy Button functionality
    $('#copy-chat').on('click', function() {
        let textToCopy = document.getElementById('output').innerText;
        navigator.clipboard.writeText(textToCopy).then(function() {
            alert('Teks modul berhasil disalin!');
        }).catch(function(err) {
            console.error('Error copying text: ', err);
            alert('Gagal menyalin teks. Silakan coba kembali.');
        });
    });

    // Share Button functionality
    $('#share-chat').on('click', function() {
        let textToShare = document.getElementById('output').innerText;
        if (navigator.share) {
            navigator.share({
                title: 'Modul Ajar (Smarteacher AI)',
                text: textToShare
            }).then(() => {
                console.log('Berhasil membagikan');
            }).catch((err) => {
                console.error('Error sharing: ', err);
            });
        } else {
            alert('Maaf, browser Anda tidak mendukung fitur Share langsung.');
        }
    });
});

function research_again()
{
    $('#form-evaluasi').removeClass('d-none');
    $('#hasil').addClass('d-none');
}

function typeWriterEffect(html, speed = 5) {
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


