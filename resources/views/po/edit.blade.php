<style>
    .ui-autocomplete {
    z-index: 215000000 !important;
    }
    input[type=number]
    {
    -moz-appearance: textfield;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title">Add Purchase Order</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('updateOrder', $resHead->id) }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-plus"></i> Item Produk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="input-group" id="seacrhItem">
                                    <input type="text" class="form-control form-control-sm" name="inputSearch" id="inputSearch" placeholder="Masukkan Nama Produk" autocomplete="off">
                                    <div class="input-group-append" >
                                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-sm-12" style="overflow-y: auto; max-height: 100vh">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-vcenter" id="list_item" style="font-size: 13px">
                                        <tr>
                                            <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
                                            <th rowspan="2" style="width: 16%; vertical-align: middle;">Nama Produk</th>
                                            <th colspan="3" class="text-center">Satuan</th>
                                            <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total (Rp.)</th>
                                            <th colspan="2" class="text-center">Potongan</th>
                                            <th rowspan="2" class="text-right" style="width: 12%;vertical-align: middle;">Sub Total Net (Rp.)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 10%">Satuan</th>
                                            <th class="text-center" style="width: 12%">Qty</th>
                                            <th class="text-center" style="width: 10%">Harga Satuan</th>
                                            <th class="text-center" style="width: 6%">%</th>
                                            <th class="text-center" style="width: 9%">Nilai</th>
                                        </tr>
                                        <tbody class="row_baru">
                                        @php
                                            $nom=1
                                            @endphp
                                            @foreach($resHead->get_detail as $list)
                                            <tr class="rows_item" name="rows_item[]">
                                                <td><input type='hidden' name='id_item[]' value="{{ $list->id }}"><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>
                                                <td><input type="hidden" name="item_id[]" value="{{ $list->id }}"><label style="color: blue; font-size: 11pt">{{ $list->get_produk->nama_produk }}</label></td>
                                                <td style="text-align: center"><label style="color: blue; font-size: 11pt">{{ $list->get_produk->get_unit->unit }}</label></td>
                                                <td align="center"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary" name="tbl_minus[]" onClick="min_qty(this)"><i class="fa fa-minus"></i></button></span><input type="number" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="{{ $list->qty }}" style="text-align:center" readonly><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary" name="tbl_plus[]" onClick="add_qty(this)"><i class="fa fa-plus"></i></button></span></div></td>
                                                <td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="{{ $list->harga }}" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)" readonly></td>
                                                <td class="text-right"><input type="text" name="item_sub_total[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka" readonly></td>
                                                <td class="text-right"><input type="text" name="item_diskon[]" value="{{ (empty($list->diskitem_persen)) ? 0 : $list->diskitem_persen }}" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)" readonly></td>
                                                <td class="text-right"><input type="text" name="item_diskonrp[]" value="{{ (empty($list->diskitem_rupiah)) ? 0 : $list->diskitem_rupiah }}" class="form-control form-control-sm text-right angka" readonly></td>
                                                <td class="text-right"><input type="text" name="item_sub_total_net[]" value="{{ $list->sub_total_net }}" class="form-control form-control-sm text-right angka" readonly></td>
                                            </tr>
                                            @php
                                            $nom++
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_nomor">Nomor PO</label>
                                    <input type="text" class="form-control" value="{{ $resHead->nomor_po }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_kemasan">Tanggal PO</label>
                                    <input type="text" class="form-control" value="{{ date_format(date_create($resHead->tanggal_po), 'd-m-Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_supplier">Supplier</label>
                            <select class="form-control select2bs4" name="sel_supplier" id="sel_supplier" style="width: 100%;" required>
                                @foreach($allSupplier as $supplier)
                                @if($resHead->supplier_id==$supplier->id)
                                <option value="{{ $supplier->id }}" selected>{{ $supplier->nama_supplier }}</option>
                                @else
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inp_carabayar">Cara Pembayaran</label>
                            <select class="form-control select2bs4" name="inp_carabayar" id="inp_carabayar" style="width: 100%;" required>
                                <option value="1" {{ ($resHead->cara_bayar==1) ? "selected" : "" }}>Tunai</option>
                                <option value="2" {{ ($resHead->cara_bayar==2) ? "selected" : "" }}>Kredit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inp_keterangan">Keterangan</label>
                            <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required>{{ $resHead->keterangan }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputTotal" class="col-sm-6 col-form-label text-right">Total</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="{{ $resHead->total_po }}" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_DiskPersen" class="col-sm-6 col-form-label text-right">Diskon (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalPersen(this)" readonly>
                            </div>
                            <label for="inputTotal_DiskRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalNilai(this)" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_PpnPersen" class="col-sm-6 col-form-label text-right">Ppn (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalPersen(this)" readonly>
                            </div>
                            <label for="inputTotal_PpnRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalNilai(this)" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotalNet" class="col-sm-6 col-form-label text-right">Total Net</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="{{ $resHead->total_po_net }}" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success" id="tbl_submit">Save changes</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/po/actEdit.js') }}"></script>