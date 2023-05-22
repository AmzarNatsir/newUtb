@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('breadcrumb', 'Kartu Stok')
@section('content')
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
</style>
<section class="content">
    <!-- Default box -->
    <div class="card">
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
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="fas fa-search"></i> Klik untuk memulai pencarian produk
                        </a>
                        <div class="navbar-search-block">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" name="inputSearch" id="inputSearch" placeholder="Masukkan Nama Obat" aria-label="Search" autocomplete="off">
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
                        <div class="form-group col-md-12">
                            <label for="searchTglTrans">Tanggal Transaksi</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control form-control-sm float-right reservation" id="searchTglTrans" name="searchTglTrans">
                                <input type="hidden" name="id_stok" id="id_stok">
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>
                        <div class="form-group col-md-12">
                            <button class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                            <button class="btn btn-danger btn-sm" name="tbl-print" id="tbl-print" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
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
                                    <h5 class="description-header text-info stok_awal">0</h5>
                                    <span class="description-text">STOK AWAL</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                    <h5 class="description-header text-warning stok_masuk">0</h5>
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
                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fa fa-table"></i> Rincian Stok Masuk</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover" style="width: 100%;">
                                        <thead>
                                            <th style="width: 10%;">No.</th>
                                            <th style="width: 30%;">No.Trans</th>
                                            <th>Tgl.Trans</th>
                                            <th style="width: 20%;" class="text-center">Qty</th>
                                        </thead>
                                        <tbody class="all_items_beli">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fa fa-table"></i> Rincian Stok Keluar</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover" style="width: 100%;">
                                        <thead>
                                            <th style="width: 10%;">No.</th>
                                            <th style="width: 30%;">No.Trans</th>
                                            <th>Tgl.Trans</th>
                                            <th style="width: 20%;" class="text-center">Qty</th>
                                        </thead>
                                        <tbody class="all_items_jual">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
                    success: function( data ) {
                        response(data);
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
</script>
@endsection

