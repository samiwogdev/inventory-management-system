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

        // Dashboard
        Route::get('/dashboard', 'AdminController@showDashboard');
        
        //User
        Route::get('/logout', 'AdminController@logout');
        Route::post('/check-current-password', 'AdminController@checkAdminPassword');
        Route::get('/editUser', 'AdminController@showEditUsers')->name('admin.editUser');;
        Route::put('updateUsers', 'AdminController@updateAdminPassword');
        Route::get('/allUsers', 'AdminController@viewUsers');
        Route::get('/addUser', 'AdminController@showAddUsers');
        Route::post('/addUser', 'AdminController@saveUser');
        Route::delete('/deleteUser/{id}', 'AdminController@deleteUser')->name('admin.deleteUser');

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

        //product
        Route::get('/productList', 'ProductController@showProductList');
        Route::get('/addProduct', 'ProductController@showAddProduct');
        Route::get('/editProduct/{id}', 'ProductController@showEditProduct')->name('admin.editProduct');
        Route::post('/addProduct', 'ProductController@store');
        Route::put('/updateProduct/{id}', 'ProductController@updateProduct');
        Route::delete('/deleteProduct/{id}', 'ProductController@deleteProduct')->name('admin.deleteProduct');

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
        Route::put('/updateStatus/{id}', 'OrdersController@updateStatus')->name('admin.updateStatus');;
        Route::delete('/deleteOrder/{id}', 'OrdersController@deleteOrder')->name('admin.deleteOrder');

        // notification 
        Route::put('/notifications', 'NotificationController@clear');

        //sales
        Route::get('/sales', 'SalesController@viewSales');

        // reports
        Route::get('/reports', 'ReportController@generateReport');
        Route::get('/generateReport', 'ReportController@showGenerateReport');
        Route::get('/ReportToCsv', 'ReportController@exportReportToCsv');

    });
});

require __DIR__ . '/auth.php';
