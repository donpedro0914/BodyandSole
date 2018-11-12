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
Route::post('front/ajaxAddon', 'FrontController@ajaxAddon');
Route::post('/gc/checker', 'FrontController@checker');
Route::post('joborder/store', 'FrontController@store');
Route::post('joborder/update', 'FrontController@update');
Route::post('joborder/cancelupdate', 'FrontController@cancelupdate');
Route::post('joborder/duration', 'FrontController@duration');
Route::post('joborder/checkavailable', 'FrontController@checkavailable');
Route::post('joborder/transfer', 'FrontController@transfer');
Route::post('f_attendance/store', 'FrontController@attendance_store');

/* Clients Front */
Route::get('f_clients', 'FrontController@f_clients');
Route::post('f_client/store', 'FrontController@f_client_store');
Route::get('f_client/clientlist', 'FrontController@clientlist')->name('f_client.clientlist');

/* GC Front */
Route::get('f_gift-certificate', 'FrontController@f_gift_certificate');
Route::post('f_gc/store', 'FrontController@f_gc_store');

/* Expenses  Front */
Route::get('f_petty-expenses', 'FrontController@f_petty_expenses');
Route::post('f_expense/store', 'FrontController@f_expense_store');

/* Payroll Front */
Route::get('f_payroll', 'FrontController@f_payroll');
Route::get('f_payroll/filtered', 'FrontController@f_payroll_filter')->name('f_payroll_filter');

Auth::routes();

/* Dashboard */
Route::get('/dashboard', 'AdminController@index');
Route::get('/logout', 'AdminController@logout');

/* Therapist */
Route::get('/therapist', 'TherapistController@index');
Route::post('therapist/store', 'TherapistController@store');
Route::get('therapist/edit/{id}', 'TherapistController@edit');
Route::post('therapist/update/{id}', 'TherapistController@update');
Route::delete('therapist/delete/{id}', 'TherapistController@delete');

/* Settings */
Route::get('settings', 'AdminController@settings');
Route::post('admin/settings/{id}', 'AdminController@save_settings');

/* Clients */
Route::get('clients', 'ClientsController@index');
Route::post('client/store', 'ClientsController@store');
Route::get('client/edit/{id}', 'ClientsController@edit');
Route::post('client/update/{id}', 'ClientsController@update');
Route::delete('client/delete/{id}', 'ClientsController@delete');

/* Services */
Route::get('services', 'ServicesController@index');
Route::post('services/store', 'ServicesController@store');
Route::get('services/edit/{id}', 'ServicesController@edit');
Route::post('services/update/{id}', 'ServicesController@update');
Route::delete('services/delete/{id}', 'ServicesController@delete');

/* Packages */
Route::get('packages', 'PackagesController@index');
Route::get('/packages/add', 'PackagesController@add_page');
Route::post('package/ajaxService', 'PackagesController@ajaxService');
Route::post('packages/store', 'PackagesController@store');
Route::get('packages/edit/{id}', 'PackagesController@edit');
Route::post('packages/getServices', 'PackagesController@getServices');
Route::post('packages/update/{id}', 'PackagesController@update');
Route::delete('packages/delete/{id}', 'PackagesController@delete');

/* Rooms */
Route::get('/rooms-lounge', 'AdminController@rooms_view');
Route::post('room/add_room', 'AdminController@add_room');
Route::get('room/edit/{id}', 'AdminController@edit_room');
Route::post('rooms/update/{id}', 'AdminController@update_room');
Route::delete('rooms/delete/{id}', 'AdminController@delete_room');

/* Gift Certificate */
Route::get('gift-certificate', 'GiftcertificateController@index');
Route::post('gc/store', 'GiftcertificateController@store');
Route::get('gc/edit/{id}', 'GiftcertificateController@edit');
Route::post('gc/update/{id}', 'GiftcertificateController@update');
Route::delete('gc/delete/{id}', 'GiftcertificateController@delete');

/* Job order */
Route::get('/job-order', 'JobOrderController@index');
Route::get('/joborder/edit/{id}', 'JobOrderController@edit');
Route::post('/joborder/update/{id}', 'JobOrderController@update');
Route::delete('joborder/delete/{id}', 'JobOrderController@delete');

/* Reports */
Route::get('/sales-reports', 'ReportsController@sales_reports');
Route::get('/payroll-reports', 'ReportsController@payroll_reports');
Route::get('/weekly-commission-reports', 'ReportsController@weekly_commission_reports');
Route::get('/weekly-attendance-reports', 'ReportsController@weekly_attendance_reports');
Route::get('/expense-reports', 'ReportsController@expense_reports');
Route::get('weekly-commission-reports/therapist/{id}', 'ReportsController@therapist_detailed_report');
Route::get('/weekly-commission-reports/filter', 'ReportsController@wcr_filter')->name('wcr_filter');
Route::get('/payroll-reports/filter', 'ReportsController@payroll_filter')->name('payroll_filter');

/* Test */
Route::get('home', 'HomeController@index');
Route::get('home/index', 'HomeController@index');
Route::get('home/printESCPOS', 'PrintESCPOSController@index');
Route::get('PrintESCPOSController', 'FrontController@printCommands');
Route::any('WebClientPrintController', 'WebClientPrintController@processRequest');