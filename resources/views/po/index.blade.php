@extends('layouts.app')
@section('title', 'Stock Keeper')
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
                        <th>{{ $list->get_supplier->nama_supplier }}</th>
                        <th class="text-right">{{ number_format($list->total_po, 0) }}</th>
                        <td class="text-center">
                            @if(empty($list->status_po)) 
                                Draft
                            @elseif($list->status_po==1)
                                Approved
                            @elseif($list->status_po==2)
                                Billed
                            @else
                                Closed
                            @endif
                        </td>
                        <td>{{ $list->keterangan }}</td>
                        <td>
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                Action
                                </button>
                                <div class="dropdown-menu">
                                    @if(empty($list->status_po))
                                    <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_edit" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goEdit(this)"><i class="fa fa-edit"></i> Edit</button>
                                    <a href="{{ url('unitDelete') }}/{{ $list->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item" id="tbl_approve" name="tbl_approve" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-print"></i> Approve</button>
                                </div>
                            </div>
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
<script type="text/javascript" src="{{ asset('assets/js/purchaseOrder.js') }}"></script>
@endsection



