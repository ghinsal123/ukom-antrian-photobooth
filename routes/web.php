<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

//ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login.page');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');

    // protected routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // nanti ganti ke controller
        })->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

//CUSTOMER
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