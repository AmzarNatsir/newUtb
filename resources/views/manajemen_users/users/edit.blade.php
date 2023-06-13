<div class="modal-header">
    <h4 class="modal-title">Edit User</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('users_update', $user->id) }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
{{ method_field('PUT') }}
    <input type="hidden" value="{{ $user->roles->pluck('id')->first() }}" id="roles_user">
    <div class="modal-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user"></i> Data Pengguna</h3>
                    </div>
                    <div class="card-body">
                        {{-- Name field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="editName" class="form-control" value="{{ $user->name }}" placeholder="Masukkan Nama Pengguna" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Email field --}}
                        <div class="input-group mb-3">
                            <input type="email" name="editEmail" class="form-control" value="{{ $user->email }}" placeholder="Masukkan Email Pengguna" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="editPassword" id="editPassword" class="form-control"
                                placeholder="Masukkan Password Pengguna">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group clearfix">
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" id="selApprover" name="selApprover" value="y" onchange="checkApprover(this)" {{ ($user->approver=='y') ? 'checked' : '' }} >
                                            <label for="selApprover">Approver</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label for="selLevelApprover" class="col-md-4 col-form-label">Level Approver</label>
                            <div class="col-md-4">
                                <select class="form-control select2bs4" name="selLevelApprover" id="selLevelApprover" style="width: 100%;" {{ ($user->approver=='y') ? '' : 'disabled' }}>
                                    <option></optionn>
                                    <option value="1" {{ ($user->lvl_approver==1) ? "selected" : "" }}>Lever Pertama</option>
                                    <option value="2" {{ ($user->lvl_approver==2) ? "selected" : "" }}>Level Kedua</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-check"></i> Role Akses Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" style="width: 100%;">
                        @foreach($allRole as $role)
                        <tr>
                            <td>
                                <div class="icheck-success d-inline">
                                <input type="radio" name="checkRole" id="checkRole{{ $role->id }}" value="{{ $role->id }}" onclick="getPermissio(this)" {{ ($role->id==$user->roles->pluck('id')->first()) ? 'checked' : '' }}><label for="checkRole{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-check"></i> Permission / Hak Akses</h3>
                    </div>
                    <div class="card-body" id="v_permission"></div>
                </div>
            </div>

        </div>

    </div>
</form>
<script>
    $(function(){
        $("#editPassword").val("");
        $("#v_permission").load(route('get_role_permission', $("#roles_user").val()));
    })
    var getPermissio = function(el)
    {
        $("#v_permission").empty();
        $("#v_permission").hide();
        $("#v_permission").show(1000);
        $("#v_permission").load(route('get_role_permission', $(el).val()));
    }

    var checkApprover = function(el)
    {
        if ($(el).is(':checked')) {
            $("#selLevelApprover").attr("disabled", false);
        } else {
            $("#selLevelApprover").attr("disabled", true);
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