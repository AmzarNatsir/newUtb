<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Client\App;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KontainerController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ViaController;
use App\Models\MerkModel;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Iterator\CustomFilterIterator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// client/customers
Route::prefix('client')->group(function(){
    Route::get('/', [App::class,'index'])->name('client:app');
});



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashbaordController::class, 'index'])->name('dashboard');
//Common Unit
Route::get('satuan', [UnitController::class, 'index'])->name("satuan");
Route::get('unitAdd', [UnitController::class, 'add'])->name("unitAdd");
Route::post('unitStore', [UnitController::class, 'store'])->name("unitStore");
Route::get('unitEdit/{id}', [UnitController::class, 'edit'])->name("unitEdit");
Route::put('unitUpdate/{id}', [UnitController::class, 'update'])->name('unitUpdate');
Route::get('unitDelete/{id}', [UnitController::class, 'delete'])->name('unitDelete');

//Common Merk
Route::get('merk', [MerkController::class, 'index'])->name("listMerk");
Route::get('merkAdd', [MerkController::class, 'add'])->name("merkAdd");
Route::post('merkStore', [MerkController::class, 'store'])->name("merkStore");
Route::get('merkEdit/{id}', [MerkController::class, 'edit'])->name("merkEdit");
Route::put('merkUpdate/{id}', [MerkController::class, 'update'])->name('merkUpdate');
Route::get('merkDelete/{id}', [MerkController::class, 'delete'])->name('merkDelete');

//Common Product
Route::get('stok', [ProductController::class, 'index'])->name('stok');
Route::get('productAdd', [ProductController::class, 'add'])->name("productAdd");
Route::post('productStore', [ProductController::class, 'store'])->name("productStore");
Route::get('productEdit/{id}', [ProductController::class, 'edit'])->name("productEdit");
Route::put('productUpdate/{id}', [ProductController::class, 'update'])->name('productUpdate');
Route::get('productDelete/{id}', [ProductController::class, 'delete'])->name('productDelete');
//create sub product
Route::get('productSub/{id}', [ProductController::class, 'add_sub_produk'])->name("productSub");
Route::post('productSubStore', [ProductController::class, 'store'])->name("productSubStore");
//Common Supplier
Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
Route::get('supplierAdd', [SupplierController::class, 'add'])->name("supplierAdd");
Route::post('supplierStore', [SupplierController::class, 'store'])->name("supplierStore");
Route::get('supplierEdit/{id}', [SupplierController::class, 'edit'])->name("supplierEdit");
Route::put('supplierUpdate/{id}', [SupplierController::class, 'update'])->name('supplierUpdate');
Route::get('supplierDelete/{id}', [SupplierController::class, 'delete'])->name('supplierDelete');

//Common Customer
Route::get('customer', [CustomerController::class, 'index'])->name('customer');
Route::get('customerAdd', [CustomerController::class, 'add'])->name("customerAdd");
Route::post('customerStore', [CustomerController::class, 'store'])->name("customerStore");
Route::get('customerEdit/{id}', [CustomerController::class, 'edit'])->name("customerEdit");
Route::put('customerUpdate/{id}', [CustomerController::class, 'update'])->name('customerUpdate');
Route::get('customerDelete/{id}', [CustomerController::class, 'delete'])->name('customerDelete');

//Common Kontainer
Route::get('kontainer', [KontainerController::class, 'index'])->name('kontainer');
Route::get('kontainerAdd', [KontainerController::class, 'add'])->name("kontainerAdd");
Route::post('kontainerStore', [KontainerController::class, 'store'])->name("kontainerStore");
Route::get('kontainerEdit/{id}', [KontainerController::class, 'edit'])->name("kontainerEdit");
Route::put('kontainerUpdate/{id}', [KontainerController::class, 'update'])->name('kontainerUpdate');
Route::get('kontainerDelete/{id}', [KontainerController::class, 'delete'])->name('kontainerDelete');

