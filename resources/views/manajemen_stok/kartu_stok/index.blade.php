@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('breadcrumb', 'Kartu Stok')
@section('content')
@routes;
<!-- @routes -->
<!-- content -->
<style type="text/css">
html .ui-autocomplete { width:1px; } /* without this, the menu expands to 100% in IE6 */
    .ui-menu {
        list-style:none;
        padding: 2px;
        margin: 0;
        display:block;
        float: left;
    }
    .ui-menu .ui-menu {
        margin-top: -3px;
    }
    .ui-menu .ui-menu-item {
        margin:0;
        padding: 0;
        zoom: 1;
        float: left;
        clear: left;
        width: 100%;
    }
    .ui-menu .ui-menu-item a {
        text-decoration:none;
        display:block;
        padding:.2em .4em;
        line-height:1.5;
        zoom:1;
    }
    .ui-menu .ui-menu-item a.ui-state-hover,
    .ui-menu .ui-menu-item a.ui-state-active {
        font-weight: normal;
        margin: -1px;
    }
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
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Kartu Stok</h3>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
        <div class="alert alert-info alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
            {!! session('message') !!}
        </div>
        @endif
        <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="col-md-12">
                    <div class="card-body">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="fas fa-search"></i> Klik untuk memulai pencarian produk
                        </a>
                        <div class="navbar-search-block">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" name="inputSearch" id="inputSearch" placeholder="Masukkan Nama Produk" aria-label="Search" autocomplete="off">
                                <input type="hidden" name="id_stok" id="id_stok">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input class="form-control dtpicker input-sm" id="searchTglTrans_1" name="searchTglTrans_1" type="text" placeholder="Tanggal Awal" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input class="form-control dtpicker input-sm" id="searchTglTrans_2" name="searchTglTrans_2" type="text" placeholder="Tanggal Akhir" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-success" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                                    <button class="btn btn-danger" name="tbl-print" id="tbl-print" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-body">
                        <div class="row">
                            <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left;"><h4>KARTU STOK</h4>
                                <p id="lbl_periode"></p></td>
                            </tr>
                            </table>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">Kode</td>
                                <td style="width: 30%;">: <label class="kode"></label></label></td>
                                <td style="width: 20%;">Merk</td>
                                <td style="width: 30%;">: <label class="nama_merk"></td>
                            </tr>
                            <tr>
                                <td>Nama Produk</td>
                                <td>: <label class="nama_produk"></label></td>
                                <td>Kemasan</td>
                                <td>: <label class="kemasan"></label></td>
                            </tr>
                            </table>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                    <h5 class="description-header text-warning stok_awal">0</h5>
                                    <span class="description-text">STOK AWAL</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                    <h5 class="description-header text-primary stok_masuk">0</h5>
                                    <span class="description-text">STOK MASUK</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                    <h5 class="description-header text-success stok_keluar">0</h5>
                                    <span class="description-text">STOK KELUAR</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                    <h5 class="description-header text-danger stok_akhir">0</h5>
                                    <span class="description-text">STOK AKHIR</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fa fa-table"></i> Rincian Stok Masuk</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table style="font-size: 10pt; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 50%;" class="text-center">Receiving</th>
                                                <th style="width: 50%;" class="text-center">Return Penjualan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <table class="table" style="font-size: 10pt; width: 100%;" border='1'>
                                                    <thead>
                                                        <th style="width: 5%;">No.</th>
                                                        <th style="width: 25%;">Tanggal</th>
                                                        <th style="width: 20%;" class="text-center">Qty</th>
                                                    </thead>
                                                    <tbody class="all_items_beli"></tbody>
                                                    </table>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <table class="table" style="font-size: 10pt; width: 100%;" border='1'>
                                                    <thead>
                                                        <th style="width: 5%;">No.</th>
                                                        <th style="width: 25%;">Tanggal</th>
                                                        <th style="width: 20%;" class="text-center">Qty</th>
                                                    </thead>
                                                    <tbody class="all_items_return_jual"></tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="total_masuk"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fa fa-table"></i> Rincian Stok Keluar</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                    <table style="font-size: 10pt; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 34%;" class="text-center">Penjualan</th>
                                                <th style="width: 33%;" class="text-center">Return Pembelian</th>
                                                <th style="width: 33%;" class="text-center">Pemberian Sampel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <table class="table" style="font-size: 10pt; width: 100%;" border='1'>
                                                    <thead>
                                                        <th style="width: 5%;">No.</th>
                                                        <th style="width: 25%;">Tanggal</th>
                                                        <th style="width: 20%;" class="text-center">Qty</th>
                                                    </thead>
                                                    <tbody class="all_items_jual"></tbody>
                                                    </table>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <table class="table" style="font-size: 10pt; width: 100%;" border='1'>
                                                    <thead>
                                                        <th style="width: 5%;">No.</th>
                                                        <th style="width: 25%;">Tanggal</th>
                                                        <th style="width: 20%;" class="text-center">Qty</th>
                                                    </thead>
                                                    <tbody class="all_items_return_beli"></tbody>
                                                    </table>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <table class="table" style="font-size: 10pt; width: 100%;" border='1'>
                                                    <thead>
                                                        <th style="width: 5%;">No.</th>
                                                        <th style="width: 25%;">Tanggal</th>
                                                        <th style="width: 20%;" class="text-center">Qty</th>
                                                    </thead>
                                                    <tbody class="all_items_pemberian_sampel"></tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="total_keluar"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#spinner-div').hide();
        $("#inputSearch").autocomplete({
            source: function(request, response) {
                //Fetch data
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
				    url: "{{ route('searchItemKartuStok') }}",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    beforeSend: function()
                    {
                        $('#spinner-div').show();
                    },
                    success: function( data ) {
                        response(data);
                    },
                    complete: function()
                    {
                        $('#spinner-div').hide();
                    }

                });
            },
            select: function(event, ui) {
                $("#inputSearch").val(ui.item.label);
                $("#id_stok").val(ui.item.value);
                //infor
                $(".nama_produk").html(ui.item.nama_produk);
                $(".kode").html(ui.item.kode);
                $(".nama_merk").html(ui.item.merk);
                $(".kemasan").html(ui.item.kemasan+" "+ui.item.satuan);
                return false;
            }
        });
    });

    var goFilter = function()
    {
        var arr_tgl_1 = $("#searchTglTrans_1").val().split('/');
        var tgl_1 = arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0];
        var arr_tgl_2 = $("#searchTglTrans_2").val().split('/');
        var tgl_2 = arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0];
        var ket_periode = $("#searchTglTrans_1").val()+" s/d "+$("#searchTglTrans_2").val();
        var id_stok = $("#id_stok").val();
        var obj = {};
        obj.tgl_1 = tgl_1;
        obj.tgl_2 = tgl_2;
        obj.id_stok = id_stok;
        obj.ket_periode = ket_periode;
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('KartuStokFilter'),
            contentType: "application/json",
            method : 'post',
            dataType: "json",
            data: JSON.stringify(obj),
            beforeSend: function()
            {
                $(".all_items_beli").empty();
                $(".all_items_return_jual").empty();
                $(".all_items_jual").empty();
                $(".all_items_pemberian_sampel").empty();
                $(".all_items_return_beli").empty();
                $('#spinner-div').show();
            },
            success: function(response)
            {
                $("#lbl_periode").html(response.periode);
                $(".stok_awal").html(response.stok_awal);
                $(".stok_masuk").html(response.stok_masuk);
                $(".stok_keluar").html(response.stok_keluar);
                $(".stok_akhir").html(response.stok_akhir);
                var nom=1;
                var total_1=0;
                $.each(response.rincian_beli, function(key, dataItems) {
                    var createdDate = new Date(dataItems.tanggal_receive);
                    var tgl_transaksi = createdDate.getDate().toString().padStart(2, 0) + "/" + (createdDate.getMonth() + 1).toString().padStart(2, 0) + "/" + createdDate.getFullYear();
                    $(".all_items_beli").append("<tr>\
                        <td>"+nom+"</td>\
                        <td>"+tgl_transaksi+"</td>\
                        <td style='text-align: center'>"+dataItems.qty+"</td>\
                    </tr>");
                    total_1+=parseInt(dataItems.qty);
                    nom++;
                });
                $(".all_items_beli").append("<tr style='background: #ffecb3'>\
                    <td colspan='2'><b>Total Receiving</b></td>\
                    <td style='text-align: center'><b>"+total_1+"</b></td>\
                </tr>");
                //return jual
                var nom=1;
                var total_2=0;
                $.each(response.rincian_return_jual, function(key, dataItems) {
                    var createdDate = new Date(dataItems.tgl_return);
                    var tgl_transaksi = createdDate.getDate().toString().padStart(2, 0) + "/" + (createdDate.getMonth() + 1).toString().padStart(2, 0) + "/" + createdDate.getFullYear();
                    $(".all_items_return_jual").append("<tr>\
                        <td>"+nom+"</td>\
                        <td>"+tgl_transaksi+"</td>\
                        <td style='text-align: center'>"+dataItems.qty+"</td>\
                    </tr>");
                    total_2+=parseInt(dataItems.qty);
                    nom++;
                });
                $(".all_items_return_jual").append("<tr style='background: #ffecb3'>\
                    <td colspan='2'><b>Total Return</b></td>\
                    <td style='text-align: center'><b>"+total_2+"</b></td>\
                </tr>");
                $(".total_masuk").html("TOTAL STOK MASUK : "+ (total_1 + total_2));
                //keluar
                var nom=1;
                var total_3=0;
                $.each(response.rincian_jual, function(key, dataItems) {
                    var createdDate = new Date(dataItems.tgl_invoice);
                    var tgl_transaksi = createdDate.getDate().toString().padStart(2, 0) + "/" + (createdDate.getMonth() + 1).toString().padStart(2, 0) + "/" + createdDate.getFullYear();

                    $(".all_items_jual").append("<tr>\
                        <td>"+nom+"</td>\
                        <td>"+tgl_transaksi+"</td>\
                        <td style='text-align: center'>"+dataItems.qty+"</td>\
                    </tr>");
                    total_3+=parseInt(dataItems.qty);
                    nom++;
                });
                $(".all_items_jual").append("<tr style='background: #99ffbb'>\
                    <td colspan='2'><b>Total Penjualan</b></td>\
                    <td style='text-align: center'><b>"+total_3+"</b></td>\
                </tr>");
                //pemberian sampel
                var nom=1;
                var total_4=0;
                $.each(response.rincian_sampel, function(key, dataItems) {
                    var createdDate = new Date(dataItems.tgl_invoice);
                    var tgl_transaksi = createdDate.getDate().toString().padStart(2, 0) + "/" + (createdDate.getMonth() + 1).toString().padStart(2, 0) + "/" + createdDate.getFullYear();

                    $(".all_items_pemberian_sampel").append("<tr>\
                        <td>"+nom+"</td>\
                        <td>"+tgl_transaksi+"</td>\
                        <td style='text-align: center'>"+dataItems.qty+"</td>\
                    </tr>");
                    total_4+=parseInt(dataItems.qty);
                    nom++;
                });
                $(".all_items_pemberian_sampel").append("<tr style='background: #99ffbb'>\
                    <td colspan='2'><b>Total Pembr. Sampel</b></td>\
                    <td style='text-align: center'><b>"+total_4+"</b></td>\
                </tr>");
                //return beli
                var nom=1;
                var total_5=0;
                $.each(response.rincian_return_beli, function(key, dataItems) {
                    var createdDate = new Date(dataItems.tgl_return);
                    var tgl_transaksi = createdDate.getDate().toString().padStart(2, 0) + "/" + (createdDate.getMonth() + 1).toString().padStart(2, 0) + "/" + createdDate.getFullYear();

                    $(".all_items_return_beli").append("<tr>\
                        <td>"+nom+"</td>\
                        <td>"+tgl_transaksi+"</td>\
                        <td style='text-align: center'>"+dataItems.qty+"</td>\
                    </tr>");
                    total_5+=parseInt(dataItems.qty);
                    nom++;
                });
                $(".all_items_return_beli").append("<tr style='background: #99ffbb'>\
                    <td colspan='2'><b>Total Return</b></td>\
                    <td style='text-align: center'><b>"+total_5+"</b></td>\
                </tr>");
                $(".total_keluar").html("TOTAL STOK KELUAR : "+ (total_3 + total_4 + total_5));
                $("#loaderDiv").hide();
            },
            complete: function()
            {
                $('#spinner-div').hide();
            }
        });
    }
</script>
@endsection

