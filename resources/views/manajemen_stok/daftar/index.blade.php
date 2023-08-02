@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('breadcrumb', 'Daftar Stok')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Stok</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-success btn-block btn-sm" data-toggle="modal" data-target="#modal-form" id="tbl_setting" name="tbl_setting"><i class="fa fa-plus"></i> Setting Harga</button>
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
        <table class="table table-bordered table-hover datatable ListData" style="width: 100%; font-size: small;">
            <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th class="text-center">Kode</th>
                <th>Produk</th>
                <th>Merk</th>
                <th class="text-center">Kemasan</th>
                <th class="text-center">Unit</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Toko</th>
                <th class="text-right">Harga Eceran</th>
                <th class="text-center">Stok Awal</th>
                <th class="text-center">Stok Akhir</th>
            </tr>
            </thead>
            <tbody>
            @php $nom=1 @endphp
            @foreach($allProduct as $list)
            <tr>
                <td class="text-left"><b>{{ $nom }}</b></td>
                <td class="text-left"><b>{{ $list->kode }}</b></td>
                <td><b>{{ $list->nama_produk }}</b></td>
                <td><b>{{ $list->get_merk->merk }}</b></td>
                <td class="text-center"><b>{{ $list->kemasan }}</b></td>
                <td class="text-center"><b>{{ $list->get_unit->unit }}</b></td>
                <td class="text-right"><b>{{ number_format($list->harga_beli, 0) }}</b></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($list->stok_awal, 0) }}</b></td>
                <td class="text-right"><b>{{ number_format($list->stok_akhir, 0) }}</b></td>
            </tr>
            @if($list->get_sub_produk()->count() > 0)
                @php $sub_no = 1 @endphp
                @foreach($list->get_sub_produk as $sub)
                <tr>
                    <td>{{ $nom.".".$sub_no }}</td>
                    <td>{{ $sub->kode }}</td>
                    <td>{{ $sub->nama_produk }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ number_format($sub->harga_toko, 0) }}</td>
                    <td class="text-right">{{ number_format($sub->harga_eceran, 0) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @php $sub_no++ @endphp
                @endforeach
            @endif
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
<script type="text/javascript" src="{{ asset('assets/js/produk/manajemen_stok.js') }}"></script>
@endsection