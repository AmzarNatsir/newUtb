@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('breadcrumb', 'Stok')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Stok Baru</h3>
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
        <table class="table table-bordered table-hover datatable ListData" style="width: 100%; font-size: small;">
            <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th class="text-center" style="width: 15%;">Kode</th>
                <th>Produk</th>
                <th style="width: 15%;">Merk</th>
                <th class="text-center" style="width: 10%;">Kemasan</th>
                <th class="text-center" style="width: 10%;">Unit</th>
                <td style="width: 15%;">Keterangan</td>
                <th style="width: 10%;">Act</th>
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
                <td></td>
                <td>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_sub_produk" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goSubProduk(this)"><i class="fa fa-plus"></i> Sub Produk</button>
                            <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_edit" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goEdit(this)"><i class="fa fa-edit"></i> Edit</button>
                            @if($list->get_sub_produk()->count() == 0)
                            <a href="{{ url('productDelete') }}/{{ $list->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @if($list->get_sub_produk()->count() > 0)
                @php $sub_no = 1 @endphp
                @foreach($list->get_sub_produk as $sub)
                <tr>
                    <td>{{ $nom.".".$sub_no }}</td>
                    <td class="text-left">{{ $sub->kode }}</td>
                    <td colspan="4">{{ $sub->nama_produk }}</td>
                    <td>{{ $sub->keterangan }}</td>
                    <td><div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item" id="tbl_edit_sub" name="tbl_edit_sub" data-toggle="modal" data-target="#modal-form" value="{{ $sub->id }}" onclick="goEditSub(this)"><i class="fa fa-edit"></i> Edit</button>
                            <a href="{{ url('productSubDelete') }}/{{ $sub->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
                        </div>
                    </div></td>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="frm_modal"></div>
        </div>
    </div>
</div>
<script>
    $(function() {
        let APP_URL_ADD = route('productAdd');
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $("#tbl_tambah").on("click", function()
        {
            $("#frm_modal").load(APP_URL_ADD);
            
        });
    });
    var goEdit = function(el) {
    $("#frm_modal").load(route('productEdit', $(el).val()));
    }

    var goSubProduk = function (el) {
        $("#frm_modal").load(route('productSub', $(el).val()));
    }

    var goEditSub = function(el) {
        $("#frm_modal").load(route('productSubEdit', $(el).val()));
    }

    function konfirmHapus()
    {
        var psn = confirm("Delete Data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }

    }
</script>
@endsection



