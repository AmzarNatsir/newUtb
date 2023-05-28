@extends('layouts.app')
@section('title', 'Pelaporan')
@section('breadcrumb', 'Laporan Return Penjualan')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Laporan Return Penjualan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control form-control-sm float-right reservation" id="searchTglTrans" name="searchTglTrans">
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="button" class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                            <button class="btn btn-primary btn-sm" name="tbl-export" id="tbl-export" onclick="goExport('table_penjualan', 'laporan_penjualan')"><i class="fa fa-table"></i> Export</button>
                            <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                <i class="fa fa-asterisk fa-spin text-info"></i>
                            </button>
                        </div>
                        <div class="form-group row">
                            <div class="form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="checkPpnPersen">
                                    <label for="checkPpnPersen">Include Detail (* Print)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-body">
                        <table class="table table-bordered table-hover  table-responsive" style="font-size: 11pt; width: 100%;" id="table_penjualan">
                            <thead>
                            <tr>
                                <td style="text-align: left;" colspan="10"><h4>Laporan Return Penjualan</h4>
                                <p class="lbl_periode"></p>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">Act</th>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 10%; text-align: center;">No.Return</th>
                                <th style="width: 10%; text-align: center;">Tgl.Return</th>
                                <th>Customer</th>
                                <th style="width: 15%; text-align: center;">Total</th>
                            </tr>
                            </thead>
                            <tbody class="viewList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- Modal -->
<div class="modal fade" id="modal-form" data-backdrop="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
<script>
    $(function(){});
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
            url : route("laporanReturnPenjualanFilter"),
            contentType: "application/json",
            method : 'post',
            dataType: "json",
            data: JSON.stringify(obj),
            beforeSend: function()
            {
                $(".viewList").empty();
                $("#loaderDiv").show();
            },
            success: function(response)
            {
                $(".viewList").html(response.all_result);
                $(".lbl_periode").html(response.periode);
                $("#loaderDiv").hide();
            }
        });
        // return false;
    };

    var goDetail = function(el)
    {
        $("#frm_modal").load(route('laporanReturnPenjualanDetail', $(el).val()));
    };

    var goPrint = function ()
    {
        var tgl_transaksi = $("#searchTglTrans").val().split(' - ');
        var arr_tgl_1 = tgl_transaksi[0].split('-');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = tgl_transaksi[1].split('-');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        if($("#checkPpnPersen").prop('checked')){
            var check_detail = 'true';
        } else {
            var check_detail = 'false';
        }
        window.open(route('laporanReturnPenjualanPrint', [tgl_1, tgl_2, check_detail]), "_blank");
    }

</script>
@endsection

