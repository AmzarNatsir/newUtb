$(function(){
    
});
var changeToNull = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("0");
    }
}
var getStokAkhir = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("0");
    }
    var currentRow=$(el).closest("tr");
    currentRow.find('td:eq(9) input[name="inp_stok_akhir[]"]').val($(el).val());
}
function konfirm()
{
    var psn = confirm("Yakin akan menyimpan data ?");
    if(psn==true)
    {
        return true;
    } else {
        return false;
    }
}