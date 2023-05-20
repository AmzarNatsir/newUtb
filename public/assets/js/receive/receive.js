$(function(){
    // let APP_URL_ADD = route('receivingAdd');
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    $("#tbl_receive").on("click", function()
    {
        var id_data = this.value;
        $("#frm_modal").load(route('receivingAdd', id_data));
    });
});