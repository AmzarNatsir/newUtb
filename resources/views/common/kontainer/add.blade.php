<div class="modal-header">
    <h4 class="modal-title">Tambah Data Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('kontainerStore') }}" method="post">
{{csrf_field()}}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_nama">Nama Kontainer</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="200" required>
        </div>
        <div class="form-group">
            <label for="inp_alamat">Alamat</label>
            <input type="text" name="inp_alamat" id="inp_alamat" class="form-control" maxlength="200">
        </div>
        <div class="form-group">
            <label for="inp_notel">No. Telepon</label>
            <input type="text" name="inp_notel" id="inp_notel" class="form-control" maxlength="50">
        </div>
        <div class="form-group">
            <label for="inp_email">Email</label>
            <input type="mail" name="inp_email" id="inp_email" class="form-control" maxlength="100">
        </div>
        <div class="form-group">
            <label for="inp_kontak">Kontak Person</label>
            <input type="text" name="inp_kontak" id="inp_kontak" class="form-control" maxlength="200">
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Save changes</button>
    </div>
</form>