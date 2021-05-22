<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/',  'HomeController@main')->middleware('auth');
Route::get('/home','HomeController@index')->middleware('auth');
Route::get('/ltr',function () {
    return view('settings.ltr');
})->name('ltr');

Auth::routes();

//Route::group(['middleware' => ['permission:المناصب']], function () {
Route::get('/roles','RolesController@index')->name('roles');
Route::get('/role/add/form','RolesController@addRoleForm')->name('role.add.form');
Route::post('/role/add','RolesController@addRole')->name('role.add');
Route::get('/edit/role/permissions/{id}','RolesController@editRolePermissionForm')->name('edit.role.permissions');
Route::post('/make/edit/role/permissions/{id}','RolesController@editRolePermissions')->name('make.edit.role.permissions');

//});
Route::get('/permissions','PermissionController@index')->name('permissions');
Route::get('/permission/add/form','PermissionController@addPermissionForm')->name('permission.add.form');
Route::post('/permission/store','PermissionController@store')->name('permission.store');


Route::resource('/repositories','RepositoryController');

// manager
Route::group(['middleware' => ['permission:المبيعات','permission:التقارير','permission:المخزون']], function () {
Route::get('/repository','Manager\RepositoryController@index')->name('repository.index');
Route::post('/store/product','Manager\RepositoryController@storeProduct')->name('store.product');
Route::get('/sales','Manager\SellController@index')->name('sales.index');
});
Route::group(['middleware'=>['permission:المبيعات','permission:التقارير','permission:المخزون','check_user']], function () {
    Route::get('/add/product/form/{repository_id}','Manager\RepositoryController@addProductForm')->name('add.product.form');
    Route::get('/show/products/{repository_id}','Manager\RepositoryController@showProducts')->name('show.products');
    Route::get('/import/products/excel/{repository_id}','Manager\RepositoryController@importExcelForm')->name('import.excel.form');
    Route::post('/store/products/excel/{repository_id}','Manager\RepositoryController@importExcel')->name('import.excel');
    Route::get('/create/invoice/form/{repository_id}','Manager\SellController@createInvoiceForm')->name('create.invoice');
    Route::get('/show/invoice/details/{repository_id}','Manager\SellController@invoiceDetails')->name('invoice.details');
    Route::post('/sell/{repository_id}','Manager\SellController@sell')->name('make.sell');
    Route::get('/show/pending/invoices/{repository_id}','Manager\SellController@showPending')->name('show.pending');
});
Route::get('/reports','Manager\ReportController@index')->name('reports.index');
Route::get('/show/invoices/{repository_id}','Manager\ReportController@showInvoices')->name('show.invoices');
Route::get('/search/invoices/{repository_id}','Manager\ReportController@searchInvoicesByDate')->name('search.invoices');
Route::get('/search/invoices/code/{repository_id}','Manager\ReportController@searchInvoicesByCode')->name('search.invoices.code');
Route::get('/search/pending/{repository_id}','Manager\ReportController@searchPending')->name('search.pending');




Route::get('/complete/invoice/form/{invoice_id}','Manager\SellController@completeInvoiceForm')->name('complete.invoice.form');
Route::post('/complete/invoice/{invoice_id}','Manager\SellController@completeInvoice')->name('complete.invoice');


Route::get('/ajax/get/product/{repository_id}/{barcode}','Manager\RepositoryController@getProductAjax');

Route::get('manager/settings','Manager\SettingsController@index')->name('manager.settings.index');
Route::get('settings/min/{repository_id}','Manager\SettingsController@minForm')->name('settings.min.form');
Route::post('change/min/{repository_id}','Manager\SettingsController@min')->name('settings.min');


Route::get('/cashier','Manager\CashierController@index')->name('cashier.index');
Route::get('/daily/cashier/{repository_id}','Manager\CashierController@dailyCashierForm')->name('daily.cashier.form');
Route::post('/submit/cashier/{repository_id}','Manager\CashierController@submitCashier')->name('submit.cashier');
Route::get('/daily/reports/{repository_id}','Manager\ReportController@dailyReports')->name('daily.reports.index');
//Route::get('/home', 'HomeController@index')->name('home');
