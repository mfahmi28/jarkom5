<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;

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

Route::get('/cms/beranda', function() {
    return view('beranda.index');
});

Route::get('/cms/kategori-produk', [KategoriProdukController::class, 'index']);
Route::get('/cms/kategori-produk/detail', [KategoriProdukController::class, 'getKategoriDetail']);
Route::post('/cms/kategori-produk', [KategoriProdukController::class, 'addKategori']);
Route::put('/cms/kategori-produk', [KategoriProdukController::class, 'editKategori']);
Route::delete('/cms/kategori-produk', [KategoriProdukController::class, 'deleteKategori']);