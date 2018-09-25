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

Route::get('list-unit-by-name/{id}','Api\SosmedapiController@list_unit_by_name');

Route::group(['prefix'=>'sosmed','middleware'=>'auth:api'],function(){
    Route::resource('group-unit','Sosmed\GroupunitController');
    Route::resource('business-unit','Sosmed\BusinessunitController');
    Route::resource('program-unit','Sosmed\ProgramunitController');
    Route::resource('sosmed','Sosmed\SosmedController');
    Route::resource('unit-sosmed','Sosmed\UnitsosmedController');
    Route::resource('unit-sosmed-follower','Sosmed\UnitsosmedfollowerController');
});
