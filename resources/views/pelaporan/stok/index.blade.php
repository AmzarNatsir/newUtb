@extends('layouts.app')
@section('title', 'Pelaporan')
@section('breadcrumb', 'Laporan Stok')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Laporan Stok</h3>
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
                            <div class="form-group col-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right reservation" id="searchTglTrans" name="searchTglTrans">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <button class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                                <button class="btn btn-danger btn-sm" name="tbl-print" id="tbl-print" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                                <button class="btn btn-primary btn-sm" name="tbl-export" id="tbl-export" onclick="goExport('table_penjualan', 'laporan_penjualan')"><i class="fa fa-table"></i> Export</button>
                                <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                    <i class="fa fa-asterisk fa-spin text-info"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-responsive datatable" style="font-size: 12pt; width: 100%;" id="table_stok">
                            <thead>
                            <tr>
                                <td style="text-align: left;" colspan="11"><h4>Laporan Stok</h4><p id="lbl_periode"></p></td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;" rowspan="2">No.</th>
                                <th style="width: 10%; text-align: center;" rowspan="2">Kode</th>
                                <th style="width: 20%;" rowspan="2">Nama Produk</th>
                                <th style="width: 5%; text-align: center;" rowspan="2">Stok Awal</th>
                                <th style="width: 10%; text-align: center;" rowspan="2">Harga Barang</th>
                                <th style="text-align: center;" colspan="2">Mutasi</th>
                                <th style="text-align: center;" colspan="2">Batal</th>
                                <th style="width: 5%; text-align: center;" rowspan="2">Stok Akhir</th>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">Masuk</th>
                                <th style="width: 5%; text-align: center;">Keluar</th>
                                <th style="width: 5%; text-align: center;">Masuk</th>
                                <th style="width: 5%; text-align: center;">Keluar</th>
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
<!-- <script type="text/javascript" src="{{ asset('assets/js/laporan/laporanStok.js') }}"></script> -->
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
            url : route("laporanStokFilter"),
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
    }
    var goPrint = function ()
    {
        var tgl_transaksi = $("#searchTglTrans").val().split(' - ');
        var arr_tgl_1 = tgl_transaksi[0].split('-');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = tgl_transaksi[1].split('-');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        window.open(route('laporanStokPrint', [tgl_1, tgl_2]), "_blank");
    }
</script>
@endsection

