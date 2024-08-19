<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {

    //Login
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    //Add middleware
    Route::group(['middleware' => ['admin']], function () {

        Route::get('/dashboard', 'AdminController@dashboard');
        Route::get('/logout', 'AdminController@logout');

        //category
        Route::get('/categoryList', 'CategoryController@showCategoryList');
        Route::get('/addCategory', 'CategoryController@showAddCategory');
        Route::get('/editCategory/{id}', 'CategoryController@showEditCategory')->name('admin.editCategory');
        Route::post('/addCategory', 'CategoryController@store');
        Route::put('/updateCategory/{id}', 'CategoryController@updateCategory');
        Route::delete('/deleteCategory/{id}', 'CategoryController@deleteCategory')->name('admin.deleteCategory');

        //supplier
        Route::get('/supplierList', 'SupplierController@showSupplierList');
        Route::get('/addSupplier', 'SupplierController@showAddSupplier');
        Route::get('/editSupplier/{id}', 'SupplierController@showEditSupplier')->name('admin.editSupplier');
        Route::post('/addSupplier', 'SupplierController@store');
        Route::put('/updateSupplier/{id}', 'SupplierController@updateSupplier');
        Route::delete('/deleteSupplier/{id}', 'SupplierController@deleteSupplier')->name('admin.deleteSupplier');
    });
});

require __DIR__ . '/auth.php';
