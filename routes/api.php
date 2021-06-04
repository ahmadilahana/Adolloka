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

//get satu barang
Route::get('/barang/{id_barang}/show', 'Api\BarangController@show');

//get Kategori Barang
Route::get('/barang/kategori', 'Api\BarangController@kategori');

Route::group([
    'middleware' => 'jwt.verify',
    'namespace' => 'Api'
], function($route){
    //data akun
    Route::get('/home', 'UserController@getAuthenticatedUser');

    //edit username
    Route::post('/username/update', 'UserController@editUsername');
    
    //edit password
    Route::post('/password/update', 'UserController@editPassword');

    //edit email
    Route::post('/email/update', 'UserController@editEmail');
    
    //edit no hp
    Route::post('/no_hp/update', 'UserController@editNoHp');

    //data akun dan data profile
    Route::get('/user', 'ProfileController@index');

    //update data profile
    Route::post('/user/profile/biodata/update', 'ProfileController@cekprofile');

    //create data alamat
    Route::post('/user/profile/alamat/update', 'AlamatUserController@cekAlamat');

    //get data alamat kirim
    Route::get('/user/alamat', 'AlamatUserController@index');

    //create data alamat kirim
    Route::post('/user/alamat/create', 'AlamatUserController@alamatbaru');

    //edit data alamat kirim
    Route::post('/user/alamat/{id_alamat}/update', 'AlamatUserController@edit');

    //delete data alamat kirim
    Route::post('/user/alamat/{id_alamat}/delete', 'AlamatUserController@destroy');
    
    //eneble data alamat kirim
    Route::post('/user/alamat/{id_alamat}/eneble', 'AlamatUserController@aktifAlamat');

    //update foto profile
    Route::post('/user/profile/foto/update', 'FotoProfileController@cekprofile');
    
    //data toko
    Route::get('/toko', 'TokoController@index');
    
    //get data barang toko
    Route::get('/toko/barang', 'TokoController@getbarang');
    
    //hapus foto barang
    Route::post('/toko/barang/foto/hapus', 'FotoBarangController@hapus');
    
    //upload foto barang
    Route::post('/toko/barang/foto/tambah', 'FotoBarangController@tambah');
    
    //create data barang toko
    Route::post('/toko/barang/create', 'TokoController@tambahBarang');

    //update data barang toko
    Route::post('/toko/barang/{id_barang}/update', 'TokoController@updateBarang');

    //update data toko
    Route::post('/toko/update', 'TokoController@cektoko');

    //create chart
    Route::post('/cart/add', 'CartController@add');

    //delete chart
    Route::post('/cart/{id}/delete', 'CartController@delete');
    
    //update chart
    Route::post('/cart/{id}/edit', 'CartController@edit');
    
    //get chart
    Route::get('/cart', 'CartController@index');
    
    //get checkout
    Route::post('/checkout', 'TransaksiController@checkout');
    
    //get beli
    Route::post('/beli ', 'TransaksiController@beli');
    
    //get bayar
    Route::post('/bayar ', 'TransaksiController@bayar');
    
    //get sudah bayar
    Route::post('/sudah_bayar ', 'TransaksiController@sudahbayar');
});