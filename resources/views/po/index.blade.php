@extends('layouts.app')
@section('title', 'Transaksi')
@section('breadcrumb', 'Purchase Order')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase Order</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-success btn-block btn-sm" data-toggle="modal" data-target="#modal-form" id="tbl_tambah" name="tbl_tambah"><i class="fa fa-plus"></i> Add PO</button>
            </li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
        <div class="alert alert-info alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Konfirmasi !</h4>
            {!! session('message') !!}
        </div>
        @endif
        <table class="table table-bordered table-hover datatable ListData" style="width: 100%;">
            <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th class="text-center" style="width: 10%;">No.PO</th>
                <th class="text-center" style="width: 10%;">Tanggal PO</th>
                <th>Supplier</th>
                <th class="text-right" style="width: 15%;">Total PO</th>
                <th class="text-center" style="width: 10%;">Status PO</th>
                <th>Keterangan</th>
                <th style="width: 10%;">Act</th>
            </tr>
            </thead>
            <tbody>
                @php
                $nom=1
                @endphp
                @foreach($all_po as $list)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td class="text-center">{{ $list->nomor_po }}</td>
                        <td class="text-center">{{ date_format(date_create($list->tanggal_po), 'd-m-Y') }}</td>
                        <td>{{ $list->get_supplier->nama_supplier }}</td>
                        <th class="text-right">{{ number_format($list->total_po_net, 0) }}</th>
                        <td class="text-center">
                            @if(empty($list->status_approval)) 
                                @if(empty($list->approved) || (empty($list->approved_2)))
                                <span class='badge bg-info'>Proses Approval</span>
                                @else 
                                <span class='badge bg-primary'>Draft</span>
                                @endif
                            @elseif($list->status_approval==1)
                            <span class='badge bg-success'>Approved</span>
                            @else
                            <span class='badge bg-danger'>Cancel PO</span>
                            @endif
                        </td>
                        <td>{{ $list->keterangan }}</td>
                        <td>
                            @if(empty($list->status_approval))
                                @if(empty($list->approved) && (empty($list->approved_2)))
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_edit" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-edit"></i> Edit</button>
                                        <a href="{{ url('deleteOrder') }}/{{ $list->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
                                    </div>
                                </div>
                                @endif
                            @endif
                            @if($list->status_approval==1)
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                Action
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item" id="tbl_print" name="tbl_print" value="{{ $list->id }}" onClick='goPrint(this)'><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @php $nom++ @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- Modal -->
<div class="modal fade" id="modal-form" data-backdrop="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        let APP_URL_ADD = route('purchaseOrderAdd');
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $("#tbl_tambah").on("click", function()
        {
            $("#frm_modal").load(APP_URL_ADD);
        });

        $(".ListData").on("click", '#tbl_edit', function()
        {
            var id_data = this.value;
            $("#frm_modal").load(route('editOrder', id_data));
        });
    });

    var goPrint = function(el)
    {
        var id_data = $(el).val();
        window.open(route('printOrder', id_data), "_blank");
    }

    function konfirmHapus()
    {
        var psn = confirm("Yakin akan menghapus data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }

    }
</script>
@endsection



