<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\CabangController;

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