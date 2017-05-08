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
 * Authentication
 */
Route::get('/login', 'AuthController@getLogin');
Route::post('/login', 'AuthController@postLogin');

Route::get('/logout', 'AuthController@logout');

/*
 * User
 */
Route::get('/profile', 'UserController@getProfile');
Route::post('/profile', 'UserController@postProfile');

Route::get('/changepassword', 'UserController@getChangePassword');
Route::post('/changepassword', 'UserController@postChangePassword');

/*
 * Devices
 */
// Index
Route::get('/devices', 'DeviceController@index');
// Create
Route::get('/device/create', 'DeviceController@getCreatePage');
Route::post('/device/create', 'DeviceController@postCreatePage');
// Read
Route::get('/device/{id}', 'DeviceController@getDevicePage');
// Update
Route::get('/device/{id}/edit', 'DeviceController@getUpdatePage');
Route::post('/device/{id}/edit', 'DeviceController@postUpdatePage');
// Delete
Route::get('/device/{id}/delete', 'DeviceController@getDeletePage');
Route::post('/device/{id}/delete', 'DeviceController@postDeletePage');


Route::get('/device/{id}/messages', 'DeviceController@showMessages');

Route::get('data/device/{id}', 'DeviceController@getDeviceData');
Route::get('data/device/{id}/expected', 'DeviceController@getDeviceExpectedData');
Route::get('data/device/{device}/test', 'DataGeneration@index');