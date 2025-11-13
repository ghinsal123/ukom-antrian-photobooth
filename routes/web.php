<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Login
Route::get('/customer/login', [AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'login'])->name('customer.login.post');

// ==== Admin Pages (sementara tanpa controller, preview aja) ====
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/booths', function () {
        return view('admin.booths.index');
    });

    Route::get('/packages', function () {
        return view('admin.packages.index');
    });

    Route::get('/users', function () {
        return view('admin.users.index');
    });

    Route::get('/reports', function () {
        return view('admin.reports.index');
    });
});