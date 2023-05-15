<div class="modal-header">
    <h4 class="modal-title">Tambah Data Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('unitStore') }}" method="post">
{{csrf_field()}}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_nama">Satuan</label>
            <input type="text" name="inp_unit" id="inp_unit" class="form-control" maxlength="200" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Save changes</button>
    </div>
</form>