@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'Tanya AI')

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
  background-color: #708090;
  color: white;
  border-bottom-right-radius: 4px;
  margin-left: auto;
  text-align: right;
}

.chat-ai {
  background-color: #708090;
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

      <h5 class="fw-bold text-center">Chat AI</h5>
      <p class="text-muted text-center small mb-4">
        Mulai percakapan dengan AI berdasarkan topik yang diinginkan berbasis teks
      </p>

      <!-- Chat area -->
      <div id="chat-result" class="p-3 border rounded bg-light mb-3" style="height: 400px; overflow-y: auto;">
        <em>What can I help with?</em>
      </div>

      <div class="mb-3 d-flex justify-content-end">
        <button class="btn btn-outline-default btn-lg" id="copy-chat">
          <i class="mdi mdi-content-copy"></i>
        </button>
        <button class="btn btn-outline-default btn-lg" id="share-chat">
          <i class="mdi mdi-share-variant"></i>
        </button>
      </div>

      <!-- Textarea -->
      <div class="mb-3">
        <textarea class="form-control" rows="3" placeholder="Send messages and generate a response (⌘/Ctrl + Enter)" id="user-message"></textarea>
      </div>

      <!-- Generate Button -->
      <button class="btn rounded-pill w-100 btn-generate" id="send-btn">Generate</button>
    </div>

    <!-- Footer -->
    <div class="text-center text-muted small mt-3">
      <strong>Tanya AI</strong> can make mistakes. Check important info.
    </div>

</div>

@stop

@section('js')
<script>
$(document).ready(function() {
    function sendMessage() {
        let message = $('#user-message').val().trim();
        let $btn = $('#send-btn');

        $btn.prop('disabled', true).text('Processing...');

        if(message === '') {
          alert('Isi chat dahulu');
          $btn.prop('disabled', false).text('Generate');
          return;
        }

        if ($('#chat-result em').length) {
            $('#chat-result').html('');
        }

        // tampilkan pesan user
        $('#chat-result').append(
            '<div class="d-flex justify-content-end"><div class="chat-bubble chat-user">'+message+'</div></div>'
        );
        $('#user-message').val('');
        $("#chat-result").scrollTop($("#chat-result")[0].scrollHeight);

        // bubble AI sementara
        let loadingId = 'loading-' + Date.now();
        $('#chat-result').append(
            '<div class="d-flex justify-content-start"><div class="chat-bubble chat-ai" id="'+loadingId+'"><em>...</em></div></div>'
        );
        $("#chat-result").scrollTop($("#chat-result")[0].scrollHeight);

        // Ajax
        $.post("{{ url('/submit_chat_ai') }}", {
            _token: "{{ csrf_token() }}",
            message: message
        }, function(data) {
            let parsed = marked.parse(data.reply); // parse markdown → html
            $('#'+loadingId).html(""); // kosongkan bubble
            typeWriterEffect(loadingId, parsed, 25); 
        }).fail(function() {
            $('#'+loadingId).html('<span class="text-danger">Terjadi kesalahan.</span>');
            $btn.prop('disabled', false).text('Generate');
        });
    }

    $('#send-btn').click(function() { sendMessage(); });

    $('#user-message').keydown(function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            sendMessage();
            e.preventDefault();
        }
    });

    $('#clear-chat').click(function(e) {
        e.preventDefault();
        $('#chat-result').html('<em>Ketik pesan untuk memulai percakapan...</em>');
    });

    // typewriter dengan support HTML
    function typeWriterEffect(elementId, html, speed = 1) {
        let tempDiv = document.createElement("div");
        tempDiv.innerHTML = html;

        let target = document.getElementById(elementId);

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
                        $("#chat-result").scrollTop($("#chat-result")[0].scrollHeight);
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
});
</script>
@stop


