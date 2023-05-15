@extends('layouts.app')
@section('title', 'Pelaporan')
@section('breadcrumb', 'Laporan Pembelian')
@section('content')
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
                        <div class="form-group col-md-3">
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
                        <div class="form-group col-md-3">
                            <button class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                            <button class="btn btn-danger btn-sm" name="tbl-print" id="tbl-print" onclick="goPrint()"><i class="fa fa-print"></i> Print</button>
                            <button class="btn btn-primary btn-sm" name="tbl-export" id="tbl-export" onclick="goExport('table_penjualan', 'laporan_penjualan')"><i class="fa fa-table"></i> Export</button>
                            <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                <i class="fa fa-asterisk fa-spin text-info"></i>
                            </button>
                        </div>
                        <div class="form-group col-md-6">
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
            <div class="col-md-7">
                <div class="card card-warning">
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-responsive" style="font-size: 12pt; width: 100%;">
                            <thead>
                            <tr>
                                <td style="text-align: left;" colspan="9"><h4>Laporan Pembelian</h4>
                                <p class="lbl_periode"></p>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">Act</th>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 10%; text-align: center;">Tgl.Invoce</th>
                                <th style="width: 10%; text-align: center;">No.Invoce</th>
                                <th>Supplier</th>
                                <th style="width: 15%; text-align: center;">Total</th>
                                <th style="width: 5%; text-align:right">Diskon</th>
                                <th style="width: 5%; text-align:right">Ppn</th>
                                <th style="width: 15%; text-align:right">Total Net</th>
                            </tr>
                            </thead>
                            <tbody class="viewList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-warning">
                    <div class="card-body">
                        <table class="table table-bordered table-hover  table-responsive" style="font-size: 10pt; width: 100%;" id="table_penjualan">
                            <thead>
                            <tr>
                                <td style="text-align: left;" colspan="9"><h4>Summary Pembelian</h4>
                                <p class="lbl_periode_summary"></p>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 5%; text-align: center;">No.</th>
                                <th style="width: 20%; text-align: center;">Kode</th>
                                <th>Nama Produk</th>
                                <th style="width: 10%; text-align: center;">Qty</th>
                                <th style="width: 20%; text-align:right">Harga</th>
                            </tr>
                            </thead>
                            <tbody class="viewListSummary"></tbody>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
@endsection

