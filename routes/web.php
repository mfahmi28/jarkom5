<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProdukController;

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
    return view('welcome');
});

Route::get('/login', function() {
    return view('login');
});

Route::get('/beranda', function() {
    return view('beranda.index');
});

Route::get('/kategori-produk', [KategoriProdukController::class, 'index']);
Route::get('/kategori-produk/detail', [KategoriProdukController::class, 'getKategoriDetail']);
Route::post('/kategori-produk', [KategoriProdukController::class, 'addKategori']);
Route::put('/kategori-produk', [KategoriProdukController::class, 'editKategori']);
Route::delete('/kategori-produk', [KategoriProdukController::class, 'deleteKategori']);

Route::get('/cabang', [CabangController::class, 'index']);
Route::get('/cabang/detail', [CabangController::class, 'getCabangDetail']);
Route::post('/cabang', [CabangController::class, 'addCabang']);
Route::put('/cabang', [CabangController::class, 'editCabang']);
Route::delete('/cabang', [CabangController::class, 'deleteCabang']);

Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/supplier/detail', [SupplierController::class, 'getSupplierDetail']);
Route::post('/supplier', [SupplierController::class, 'addSupplier']);
Route::put('/supplier', [SupplierController::class, 'editSupplier']);
Route::delete('/supplier', [SupplierController::class, 'deleteSupplier']);

Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/detail', [ProdukController::class, 'getProdukDetail']);
Route::post('/produk', [ProdukController::class, 'addProduk']);
Route::put('/produk', [ProdukController::class, 'editProduk']);
Route::delete('/produk', [ProdukController::class, 'deleteProduk']);