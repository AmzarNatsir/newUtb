<!-- jQuery -->
<script src="{{ asset('assets/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{asset('assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/AdminLTE/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('assets/AdminLTE/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js')}} "></script>
<!-- Toastr -->
<script src="{{asset('assets/AdminLTE/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/select2/js/select2.full.min.js')}} "></script>
<script src="{{asset('assets/AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('assets/AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/AdminLTE/plugins/number/jquery.number.js')}}"></script>
<!-- <script src="{{asset('assets/AdminLTE/plugins/simpleDatePicker/dcalendar.picker.js')}}"></script> -->
<!-- ChartJS -->
<script src="{{asset('assets/AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
<!-- <script src="{{asset('assets/AdminLTE/plugins/pace-progress/pace.min.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('assets/AdminLTE/dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('assets/AdminLTE/dist/js/pages/dashboard2.js')}}"></script> -->

<script type="text/javascript">
    $(document).ready(function() 
    {
        $('.datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language" : { processing:  '<i class="fa fa-sync fa-spin fa-2x fa-fw"></i><span>  Loading Data...</span>' } ,
        });
        $(".select2").select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Select",
            allowClear: true
        });
        $('.angka').number( true, 0 );
        $('.angka_dec').number( true, 2);
        $('.dtpicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
        });
        $('.reservation').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
        });
    });
</script>