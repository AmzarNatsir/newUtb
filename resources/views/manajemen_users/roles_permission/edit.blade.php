<div class="modal-header">
    <h4 class="modal-title">Edit Roles Permission</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('roles_permission_update', $role->id) }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
{{ method_field('PUT') }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Roles</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inpNamaRole">Nama</label>
                            <input type="text" class="form-control" name="inpNamaRole" id="inpNamaRole" maxlength="100" value="{{ $role->name }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"> Set Permission</h3>
                    </div>
                    <div class="card-body">
                        <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                            <table style="width: 100%; font-size: 10pt">
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkDashboard" name="checkMenu[0]" value="dashboard" {{ in_array('dashboard', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkDashboard"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkDashboard">DASHBOARD</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td colspan="2"><label for="checkPelaporan">PELAPORAN</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanStok" name="checkMenu[2]" value="laporan_stok" {{ in_array('laporan_stok', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanStok"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanStok">Stok</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanSampel" name="checkMenu[3]" value="laporan_pemberian_sampel" {{ in_array('laporan_pemberian_sampel', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanSampel"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanSampel">Pemberian Sampel</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanPembelian" name="checkMenu[4]" value="laporan_pembelian" {{ in_array('laporan_pembelian', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanPembelian"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanPembelian">Pembelian</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanPenjualan" name="checkMenu[5]" value="laporan_penjualan" {{ in_array('laporan_penjualan', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanPenjualan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanPenjualan">Penjualan</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanReturnPembelian" name="checkMenu[6]" value="laporan_return_pembelian" {{ in_array('laporan_return_pembelian', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanReturnPembelian"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanReturnPembelian">Return Pembelian</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanReturnPenjualan" name="checkMenu[7]" value="laporan_return_penjualan" {{ in_array('laporan_return_penjualan', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanReturnPenjualan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanReturnPenjualan">Return Penjualan</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanBayarHutang" name="checkMenu[8]" value="laporan_bayar_hutang" {{ in_array('laporan_bayar_hutang', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanBayarHutang"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanBayarHutang">Pembayaran Hutang</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanTerimaPiutang" name="checkMenu[9]" value="laporan_terima_piutang" {{ in_array('laporan_terima_piutang', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanTerimaPiutang"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanTerimaPiutang">Pembayaran Hutang</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanHutangKontainer" name="checkMenu[10]" value="laporan_hutang_kontainer" {{ in_array('laporan_hutang_kontainer', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanHutangKontainer"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanHutangKontainer">Pembayaran Hutang Kontainer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanHPP" name="checkMenu[40]" value="laporan_hpp" {{ in_array('laporan_hpp', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkPelaporanHPP"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanHPP">Harga Pokok Penjualan (HPP)</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td colspan="2"><label for="checkDataMaster">DATA MASTER</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterSatuan" name="checkMenu[11]" value="master_satuan" {{ in_array('master_satuan', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkmasterSatuan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterSatuan">Satuan</label></td>
                                </tr>


                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterMerek" name="checkMenu[12]" value="master_merek" {{ in_array('master_merek', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkmasterMerek"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterMerek">Merek</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterSupplier" name="checkMenu[13]" value="master_supplier" {{ in_array('master_supplier', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkmasterSupplier"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterSupplier">Supplier</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterKontainer" name="checkMenu[14]" value="master_kontainer" {{ in_array('master_kontainer', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkmasterKontainer"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterKontainer">Kontainer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterVia" name="checkMenu[15]" value="master_via" {{ in_array('master_via', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkmasterVia"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterVia">Penerimaan Via</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td colspan="2"><label for="checkCustomer">CUSTOMER</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerDaftar" name="checkMenu[16]" value="daftar_customer" {{ in_array('daftar_customer', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkCustomerDaftar"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerDaftar">Customer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerSubmission" name="checkMenu[17]" value="customer_submission" {{ in_array('customer_submission', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkCustomerSubmission"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerSubmission">Submission Approval</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerSwitch" name="checkMenu[18]" value="customer_switch_level" {{ in_array('customer_switch_level', $rolePermissions) ? 'checked' : '' }}>
                                                <label for="checkCustomerSwitch"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerSwitch">Switch Level Customer</label></td>
                                </tr>
                            </table>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <table style="width: 100%; font-size: 10pt">
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkManajemenStok">MANAJEMEN STOK</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokBaru" name="checkMenu[19]" value="manajemen_stok_baru" {{ in_array('manajemen_stok_baru', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkManajemenStokBaru"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokBaru">Stok Baru</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokDaftar" name="checkMenu[20]" value="manajemen_stok_daftar" {{ in_array('manajemen_stok_daftar', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkManajemenStokDaftar"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokDaftar">Daftar Stok</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokKartu" name="checkMenu[21]" value="manajemen_stok_kartu" {{ in_array('manajemen_stok_kartu', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkManajemenStokKartu"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokKartu">Kartu Stok</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkDaftarTrans">DAFTAR TRANSAKSI</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransPO" name="checkMenu[22]" value="daftar_transaksi_po" {{ in_array('daftar_transaksi_po', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkDaftarTransPO"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransPO">Purchase Order</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransReceive" name="checkMenu[23]" value="daftar_transaksi_receive" {{ in_array('daftar_transaksi_receive', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkDaftarTransReceive"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransReceive">Receive</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransPenjualan" name="checkMenu[24]" value="daftar_transaksi_penjualan" {{ in_array('daftar_transaksi_penjualan', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkDaftarTransPenjualan"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransPenjualan">Penjualan</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkTransaksi">TRANSAKSI</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransSampel" name="checkMenu[25]" value="transaksi_sampel" {{ in_array('transaksi_sampel', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransSampel"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransSampel">Pemberian Sample</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransPO" name="checkMenu[26]" value="transaksi_po" {{ in_array('transaksi_po', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransPO"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransPO">Purchase Order</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReceive" name="checkMenu[27]" value="transaksi_receive" {{ in_array('transaksi_receive', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransReceive"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReceive">Receiving</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransPenjualan" name="checkMenu[28]" value="transaksi_penjualan" {{ in_array('transaksi_penjualan', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransPenjualan"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransPenjualan">Penjualan</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReturnBeli" name="checkMenu[29]" value="transaksi_return_beli" {{ in_array('transaksi_return_beli', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransReturnBeli"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReturnBeli">Return Pembelian</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReturnJual" name="checkMenu[30]" value="transaksi_return_jual" {{ in_array('transaksi_return_jual', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkTransReturnJual"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReturnJual">Return Penjualan</label></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkKeuangan">KEUANGAN</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganBayarHutang" name="checkMenu[31]" value="keuangan_bayar_hutang" {{ in_array('keuangan_bayar_hutang', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkKeuanganBayarHutang"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganBayarHutang">Pembayaran Hutang</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganTerimaPiutang" name="checkMenu[32]" value="keuangan_terima_piutang" {{ in_array('keuangan_terima_piutang', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkKeuanganTerimaPiutang"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganTerimaPiutang">Penerimaan Piutang</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganHutangKontainer" name="checkMenu[33]" value="keuangan_hutang_kontainer" {{ in_array('keuangan_hutang_kontainer', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkKeuanganHutangKontainer"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganHutangKontainer">Pembayaran Hutang Kontainer</label></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkPersetujuan">PERSETUJUAN</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkPersetujuanSample" name="checkMenu[39]" value="persetujuan_pemberian_sampel" {{ in_array('persetujuan_pemberian_sampel', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkPersetujuanSample"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkPersetujuanSample">Pemberian Sample</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkPersetuPO" name="checkMenu[38]" value="persetujuan_po" {{ in_array('persetujuan_po', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkPersetuPO"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkPersetuPO">Purchase Order</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkPersetujuanJual" name="checkMenu[34]" value="persetujaun_penjualan" {{ in_array('persetujaun_penjualan', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkPersetujuanJual"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkPersetujuanJual">Penjualan</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td colspan="2"><label for="checkManajUser">MANAJEMEN USER</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkUserRolesPermission" name="checkMenu[35]" value="manaj_users_roles_permission" {{ in_array('manaj_users_roles_permission', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkUserRolesPermission"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkUserRolesPermission">Roles Permission</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkUsersUser" name="checkMenu[36]" value="manaj_users_user" {{ in_array('manaj_users_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <label for="checkUsersUser"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkUsersUser">Users</label></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success" id="tbl_approve">Submit</button>
    </div>
</form>
<script>
    $(function(){});
    var checkChoice = function(el)
    {
        var val_choice = $(el).val();
        if(val_choice=="laporan_stok" || val_choice=="laporan_pemberian_sampel" || val_choice=="laporan_pembelian" || val_choice=="laporan_penjualan" || val_choice=="laporan_return_pembelian" || val_choice=="laporan_return_penjualan" || val_choice=="laporan_bayar_hutang" || val_choice=="laporan_terima_piutang" || val_choice=="laporan_hutang_kontainer")
        {
            alert("check head pelaporan");
        }
    }

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