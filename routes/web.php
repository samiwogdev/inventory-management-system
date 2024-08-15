<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    });
});

require __DIR__ . '/auth.php';

// returns all users
Route::get('/', UserController::class .'@index')->name('users.index');
// returns the form to create a new user
Route::get('/users/create', UserController::class . '@create')->name('users.create');;
// add a user to the database
Route::post('users', UserController::class .'@store')->name('users.store');
// returns a page that shows a user
Route::get('/users/{user}', UserController::class .'@show')->name('users.show');
// returns the form for editing a user
Route::get('/users/{user}/edit', UserController::class .'@edit')->name('users.edit');
// updates a post
Route::put('/users/{user}', UserController::class .'@update')->name('users.update');
// deletes a post
Route::delete('/users/{user}', UserController::class .'@destroy')->name('users.destroy');


