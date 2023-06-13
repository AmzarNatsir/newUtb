@extends('layouts.app')
@section('title', 'Manajemen User')
@section('breadcrumb', 'Semua User')
@section('content')
@routes
<!-- content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Semua User</h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-success btn-block btn-sm" data-toggle="modal" data-target="#modal-form" id="tbl_new" name="tbl_new"><i class="fa fa-plus"></i> User Baru</button>
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
                <th class="text-center" style="width: 5%;">No.</th>
                <th>Nama User</th>
                <th>Email</th>
                <th style="width: 20%;">Role</th>
                <th class="text-center" style="width: 20%;">Approver</th>
                <th class="text-center" style="width: 10%;">Aktif</th>
                <th style="width: 15%;">Act</th>
            </tr>
            </thead>
            <tbody>
            @php $nom=1 @endphp
            @foreach($all_users as $list)
            <tr>
                <td class="text-center">{{ $nom }}</td>
                <td>{{ $list->name }}</td>
                <td>{{ $list->email }}</td>
                <td>{{ $list->roles->pluck('name')->first() }}</td>
                <td class="text-center">{{ (empty($list->approver)) ? "" : "Approver" }}</td>
                <td class="text-center">{{ ($list->active=='y') ? "Aktif" : "Tidak Aktif" }}</td>
                <td class="text-center"><div class="input-group-prepend">
                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      Action
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" id="tbl_edit" name="tbl_edit" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}" onclick="goEdit(this)"><i class="fa fa-edit"></i> Edit</button>
                        <a href="{{ url('users_delete') }}/{{ $list->id }}" class="dropdown-item" onclick="return konfirmHapus()" ><i class="fa fa-trash-alt"></i> Delete</a>
                    </div>
                  </div></td>
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
    $(function() {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $("#tbl_new").on("click", function()
        {
            $("#frm_modal").load("{{ url('users_add') }}");
            
        });
    });
    var goEdit = function(el) {
        $("#frm_modal").load(route('users_edit', $(el).val()));
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



