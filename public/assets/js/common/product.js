$(function(){
    let APP_URL_ADD = route('productAdd');
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    $("#tbl_tambah").on("click", function()
    {
        $("#frm_modal").load(APP_URL_ADD);
        
    });
});
var goEdit = function(el) {
    $("#frm_modal").load(route('productEdit', $(el).val()));
}

function konfirmHapus()
{
    var psn = confirm("Delete Data ?");
    if(psn==true)
    {
        return true;
    } else {
        return false;
    }

}