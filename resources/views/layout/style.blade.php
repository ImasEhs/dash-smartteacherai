      <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('logo.png') }}">

    <!-- Daterangepicker css -->
    <link href="{{ URL::asset('assets/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css">

    <!-- Vector Map css -->
    <link href="{{ URL::asset('assets/vendor/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme Config Js -->
    <script src="{{ URL::asset('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ URL::asset('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

      {{-- datatables --}}

      <!-- Datatables css -->
      <link href="{{ URL::asset('assets/vendor/datatable-net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
      {{-- <link href="{{ URL::asset('assets/vendor/datatable-net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" /> --}}

      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

      <!-- Styles -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

      <style>
           .brand {
    font-size: 20px;
    font-weight: bold;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    line-height: 1; /* pastikan teks sejajar */
    flex-wrap: nowrap; /* cegah teks turun ke bawah */
  }

  .brand span {
    background-color: #2563eb;
    color: #fff;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 18px;
    margin-left: 6px;
    line-height: 1; /* sejajarkan vertikal */
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

        /* Sidebar default (desktop) */
        .leftside-menu {
          position: fixed;
          top: 90px;
          left: 10px;
          width: 250px;
          height: calc(100vh - 90px);
          background: #fff;
          /* box-shadow: 0 4px 12px rgba(0,0,0,0.1); */
          padding: 15px;
          z-index: 999;
          transition: transform 0.3s ease;
        }

        /* Saat mobile, sidebar disembunyikan dulu */
        @media (max-width: 991px) {
          .leftside-menu {
            /* transform: translateX(-100%); */
          }
          .leftside-menu.active {
            transform: translateX(0);
          }
              .brand {
      font-size: 16px;
    }
    .brand span {
      font-size: 14px;
      padding: 2px 6px;
      margin-left: 4px;
    }
        }

      </style>