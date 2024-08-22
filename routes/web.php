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

        // users
        Route::get('/allUsers', 'UsersControllers@viewUsers');
        Route::get('/addUser', 'UsersControllers@showAddUsers');
        Route::get('/editUser/{id}', 'UsersControllers@showEditUsers')->name('admin.editUser');
        Route::post('/addUser', 'UsersControllers@saveUser');
        Route::put('/updateUsers/{id}', 'UsersControllers@updateUser');
        Route::delete('/deleteUser/{id}', 'UsersControllers@deleteUser')->name('admin.deleteUser');

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

        //customer
        Route::get('/viewCustomer', 'CustomersController@viewCustomers');
        Route::get('/addCustomer', 'CustomersController@addCustomers');
        Route::get('/editCustomer/{id}', 'CustomersController@searchEditCustomer')->name('admin.editCustomer');
        Route::post('/saveCustomer', 'CustomersController@storeCustomer');
        Route::put('/editCustomer/{id}', 'CustomersController@updateCustomer');
        Route::delete('/deleteCustomer/{id}', 'CustomersController@deleteCustomer')->name('admin.deleteCustomer');

        // orders
        Route::get('/orders', 'OrdersController@viewOrders');
        Route::get('/addOrder', 'OrdersController@showAddOrder');
        Route::get('/editOrder/{id}', 'OrdersController@showEditOrder')->name('admin.editOrder');
        Route::post('/addOrder', 'OrdersController@createOrder');
        Route::put('/updateOrder/{id}', 'OrdersController@updateOrder');
        Route::delete('/deleteOrder/{id}', 'OrdersController@deleteOrder')->name('admin.deleteOrder');

    });
});

require __DIR__ . '/auth.php';
