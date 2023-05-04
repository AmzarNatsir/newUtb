<div class="modal-header">
    <h4 class="modal-title">Add Purchase Order</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('purchaseOrderStore') }}" method="post">
{{csrf_field()}}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel_supplier">Supplier</label>
                    <select class="form-control select2bs4" name="sel_supplier" id="sel_supplier" style="width: 100%;" required>
                        @foreach($allSupplier as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_total_po">Total PO</label>
                    <input type="text" class="form-control text-right angka" name="inp_total_po" id="inp_total_po" value="0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                        <label for="inp_keterangan">Keterangan</label>
                        <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                    </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inp_carabayar">Cara Pembayaran</label>
                    <select class="form-control select2bs4" name="inp_carabayar" id="inp_carabayar" style="width: 100%;" required>
                        <option value="1">Tunai</option>
                        <option value="2">Kredit</option>
                    </select>
                </div>
            </div>
        </div>
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
                                        <tbody class="row_baru"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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