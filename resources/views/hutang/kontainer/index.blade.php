@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Hutang Kontainer')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Pembayaran Hutang Kontainer</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('pembayaranHutangKontainerStore') }}" method="post" onsubmit="return konfirm()">
        {{csrf_field()}}
        <input type="hidden" name="id_receive" id="id_receive">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sel_kontainer">Kontainer</label>
                            <select class="form-control select2bs4" name="sel_kontainer" id="sel_kontainer" style="width: 100%;" required>   
                                @foreach($allKontainer as $kontainer)
                                <option value="{{ $kontainer->id }}">{{ $kontainer->nama_kontainer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-sm" name="tbl-filter" id="tbl-filter" onclick="goFilter()"><i class="fa fa-search"></i> Filter</button>
                            <button class="btn btn-danger btn-sm" type="button" id="loaderDiv" style="display: none">
                                <i class="fa fa-asterisk fa-spin text-info"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-list"></i> Summary Hutang</h3>
                    </div>
                    <div class="card-body">
                        <div class="row profil_supplier">
                            <div class="col-md-12">
                                <!-- Widget: user widget style 2 -->
                                <div class="card card-widget widget-user-2">
                                    <div class="card-footer p-0">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                Jumlah Invoice <span class="float-right badge bg-primary t_invoice">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                Total Hutang <span class="float-right badge bg-info t_hutang">Rp. 0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                Total Terbayar <span class="float-right badge bg-success t_terbayar">Rp. 0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                Total Oustanding <span class="float-right badge bg-danger t_outstanding">Rp. 0</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-table"></i> Daftar Invoice</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive datatable" style="font-size: 10pt; width: 100%;" id="table_list_invoice">
                            <thead>
                            <th style="width: 5%;">No</th>
                            <th>Inv. Kontainer</th>
                            <th style="width: 15%;">Tgl. Tiba</th>
                            <th style="width: 15%; text-align: right">Total&nbsp;Invoice</th>
                            <th style="width: 15%; text-align: right">Oustanding</th>
                            <th style="width: 23%;"></th>
                            </thead>
                            <tbody class="viewList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-edit"></i> Form Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        @if (Session::has('message'))
                        <div class="alert alert-info alert-dismissible" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
                            {!! session('message') !!}
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="inpPpembayaranKe" class="col-sm-4 col-form-label">Pembayaran Ke</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="inpPembayaranKe" id="inpPembayaranKe" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inpNoInvoice" class="col-sm-4 col-form-label">Nomor Invoice</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="inpNoInvoice" id="inpNoInvoice" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inpTotalInvoice" class="col-sm-4 col-form-label">Total Invoice</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control angka" name="inpTotalInvoice" id="inpTotalInvoice" style="text-align: right" value="0" readonly>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-group row">
                            <label for="inpTglBayar" class="col-sm-4 col-form-label">Tgl. Bayar</label>
                            <div class="col-sm-8">
                                <div class="input-group date" id="inp_tgl_jatuh_tempo">
                                    <input type="text" class="form-control datetimepicker-input datepicker" id="inpTglBayar" name="inpTglBayar" value="{{ date('d/m/Y') }}" disabled />
                                    <div class="input-group-append" >
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="selCaraBayar" class="col-sm-4 col-form-label">Metode Pembayaran</label>
                            <div class="col-sm-8">
                                <select class="form-control select2bs4" name="selCaraBayar" id="selCaraBayar" style="width: 100%;" disabled>
                                    <option value="1">Tunai</option>
                                    <option value="2">Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-group row">
                            <label for="inpTerhutang" class="col-sm-4 col-form-label">Terhutang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control angka" name="inpTerhutang" id="inpTerhutang" style="text-align: right" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inpBayar" class="col-sm-4 col-form-label">Nilai Pembayaran</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control angka" name="inpBayar" id="inpBayar" style="text-align: right" value="0" onkeyup="getSisaHutang(this)" onblur="changeToNull(this)" disabled />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inpSisaHutang" class="col-sm-4 col-form-label">Sisa Hutang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control angka" name="inpSisaHutang" id="inpSisaHutang" style="text-align: right" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inpKeterangan">Keterangan</label>
                            <textarea class="form-control" name="inpKeterangan" id="inpKeterangan" disabled></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-outline-primary btn-block btn-sm" id="tbl_submit" disabled >Bayar</button>
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
<!-- Modal -->
<div class="modal fade" id="modal-form" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        reset_teks();
        aktif_teks(true);
    });
    var goFilter = function()
    {
        var kontainer = $("#sel_kontainer").val();
        reset_teks();
        aktif_teks(true);
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route("pembayaranHutangKontainerFilter"),
            method : 'post',
            dataType: "json",
            data: {kontainer : kontainer},
            beforeSend: function()
            {
                $(".viewList").empty();
                $(".t_invoice").empty();
                $(".t_hutang").empty();
                $(".t_terbayar").empty;
                $(".t_outstanding").empty();
                $("#loaderDiv").show();
            },
            success: function(response)
            {
                $(".viewList").html(response.all_result);
                $(".t_invoice").html(response.totalInvoice);
                $(".t_hutang").html('Rp. '+response.totalHutang);
                $(".t_terbayar").html('Rp. '+response.totalTerbayar);
                $(".t_outstanding").html('Rp. '+response.sisaOutstanding);
                $("#loaderDiv").hide();
            }
        });
    }

    var goBayar = function(id_receive)
    {
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route("pembayaranHutangKontainerBayar"),
            method : 'post',
            dataType: "json",
            data: {id_receive : id_receive},
            beforeSend: function()
            {
                reset_teks();
                aktif_teks(true);
                $("#loaderDiv2").show();
            },
            success: function(response)
            {
                $("#id_receive").val(response.id_receive);
                $("#inpPembayaranKe").val(response.nama_kontainer);
                $("#inpNoInvoice").val(response.no_invoice);
                $("#inpTotalInvoice").val(response.total_invoice_net);
                $("#inpTerhutang").val(response.total_terhutang);
                $("#inpBayar").val(response.total_terhutang);
                $("#inpSisaHutang").val(response.total_terhutang);
                aktif_teks(false);
                $("#loaderDiv2").hide();
            }
        });
    }

    var changeToNull = function(el)
    {
        var n_terhutang = $("#inpTerhutang").val();
        if($(el).val()=="" || $(el).val()== 0)
        {
            $(el).val(n_terhutang);
            $("#inpSisaHutang").val(n_terhutang);
        }
        
    }

    var getSisaHutang = function(el)
    {
        var n_terhutang = $("#inpTerhutang").val();
        var n_bayar = $(el).val();
        var n_sisa = n_terhutang - n_bayar;

        if(parseFloat(n_bayar) > parseFloat(n_terhutang)) {
            $(el).css('background-color', 'red');
            $(el).css('color', 'white');
            $("#tbl_submit").attr('disabled', true);
        } else {
            $(el).css('background-color', 'white');
            $(el).css('color', 'black');
            $("#tbl_submit").attr('disabled', false);
        }

        $("#inpSisaHutang").val(n_sisa);
    }

    var goMutasi = function(el)
    {
        var id_receiving = el;
        $("#frm_modal").load(route('pembayaranHutangKontainerMutasi', id_receiving));
    }

    function reset_teks()
    {
        $("#id_receive").val("");
        $("#inpPembayaranKe").val("");
        $("#inpNoInvoice").val("");
        $("#inpTotalInvoice").val("0");
        $("#inpTerhutang").val("0");
        $("#inpBayar").val("0");
        $("#inpSisaHutang").val("0");
        $("#inpKeterangan").val("");
        $("#inpTglBayar").val(moment().format('DD/MM/YYYY'));
    }

    function aktif_teks(tf)
    {
        $("#inpTglBayar").attr('disabled', tf);
        $("#selCaraBayar").attr('disabled', tf);
        $("#inpBayar").attr('disabled', tf);
        $("#inpKeterangan").attr('disabled', tf);
        $("#tbl_submit").attr('disabled', tf);
    }

    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection

