<div class="modal-header">
    <h4 class="modal-title">Edit Form</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('unitUpdate', $res->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_unit">Unit</label>
            <input type="text" name="inp_unit" id="inp_unit" class="form-control" maxlength="200" value="{{ $res->unit }}" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Save changes</button>
    </div>
</form>