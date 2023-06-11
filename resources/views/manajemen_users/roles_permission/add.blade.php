<div class="modal-header">
    <h4 class="modal-title">Roles Permission</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="#" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Roles</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inpNamaRole">Nama</label>
                            <input type="text" class="form-control" name="inpNamaRole" id="inpNamaRole" maxlength="100" required>
                        </div>
                    </div>
                </div>
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"> Set Permission</h3>
                    </div>
                    <div class="card-body">
                        <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkDashboard" value="dashboard">
                                                <label for="checkDashboard"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkDashboard">DASHBOARD</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkSummary" value="summary">
                                                <label for="checkSummary"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkSummary">SUMMARY</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkPelaporan" value="pelaporan">
                                                <label for="checkPelaporan"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkPelaporan">PELAPORAN</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanStok" value="pelaporan_stok">
                                                <label for="checkPelaporanStok"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanStok">Stok</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanSampel" value="pelaporan_pemberian_sampel">
                                                <label for="checkPelaporanSampel"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanSampel">Pemberian Sampel</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanPembelian" value="laporan_pembelian">
                                                <label for="checkPelaporanPembelian"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanPembelian">Pembelian</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanPenjualan" value="laporan_penjualan">
                                                <label for="checkPelaporanPenjualan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanPenjualan">Penjualan</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanReturnPembelian" value="laporan_return_pembelian">
                                                <label for="checkPelaporanReturnPembelian"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanReturnPembelian">Return Pembelian</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanReturnPenjualan" value="laporan_return_penjualan">
                                                <label for="checkPelaporanReturnPenjualan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanReturnPenjualan">Return Penjualan</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanBayarHutang" value="laporan_bayar_hutang">
                                                <label for="checkPelaporanBayarHutang"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanBayarHutang">Pembayaran Hutang</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanTerimaPiutang" value="laporan_terima_piutang">
                                                <label for="checkPelaporanTerimaPiutang"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanTerimaPiutang">Pembayaran Hutang</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkPelaporanHutangKontainer" value="laporan_hutang_kontainer">
                                                <label for="checkPelaporanHutangKontainer"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkPelaporanHutangKontainer">Pembayaran Hutang Kontainer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkDataMaster" value="data_master">
                                                <label for="checkDataMaster"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkDataMaster">DATA MASTER</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterSatuan" value="master_satuan">
                                                <label for="checkmasterSatuan"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterSatuan">Satuan</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterMerek" value="master_merek">
                                                <label for="checkmasterMerek"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterMerek">Merek</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterSupplier" value="master_supplier">
                                                <label for="checkmasterSupplier"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterSupplier">Supplier</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterKontainer" value="master_kontainer">
                                                <label for="checkmasterKontainer"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterKontainer">Kontainer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkmasterVia" value="master_via">
                                                <label for="checkmasterVia"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkmasterVia">Penerimaan Via</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkCustomer" value="customer">
                                                <label for="checkCustomer"></label>
                                            </div>
                                        </div></td>
                                    <td colspan="2"><label for="checkCustomer">CUSTOMER</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerDaftar" value="daftar_customer">
                                                <label for="checkCustomerDaftar"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerDaftar">Customer</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerSubmission" value="customer_submission">
                                                <label for="checkCustomerSubmission"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerSubmission">Submission Approval</label></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 5%;"><div class="form-group clearfix">
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" id="checkCustomerSwitch" value="customer_switch_level">
                                                <label for="checkCustomerSwitch"></label>
                                            </div>
                                        </div></td>
                                    <td><label for="checkCustomerSwitch">Switch Level Customer</label></td>
                                </tr>
                            </table>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <table style="width: 100%;">
                                    
                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkManajemenStok" value="manajemen_stok">
                                                    <label for="checkManajemenStok"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkManajemenStok">MANAJEMEN STOK</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokBaru" value="manajemen_stok_baru">
                                                    <label for="checkManajemenStokBaru"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokBaru">Stok Baru</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokDaftar" value="manajemen_stok_daftar">
                                                    <label for="checkManajemenStokDaftar"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokDaftar">Daftar Stok</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkManajemenStokKartu" value="manajemen_stok_kartu">
                                                    <label for="checkManajemenStokKartu"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkManajemenStokKartu">Kartu Stok</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkDaftarTrans" value="daftar_tarnsaksi">
                                                    <label for="checkDaftarTrans"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkDaftarTrans">DAFTAR TRANSAKSI</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransPO" value="daftar_transaksi_po">
                                                    <label for="checkDaftarTransPO"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransPO">Purchase Order</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransReceive" value="daftar_transaksi_receive">
                                                    <label for="checkDaftarTransReceive"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransReceive">Receive</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkDaftarTransPenjualan" value="daftar_transaksi_penjualan">
                                                    <label for="checkDaftarTransPenjualan"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkDaftarTransPenjualan">Penjualan</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkTransaksi" value="transaksi">
                                                    <label for="checkTransaksi"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkTransaksi">TRANSAKSI</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransSampel" value="transaksi_sampel">
                                                    <label for="checkTransSampel"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransSampel">Pemberian Sample</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransPO" value="transaksi_po">
                                                    <label for="checkTransPO"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransPO">Purchase Order</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReceive" value="transaksi_receive">
                                                    <label for="checkTransReceive"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReceive">Receiving</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransPenjualan" value="transaksi_penjualan">
                                                    <label for="checkTransPenjualan"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransPenjualan">Penjualan</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReturnBeli" value="transaksi_return_beli">
                                                    <label for="checkTransReturnBeli"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReturnBeli">Return Pembelian</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkTransReturnJual" value="transaksi_return_jual">
                                                    <label for="checkTransReturnJual"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkTransReturnJual">Return Penjualan</label></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkTransaksi" value="transaksi">
                                                    <label for="checkTransaksi"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkTransaksi">KEUANGAN</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganBayarHutang" value="keuangan_bayar_hutang">
                                                    <label for="checkKeuanganBayarHutang"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganBayarHutang">Pembayaran Hutang</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganTerimaPiutang" value="keuangan_terima_piutang">
                                                    <label for="checkKeuanganTerimaPiutang"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganTerimaPiutang">Penerimaan Piutang</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkKeuanganHutangKontainer" value="keuangan_hutang_kontainer">
                                                    <label for="checkKeuanganHutangKontainer"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkKeuanganHutangKontainer">Pembayaran Hutang Kontainer</label></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkPersetujuan" value="persetujuan">
                                                    <label for="checkPersetujuan"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkPersetujuan">PERSETUJUAN</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkPersetujuanJual" value="persetujaun_penjualan">
                                                    <label for="checkPersetujuanJual"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkPersetujuanJual">Penjualan</label></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="checkManajUser" value="manaj_user">
                                                    <label for="checkManajUser"></label>
                                                </div>
                                            </div></td>
                                        <td colspan="2"><label for="checkManajUser">MANAJEMEN USER</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkUserRolesPermission" value="manaj_users_roles_permission">
                                                    <label for="checkUserRolesPermission"></label>
                                                </div>
                                            </div></td>
                                        <td><label for="checkUserRolesPermission">Roles Permission</label></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 5%;"><div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="checkUsersUser" value="manaj_users_user">
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
        <button type="submit" class="btn btn-outline-success" id="tbl_approve" disabled>Submit</button>
    </div>
</form>