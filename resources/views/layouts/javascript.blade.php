<!-- jQuery -->
<script src="{{ asset('assets/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/AdminLTE/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('asset/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/AdminLTE/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/AdminLTE/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/AdminLTE/dist/js/pages/dashboard.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/AdminLTE/plugins/toastr/toastr.min.js') }}"></script>
<!-- Custom -->
<script src="{{ asset('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
@if ($message = Session::get('success'))
<script>
    $(document).ready(function() {
      toastr.success('{{ $message }}')
    });
</script>
@endif
@if ($message = Session::get('error'))
<script>
    $(document).ready(function() {
      toastr.error('{{ $message }}')
    });
</script>
@endif
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>

@yield('customjs')

