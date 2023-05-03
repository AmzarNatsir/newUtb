<?php

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

Route::get('unit', [UnitController::class, 'index'])->name("listUnit");
Route::get('unitAdd', [UnitController::class, 'add'])->name("unitAdd");
Route::post('unitStore', [UnitController::class, 'store'])->name("unitStore");
Route::get('unitEdit/{id}', [UnitController::class, 'edit'])->name("unitEdit");
Route::put('unitUpdate/{id}', [UnitController::class, 'update'])->name('unitUpdate');
Route::get('unitDelete/{id}', [UnitController::class, 'delete'])->name('unitDelete');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
