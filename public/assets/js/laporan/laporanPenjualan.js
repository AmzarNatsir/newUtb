$(function(){
    $('.reservation').daterangepicker({
        locale: {
            format: 'DD-MM-YYYY'
        },
    });
});
var goFilter = function()
{
    var tgl_transaksi = $("#searchTglTrans").val().split(' - ');
    var arr_tgl_1 = tgl_transaksi[0].split('-');
    var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
    var arr_tgl_2 = tgl_transaksi[1].split('-');
    var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
    var ket_periode = tgl_transaksi[0]+" s/d "+tgl_transaksi[1];
    var obj = {};
    obj.tgl_1 = tgl_1;
    obj.tgl_2 = tgl_2;
    obj.ket_periode = ket_periode;
    $.ajax(
    {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route("laporanPenjualanFilter"),
        contentType: "application/json",
        method : 'post',
        dataType: "json",
        data: JSON.stringify(obj),
        beforeSend: function()
        {
            $(".viewList").empty();
            $(".viewListSummary").empty();
            $("#loaderDiv").show();
        },
        success: function(response)
        {
            $(".viewList").html(response.all_result);
            $(".viewListSummary").html(response.result_summary);
            $(".lbl_periode").html(response.periode);
            $(".lbl_periode_summary").html(response.periode);
            $("#loaderDiv").hide();
        }
    });
    // return false;
};

var goDetail = function(el)
{
    $("#frm_modal").load(route('laporanPenjualanDetail', $(el).val()));
};

