<div class="modal-header">
    <h4 class="modal-title">Edit</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('merkUpdate', $res->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_merk">Merk</label>
            <input type="text" name="inp_merk" id="inp_merk" class="form-control" maxlength="100" value="{{ $res->merk }}" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Save changes</button>
    </div>
</form>