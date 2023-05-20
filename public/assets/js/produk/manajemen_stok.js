$(function(){
    // let APP_URL_ADD = route('receivingAdd');
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    $("#tbl_setting").on("click", function()
    {
        $("#frm_modal").load(route('settingStok'));
    });
});