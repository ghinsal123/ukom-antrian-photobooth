<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// Home
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {

    // Auth
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login.page');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login');

    // Protected Routes (kalau pakai middleware auth)
    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/antrian', function () {
            return view('Customer.antrian');
        })->name('antrian');

        Route::get('/activity/{id}', function () {
            return view('Customer.detail');
        })->name('activity.detail');

        Route::get('/activity/{id}/edit', function () {
            return view('Customer.edit');
        })->name('activity.edit');

        Route::get('/activity/{id}/delete', function () {
            return view('Customer.hapus');
        })->name('activity.delete');

        Route::post('/logout', function () {
            auth()->logout();
            return redirect()->route('customer.login.page');
        })->name('logout');
    });
});