//Common Penerimaan
Route::get('via', [ViaController::class, 'index'])->name("via");
Route::get('viaAdd', [ViaController::class, 'add'])->name("viaAdd");
Route::post('viaStore', [ViaController::class, 'store'])->name("viaStore");
Route::get('viaEdit/{id}', [ViaController::class, 'edit'])->name("viaEdit");
Route::put('viaUpdate/{id}', [ViaController::class, 'update'])->name('viaUpdate');
Route::get('viaDelete/{id}', [ViaController::class, 'delete'])->name('viaDelete');

//Manajemen Stok
Route::get('daftarStok', [ProductController::class, 'list_stok'])->name('daftarStok');
Route::get('settingStok', [ProductController::class, 'setting_stok'])->name('settingStok');
Route::post('settingStokStore', [ProductController::class, 'setting_stok_store'])->name('settingStokStore');
//kartu stok
Route::get('kartuStok', [ProductController::class, 'kartu_stok'])->name('kartuStok');
Route::post('searchItemKartuStok', [ProductController::class, 'searchItemKartuStok'])->name('searchItemKartuStok');
Route::post('KartuStokFilter', [ProductController::class, 'kartu_stok_filter'])->name('KartuStokFilter');
//Purchase Order
Route::get('purchaseOrder', [POController::class, 'index'])->name('purchaseOrder');
Route::get('purchaseOrderAdd', [POController::class, 'add'])->name('purchaseOrderAdd');
Route::post('purchaseOrderStore', [POController::class, 'store'])->name("purchaseOrderStore");
Route::get('editOrder/{id}', [POController::class, 'edit'])->name('editOrder');
Route::put('updateOrder/{id}', [POController::class, 'update'])->name('updateOrder');
Route::post('deleteItemOrder', [POController::class, 'delete_items'])->name('deleteItemOrder');
Route::get('deleteOrder/{id}', [POController::class, 'delete_po'])->name('deleteOrder');
//approve PO
Route::get('approveOrder/{id}', [POController::class, 'approve'])->name('approveOrder');
Route::put('approvePOStore/{id}', [POController::class, 'approveStore'])->name('approvePOStore');
Route::get('printOrder/{id}', [POController::class, 'print'])->name('printOrder');
//Receiving
Route::get('receiving', [ReceivingController::class, 'index'])->name('receiving');
Route::get('receivingAdd/{id}', [ReceivingController::class, 'add'])->name('receivingAdd');
Route::post('receiveStore', [ReceivingController::class, 'store'])->name('receiveStore');
//penjualan
Route::get('penjualan', [PenjualanController::class, 'index'])->name("penjualan");
Route::post('penjualanStore', [PenjualanController::class, 'store'])->name("penjualanStore");

//pemberian sample produk
Route::get('pemberianSampel', [ProductController::class, 'pemberian_sampel'])->name("pemberianSampel");
Route::post('pemberianSampelStore', [ProductController::class, 'pemberian_sampel_store'])->name("pemberianSampelStore");


