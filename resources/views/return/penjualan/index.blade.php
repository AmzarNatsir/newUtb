@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Return')
@section('content')
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
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Return Penjualan</h3>
    </div>
    <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-search"></i> Filter Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Input Nomor Invoice" name="Inpsearch" id="Inpsearch">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" onclick="goSearch()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_supplier">Customer</label>
                            <select class="form-control select2bs4" name="sel_customer" id="sel_customer" style="width: 100%;" required>
                                @foreach($allCustomer as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama_customer }}</option>
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
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-table"></i> Daftar Invoice</h3>
                    </div>
                    <div class="card-body viewList"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-edit"></i> Pengembalian</h3>
                    </div>
                    <div class="card-body">
                        @if (Session::has('message'))
                        <div class="alert alert-info alert-dismissible" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
                            {!! session('message') !!}
                        </div>
                        @endif
                        <form action="#" method="post" onsubmit="return konfirm()">
                        {{csrf_field()}}
                        <div id="viewInvoice"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<script>
    $(function(){
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });

    var goSearch = function()
    {
        var keyWord = $("#Inpsearch").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: route('returnPenjualanSearch'),
            dataType: "json",
            data: {
                search: keyWord
            },
            beforeSend: function()
            {
                $('#spinner-div').show();
            },
            success: function( data ) {
                // alert(data.success);
                if(data.success=='false')
                {
                    // alert(data.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Hasil Pencarian',
                        text: data.message,
                    })
                    $("#viewInvoice").empty();
                    return false;
                } else {
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Hasil Pencarian',
                    text: data.message,
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Tidak ! ',
                    confirmButtonText: 'Ya ! ',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $("#viewInvoice").load("{{ url('returnPenjualanDetailInvoice') }}/"+data.data.id);
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        $("#viewInvoice").empty();
                        return false
                    }
                    })
                }
            },
            complete: function()
            {
                $('#spinner-div').hide();
            }

        })
        .done(function(e){
            $('.angka').number( true, 0 );
        });
    }

    var goFilter = function()
    {
        $('#spinner-div').show();
        var customer = $("#sel_customer").val();
        $(".viewList").load("{{ url('returnPenjualanFilter') }}/"+customer, function(){
            $('#spinner-div').hide();
        });
    }

    var viewInvoice = function(el)
    {
        $('#spinner-div').show();
        var id_invoice = el.id;
        $("#viewInvoice").load("{{ url('returnPenjualanDetailInvoice') }}/"+id_invoice, function(){
            $('#spinner-div').hide();
        });
        $('.angka').number( true, 0 );
    }
</script>
@endsection

