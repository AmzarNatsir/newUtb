$(function(){
    let APP_URL_ADD = route('purchaseOrderAdd');
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    $("#tbl_tambah").on("click", function()
    {
        $("#frm_modal").load(APP_URL_ADD);
        
    });
});