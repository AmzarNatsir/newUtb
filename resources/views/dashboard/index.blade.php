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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Summary Periode :</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="description-block border-right inner">
                                    <span class="description-header"> 0 Items</span>
                                    <h5 class="description-header">Rp. 0</h5>
                                    <span class="description-text">Penjualan Tunai</span>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="description-block border-right inner">
                                    <span class="description-header"> 0 Items</span>
                                    <h5 class="description-header">Rp. 0</h5>
                                    <span class="description-text">Penjualan Kredit</span>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="description-block border-right inner">
                                    <span class="description-header"> 0</span>
                                    <h5 class="description-header">Rp. </h5>
                                    <span class="description-text">GRAND TOTAL</span>
                                </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        
                    </div>

                    

                </div>
            </div>
          <!-- ./col -->
        </div>
        
        <div class="row">
        <!-- /.col -->
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-header">
                        <h5 class="card-title">Summary Periode {{ date('Y') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="description-block border-right inner">
                                        <span class="description-percentage"> 0 Items</span>
                                        <h5 class="description-header">Rp. 0</h5>
                                        <span class="description-text">Penjualan Tunai</span>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="description-block border-right inner">
                                        <span class="description-percentage"> 0 Items</span>
                                        <h5 class="description-header">Rp. 0</h5>
                                        <span class="description-text">Penjualan Kredit</span>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-4">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="description-block border-right inner">
                                        <span class="description-percentage"> 0 Items</span>
                                        <h5 class="description-header">Rp. 0</h5>
                                        <span class="description-text">GRAND TOTAL</span>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <div class="card-footer">
                        <div class="row"></div>
                        <!-- /.row -->
                        </div>
                    </div>
                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <h5 class="card-title">Penjualan Periode Tahun {{ date('Y') }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div> -->
                        <figure class="highcharts-figure">
                        <div id="container"></div>
                        </figure>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card card-danger">
                    <div class="card-header border-0">
                        <h3 class="card-title"><strong>10 Produk Terlaris Periode {{ date('Y') }}</strong></h3>
                    </div>
                    <div class="card-body">
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
