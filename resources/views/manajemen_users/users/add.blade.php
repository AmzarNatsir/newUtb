<div class="modal-header">
    <h4 class="modal-title">Buat User Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('users_store') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
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
                            <input type="text" name="name" class="form-control" value="" placeholder="Masukkan Nama Pengguna" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Email field --}}
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" value="" placeholder="Masukkan Email Pengguna" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan Password Pengguna" required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
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
                                <input type="radio" name="checkRole" id="checkRole{{ $role->id }}" value="{{ $role->id }}" onclick="getPermissio(this)"><label for="checkRole{{ $role->id }}">{{ $role->name }}</label>
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
    var getPermissio = function(el)
    {
        $("#v_permission").empty();
        $("#v_permission").hide();
        $("#v_permission").show(1000);
        $("#v_permission").load(route('get_role_permission', $(el).val()));
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