Route::post('searchItem', [ProductController::class, 'searchItemJual'])->name('searchItem');
Route::post('searchItemPenjualan', [ProductController::class, 'searchItemJual'])->name('searchItemPenjualan');
//Hutang
Route::get('pembayaranHutang', [HutangController::class, 'index'])->name('pembayaranHutang');
Route::post('pembayaranHutangFilter', [HutangController::class, 'filter'])->name("pembayaranHutangFilter");
Route::post('pembayaranHutangBayar', [HutangController::class, 'bayar'])->name("pembayaranHutangBayar");
Route::post('pembayaranHutangStore', [HutangController::class, 'bayar_store'])->name("pembayaranHutangStore");
Route::get('pembayaranHutangMutasi/{id}', [HutangController::class, 'mutasi'])->name("pembayaranHutangMutasi");
Route::get('pembayaranHutangMutasiPrint/{id}', [HutangController::class, 'mutasi_print'])->name("pembayaranHutangMutasiPrint");
//pembayaran hutang kontainer
Route::get('pembayaranHutangKontainer', [HutangController::class, 'hutang_kontainer'])->name('pembayaranHutangKontainer');
Route::post('pembayaranHutangKontainerFilter', [HutangController::class, 'hutang_kontainer_filter'])->name("pembayaranHutangKontainerFilter");
Route::post('pembayaranHutangKontainerBayar', [HutangController::class, 'hutang_kontainer_bayar'])->name("pembayaranHutangKontainerBayar");
Route::post('pembayaranHutangKontainerStore', [HutangController::class, 'hutang_kontainer_store'])->name("pembayaranHutangKontainerStore");
Route::get('pembayaranHutangKontainerMutasi/{id}', [HutangController::class, 'hutang_kontainer_mutasi'])->name("pembayaranHutangKontainerMutasi");
Route::get('pembayaranHutangKontainerMutasiPrint/{id}', [HutangController::class, 'hutang_kontainer_mutasi_print'])->name("pembayaranHutangKontainerMutasiPrint");

//Piutang
Route::get('penerimaanPiutang', [PiutangController::class, 'index'])->name('penerimaanPiutang');
Route::post('penerimaanPiutangFilter', [PiutangController::class, 'filter'])->name("penerimaanPiutangFilter");
Route::post('penerimaanPiutangBayar', [PiutangController::class, 'bayar'])->name("penerimaanPiutangBayar");
Route::post('penerimaanPiutangStore', [PiutangController::class, 'bayar_store'])->name("penerimaanPiutangStore");
Route::get('penerimaanPiutangMutasi/{id}', [PiutangController::class, 'mutasi'])->name("penerimaanPiutangMutasi");
Route::get('penerimaanPiutangMutasiPrint/{id}', [PiutangController::class, 'mutasi_print'])->name("penerimaanPiutangMutasiPrint");


//Return
//Pembelian
Route::get('returnPembelian', [ReturnController::class, 'return_pembelian'])->name('returnPembelian');
Route::get('returnPembelianFilter/{param}', [ReturnController::class, 'filter_invoice_pembelian'])->name('returnPembelianFilter');
Route::post('returnPembelianSearch', [ReturnController::class, 'search_invoice_pembelian'])->name('returnPembelianSearch');
Route::get('returnPembelianDetailInvoice/{param}', [ReturnController::class, 'filter_invoice_pembelian_detail'])->name('returnPembelianDetailInvoice');
Route::post('returnPembelianStore', [ReturnController::class, 'return_pembelian_store'])->name('returnPembelianStore');
//penjualan
Route::get('returnPenjualan', [ReturnController::class, 'return_penjualan'])->name('returnPenjualan');
Route::get('returnPenjualanFilter/{param}', [ReturnController::class, 'filter_invoice_penjualan'])->name('returnPenjualanFilter');
Route::post('returnPenjualanSearch', [ReturnController::class, 'search_invoice_penjualan'])->name('returnPenjualanSearch');
Route::get('returnPenjualanDetailInvoice/{param}', [ReturnController::class, 'filter_invoice_penjualan_detail'])->name('returnPenjualanDetailInvoice');
Route::post('returnPenjualanStore', [ReturnController::class, 'return_penjualan_store'])->name('returnPenjualanStore');
//Pelaporan
//Pembelian
Route::get('laporanPembelian', [PelaporanController::class, 'laporan_pembelian'])->name("laporanPembelian");
Route::post('laporanPembelianFilter', [PelaporanController::class, 'laporan_pembelian_filter'])->name('laporanPembelianFilter');
Route::get('laporanPembelianDetail/{id}', [PelaporanController::class, 'laporan_pembelian_detail'])->name('laporanPembelianDetail');
Route::get('laporanPembelianPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_pembelian_print'])->name('laporanPembelianPrint');
//penjualan
Route::get('laporanPenjualan', [PelaporanController::class, 'laporan_penjualam'])->name("laporanPenjualan");
Route::post('laporanPenjualanFilter', [PelaporanController::class, 'laporan_penjualan_filter'])->name('laporanPenjualanFilter');
Route::get('laporanPenjualanDetail/{id}', [PelaporanController::class, 'laporan_penjualan_detail'])->name('laporanPenjualanDetail');
Route::get('laporanPenjualanPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_penjualan_print'])->name('laporanPenjualanPrint');

