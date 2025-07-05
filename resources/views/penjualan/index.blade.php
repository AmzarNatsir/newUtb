@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Penjualan')
@section('content')
@routes
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
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>
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
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-vcenter" id="list_item" style="font-size: 13px; width: 100%;" cellpadding='3'>
                                            <tr>
                                                <th rowspan="2" class="text-center" style="width: 3%; vertical-align: middle;">Act</th>
                                                <th rowspan="2" style="width: 16%; vertical-align: middle;">Nama Produk</th>
                                                <th colspan="4" class="text-center">Satuan</th>
                                                <th rowspan="2" class="text-right" style="width: 10%; vertical-align: middle;" >Sub Total (Rp.)</th>
                                                <th colspan="2" class="text-center">Potongan</th>
                                                <th rowspan="2" class="text-right" style="width: 10%;vertical-align: middle;">Sub Total Net (Rp.)</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 10%">Satuan</th>
                                                <th class="text-center" style="width: 8%">Qty</th>
                                                <th class="text-center" style="width: 10%">Kat.Harga</th>
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
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inp_tgl_trans">Tgl. Transaksi</label>
                                        <div class="input-group date" id="inp_tgl_po">
                                            <input type="text" class="form-control datetimepicker-input dtpicker" id="inp_tgl_trans" name="inp_tgl_trans" value="{{ date('d/m/Y') }}" />
                                            <div class="input-group-append" >
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="sel_customer">Customer</label>
                                        <select class="select2bs4 form-control" name="sel_customer" id="sel_customer" style="width: 100%;" required>
                                        <option></option>
                                        @foreach($allCustomer as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama_customer }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inp_carabayar" class="col-form-label">Metode Pembayaran</label>
                                        <select class="form-control select2bs4" name="inp_carabayar" id="inp_carabayar" style="width: 100%;" required onchange="aktifJTP(this)">
                                            <option></optionn>
                                            <option value="1">Tunai</option>
                                            <option value="2">Kredit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="inpJatuhTempo" class="col-form-label">Jatuh Tempo</label>
                                    <div class="input-group date" id="reservationdate">
                                        <input type="text" class="form-control datetimepicker-input dtpicker" id="inpTglJatuhTempo" name="inpTglJatuhTempo" disabled>
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sel_via" class="col-form-label">Penerimaan Via</label>
                                        <select class="form-control select2bs4" name="sel_via" id="sel_via" style="width: 100%;" disabled>
                                            <option></optionn>
                                            @foreach($allVia as $via)
                                            <option value="{{ $via->id }}">{{ $via->penerimaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inp_keterangan">Keterangan</label>
                                <textarea class="form-control" name="inp_keterangan" id="inp_keterangan"></textarea>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="sel_kontainer">Kontainer</label>
                                            <select class="form-control select2bs4" name="sel_kontainer" id="sel_kontainer" style="width: 100%;" placeholder="Pilihan Kontainer" required>
                                                <option></optionn>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inp_nomor">Nomor Invoice Kontainer</label>
                                            <input type="text" class="form-control" name="inp_invoice_kontainer" id="inp_invoice_kontainer" maxlength="50" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inp_ongkir_kontainer">Ongkir Kontainer</label>
                                            <input type="text" class="form-control angka" id="inp_ongkir_kontainer" name="inp_ongkir_kontainer" value="0" style="text-align: right;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inpTglTiba">Tanggal Tiba</label>
                                            <div class="input-group date" id="inpTglTiba">
                                                <input type="text" class="form-control datetimepicker-input dtpicker" id="inpTglTiba" name="inpTglTiba" required />
                                                <div class="input-group-append" >
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-success btn-block" id="tbl_submit">Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <table style="width: 100%;" cellpadding='5'>
                            <tr>
                                <td style="width: 30%;"><label for="inputTotal" class="col-form-label text-right">Total</label></td>
                                <td colspan="3"><input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="0" style="text-align: right; background-color: black; color: white;" readonly></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><label for="inputTotal_DiskPersen" class="col-form-label text-right">Diskon (%)</label></td>
                                <td style="width: 20%;"><input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalPersen(this)"></td>
                                <td style="width: 10%;"><label for="inputTotal_DiskRupiah" class="col-form-label text-right">Rp.</label></td>
                                <td style="width: 40%;"><input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalNilai(this)"></td>
                            </tr>
                            <tr>
                                <td><label for="inputTotal_PpnPersen" class="col-form-label text-right">Ppn (%)</label></td>
                                <td><input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalPersen(this)"></td>
                                <td><label for="inputTotal_PpnRupiah" class="col-form-label text-right">Rp.</label></td>
                                <td><input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalNilai(this)"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><label for="inputOngkosKirim" class="col-form-label text-right">Ongkos Kirim</label></td>
                                <td colspan="3"><input type="text" class="form-control angka" id="inputOngkosKirim" name="inputOngkosKirim" value="0" onkeyup="hitOngkir(this)" style="text-align: right;"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><label for="inputTotalNet" class="col-form-label text-right">Total Net</label></td>
                                <td colspan="3"><input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="0" style="text-align: right; background-color: black; color: white;" readonly></td>
                            </tr>
                            </table>
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
<script>
    $(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        hapus_teks();
        var total_net = $("#inputTotalNet").val();
        if(total_net==0)
        {
            $("#tbl_submit").attr("disabled", true);
        }
        $("#inputSearch").autocomplete({
            source: function(request, response) {
                //Fetch data
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route('searchItemPenjualan'),
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
                if(ui.item.stok == 0)
                {
                    alert("Persediaan Stok Habis");
                } else {
                    $("#inputSearch").val(ui.item.label);
                    var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+'<td><input type="hidden" name="item_id[]" value="'+ui.item.value+'"><input type="hidden" name="item_head_id[]" value="'+ui.item.id_head_produk+'"><label style="color: blue; font-size: 11pt">'+ui.item.label+'</label></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.kemasan+' '+ui.item.satuan+'</label></td>'+'<td align="center"><input type="hidden" name="stok_akhir[]" value="'+ui.item.stok+'"><input type="text" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="1" style="text-align:center" onkeyup="hitungSubTotal(this)" onblur="cekPersediaan(this)"></td>'+'<td><select class="form-control form-control-sm" name="selKatHarga[]" id="selKatHarga[]" onchange="getHarga(this)"><option value="1">Harga Eceran</option><option value="2">Harga Toko</option></select></td>'+'<td class="text-right"><input type="hidden" id="temp_harga_beli[]" name="temp_harga_beli[]" value="'+ui.item.harga_beli+'"><input type="hidden" id="temp_harga_ecer[]" name="temp_harga_ecer[]" value="'+ui.item.harga_eceran+'"><input type="hidden" id="temp_harga_toko[]" name="temp_harga_toko[]" value="'+ui.item.harga_toko+'"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="'+ui.item.harga_eceran+'" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)" readonly></td>'+'<td class="text-right"><input type="text" name="item_sub_total[]" value="'+ui.item.harga_eceran+'" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskon[]" value="0" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)"></td>'+'<td class="text-right"><input type="text" name="item_diskonrp[]" value="0" class="form-control form-control-sm text-right angka" onkeyup="hitDiskonNilai(this)" onblur="changeToNull()"></td>'+'<td class="text-right"><input type="text" name="item_sub_total_net[]" value="'+ui.item.harga_eceran+'" class="form-control form-control-sm text-right angka" readonly></td>'+'</tr>';
                    $(".row_baru").after(content_item);
                    $('.angka').number( true, 0 );
                    $("#inputSearch").val("");
                    total();
                }
                return false;
            }
        });
    });

    var hapus_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
            total();
        });
    }

    var changeToNull = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("1");
        }
    }

    var cekPersediaan = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("0");
        }
        var currentRow=$(el).closest("tr");
        var qty = $(el).val();
        var stok_akhir = $(el).parent().parent().find('input[name="stok_akhir[]"]').val();
        if(parseInt(qty) > parseInt(stok_akhir))
        {
            alert("Maaf. Persediaan Stok tidak cukup");
            $(el).val("1");
            hitungSubTotal(el);
            return false
        }
    }

    var getHarga = function(el)
    {
        var currentRow=$(el).closest("tr");
        var harga_ecer = currentRow.find('td:eq(5) input[name="temp_harga_ecer[]"]').val();
        var harga_toko = currentRow.find('td:eq(5) input[name="temp_harga_toko[]"]').val();
        if($(el).val()==1)
        {
            currentRow.find('td:eq(5) input[name="harga_satuan[]"]').val(harga_ecer);
        } else {
            currentRow.find('td:eq(5) input[name="harga_satuan[]"]').val(harga_toko);
        }
        hitungSubTotal(el);
    }

    var aktifJTP = function(el)
    {
        if($(el).val()==2)
        {
            $("#inpTglJatuhTempo").attr("disabled", false);
            $("#sel_via").attr('disabled', true);
            $("#sel_via").attr('required', false);
        } else if($(el).val()==1) {
            $("#inpTglJatuhTempo").attr("disabled", true);
            $("#sel_via").attr('disabled', false);
            $("#sel_via").attr('required', true);
        } else {
            $("#inpTglJatuhTempo").attr("disabled", true);
            $("#sel_via").attr('disabled', true);
            $("#sel_via").attr('required', false);
        }
    }

    var hitSubTotal = function(el)
    {
        hitungSubTotal(el);
    }

    var hitDiskon = function(el)
    {
        var currentRow=$(el).closest("tr");
        var diskon = $(el).parent().parent().find('input[name="item_diskon[]"]').val();
        var sub_total = currentRow.find('td:eq(6) input[name="item_sub_total[]"]').val();
        var nilai_diskon = (diskon/100)*sub_total;
        currentRow.find('td:eq(8) input[name="item_diskonrp[]"]').val(nilai_diskon);
        hitungSubTotal(el);
    }

    var hitDiskonNilai = function(el)
    {
        var currentRow=$(el).closest("tr");
        var total = currentRow.find('td:eq(6) input[name="item_sub_total[]"]').val();
        var diskon_rupiah = $(el).parent().parent().find('input[name="item_diskonrp[]"]').val();
        var persen_disk_total = (Math.round(diskon_rupiah*100)) / total;
        currentRow.find('td:eq(7) input[name="item_diskon[]"]').val(parseFloat(persen_disk_total).toFixed(2));
        hitungSubTotal(el)
    }

    var hitDiskonTotalPersen = function(el)
    {
        var total = $("#inputTotal").val();
        var diskon_persen = $(el).val();
        var nilai_disk_total = (diskon_persen/100)*total;
        $("#inputTotal_DiskRupiah").val(nilai_disk_total);
        hitung_total_net()
    }

    var hitDiskonTotalNilai = function(el)
    {
        var total = $("#inputTotal").val();
        var diskon_rupiah = $(el).val();
        var persen_disk_total = (Math.round(diskon_rupiah*100)) / total;
        $("#inputTotal_DiskPersen").val(parseFloat(persen_disk_total).toFixed(2));
        hitung_total_net()
    }

    var hitPpnTotalPersen = function(el)
    {
        var total = $("#inputTotal").val();
        var ppn_persen = $(el).val();
        var nilai_ppntotal = (ppn_persen/100)*total;
        $("#inputTotal_PpnRupiah").val(nilai_ppntotal);
        hitung_total_net()
    }

    var hitOngkir = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("0");
        }
        hitung_total_net();
    }

    var hitPpnTotalNilai = function(el)
    {
        var total = $("#inputTotal").val();
        var ppn_rupiah = $(el).val();
        var persen_ppn_total = (Math.round(ppn_rupiah*100)) / total;
        $("#inputTotal_PpnPersen").val(parseFloat(persen_ppn_total).toFixed(2));
        hitung_total_net()
    }

    var hitungSubTotal = function(el){
        var currentRow=$(el).closest("tr");
        var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
        var harga = currentRow.find('td:eq(5) input[name="harga_satuan[]"]').val();
        var sub_total = parseFloat(jumlah) * parseFloat(harga);
        currentRow.find('td:eq(6) input[name="item_sub_total[]"]').val(sub_total);
        var hasil_diskon = currentRow.find('td:eq(8) input[name="item_diskonrp[]"]').val();
        var sub_total_setelah_diskon = sub_total - hasil_diskon;
        currentRow.find('td:eq(9) input[name="item_sub_total_net[]"]').val(sub_total_setelah_diskon);
        total();
    }

    var total = function(){

        var total = 0;
        var sub_total = 0;
        $.each($('input[name="item_sub_total_net[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })
        $("#inputTotal").val(total);
        hitung_total_net();
    }

    function hitung_total_net()
    {
        var total = $("#inputTotal").val();
        var diskon_rupiah = $("#inputTotal_DiskRupiah").val();
        var ppn_rupiah = $("#inputTotal_PpnRupiah").val();
        var ongkir = $("#inputOngkosKirim").val();
        var total_net = (total - diskon_rupiah) + parseInt(ppn_rupiah) + parseInt(ongkir);
        $("#inputTotalNet").val(total_net);
        if(total_net>0)
        {
            $("#tbl_submit").attr("disabled", false);
        } else {
            $("#tbl_submit").attr("disabled", true);
        }
    }

    function hapus_teks()
    {
        $("#inp_tgl_trans").val("{{ date('d/m/Y') }}");
        $("#sel_customer").val(null).trigger('change');
        $("#inp_carabayar").val(null).trigger('change');
        $("#sel_via").val(null).trigger('change');
        $("#inpTglJatuhTempo").val("");
        $("#inp_keterangan").val("");
        $("#inputTotal").val("0");
        $("#inputTotal_DiskPersen").val("0");
        $("#inputTotal_DiskRupiah").val("0");
        $("#inputTotal_PpnPersen").val("0");
        $("#inputTotal_PpnRupiah").val("0");
        $("#inputOngkosKirim").val("0");
        $("#inputTotalNet").val("0");
        $("#sel_via").attr('required', false);
        $("#sel_kontainer").val(null).trigger('change');
        $("#inp_invoice_kontainer").val("");
        $("#inp_ongkir_kontainer").val("0");
        $("#inpTglTiba").val("");
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




