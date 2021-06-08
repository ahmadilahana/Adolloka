<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', 'Api\UserController@register');
Route::post('/login', 'Api\UserController@login');


//get barang
Route::get('/barang', 'Api\BarangController@index');

//get barang
Route::get('/barang/kategori/{id_kategori}', 'Api\BarangController@barangPerKategori');

//get satu barang
Route::get('/barang/{id_barang}/show', 'Api\BarangController@show');

//get Kategori Barang
Route::get('/barang/kategori', 'Api\BarangController@kategori');

Route::group([
    'middleware' => 'jwt.verify',
    'namespace' => 'Api'
], function($route){

    //AKUN
    Route::get('/home', 'UserController@getAuthenticatedUser');
    Route::post('/username/update', 'UserController@editUsername');
    Route::post('/password/update', 'UserController@editPassword');
    Route::post('/email/update', 'UserController@editEmail');
    Route::post('/no_hp/update', 'UserController@editNoHp');
    
    //ALAMAT & PROFILE
    Route::get('/user', 'ProfileController@index');
    Route::post('/user/profile/biodata/update', 'ProfileController@cekprofile');
    Route::post('/user/profile/foto/update', 'FotoProfileController@cekprofile');
    Route::post('/user/profile/alamat/update', 'AlamatUserController@cekAlamat');
    Route::get('/user/alamat', 'AlamatUserController@index');
    Route::post('/user/alamat/create', 'AlamatUserController@alamatbaru');
    Route::post('/user/alamat/{id_alamat}/update', 'AlamatUserController@edit');
    Route::post('/user/alamat/{id_alamat}/delete', 'AlamatUserController@destroy');
    Route::post('/user/alamat/{id_alamat}/eneble', 'AlamatUserController@aktifAlamat');
    
    //TOKO
    Route::get('/toko', 'TokoController@index');
    Route::post('/toko/update', 'TokoController@cektoko');
    Route::get('/toko/barang', 'TokoController@getbarang');
    Route::post('/toko/barang/create', 'TokoController@tambahBarang');
    Route::post('/toko/barang/foto/tambah', 'FotoBarangController@tambah');
    Route::post('/toko/barang/{id_barang}/update', 'TokoController@updateBarang');
    Route::post('/toko/barang/foto/hapus', 'FotoBarangController@hapus');
    Route::post('/toko/barang/{id_barang}/hapus', 'TokoController@deletebarang');
    
    //CART
    Route::post('/cart/add', 'CartController@add');
    Route::post('/cart/{id}/delete', 'CartController@delete');
    Route::post('/cart/{id}/edit', 'CartController@edit');
    Route::get('/cart', 'CartController@index');
    
    //TRANSAKSI
    Route::post('/checkout', 'TransaksiController@checkout');
    Route::post('/beli ', 'TransaksiController@beli');
    Route::post('/bayar ', 'TransaksiController@bayar');
    Route::post('/sudah_bayar ', 'TransaksiController@sudahbayar');
    Route::get('/user/transaksi ', 'TransaksiController@index');
    Route::post('/sudah_bayar/edit ', 'TransaksiController@editsudahbayar');
    Route::get('/toko/transaksi', 'TransaksiController@transaksitoko');
    Route::get('/transaksi/detail/{id_transksi} ', 'TransaksiController@detailtransaksi');
    Route::post('/transaksi/pembayaran-ditolak/{id_transksi} ', 'TransaksiController@pembayaranditolak');
    Route::post('/transaksi/pembayaran-diterima/{id_transksi} ', 'TransaksiController@pembayaranditerima');
    Route::post('/transaksi/packing/{id_transksi} ', 'TransaksiController@packing');
    Route::post('/transaksi/pengiriman/{id_transksi} ', 'TransaksiController@pengiriman');
    Route::post('/transaksi/diterima/{id_transksi} ', 'TransaksiController@diterima');
    
});