@extends('layout.index')
@section('meta_desc' , 'Smarteacher AI')
@section('title' , 'History Chat AI')

@section('style_additional')
<style>
    body {
      background-color: #f8f9fa;
    }
    .chat-card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .btn-generate {
      background-color: #0d6efd;
      border-radius: 50px;
      font-weight: 600;
      padding: 12px;
      font-size: 16px;
      color: white;
    }
    textarea {
      resize: none;
    }
  </style>

@stop

@section('content')

<div class="container py-4">

    <!-- Back -->
    <div class="mb-3">
      <a href="{{ route('chat_ai') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <!-- Card -->
    <div class="card chat-card p-4">
      <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-3">
          <a href="#" class="text-decoration-none">
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

      <div class="row">
        <div class="col-md-4">
          <div class="card border border-dark border-1">
            <div class="card-body">
              {{ date('Y-m-d H:i:s') }}
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card border border-dark border-1">
            <div class="card-body">
              @foreach($get_history as $val_get_history)
              <p>{{ $val_get_history->question }}</p>
              <div data-simplebar style="max-height: 250px;">
                <p>{!! $val_get_history->answer !!}</p>
              </div>
              <hr>
              @endforeach
            </div>
          </div>
        </div>
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

</script>

@stop
