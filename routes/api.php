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

Route::group([
    'middleware' => 'jwt.verify',
    'namespace' => 'Api'
], function($route){
    //data akun
    Route::get('/home', 'UserController@getAuthenticatedUser');

    //edit username
    Route::post('/username/update', 'UserController@editUsername');

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

    //update foto profile
    Route::post('/user/profile/foto/update', 'FotoProfileController@cekprofile');
    
    Route::get('/allprofile', 'FotoProfileController@index');
    //data toko
    Route::get('/toko', 'TokoController@index');

    //update data toko
    Route::post('/toko/update', 'TokoController@cektoko');

    //create data barang
    Route::post('/{id}/barang', 'BarangController@store');
    
});