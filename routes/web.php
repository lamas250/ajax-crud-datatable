<?php

use Illuminate\Support\Facades\Route;

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

/**
 * Users
 */
Route::resource('ajax-crud', 'AjaxCrudController');
Route::post('ajax-crud/update', 'AjaxCrudController@update')->name('ajax-crud.update');
Route::get('ajax-crud/destroy/{id}', 'AjaxCrudController@destroy');
/**
 * Address
 */
Route::resource('address', 'AddressController');
Route::post('address/update', 'AddressController@update')->name('address.update');
Route::get('address/destroy/{id}', 'AddressController@destroy');