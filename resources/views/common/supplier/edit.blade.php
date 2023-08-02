<div class="modal-header">
    <h4 class="modal-title">Edit Data</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('supplierUpdate', $res->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="modal-body">
    <div class="form-group">
            <label for="inp_nama">Nama Supplier</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="200" value="{{ $res->nama_supplier}}" required>
        </div>
        <div class="form-group">
            <label for="inp_alamat">Alamat</label>
            <input type="text" name="inp_alamat" id="inp_alamat" class="form-control" maxlength="200" value="{{ $res->alamat }}">
        </div>
        <div class="form-group">
            <label for="inp_notel">No. Telepon</label>
            <input type="text" name="inp_notel" id="inp_notel" class="form-control" maxlength="50" value="{{ $res->no_telepon }}">
        </div>
        <div class="form-group">
            <label for="inp_email">Email</label>
            <input type="mail" name="inp_email" id="inp_email" class="form-control" maxlength="100" value="{{ $res->email }}">
        </div>
        <div class="form-group">
            <label for="inp_kontak">Kontak Person</label>
            <input type="text" name="inp_kontak" id="inp_kontak" class="form-control" maxlength="200" value="{{ $res->kontak_person }}">
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>