<div class="modal-header">
    <h4 class="modal-title">Edit Data</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('customerUpdate', $res->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_kode">Kode</label>
            <input type="text" name="inp_kode" id="inp_kode" class="form-control" maxlength="20" value="{{ $res->kode}}" readonly>
        </div>
        <div class="form-group">
            <label for="inp_nama">Nama Customer</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="100" value="{{ $res->nama_customer}}" required>
        </div>
        <div class="form-group">
            <label for="inp_alamat">Alamat</label>
            <input type="text" name="inp_alamat" id="inp_alamat" class="form-control" maxlength="100" value="{{ $res->alamat }}">
        </div>
        <div class="form-group">
            <label for="inp_kota">Kota</label>
            <input type="text" name="inp_kota" id="inp_kota" class="form-control" maxlength="100" value="{{ $res->kota }}" required>
        </div>
        <div class="form-group">
            <label for="inp_notel">No. Telepon</label>
            <input type="text" name="inp_notel" id="inp_notel" class="form-control" maxlength="50" value="{{ $res->no_telepon }}">
        </div>
        <div class="form-group">
            <label for="inp_level">Level Customer</label>
            <select class="form-control select2bs4" name="inp_level" id="inp_level" style="width: 100%;">
                <option value="1">Customer</option>
                <option value="2">Agent</option>
                <option value="3">Reseller</option>
            </select>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>
<script>
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