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
Route::group(['middleware' => ['permission:المبيعات']], function () {
    Route::get('/sales','Manager\SellController@index')->name('sales.index');
    Route::get('/ajax/get/product/{repository_id}/{barcode}','Manager\RepositoryController@getProductAjax');
    Route::group(['middleware' => ['check_user']], function () {
        Route::get('/create/invoice/form/{repository_id}','Manager\SellController@createInvoiceForm')->name('create.invoice');
        //Route::get('/modal/customer/{repository_id}','Manager\SellController@modalCustomer')->name('modal.customer');  // 2
        Route::get('/create/special/invoice/form/{repository_id}','Manager\SellController@createSpecialInvoiceForm')->name('create.special.invoice'); // 2
        Route::post('/sell/{repository_id}','Manager\SellController@sell')->name('make.sell');
        Route::get('/show/pending/invoices/{repository_id}','Manager\SellController@showPending')->name('show.pending');
        Route::get('/search/pending/{repository_id}','Manager\ReportController@searchPending')->name('search.pending');
        Route::get('/show/invoice/details/{repository_id}','Manager\SellController@invoiceDetails')->name('invoice.details');
        //Route::get('/show/special/invoice/details/{repository_id}','Manager\SellController@specialInvoiceDetails')->name('special.invoice.details');  // 2
        Route::post('/sell/special/invoice/{repository_id}','Manager\SellController@sellSpecialInvoice')->name('sell.special.invoice');  // 2
        Route::post('/save/special/invoice/{repository_id}','Manager\SellController@saveSpecialInvoice')->name('save.special.invoice');  // 2
    });
    // need middleware for variable id
    Route::get('/complete/invoice/form/{invoice_id}','Manager\SellController@completeInvoiceForm')->name('complete.invoice.form')->middleware('permission:استكمل فاتورة معلقة');
    Route::post('/complete/invoice/{invoice_id}','Manager\SellController@completeInvoice')->name('complete.invoice')->middleware('permission:استكمل فاتورة معلقة');
});
Route::group(['middleware' => ['permission:المخزون']], function () {
    Route::get('/repository','Manager\RepositoryController@index')->name('repository.index');
    Route::post('/store/product','Manager\RepositoryController@storeProduct')->name('store.product');
    Route::group(['middleware' => ['check_user']], function () {
        Route::get('/add/product/form/{repository_id}','Manager\RepositoryController@addProductForm')->name('add.product.form');
        Route::get('/import/products/excel/{repository_id}','Manager\RepositoryController@importExcelForm')->name('import.excel.form');
        Route::post('/store/products/excel/{repository_id}','Manager\RepositoryController@importExcel')->name('import.excel');
        Route::get('/show/products/{repository_id}','Manager\RepositoryController@showProducts')->name('show.products');
    });
});
Route::group(['middleware'=>['permission:التقارير']], function () {
    Route::get('/reports','Manager\ReportController@index')->name('reports.index');
    Route::group(['middleware' => ['check_user']], function () {
        Route::get('/show/invoices/{repository_id}','Manager\ReportController@showInvoices')->name('show.invoices');
        Route::get('/search/invoices/{repository_id}','Manager\ReportController@searchInvoicesByDate')->name('search.invoices');
        Route::get('/search/invoices/code/{repository_id}','Manager\ReportController@searchInvoicesByCode')->name('search.invoices.code');
        Route::get('/daily/reports/{repository_id}','Manager\ReportController@dailyReports')->name('daily.reports.index');
    });
});



Route::group(['middleware'=>['permission:الاعدادات']], function () {
    Route::get('manager/settings','Manager\SettingsController@index')->name('manager.settings.index');
    Route::group(['middleware' => ['check_user']], function () {
        Route::get('settings/min/{repository_id}','Manager\SettingsController@minForm')->name('settings.min.form');
        Route::post('change/min/{repository_id}','Manager\SettingsController@min')->name('settings.min');
        Route::post('change/tax/{repository_id}','Manager\SettingsController@tax')->name('settings.tax');
        Route::get('settings/app/{repository_id}','Manager\SettingsController@app')->name('settings.app');
        Route::post('submit/settings/app/{repository_id}','Manager\SettingsController@submitApp')->name('submit.settings.app'); 
        Route::get('/worker/add/{repository_id}','Manager\SettingsController@addWorkerForm')->name('add.worker')->middleware('permission:اضافة موظف جديد');
        Route::post('/worker/store/{repository_id}','Manager\SettingsController@storeWorker')->name('store.worker')->middleware('permission:اضافة موظف جديد');
        Route::get('all/workers/{repository_id}','Manager\SettingsController@showWorkers')->name('show.workers');
    });
    // need middleware for variable
    Route::get('show/worker/permissions/{user_id}','Manager\SettingsController@showWorkerPermissions')->name('show.worker.permissions')->middleware('permission:عرض الموظفين');
    Route::post('edit/worker/permissions/{user_id}','Manager\SettingsController@editWorkerPermissions')->name('edit.worker.permissions')->middleware('permission:تعديل صلاحيات موظف'); 
});

Route::group(['middleware'=>['permission:الكاشير']], function () {
    Route::get('/cashier','Manager\CashierController@index')->name('cashier.index');
    Route::group(['middleware' => ['check_user']], function () {
        Route::get('/daily/cashier/{repository_id}','Manager\CashierController@dailyCashierForm')->name('daily.cashier.form')->middleware('permission:اغلاق الكاشير');
        Route::post('/submit/cashier/{repository_id}','Manager\CashierController@submitCashier')->name('submit.cashier')->middleware('permission:اغلاق الكاشير');
    });
});

Route::get('/clients/{repository_id}','Manager\SettingsController@clients')->name('clients');
Route::get('/client/edit/{client_id}','Manager\SettingsController@editClient')->name('edit.client');
Route::post('/client/update/{client_id}','Manager\SettingsController@updateClient')->name('update.client');


Route::post('edit/product','Manager\RepositoryController@editProductForm')->name('edit.product'); // we use form input hidden to use id and not passing it into url
Route::post('update/product','Manager\RepositoryController@updateProduct')->name('update.product'); // we use form input hidden to use id and not passing it into url


//Route::get('/home', 'HomeController@index')->name('home');
