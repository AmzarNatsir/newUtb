@extends('layouts.app')
@section('title', 'Data Master')
@section('breadcrumb', 'Stok')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Stok</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-success btn-block btn-sm" data-toggle="modal" data-target="#modal-form" id="tbl_tambah" name="tbl_tambah"><i class="fa fa-plus"></i> Tambah Data</button>
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
                <th class="text-center">Kode</th>
                <th>Produk</th>
                <th>Merk</th>
                <th class="text-center">Kemasan</th>
                <th class="text-center">Unit</th>
                <th class="text-right">Harga Toko</th>
                <th class="text-right">Harga Eceran</th>
                <th style="width: 10%;">Act</th>
            </tr>
            </thead>
            <tbody>
            @php $nom=1 @endphp
            @foreach($allProduct as $list)
            <tr>
                <td class="text-center">{{ $nom }}</td>
                <td class="text-center">{{ $list->kode }}</td>
                <td>{{ $list->nama_produk }}</td>
                <td>{{ $list->get_merk->merk }}</td>
                <td class="text-center">{{ $list->kemasan }}</td>
                <td class="text-center">{{ $list->get_unit->unit }}</td>
                <td class="text-right">{{ number_format($list->harga_toko, 0) }}</td>
                <td class="text-right">{{ number_format($list->harga_eceran, 0) }}</td>
                <td>
                    <div class="input-group-prepend">
                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      Action
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_edit" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goEdit(this)"><i class="fa fa-edit"></i> Edit</button>
                        <a href="{{ url('productDelete') }}/{{ $list->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/common/product.js') }}"></script>
@endsection



