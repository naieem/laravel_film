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

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('getRefreshToken', 'AuthController@getRefreshToken');
    Route::get('getLoggedInUserInfo', 'AuthController@getLoggedInUserInfo');

});
// =========================================
// getting all films =======================
// =========================================
Route::get('films','FilmController@index');
// =========================================
// creating new films ======================
// =========================================
Route::post('film/create','FilmController@create');
// =========================================
// getting single film =====================
// =========================================
Route::get('films/{id}','FilmController@show');
// =========================================
// getting single film by slug =============
// =========================================
Route::get('films/getBySlug/{slug}','FilmController@getByslug');
// =========================================
// getting single film by complexx query ===
// =========================================
Route::post('films/getByComplexQuery','FilmController@getByComplexQuery');
// =========================================
// updating film ===========================
// =========================================
Route::post('films/{id}','FilmController@update');
// =========================================
// registering new user ====================
// =========================================
Route::post('user/new','UserController@register');
// =========================================
// Adding comment to films =================
// =========================================
Route::post('comment/add','CommentController@addComment');