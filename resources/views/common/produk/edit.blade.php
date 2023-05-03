<div class="modal-header">
    <h4 class="modal-title">Edit Form</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('productUpdate', $res->id) }}" method="post">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
        <div class="form-group">
            <label for="inp_kode">Kode</label>
            <input type="text" name="inp_kode" id="inp_kode" class="form-control" maxlength="50" value="{{ $res->kode }}" required>
        </div>
        <div class="form-group">
            <label for="inp_nama">Nama Produk</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="150" value="{{ $res->nama_produk }}" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel_satuan">Satuan</label>
                    <select class="form-control select2bs4" name="sel_satuan" id="sel_satuan" style="width: 100%;" required>
                        @foreach($allUnit as $unit)
                            @if($res->unit_id==$unit->id)
                                <option value="{{ $unit->id }}" selected>{{ $unit->unit }}</option>
                            @else
                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_kemasan">Kemasan</label>
                    <input type="text" name="inp_kemasan" id="inp_kemasan" class="form-control" maxlength="50" value="{{ $res->kemasan }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_harga_toko">Harga Toko (Rp.)</label>
                    <input type="text" name="inp_harga_toko" id="inp_harga_toko" class="form-control angka" value="{{ $res->harga_toko }}" style="text-align: right;" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_harga_eceran">Harga Eceran (Rp.)</label>
                    <input type="text" name="inp_harga_eceran" id="inp_harga_eceran" class="form-control angka" value="{{ $res->harga_eceran }}" style="text-align: right;" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Save changes</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>