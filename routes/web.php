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
Route::get('/sales','Manager\SellController@index')->name('sales.index');
Route::get('/repository','Manager\RepositoryController@index')->name('repository.index');
Route::get('/add/product/form/{repository_id}','Manager\RepositoryController@addProductForm')->name('add.product.form');
Route::post('/store/product','Manager\RepositoryController@storeProduct')->name('store.product');
Route::get('/show/products/{repository_id}','Manager\RepositoryController@showProducts')->name('show.products');
Route::get('/import/products/excel/{repository_id}','Manager\RepositoryController@importExcelForm')->name('import.excel.form');
Route::post('/store/products/excel/{repository_id}','Manager\RepositoryController@importExcel')->name('import.excel');

//Route::get('/home', 'HomeController@index')->name('home');
