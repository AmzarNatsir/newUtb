$(function(){
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
                url: route('searchItem'),
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
            $("#inputSearch").val(ui.item.label);
            var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="id_item[]" value="0"><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+'<td><input type="hidden" name="item_id[]" value="'+ui.item.value+'"><label style="color: blue; font-size: 11pt">'+ui.item.label+'</label></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.satuan+'</label></td>'+'<td align="center"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary" name="tbl_minus[]" onClick="min_qty(this)"><i class="fa fa-minus"></i></button></span><input type="number" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="1" style="text-align:center" readonly><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary" name="tbl_plus[]" onClick="add_qty(this)"><i class="fa fa-plus"></i></button></span></div></td>'+'<td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="'+ui.item.harga_toko+'" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)" readonly></td>'+'<td class="text-right"><input type="text" name="item_sub_total[]" value="'+ui.item.harga_toko+'" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskon[]" value="0" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskonrp[]" value="0" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_sub_total_net[]" value="'+ui.item.harga_toko+'" class="form-control form-control-sm text-right angka" readonly></td>'+'</tr>';
            $(".row_baru").after(content_item);
            $('.angka').number( true, 0 );
            $("#inputSearch").val("");
            total();
            return false;
        }
    });
});

var hapus_item = function(el){
    var id_data = $(el).parent().parent().find('input[name="id_item[]"]').val();
    var psn = confirm("Yakin akan mengahpus item po ?");
    if(psn==true)
    {
        if(id_data > 0)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: route('deleteItemOrder'),
                dataType: "json",
                data: {
                    id_data: id_data
                },
                success: function( response ) {
                    if(response=='true') {
                        return true;
                    } else {
                        return false
                    }
                }
            });
            $(el).parent().parent().slideUp(100,function(){
                $(this).remove();
                total();
            });
        } else {
            $(el).parent().parent().slideUp(100,function(){
                $(this).remove();
                total();
            });
        }
        
    } else {
        return false;
    }
    
    
}
var changeToNull = function(el)
{
    if($(el).val()=="")
    {
        $(el).val("1");
    }
}

// var add_qty = function(el)
// {
//     var input = $(el).parent().parent().find('input[name="item_qty[]"]'),
//         min = input.attr("min"),
//         max = input.attr("max");
//     var oldValue = parseFloat(input.val());
//     if (oldValue >= max) {
//       var newVal = oldValue;
//     } else {
//       var newVal = oldValue + 1;
//     }
//     // input.val(newVal);
//     $(el).parent().parent().find('input[name="item_qty[]"]').val(newVal);
//     hitungSubTotal(el);
// }

// var min_qty = function(el)
// {
//     var input = $(el).parent().parent().find('input[name="item_qty[]"]'),
//         min = input.attr("min"),
//         max = input.attr("max");
//     var oldValue = parseFloat(input.val());
//     if (oldValue <= min) {
//       var newVal = oldValue;
//     } else {
//       var newVal = oldValue - 1;
//     }
//     //input.val(newVal);
//     $(el).parent().parent().find('input[name="item_qty[]"]').val(newVal);
//     hitungSubTotal(el);
// }

var hitungSubTotal = function(el){
    var currentRow=$(el).closest("tr");
    var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
    var harga = currentRow.find('td:eq(4) input[name="harga_satuan[]"]').val();
    var sub_total = parseFloat(jumlah) * parseFloat(harga);
    currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val(sub_total);
    // var hasil_diskon = currentRow.find('td:eq(7) input[name="item_diskonrp[]"]').val();
    // var sub_total_setelah_diskon = sub_total - hasil_diskon;
    // currentRow.find('td:eq(8) input[name="item_sub_total_net[]"]').val(sub_total_setelah_diskon);
    total();
}  

var total = function(){
    
    var total = 0;
    var sub_total = 0;
    $.each($('input[name="item_sub_total[]"]'),function(key, value){
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