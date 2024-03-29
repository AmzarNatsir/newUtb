<div class="modal-header">
    <h4 class="modal-title">Edit Data Produk</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('productUpdate', $res->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
        <div class="form-group">
            <label for="inp_kode">Kode</label>
            <input type="text" name="inp_kode" id="inp_kode" class="form-control" maxlength="50" value="{{ $res->kode }}" readonly>
        </div>
        <div class="form-group">
            <label for="inp_nama">Nama Produk</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="150" value="{{ $res->nama_produk }}" required>
        </div>
        <div class="form-group">
            <label for="sel_merk">Merk</label>
            <select class="form-control select2bs4" name="sel_merk" id="sel_merk" style="width: 100%;" required>
                @foreach($allMerk as $merk)
                    @if($res->merk_id==$merk->id)
                    <option value="{{ $merk->id }}" selected>{{ $merk->merk }}</option>
                    @else
                    <option value="{{ $merk->id }}">{{ $merk->merk }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_kemasan">Kemasan</label>
                    <input type="text" name="inp_kemasan" id="inp_kemasan" class="form-control" maxlength="50" value="{{ $res->kemasan }}" required>
                </div>
            </div>
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
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
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