@extends('layouts.app')
@section('title', 'Pelaporan')
@section('breadcrumb', 'Laporan Pembelian')
@section('content')
@routes
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<section class="content">
    <!-- Default box -->
    <div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Laporan Pembelian</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    <input class="form-control dtpicker input-sm" id="searchTglTrans_1" name="searchTglTrans_1" type="text" placeholder="Tanggal Awal" value="{{ date('d/m/Y') }}">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    <input class="form-control dtpicker input-sm" id="searchTglTrans_2" name="searchTglTrans_2" type="text" placeholder="Tanggal Akhir" value="{{ date('d/m/Y') }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <button class="btn btn-success" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                                <button class="btn btn-danger" name="tbl-print" id="tbl-print" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                                <button class="btn btn-primary" name="tbl-export" id="tbl-export" onclick="goExport('table_penjualan', 'laporan_penjualan')"><i class="fa fa-table"></i> Export</button>
                                <button class="btn btn-danger" type="button" id="loaderDiv" style="display: none">
                                    <i class="fa fa-asterisk fa-spin text-info"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-4">
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
            </div>
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-body table-responsive">
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                            <div class="spinner-border text-primary" role="status">
                            </div>
                        </div>
                        <table class="table table-bordered table-hover" style="font-size: 10pt; width: 100%;">
                            <thead>
                            <tr>
                                <td style="text-align: left;" colspan="10"><h4>Laporan Pembelian</h4>
                                <p class="lbl_periode"></p>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">Act</th>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 10%; text-align: center;">No.Invoce</th>
                                <th style="width: 10%; text-align: center;">Tgl.Invoce</th>
                                <th style="width: 10%; text-align: center;">Tgl.Tiba</th>
                                <th>Supplier</th>
                                <th style="width: 10%; text-align: right">Total Net</th>
                                <th style="width: 10%; text-align: right;">Pembayaran</th>
                                <th style="width: 10%; text-align: right">Outstanding</th>
                                <th style="width: 10%; text-align: center;">Ket.</th>
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
<!-- <script type="text/javascript" src="{{ asset('assets/js/laporan/laporanPembelian.js') }}"></script> -->
<script>
    $(function(){ 
        $('#spinner-div').hide();
    });
    var goFilter = function()
    {
        var arr_tgl_1 = $("#searchTglTrans_1").val().split('/');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = $("#searchTglTrans_2").val().split('/');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        var ket_periode = $("#searchTglTrans_1").val()+" s/d "+$("#searchTglTrans_2").val();
        var obj = {};
        obj.tgl_1 = tgl_1;
        obj.tgl_2 = tgl_2;
        obj.ket_periode = ket_periode;

        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : route("laporanPembelianFilter"),
                contentType: "application/json",
                method : 'post',
                dataType: "json",
                data: JSON.stringify(obj),
                beforeSend: function()
                {
                    $(".viewList").empty();
                    $('#spinner-div').show();
                },
                success: function(response)
                {
                    $(".viewList").html(response.all_result);
                    $(".lbl_periode").html(response.periode);
                },
                complete: function()
                {
                    $('#spinner-div').hide();
                }
            });
    }

    var goPrint = function ()
    {
        var arr_tgl_1 = $("#searchTglTrans_1").val().split('/');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = $("#searchTglTrans_2").val().split('/');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        if($("#checkPpnPersen").prop('checked')){
            var check_detail = 'true';
        } else {
            var check_detail = 'false';
        }
        window.open(route('laporanPembelianPrint', [tgl_1, tgl_2, check_detail]), "_blank");
    }

    var goDetail = function(el)
    {
        $('#spinner-div').show();
        $("#frm_modal").load(route('laporanPembelianDetail', $(el).val()), function() {
            $('#spinner-div').hide();
        });
    };
</script>
@endsection

