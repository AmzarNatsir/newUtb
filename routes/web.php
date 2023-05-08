<?php

use App\Http\Controllers\POController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Common Unit
Route::get('unit', [UnitController::class, 'index'])->name("listUnit");
Route::get('unitAdd', [UnitController::class, 'add'])->name("unitAdd");
Route::post('unitStore', [UnitController::class, 'store'])->name("unitStore");
Route::get('unitEdit/{id}', [UnitController::class, 'edit'])->name("unitEdit");
Route::put('unitUpdate/{id}', [UnitController::class, 'update'])->name('unitUpdate');
Route::get('unitDelete/{id}', [UnitController::class, 'delete'])->name('unitDelete');

//Common Product
Route::get('product', [ProductController::class, 'index'])->name('product');
Route::get('productAdd', [ProductController::class, 'add'])->name("productAdd");
Route::post('productStore', [ProductController::class, 'store'])->name("productStore");
Route::get('productEdit/{id}', [ProductController::class, 'edit'])->name("productEdit");
Route::put('productUpdate/{id}', [ProductController::class, 'update'])->name('productUpdate');
Route::get('productDelete/{id}', [ProductController::class, 'delete'])->name('productDelete');

//Common Supplier
Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
Route::get('supplierAdd', [SupplierController::class, 'add'])->name("supplierAdd");
Route::post('supplierStore', [SupplierController::class, 'store'])->name("supplierStore");
Route::get('supplierEdit/{id}', [SupplierController::class, 'edit'])->name("supplierEdit");
Route::put('supplierUpdate/{id}', [SupplierController::class, 'update'])->name('supplierUpdate');
Route::get('supplierDelete/{id}', [SupplierController::class, 'delete'])->name('supplierDelete');

//Purchase Order
Route::get('purchaseOrder', [POController::class, 'index'])->name('purchaseOrder');
Route::get('purchaseOrderAdd', [POController::class, 'add'])->name('purchaseOrderAdd');
Route::post('purchaseOrderStore', [POController::class, 'store'])->name("purchaseOrderStore");
Route::get('editOrder/{id}', [POController::class, 'edit'])->name('editOrder');
Route::put('updateOrder/{id}', [POController::class, 'update'])->name('updateOrder');
Route::post('deleteItemOrder', [POController::class, 'delete_items'])->name('deleteItemOrder');
Route::post('deleteOrder', [POController::class, 'delete_po'])->name('deleteOrder');
//approve PO
Route::get('approveOrder/{id}', [POController::class, 'approve'])->name('approveOrder');
Route::put('approvePOStore/{id}', [POController::class, 'approveStore'])->name('approvePOStore');
Route::get('printOrder/{id}', [POController::class, 'print'])->name('printOrder');
//Receiving
Route::get('receiving', [ReceivingController::class, 'index'])->name('receiving');
Route::get('receivingAdd/{id}', [ReceivingController::class, 'add'])->name('receivingAdd');
Route::post('receiveStore', [ReceivingController::class, 'store'])->name('receiveStore');

//Manajemen Stok
Route::get('daftarStok', [ProductController::class, 'list_stok'])->name('daftarStok');

Route::post('searchItem', [ProductController::class, 'searchItem'])->name('searchItem');
