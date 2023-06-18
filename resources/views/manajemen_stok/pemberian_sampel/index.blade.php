@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Pemberian Sampel')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Pemberian Sampel</h3>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
        <div class="alert alert-info alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
            {!! session('message') !!}
        </div>
        @endif
        <form action="{{ route('pemberianSampelStore') }}" method="post" onsubmit="return konfirm()">
        {{csrf_field()}}
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inp_carabayar" class="col-sm-6 col-form-label">Tgl Pemberian</label>
                                <div class="col-sm-6">
                                    <div class="input-group date" id="inp_tgl_pemberian">
                                        <input type="text" class="form-control datetimepicker-input dtpicker" id="inp_tgl_pemberian" name="inp_tgl_pemberian" value="{{ date('d-m-Y') }}">
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sel_customer">Customer</label>
                                <select class="form-control select2bs4" name="sel_customer" id="sel_customer" style="width: 100%;" required>
                                <option></option> 
                                @foreach($allCustomer as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama_customer }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inp_keterangan">Keterangan</label>
                                <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer float-right">
                            <button type="submit" class="btn btn-success" id="tbl_submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
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
                                        <table class="table table-bordered table-vcenter" id="list_item" style="font-size: 11pt">
                                            <tr>
                                                <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
                                                <th rowspan="2" style="vertical-align: middle;">Nama Produk</th>
                                                <th colspan="3" class="text-center">Satuan</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 20%">Qty</th>
                                                <th class="text-center" style="width: 10%">Kemasan</th>
                                                <th class="text-center" style="width: 10%">Satuan</th>
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
        </form>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<script>
    $(function(){
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
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
                    success: function( data ) {
                        response(data);
                    }

                });
            },
            select: function(event, ui) {
                if(ui.item.stok == 0)
                {
                    alert("Persediaan Stok Habis");
                } else {
                    $("#inputSearch").val(ui.item.label);
                    var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+'<td><input type="hidden" name="item_id[]" value="'+ui.item.value+'"><input type="hidden" name="item_sub_id[]" value="'+ui.item.id_head_produk+'"><label style="color: blue; font-size: 11pt">'+ui.item.label+'</label></td>'+'<td align="center"><input type="hidden" name="stok_akhir[]" value="'+ui.item.stok+'"><input type="text" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="1" style="text-align:center" onblur="cekPersediaan(this)"></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.kemasan+'</label></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.satuan+'</label></td>'+'</tr>';
                    $(".row_baru").after(content_item);
                    $('.angka').number( true, 0 );
                    $("#inputSearch").val("");
                    // total();
                }
                return false;
            }
        });
    });
    var hapus_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
        });
    }

    var cekPersediaan = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("1");
        }
        var currentRow=$(el).closest("tr");
        var qty = $(el).val();
        var stok_akhir = $(el).parent().parent().find('input[name="stok_akhir[]"]').val();
        if(parseInt(qty) > parseInt(stok_akhir))
        {
            alert("Maaf. Persediaan Stok tidak cukup");
            $(el).val("1");
            return false
        }
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




