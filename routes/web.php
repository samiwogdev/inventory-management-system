<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dash', function () {
    return view('admin/dashboard');
});

Route::get('/signup', function () {
    return view('signup');
});