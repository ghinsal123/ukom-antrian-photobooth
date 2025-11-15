<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
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
=======
use App\Http\Controllers\Customer\CustomerController;


Route::get('/customer/login', [CustomerController::class, 'showLogin'])
    ->name('customer.login');

Route::post('/customer/login', [CustomerController::class, 'login'])
    ->name('customer.login.submit');

Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])
    ->name('customer.dashboard');

    

Route::get('/customer/antrian', function () {return view('Customer.antrian');})->name('customer.antrian');
Route::get('/customer/logout', function () {return view('Customer.logout');})->name('customer.logout');
Route::get('/customer/activity/{id}', function () {return view('Customer.detail');})->name('customer.activity.detail');
Route::get('/customer/activity/{id}/edit', function () {return view('Customer.edit');})->name('customer.activity.edit');
Route::get('/customer/activity/{id}/delete', function () {return view('Customer.hapus');})->name('customer.activity.delete');
>>>>>>> Stashed changes
