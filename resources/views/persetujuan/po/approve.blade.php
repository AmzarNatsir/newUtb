<div class="modal-header">
    <h4 class="modal-title">Approve Purchase Order</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('persetujuanPOStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
<input type="hidden" name="id_po" id="id_po" value="{{ $resHead->id }}">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"> Item Produk Order</h3>
                    </div>
                    <div class="card-body">
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
                                        <tbody>
                                            @php
                                            $nom=1
                                            @endphp
                                            @foreach($resHead->get_detail as $list )
                                            <tr>
                                                <td class="text-center">{{ $nom }}</td>
                                                <td>{{ $list->get_produk->nama_produk }}</td>
                                                <td class="text-center">{{ $list->get_produk->get_unit->unit }}</td>
                                                <td class="text-center">{{ $list->qty }}</td>
                                                <td class="text-right">{{ number_format($list->harga, 0) }}</td>
                                                <td class="text-right">{{ number_format($list->sub_total, 0) }}</td>
                                                <td class="text-right">{{ number_format($list->diskitem_persen, 0) }}</td>
                                                <td class="text-right">{{ number_format($list->diskitem_rupiah, 0) }}</td>
                                                <td class="text-right">{{ number_format($list->sub_total, 0) }}</td>
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
                            <input type="text" class="form-control" value="{{ $resHead->get_supplier->nama_supplier }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inp_carabayar">Cara Pembayaran</label>
                            <input type="text" class="form-control" value="{{ ($resHead->cara_bayar==1) ? 'Tunai' : 'Kredit' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inp_keterangan">Keterangan</label>
                            <textarea class="form-control" readonly>{{ $resHead->keterangan }}</textarea>
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
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputTotal" class="col-sm-4 col-form-label">Pilihan Persetujuan</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selApproval" id="selApproval">
                                    <option value="1">Setuju</option>
                                    <option value="2">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inp_catatan_persetujuan">Catatan Persetujuan</label>
                            <textarea class="form-control" name="inp_catatan_persetujuan" id="inp_catatan_persetujuan"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success" id="tbl_approve">Approve</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script>
    $(function(){
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
    });
</script>
