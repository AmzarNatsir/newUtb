$(document).ready(function() 
{
    $('.angka').number( true, 0 );
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
    });
});