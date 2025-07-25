@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
@section('content')
@routes
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">Aktifitas hari ini</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pembelian</span>
                                    <span class="info-box-number">Rp. </span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Penjualan</span>
                                    <span class="info-box-number">Rp. </span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Return Pembelian</span>
                                    <span class="info-box-number">Rp. </span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Return Penjualan</span>
                                    <span class="info-box-number">Rp. </span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
            </div>
          <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">Produk Terlaris</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-header" style="margin-top: 20px;">
                                    <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="selBulan_1" class="col-sm-12 col-form-label">Periode</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8">
                                            <select class="form-control" name="selBulan_1" id="selBulan_1" style="width: 100%;" required>
                                            @foreach($list_bulan as $key => $bulan)
                                            <option value="{{ $key }}" {{ (sprintf('%02s', $key)==date("m")) ? 'selected' : '' }}>{{ $bulan }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control"  name="inpTahun_1" id="inpTahun_1">
                                                @foreach($list_tahun as $thn)
                                                    @if($thn==date("Y"))
                                                    <option value="{{ $thn }}" selected>{{ $thn }}</option>
                                                    @else
                                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" name="tbl-filter_1" id="tbl-filter_1" onclick="goFilterProdukTerlaris()"><i class="fa fa-search"></i> Filter</button>
                                        <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                            <i class="fa fa-asterisk fa-spin text-info"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div id="spinner-div-1" class="pt-5 justify-content-center spinner-div">
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                                <div id="dash_1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Penjualan</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-header" style="margin-top: 20px;">
                                    <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inpTahun_2" class="col-sm-12 col-form-label">Periode</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <select class="form-control"  name="inpTahun_2" id="inpTahun_2">
                                                @foreach($list_tahun as $thn)
                                                    @if($thn==date("Y"))
                                                    <option value="{{ $thn }}" selected>{{ $thn }}</option>
                                                    @else
                                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success" name="tbl-filter_2" id="tbl-filter_2" onclick="goFilterPenjualan()"><i class="fa fa-search"></i> Filter</button>
                                                <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                                    <i class="fa fa-asterisk fa-spin text-info"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div id="spinner-div-2" class="pt-5 justify-content-center spinner-div">
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                                <div id="dash_2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <!-- ./col -->
        </div>
        <div class="row">
        <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Pembelian</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-header" style="margin-top: 20px;">
                                    <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inpTahun_3" class="col-sm-12 col-form-label">Periode</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <select class="form-control"  name="inpTahun_3" id="inpTahun_3">
                                                @foreach($list_tahun as $thn)
                                                    @if($thn==date("Y"))
                                                    <option value="{{ $thn }}" selected>{{ $thn }}</option>
                                                    @else
                                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success" name="tbl-filter_3" id="tbl-filter_3" onclick="goFilterPembelian()"><i class="fa fa-search"></i> Filter</button>
                                                <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                                    <i class="fa fa-asterisk fa-spin text-info"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div id="spinner-div-3" class="pt-5 justify-content-center spinner-div">
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                                <div id="dash_3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        {{-- <div class="row">
        <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Stok</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
        <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Hutang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
        <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Piutang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        <!-- /.col -->
        </div> --}}
        <!-- /.row -->
        <input type="hidden" id="temp_array" class="form-control">
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->
<script>
    $(function(){
        $('#spinner-div-1').show();
        $('#spinner-div-2').show();
        $('#spinner-div-3').show();
        // $(document)
        //     .ajaxStart(function () {
        //     $loading_1.show();
        //     $loading_2.show();
        // })
        //     .ajaxStop(function () {
        //     $loading_1.hide();
        //     $loading_2.hide();
        // });
        const d = new Date();
        let bulan = d.getMonth()+1;
        let tahun = d.getFullYear();
        $("#dash_1").load(route('dashboarTopTen', [bulan, tahun]), function() {
            $('#spinner-div-1').hide();
        });
        $("#dash_2").load(route('dashboarPenjualan', tahun), function() {
            $('#spinner-div-2').hide();
        });
        $("#dash_3").load(route('dashboarPembelian', tahun), function() {
            $('#spinner-div-3').hide();
        });
    });
    var goFilterProdukTerlaris = function()
    {
        $('#spinner-div-1').show();
        let bulan = $("#selBulan_1").val();
        let tahun = $("#inpTahun_1").val();
        $("#dash_1").load(route('dashboarTopTen', [bulan, tahun]), function() {
            $('#spinner-div-1').hide();
        });
    }
    var goFilterPenjualan = function()
    {
        $('#spinner-div-2').show();
        let tahun = $("#inpTahun_2").val();
        $("#dash_2").load(route('dashboarPenjualan', tahun), function() {
            $('#spinner-div-2').hide();
        });
    }
    var goFilterPembelian = function()
    {
        $('#spinner-div-3').show();
        let tahun = $("#inpTahun_3").val();
        $("#dash_3").load(route('dashboarPembelian', tahun), function () {
            $('#spinner-div-3').hide();
        });
    }
</script>
@endsection
