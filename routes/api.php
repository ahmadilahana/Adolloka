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

    //data akun dan data profile
    Route::get('/user', 'ProfileController@index');

    //update data profile dan alamat utama
    Route::post('/user/update', 'ProfileController@cekprofile');
});