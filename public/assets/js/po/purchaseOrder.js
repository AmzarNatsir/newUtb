$(function(){
    let APP_URL_ADD = route('purchaseOrderAdd');
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    $("#tbl_tambah").on("click", function()
    {
        $("#frm_modal").load(APP_URL_ADD);
    });

    $("#tbl_edit").on("click", function()
    {
        var id_data = this.value;
        $("#frm_modal").load(route('editOrder', id_data));
    });

    $("#tbl_approve").on("click", function()
    {
        var id_data = this.value;
        $("#frm_modal").load(route('approveOrder', id_data));
    });
});

var goPrint = function(el)
{
    var id_data = $(el).val();
    window.open(route('printOrder', id_data), "_blank");
}

function konfirmHapus()
{
    var psn = confirm("Yakin akan menghapus data ?");
    if(psn==true)
    {
        return true;
    } else {
        return false;
    }

}