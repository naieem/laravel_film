<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// =========================================
// getting all films =======================
// =========================================
Route::get('films','FilmController@index');
// =========================================
// getting single film =======================
// =========================================
Route::get('films/{id}','FilmController@show');
// =========================================
// updating film ===========================
// =========================================
Route::post('films/{id}','FilmController@update');
// =========================================
// registering new user ====================
// =========================================
Route::post('user/new','UserController@register');
// =========================================
// login user ====================
// =========================================
Route::post('user/login','UserController@login');
// =========================================
// verify token ====================
// =========================================
Route::post('verify/token','UserController@verify')->middleware('jwt-validation');