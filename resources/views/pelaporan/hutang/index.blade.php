@extends('layouts.app')
@section('title', 'Pelaporan')
@section('breadcrumb', 'Laporan Pembayaran Hutang')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Laporan Pembayaran Hutang</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="searchTglTrans">Periode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control form-control-sm float-right reservation" id="searchTglTrans" name="searchTglTrans">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_supplier">Supplier</label>
                            <select class="form-control select2bs4" name="sel_supplier" id="sel_supplier" style="width: 100%;" required>   
                                @foreach($allSupplier as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                            <button class="btn btn-primary btn-sm" name="tbl-export" id="tbl-export" onclick="goExport('table_penjualan', 'laporan_penjualan')"><i class="fa fa-table"></i> Export</button>
                            <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                <i class="fa fa-asterisk fa-spin text-info"></i>
                            </button>
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
                                <td style="text-align: left;" colspan="10"><h4>Laporan Pembayaran Hutang</h4>
                                <p class="lbl_periode"></p>
                                <p class="lbl_supplier"></p>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 10%; text-align: center;">No.Bayar</th>
                                <th style="width: 10%; text-align: center;">Tgl.Bayar</th>
                                <th>Supplier</th>
                                <th style="width: 15%; text-align: center;">Nominal</th>
                                <th style="width: 10%;">Keterangan</th>
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
        var selSupplier = $("#sel_supplier").val();
        var tgl_transaksi = $("#searchTglTrans").val().split(' - ');
        var arr_tgl_1 = tgl_transaksi[0].split('-');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = tgl_transaksi[1].split('-');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        var ket_periode = tgl_transaksi[0]+" s/d "+tgl_transaksi[1];
        var obj = {};
        obj.tgl_1 = tgl_1;
        obj.tgl_2 = tgl_2;
        obj.selSupplier = selSupplier;
        obj.ket_periode = ket_periode;
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route("laporanHutangFilter"),
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
                $(".lbl_supplier").html(response.supplier);
                $("#loaderDiv").hide();
            }
        });
        // return false;
    };

    var goPrint = function ()
    {
        var tgl_transaksi = $("#searchTglTrans").val().split(' - ');
        var arr_tgl_1 = tgl_transaksi[0].split('-');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = tgl_transaksi[1].split('-');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        var selSupplier = ($("#sel_supplier").val()==null) ? 'null' : $("#sel_supplier").val();
        window.open(route('laporanHutangPrint', [tgl_1, tgl_2, selSupplier]), "_blank");
    }

</script>
@endsection

