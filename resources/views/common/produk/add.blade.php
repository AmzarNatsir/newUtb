<div class="modal-header">
    <h4 class="modal-title">Tambah Data Produk Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('productStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
    <div class="modal-body">
        <div class="form-group">
            <label for="inp_kode">Kode</label>
            <input type="text" name="inp_kode" id="inp_kode" class="form-control" maxlength="50" value="{{ $kode_baru }}" readonly>
        </div>
        <div class="form-group">
            <label for="inp_nama">Nama Produk</label>
            <input type="text" name="inp_nama" id="inp_nama" class="form-control" maxlength="150" required>
        </div>
        <div class="form-group">
            <label for="sel_merk">Merk</label>
            <select class="form-control select2bs4" name="sel_merk" id="sel_merk" style="width: 100%;" required>
                @foreach($allMerk as $merk)
                <option value="{{ $merk->id }}">{{ $merk->merk }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_kemasan">Kemasan</label>
                    <input type="text" name="inp_kemasan" id="inp_kemasan" class="form-control" maxlength="50" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel_satuan">Satuan</label>
                    <select class="form-control select2bs4" name="sel_satuan" id="sel_satuan" style="width: 100%;" required>
                        @foreach($allUnit as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
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