@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Return')
@section('content')
@routes
<section class="content">
    <!-- Default box -->
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Return Pemberian Sample</h3>
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
            url: route('returnPemberianSampleSearch'),
            dataType: "json",
            data: {
                search: keyWord
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
                        $("#viewInvoice").load("{{ url('returnPemberianSampleDetailInvoice') }}/"+data.data.id);
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        $("#viewInvoice").empty();
                        return false
                    }
                    })
                }
            }

        })
        .done(function(e){
            $('.angka').number( true, 0 );
        });
    }

    var goFilter = function()
    {
        var customer = $("#sel_customer").val();
        $(".viewList").load("{{ url('returnPemberianSampleFilter') }}/"+customer);
    }

    var viewInvoice = function(el)
    {
        var id_invoice = el.id;
        $("#viewInvoice").load("{{ url('returnPemberianSampleDetailInvoice') }}/"+id_invoice);
        $('.angka').number( true, 0 );
    }
</script>
@endsection

