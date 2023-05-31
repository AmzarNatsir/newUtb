@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="css">
    #container {
  height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}

.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</script>
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Penjualan</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pembelian</span>
                                    <span class="info-box-number">760</span>
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
                                    <span class="info-box-number">760</span>
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
                                    <span class="info-box-number">760</span>
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
                                    <span class="info-box-number">760</span>
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
        <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Pembelian</h5>
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
        </div>
        <!-- /.row -->
        <input type="hidden" id="temp_array" class="form-control">
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
