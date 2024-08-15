<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {

    //Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    //Add admin middleware
    Route::group(['middleware' => ['admin']], function () {

        //Admin Dashboard Route
        Route::get('/dashboard', 'AdminController@dashboard');
        Route::get('/logout', 'AdminController@logout');
        Route::get('/category', 'AdminController@category');
    });
});

require __DIR__ . '/auth.php';
