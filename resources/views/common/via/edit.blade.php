<div class="modal-header">
    <h4 class="modal-title">Edit Data</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('viaUpdate', $res->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_nama">Penerimaan Via</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="200" value="{{ $res->penerimaan }}" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>