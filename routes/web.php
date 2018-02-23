<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('import-data','HomeController@import_data');

Route::group(['prefix'=>'sosmed'],function(){
    Route::get('official-and-program-account-all-tv','HomeController@official_and_program');
    
    Route::resource('group-unit','Sosmed\GroupunitController');
    Route::get('list-group','Sosmed\GroupunitController@list_group');
    Route::resource('business-unit','Sosmed\BusinessunitController');
    Route::get('list-unit','Sosmed\BusinessunitController@list_unit');
    Route::resource('program-unit','Sosmed\ProgramunitController');
    Route::resource('sosmed','Sosmed\SosmedController');
    Route::get('list-sosmed','Sosmed\SosmedController@list_sosmed');
    Route::resource('unit-sosmed','Sosmed\UnitsosmedController');
    Route::resource('unit-sosmed-follower','Sosmed\UnitsosmedfollowerController');
});