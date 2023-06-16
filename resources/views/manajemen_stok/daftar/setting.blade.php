<div class="modal-header">
    <h4 class="modal-title">Setting Produk</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('settingStokStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
    <div class="modal-body">
        <div class="row">
            <div class="card-body">
                <table class="table table-bordered table-hover datatable ListData" style="width: 100%; font-size:small">
                    <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th class="text-center">Kode</th>
                        <th>Produk</th>
                        <th>Merk</th>
                        <th class="text-center">Kemasan</th>
                        <th class="text-center">Unit</th>
                        <th class="text-right;" style="width: 15%">Harga Beli</th>
                        <th class="text-right;" style="width: 15%">Harga Eceran</th>
                        <th class="text-right;" style=" width: 15%">Harga Eceran</th>
                        <th class="text-center;" style=" width: 10%">Stok Awal</th>
                        <th class="text-center;" style=" width: 10%">Stok Akhit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $nom=1 @endphp
                    @foreach($allProduct as $list)
                    <tr>
                        <td class="text-center">{{ $nom }}</td>
                        <td class="text-center"><input type="hidden" name="id_stok[]" value="{{ $list->id }}">{{ $list->kode }}</td>
                        <td>{{ $list->nama_produk }}</td>
                        <td>{{ $list->get_merk->merk }}</td>
                        <td class="text-center">{{ $list->kemasan }}</td>
                        <td class="text-center">{{ $list->get_unit->unit }}</td>
                        <td class="text-right"><input type="text" class="form-control text-right angka" name="inp_harga_beli[]" value="{{ number_format($list->harga_beli, 0) }}" onblur="changeToNull(this)"></td>
                        <td class="text-right"><input type="text" class="form-control text-right angka" name="inp_harga_toko[]" value="{{ number_format($list->harga_toko, 0) }}" onblur="changeToNull(this)"></td>
                        <td class="text-right"><input type="text" class="form-control text-right angka" name="inp_harga_eceran[]" value="{{ number_format($list->harga_eceran, 0) }}" onblur="changeToNull(this)"></td>
                        <td class="text-center"><input type="text" class="form-control text-right angka" name="inp_stok_awal[]" value="{{ (empty($list->stok_awal)) ? 0 : $list->stok_awal }}" onblur="changeToNull(this)" onkeyup="getStokAkhir(this)" <?= ((empty($list->stok_akhir))) ? "" : "readonly" ?>></td>
                        <td class="text-center"><input type="text" class="form-control text-right angka" name="inp_stok_akhir[]" value="{{ (empty($list->stok_akhir)) ? 0 : $list->stok_akhir }}" onblur="changeToNull(this)" readonly></td>
                    </tr>
                    @php $nom++ @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success" id="tbl_submit">Save changes</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/produk/setting_stok.js') }}"></script>