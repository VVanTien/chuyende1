<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AdminDashboardController;

// Route::group(['prefix' => '/'], function () {
//     Route::get('/', function () {
//         return view('client.index');
//     });

//     Route::get('/payment', function () {
//         return view('client.payment');
//     });

//     Route::get('/car_detail', function () {
//         return view('client.car_detail');
//     });

//     Route::get('/settings', function () {
//         return view('client.settings');
//     });
// });

Route::get('/', function () {
    return redirect('/auth/login');
});

Route::group(["prefix" => "admin", "middleware" => "auth"], function () {
    Route::get('/', [AdminDashboardController::class, 'index']);

    Route::patch('users/{user}/status', [UserController::class, 'updateStatus']);
    
    Route::resource('users', UserController::class);
    Route::resource('cars', CarController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class);
});

/* ── Auth routes ── */
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('auth.register');
    });
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', function () {
        return view('auth.forgot_pass');
    });
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
