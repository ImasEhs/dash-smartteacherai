{{ Session::forget('message') }}
{{ Session::forget('class') }}
{{ Session::forget('antrian_no') }}
{{ Session::forget('nilai') }}
{{ Session::forget('status_lulus') }}
{{ Session::forget('message_pretest') }}
{{ Session::forget('message_pretest_modal') }}
{{ Session::forget('nilai_pretest') }}
{{ Session::forget('status_pretest') }}
<!-- Vendor js -->
    <script src="{{ URL::asset('assets/js/vendor.min.js') }}"></script>

    <!-- Daterangepicker js -->
    <script src="{{ URL::asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Apex Charts js -->


    <!-- Vector Map Js -->
    <script src="{{ URL::asset('assets/vendor/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jsvectormap/maps/world.js') }}"></script>

    <!-- Dashboard App js -->
    {{-- <script src="{{ URL::asset('assets/js/pages/demo.dashboard.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ URL::asset('assets/js/app.min.js') }}"></script>

    {{-- datatable js --}}
    <!-- Datatables js -->
<script src="{{ URL::asset('assets/vendor/datatable-net/js/dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/vendor/datatable-net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('assets/vendor/datatable-net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/vendor/datatable-net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>

{{-- // select2 --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<!-- Typewriter Effect -->
<script src="https://cdn.jsdelivr.net/npm/typewriter-effect@2.20.1/dist/core.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

{{-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

@yield('js')