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

Route::get('/', 'FrontController@index');

Auth::routes();

/* Dashboard */
Route::get('/dashboard', 'AdminController@index')->name('home');
Route::get('/logout', 'AdminController@logout');

/* Therapist */
Route::get('/therapist', 'TherapistController@index');
Route::post('therapist/store', 'TherapistController@store');

/* Settings */
Route::get('settings', 'AdminController@settings');
Route::post('admin/settings', 'AdminController@save_settings');

/* Clients */
Route::get('clients', 'ClientsController@index');
Route::post('client/store', 'ClientsController@store');
Route::get('client/client_list', 'ClientsController@client_list')->name('client.client_list');