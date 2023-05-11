$(function(){

});
var hapus_item = function(el){
    $(el).parent().parent().slideUp(100,function(){
        $(this).remove();
        total();
    });
}
var changeToNull = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("0");
    }
}

var hitSubTotal = function(el)
{
    hitungSubTotal(el);
}

var hitDiskon = function(el)
{
    var currentRow=$(el).closest("tr");
    var diskon = $(el).parent().parent().find('input[name="item_diskon[]"]').val();
    var sub_total = currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val();
    var nilai_diskon = (diskon/100)*sub_total;
    currentRow.find('td:eq(7) input[name="item_diskonrp[]"]').val(nilai_diskon);
    hitungSubTotal(el);
}

var hitDiskonNilai = function(el)
{
    var currentRow=$(el).closest("tr");
    var total = currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val();
    var diskon_rupiah = $(el).parent().parent().find('input[name="item_diskonrp[]"]').val();
    var persen_disk_total = (diskon_rupiah*100)/total;
    currentRow.find('td:eq(6) input[name="item_diskon[]"]').val(Math.floor(persen_disk_total));
    hitungSubTotal(el)
}

var hitDiskonTotalPersen = function(el)
{
    var total = $("#inputTotal").val();
    var diskon_persen = $(el).val();
    var nilai_disk_total = (diskon_persen/100)*total;
    $("#inputTotal_DiskRupiah").val(nilai_disk_total);
    hitung_total_net()
}

var hitDiskonTotalNilai = function(el)
{
    var total = $("#inputTotal").val();
    var diskon_rupiah = $(el).val();
    var persen_disk_total = (diskon_rupiah*100)/total;
    $("#inputTotal_DiskPersen").val(persen_disk_total);
    hitung_total_net()
}

var hitPpnTotalPersen = function(el)
{
    var total = $("#inputTotal").val();
    var ppn_persen = $(el).val();
    var nilai_ppntotal = (ppn_persen/100)*total;
    $("#inputTotal_PpnRupiah").val(nilai_ppntotal);
    hitung_total_net()
}

var hitPpnTotalNilai = function(el)
{
    var total = $("#inputTotal").val();
    var ppn_rupiah = $(el).val();
    var persen_ppn_total = (ppn_rupiah*100)/total;
    $("#inputTotal_PpnPersen").val(persen_ppn_total);
    hitung_total_net()
}


var hitungSubTotal = function(el){
    var currentRow=$(el).closest("tr");
    var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
    var harga = currentRow.find('td:eq(4) input[name="harga_satuan[]"]').val();
    var sub_total = parseFloat(jumlah) * parseFloat(harga);
    currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val(sub_total);
    var hasil_diskon = currentRow.find('td:eq(7) input[name="item_diskonrp[]"]').val();
    var sub_total_setelah_diskon = sub_total - hasil_diskon;
    currentRow.find('td:eq(8) input[name="item_sub_total_net[]"]').val(sub_total_setelah_diskon);
    total();
}  

var total = function(){
    
    var total = 0;
    var sub_total = 0;
    $.each($('input[name="item_sub_total_net[]"]'),function(key, value){
        sub_total = $(value).val() ?  $(value).val() : 0;
        total += parseFloat($(value).val());
    })
    $("#inputTotal").val(total);
    hitung_total_net();
} 

function hitung_total_net()
{
    var total = $("#inputTotal").val();
    var diskon_rupiah = $("#inputTotal_DiskRupiah").val();
    var ppn_rupiah = $("#inputTotal_PpnRupiah").val();
    var total_net = (total - diskon_rupiah) + parseInt(ppn_rupiah);
    $("#inputTotalNet").val(total_net);
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