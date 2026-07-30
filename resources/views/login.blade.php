<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - SMARTEACHER AI</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
    }

    .container-login {
      width: 100vw;
      height: 100vh;
      display: flex;
    }



    .left-panel {
      flex: 0 0 512px;   /* fix 512px */
      max-width: 512px;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #fff;
    }

    .right-panel {
      background-image: url("{{ asset('assets/images/sidelogin.png') }}");
      background-size: cover;
      background-position: center;
      flex: 1;           /* ambil semua sisa ruang */
      height: 100vh;
      color: white;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }




    .brand {
      font-size: 28px;
      font-weight: bold;
      color: #1d4ed8;
    }

    .brand span {
      background-color: #2563eb;
      color: #fff;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 18px;
      margin-left: 5px;
    }

    .form-control {
      background: #e0f2fe;
      border: none;
      border-radius: 10px;
    }

    .btn-login {
      background: linear-gradient(to right, #4f46e5, #3b82f6);
      color: white;
      border: none;
      border-radius: 15px; /* bikin oval */
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4);
      padding: 20px 30px; /* jarak teks */
      display: inline-block;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(59, 130, 246, 0.5);
    }

    .social-btn {
      border-radius: 10px;
      border: 1px solid #ccc;
      background: white;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .quote-box {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      max-width: 300px;
    }

    .quote-box img {
      max-width: 100%;
      border-radius: 12px;
      margin-top: 20px;
    }

    

    .input-wrapper {
      display: flex;
      align-items: center; /* ikon & input rata tengah */
      background: #dbeafe;
      border-radius: 20px;
      padding: 0.5rem 1rem;
      margin-bottom: 1rem;
      border: 1px solid #ced4da;
    }

    .input-wrapper:focus-within {
      border-color: #3b82f6;
      box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
    }

    .input-wrapper i {
      font-size: 1.2rem;
      margin-right: 10px;
      color: #6b7280;
    }

    .input-wrapper input {
      border: none !important;
      outline: none !important;
      background: transparent !important;
      flex: 1;              /* 👈 kunci biar sejajar dan isi sisa ruang */
      width: auto !important; /* override bootstrap */
      box-shadow: none !important;
      font-size: 1rem;
      color: #111827;
    }

    .input-wrapper input::placeholder {
      color: #6c757d;
    }

    @media (max-width: 768px) {
      .container-login {
        flex-direction: column;
      }
      .left-panel, .right-panel {
        flex: none;
        max-width: 100%;
        width: 100%;
        height: auto;
      }
    }

    

  </style>
</head>
<body>
  <div class="container container-login d-flex flex-column flex-md-row">
    <!-- Left Panel -->
    <div class="left-panel">
      <div class="w-100" style="max-width: 360px;">
        <div class="brand mb-4 text-center">SMARTEACHER <span>AI</span></div>
        <h4 class="fw-bold mb-1 text-center">LOGIN</h4>
        <p class="text-muted mb-4 text-center">Login untuk masuk kedalam aplikasi</p>

        <!-- Username -->
        <div class="input-wrapper">
          <i class="bi bi-person"></i>
          <input type="text" class="form-control border-0 shadow-none" placeholder="Username">
        </div>

        <!-- Password -->
        <div class="input-wrapper">
          <i class="bi bi-lock"></i>
          <input type="password" class="form-control border-0 shadow-none" placeholder="Password">
        </div>


        <center>
          <div>
            <button class="btn-login">Login Now</button>
          </div>
        </center>

        <div class="d-flex align-items-center my-4">
          <div class="flex-grow-1 border-top"></div>
          <div class="px-3 text-muted small text-nowrap">
            <strong>Login</strong> with Others
          </div>
          <div class="flex-grow-1 border-top"></div>
        </div>

        <div class="d-grid gap-2">
          <button class="social-btn" onclick="redirecttogoogle()">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Google_Favicon_2025.svg/120px-Google_Favicon_2025.svg.png" width="20" />
            Login with<strong>Google</strong>
          </button>
          <button class="social-btn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png" width="20" />
            Login with<strong>Facebook</strong>
          </button>
          
          {{--
          @if(app()->environment('local'))
          <a href="{{ url('/bypass-login') }}" class="social-btn text-decoration-none text-dark" style="background: #e2e8f0; border-color: #cbd5e1;">
            <i class="bi bi-bug-fill"></i>
            <strong>Bypass Login</strong> (Khusus Lokal)
          </a>
          @endif
          --}}
        </div>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
      
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  

  <script type="text/javascript">
    function redirecttogoogle()
    {
      window.location.href="{{ url('auth/google') }}";
    }
  </script>

</body>
</html>