Route::get('printInvoice/{id}', [PenjualanController::class, 'print_invoice'])->name('printInvoice');

//pemberian sampel
Route::get('laporanPemerianSampel', [PelaporanController::class, 'laporan_pemberian_sampel'])->name('laporanPemerianSampel');
Route::post('laporanPemerianSampelFilter', [PelaporanController::class, 'laporan_pemberian_sampel_filter'])->name('laporanPemerianSampelFilter');
Route::get('laporanPemerianSampelDetail/{id}', [PelaporanController::class, 'laporan_pemberian_sampel_detail'])->name('laporanPemerianSampelDetail');
Route::get('laporanPemerianSampelPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_pemberian_sampel_print'])->name('laporanPemerianSampelPrint');

//laporan stok
Route::get('laporanStok', [PelaporanController::class, 'laporan_stok'])->name("laporanStok");
Route::post('laporanStokFilter', [PelaporanController::class, 'laporan_stok_filter'])->name('laporanStokFilter');
Route::get('laporanStokPrint/{param1}/{param2}', [PelaporanController::class, 'laporan_stok_print'])->name('laporanStokPrint');

//laporan return pembelian
Route::get('laporanReturnPembelian', [PelaporanController::class, 'laporan_return_pembelian'])->name("laporanReturnPembelian");
Route::post('laporanReturnPembelianFilter', [PelaporanController::class, 'laporan_return_pembelian_filter'])->name("laporanReturnPembelianFilter");
Route::get('laporanReturnPembelianDetail/{id}', [PelaporanController::class, 'laporan_return_pembelian_detail'])->name('laporanReturnPembelianDetail');
Route::get('laporanReturnPembelianPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_return_pembelian_print'])->name('laporanReturnPembelianPrint');

//laporan return penjualan
Route::get('laporanReturnPenjualan', [PelaporanController::class, 'laporan_return_penjualan'])->name("laporanReturnPenjualan");
Route::post('laporanReturnPenjualanFilter', [PelaporanController::class, 'laporan_return_penjualan_filter'])->name("laporanReturnPenjualanFilter");
Route::get('laporanReturnPenjualanDetail/{id}', [PelaporanController::class, 'laporan_return_penjualan_detail'])->name('laporanReturnPenjualanDetail');
Route::get('laporanReturnPenjualanPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_return_penjualan_print'])->name('laporanReturnPenjualanPrint');

//laporan hutang
Route::get('laporanHutang', [PelaporanController::class, 'laporan_hutang'])->name("laporanHutang");
Route::post('laporanHutangFilter', [PelaporanController::class, 'laporan_hutang_filter'])->name("laporanHutangFilter");
Route::get('laporanHutangPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_hutang_print'])->name('laporanHutangPrint');

//laporan piutang
Route::get('laporanPiutang', [PelaporanController::class, 'laporan_piutang'])->name("laporanPiutang");
Route::post('laporanPiutangFilter', [PelaporanController::class, 'laporan_piutang_filter'])->name("laporanPiutangFilter");
Route::get('laporanPiutangPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_piutang_print'])->name('laporanPiutangPrint');

