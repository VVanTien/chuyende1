<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::get('/users', function () {
    return view('admin.users');
});

Route::get('/cars', function () {
    return view('admin.cars');
});

Route::get('/brands', function () {
    return view('admin.brands');
});

/* ── Auth routes ── */
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot_pass');
});