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

Route::get('/', 'HomeController@index');

/*
 * Devices
 */
// Index
Route::get('/devices', 'DeviceController@index');
// Create
Route::get('/device/create', 'DeviceController@getCreatePage');
// Read
Route::get('/device/{id}', 'DeviceController@getDevicePage');
// Update
Route::get('/device/{id}/edit', 'DeviceController@getUpdatePage');
// Delete
Route::get('/device/{id}/delete', 'DeviceController@getDeletePage');
Route::post('/device/{id}/delete', 'DeviceController@postDeletePage');


Route::get('/device/{id}/messages', 'DeviceController@showMessages');