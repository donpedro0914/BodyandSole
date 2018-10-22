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

/* Job Order Front */
Route::get('/', 'FrontController@index');
Route::post('package/getpackagedetails', 'FrontController@getpackagedetails');
Route::post('front/ajaxService', 'FrontController@ajaxService');
Route::post('/gc/checker', 'FrontController@checker');
Route::post('joborder/store', 'FrontController@store');
Route::post('joborder/update', 'FrontController@update');
Route::post('joborder/cancelupdate', 'FrontController@cancelupdate');
Route::post('joborder/duration', 'FrontController@duration');
Route::post('joborder/checkavailable', 'FrontController@checkavailable');

Auth::routes();

/* Dashboard */
Route::get('/dashboard', 'AdminController@index');
Route::get('/logout', 'AdminController@logout');

/* Therapist */
Route::get('/therapist', 'TherapistController@index');
Route::post('therapist/store', 'TherapistController@store');
Route::get('therapist/edit/{id}', 'TherapistController@edit');
Route::post('therapist/update/{id}', 'TherapistController@update');

/* Settings */
Route::get('settings', 'AdminController@settings');
Route::post('admin/settings/{id}', 'AdminController@save_settings');

/* Clients */
Route::get('clients', 'ClientsController@index');
Route::post('client/store', 'ClientsController@store');
Route::get('client/edit/{id}', 'ClientsController@edit');
Route::post('client/update/{id}', 'ClientsController@update');

/* Services */
Route::get('services', 'ServicesController@index');
Route::post('services/store', 'ServicesController@store');
Route::get('services/edit/{id}', 'ServicesController@edit');
Route::post('services/update/{id}', 'ServicesController@update');

/* Packages */
Route::get('packages', 'PackagesController@index');
Route::get('/packages/add', 'PackagesController@add_page');
Route::post('package/ajaxService', 'PackagesController@ajaxService');
Route::post('packages/store', 'PackagesController@store');

/* Rooms */
Route::get('/rooms-lounge', 'AdminController@rooms_view');
Route::post('room/add_room', 'AdminController@add_room');
Route::get('room/edit/{id}', 'AdminController@edit_room');
Route::post('rooms/update/{id}', 'AdminController@update_room');

/* Gift Certificate */
Route::get('gift-certificate', 'GiftcertificateController@index');
Route::post('gc/store', 'GiftcertificateController@store');

/* Job order */
Route::get('/job-order', 'JobOrderController@index');

/* Reports */
Route::get('/sales-reports', 'ReportsController@sales_reports');
Route::get('/payroll-reports', 'ReportsController@payroll_reports');
Route::get('/weekly-commission-reports', 'ReportsController@weekly_commission_reports');
Route::get('/expense-reports', 'ReportsController@expense_reports');

/* Test */
Route::get('home', 'HomeController@index');
Route::get('home/index', 'HomeController@index');
Route::get('home/printESCPOS', 'PrintESCPOSController@index');
Route::get('PrintESCPOSController', 'PrintESCPOSController@printCommands');
Route::any('WebClientPrintController', 'WebClientPrintController@processRequest');