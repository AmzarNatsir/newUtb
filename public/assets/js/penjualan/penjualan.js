$(function(){
    window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    var total_net = $("#inputTotalNet").val();
    if(total_net==0)
    {
        $("#tbl_submit").attr("disabled", true);
    }
    $("#inputSearch").autocomplete({
        source: function(request, response) {
            //Fetch data
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: route('searchItemPenjualan'),
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response(data);
                }

            });
        },
        select: function(event, ui) {
            if(ui.item.stok == 0)
            {
                alert("Persediaan Stok Habis");
            } else {
                $("#inputSearch").val(ui.item.label);
                var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+'<td><input type="hidden" name="item_id[]" value="'+ui.item.value+'"><label style="color: blue; font-size: 11pt">'+ui.item.label+'</label></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.satuan+'</label></td>'+'<td align="center"><input type="hidden" name="stok_akhir[]" value="'+ui.item.stok+'"><input type="text" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="1" style="text-align:center" onkeyup="hitungSubTotal(this)" onblur="cekPersediaan(this)"></td>'+'<td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="'+ui.item.harga_eceran+'" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)" readonly></td>'+'<td class="text-right"><input type="text" name="item_sub_total[]" value="'+ui.item.harga_toko+'" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskon[]" value="0" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)"></td>'+'<td class="text-right"><input type="text" name="item_diskonrp[]" value="0" class="form-control form-control-sm text-right angka" onkeyup="hitDiskonNilai(this)" onblur="changeToNull()"></td>'+'<td class="text-right"><input type="text" name="item_sub_total_net[]" value="'+ui.item.harga_toko+'" class="form-control form-control-sm text-right angka" readonly></td>'+'</tr>';
                $(".row_baru").after(content_item);
                $('.angka').number( true, 0 );
                $("#inputSearch").val("");
                total();
            }
            return false;
        }
    });

    // $("#tbl_print").on("click", function() {
    //     var id_head = 2;
    //      var myWindow = window.open(route('printInvoice', id_head), "_blank", "scrollbars=yes,width=400,height=500,top=300");
         
    //      // focus on the popup //
    //      myWindow.focus();
    // });
});

var printInvoice = function()
{
    alert("hmmmmm");
}
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

var cekPersediaan = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("0");
    }
    var currentRow=$(el).closest("tr");
    var qty = $(el).val();
    var stok_akhir = $(el).parent().parent().find('input[name="stok_akhir[]"]').val();
    if(parseInt(qty) > parseInt(stok_akhir))
    {
        alert("Maaf. Persediaan Stok tidak cukup");
        $(el).val("1");
        hitungSubTotal(el);
        return false
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

var hitOngkir = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("0");
    }
    hitung_total_net();
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
    var ongkir = $("#inputOngkosKirim").val();
    var total_net = (total - diskon_rupiah) + parseInt(ppn_rupiah) + parseInt(ongkir);
    $("#inputTotalNet").val(total_net);
    if(total_net>0)
    {
        $("#tbl_submit").attr("disabled", false);
    } else {
        $("#tbl_submit").attr("disabled", true);
    }
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