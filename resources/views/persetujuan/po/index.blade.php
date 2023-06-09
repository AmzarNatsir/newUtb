@extends('layouts.app')
@section('title', 'Persetujuan')
@section('breadcrumb', 'Purchase Order')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Persetujuan Purchase Order</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input class="form-control dtpicker input-sm" id="searchTglTrans_1" name="searchTglTrans_1" type="text" placeholder="Tanggal Awal">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input class="form-control dtpicker input-sm" id="searchTglTrans_2" name="searchTglTrans_2" type="text" placeholder="Tanggal Akhir">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="button" class="btn btn-success" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                                    <button class="btn btn-danger" type="button" id="loaderDiv" style="display: none">
                                        <i class="fa fa-asterisk fa-spin text-info"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover datatable ListData" style="font-size: 11pt; width: 100%;">
                            <thead>
                            <tr>
                                <th style="width: 15%; text-align: center;">Act</th>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 10%; text-align: center;">No.PO</th>
                                <th style="width: 10%; text-align: center;">Tanggal PO</th>
                                <th>Supplier</th>
                                <th style="width: 10%; text-align: center;">Total PO</th>
                                <th style="width: 10%; text-align: center;">Metode Bayar</th>
                                <th style="width: 15%; text-align: left;">Keterangan</th>
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
    $(function(){
        $(".viewList").load(route('persetujuanPOData'));
        $(".ListData").on("click", '#tbl_approve', function()
        {
            var id_data = this.value;
            $("#frm_modal").load(route('persetujuanPOApprove', id_data));
        });

        $(".ListData").on("click", '#tbl_approve_2', function()
        {
            var id_data = this.value;
            $("#frm_modal").load(route('persetujuanPOApprove_2', id_data));
        });
    });
    var goFilter = function()
    {
        $("#loaderDiv").show();
        var arr_tgl_1 = $("#searchTglTrans_1").val().split('/');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = $("#searchTglTrans_2").val().split('/');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        var ket_periode = $("#searchTglTrans_1").val()+" s/d "+$("#searchTglTrans_2").val();
        $(".viewList").load(route('persetujuanPOFilter', [tgl_1, tgl_2]));
        $("#loaderDiv").hide();
        
    };
</script>
@endsection

