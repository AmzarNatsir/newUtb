@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Penjualan')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Penjualan</h3>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
        <div class="alert alert-info alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
            {!! session('message') !!}
        </div>
        @endif
        <form action="{{ route('penjualanStore') }}" method="post" onsubmit="return konfirm()">
        {{csrf_field()}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-plus"></i> Item Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group" id="seacrhItem">
                                        <input type="text" class="form-control form-control-sm" name="inputSearch" id="inputSearch" placeholder="Masukkan Nama Produk" autocomplete="off">
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="row">
                                <div class="col-sm-12" style="overflow-y: auto; max-height: 100vh">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-vcenter" id="list_item" style="font-size: 13px">
                                            <tr>
                                                <th rowspan="2" class="text-center" style="width: 3%; vertical-align: middle;">Act</th>
                                                <th rowspan="2" style="width: 16%; vertical-align: middle;">Nama Produk</th>
                                                <th colspan="3" class="text-center">Satuan</th>
                                                <th rowspan="2" class="text-right" style="width: 10%; vertical-align: middle;" >Sub Total (Rp.)</th>
                                                <th colspan="2" class="text-center">Potongan</th>
                                                <th rowspan="2" class="text-right" style="width: 10%;vertical-align: middle;">Sub Total Net (Rp.)</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 10%">Satuan</th>
                                                <th class="text-center" style="width: 10%">Qty</th>
                                                <th class="text-center" style="width: 10%">Harga Satuan</th>
                                                <th class="text-center" style="width: 5%">%</th>
                                                <th class="text-center" style="width: 10%">Nilai</th>
                                            </tr>
                                            <tbody class="row_baru"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="sel_customer">Customer</label>
                                <select class="form-control select2bs4" name="sel_customer" id="sel_customer" style="width: 100%;" required>
                                <option></option> 
                                @foreach($allCustomer as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama_customer }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="inp_carabayar" class="col-sm-3 col-form-label">Pembayaran Via</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2bs4" name="inp_carabayar" id="inp_carabayar" style="width: 100%;" required>
                                        <option value="1">Tunai</option>
                                        <option value="2">Kredit</option>
                                    </select>
                                </div>
                                <label for="inpJatuhTempo" class="col-sm-3 col-form-label">Jatuh Tempo</label>
                                <div class="col-sm-3">
                                    <div class="input-group date" id="reservationdate">
                                        <input type="text" class="form-control datetimepicker-input datepicker" id="inpTglJatuhTempo" name="inpTglJatuhTempo">
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inp_keterangan">Keterangan</label>
                                <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-outline-success btn-block btn-sm" id="tbl_submit">Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputTotal" class="col-sm-6 col-form-label text-right">Total</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTotal_DiskPersen" class="col-sm-6 col-form-label text-right">Diskon (%)</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalPersen(this)">
                                </div>
                                <label for="inputTotal_DiskRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalNilai(this)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTotal_PpnPersen" class="col-sm-6 col-form-label text-right">Ppn (%)</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalPersen(this)">
                                </div>
                                <label for="inputTotal_PpnRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalNilai(this)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputOngkosKirim" class="col-sm-6 col-form-label text-right">Ongkos Kirim</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" id="inputOngkosKirim" name="inputOngkosKirim" value="0" onkeyup="hitOngkir(this)" style="text-align: right;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTotalNet" class="col-sm-6 col-form-label text-right">Total Net</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/penjualan/penjualan.js') }}"></script>
@endsection




