<div class="modal-header">
    <h4 class="modal-title">Tambah Data Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('merkStore') }}" method="post">
{{csrf_field()}}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_merk">Merek</label>
            <input type="text" name="inp_merk" id="inp_merk" class="form-control" maxlength="100" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>