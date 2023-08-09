@extends('layouts.app')
@section('title', 'Customer')
@section('breadcrumb', 'Customer')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Customer</h3>
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
                <th style="width: 5%;" class="text-center">No.</th>
                <th class="text-center">Diajukan Tgl.</th>
                <th class="text-center">Customer</th>
                <th class="text-center">No.Identitas</th>
                <th class="text-center">Email</th>
                <th class="text-center">Alamat Badan Usaha / Kota</th>
                <th class="text-center">No. Telepon</th>
                <th class="text-center">Level Customer</th>
                <th style="width: 10%;">Act</th>
            </tr>
            </thead>
            <tbody>
            @php $nom=1 @endphp
            @foreach($allCustomer as $list)
            <tr>
                <td class="text-center">{{ $nom }}</td>
                <td class="text-center">{{ $list->kode }}</td>
                <td>{{ $list->nama_customer }}</td>
                <td>{{ $list->kota }}</td>
                <td>{{ $list->no_identitas }}</td>
                <td>{{ $list->alamat }} / {{ $list->kota }}</td>
                <td>{{ $list->no_telepon }}</td>
                <td class="text-center">
                @if($list->level==1)
                <span class='badge bg-primary' style="font-size: small;">Customer</span>
                @elseif($list->level==2)
                <span class='badge bg-success' style="font-size: small;">Agent</span>
                @else
                <span class='badge bg-danger' style="font-size: small;">Reseller</span>
                @endif
                </td>
                <td>
                    <button type="button" id="tbl_edit" name="tbl_approval" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goApprove(this)"><i class="fa fa-edit"></i> Apply</button>
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
        let APP_URL_ADD = route('kontainerAdd');
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goApprove = function(el) {
        $("#frm_modal").load(route('submissionCustomerApproval', $(el).val()));
    }
</script>
@endsection