//laporan hutang kontainer
Route::get('laporanHutangKontainer', [PelaporanController::class, 'laporan_hutang_kontainer'])->name("laporanHutangKontainer");
Route::post('laporanHutangKontainerFilter', [PelaporanController::class, 'laporan_hutang_kontainer_filter'])->name("laporanHutangKontainerFilter");
Route::get('laporanHutangKontainerPrint/{param1}/{param2}/{param3}', [PelaporanController::class, 'laporan_hutang_kontainer_print'])->name('laporanHutangKontainerPrint');


//Invoice
//PO
Route::get('invoicePO', [InvoiceController::class, 'invoice_po'])->name('invoicePO');
Route::post('invoicePOFilter', [InvoiceController::class, 'invoice_po_filter'])->name('invoicePOFilter');

//Receiving
Route::get('invoiceReceiving', [InvoiceController::class, 'invoice_receiving'])->name('invoiceReceiving');
Route::post('invoiceReceivingFilter', [InvoiceController::class, 'invoice_receive_filter'])->name('invoiceReceivingFilter');
Route::get('invoiceReceivingPrint/{param1}', [InvoiceController::class, 'invoice_receiving_print'])->name('invoiceReceivingPrint');

//Penjualan
Route::get('invoicePenjualan', [InvoiceController::class, 'invoice_penjualan'])->name('invoicePenjualan');
Route::post('invoicePenjualanFilter', [InvoiceController::class, 'invoice_penjualan_filter'])->name('invoicePenjualanFilter');

//Persetujuan
//penjualan
Route::get('persetujuanPenjualan', [PersetujuanController::class, 'persetujuan_penjualan'])->name('persetujuanPenjualan');
Route::get('persetujuanPenjualanData', [PersetujuanController::class, 'persetujuan_penjualan_data'])->name('persetujuanPenjualanData');
Route::get('persetujuanPenjualanFilter/{param1}/{param2}', [PersetujuanController::class, 'persetujuan_penjualan_filter'])->name('persetujuanPenjualanFilter');
Route::get('persetujuanPenjualanApprove/{param}', [PersetujuanController::class, 'persetujuan_penjualan_approve'])->name('persetujuanPenjualanApprove');
Route::post('persetujuanPenjualanStore', [PersetujuanController::class, 'persetujuan_penjualan_store'])->name('persetujuanPenjualanStore');

//level 2
Route::get('persetujuanPenjualanApprove_2/{param}', [PersetujuanController::class, 'persetujuan_penjualan_approve_2'])->name('persetujuanPenjualanApprove_2');
Route::post('persetujuanPenjualanStore_2', [PersetujuanController::class, 'persetujuan_penjualan_store_2'])->name('persetujuanPenjualanStore_2');

Route::get('vqrcode', [QrController::class, 'index'])->name('vqrcode');

//manajemen user
//roles permission
Route::get('roles_permission', [UsersController::class, 'roles_permission'])->name('roles_permission');
Route::get('roles_permission_add', [UsersController::class, 'roles_permission_add'])->name('roles_permission_add');
Route::post('roles_permission_store', [UsersController::class, 'roles_permission_store'])->name('roles_permission_store');
Route::get('roles_permission_edit/{id}', [UsersController::class, 'roles_permission_edit'])->name('roles_permission_edit');
Route::put('roles_permission_update/{id}', [UsersController::class, 'roles_permission_update'])->name('roles_permission_update');
Route::get('roles_permission_delete/{id}', [UsersController::class, 'roles_permission_delete'])->name('roles_permission_delete');

//users
Route::get('users', [UsersController::class, 'index'])->name('users');
Route::get('users_add', [UsersController::class, 'users_add'])->name('users_add');
Route::get('get_role_permission/{param}', [UsersController::class, 'get_role_permission'])->name('get_role_permission');
Route::post('users_store', [UsersController::class, 'users_store'])->name('users_store');
Route::get('users_edit/{id}', [UsersController::class, 'users_edit'])->name('users_edit');
Route::put('users_update/{id}', [UsersController::class, 'users_update'])->name('users_update');
Route::get('users_delete/{id}', [UsersController::class, 'users_delete'])->name('users_delete');