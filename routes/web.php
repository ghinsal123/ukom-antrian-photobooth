<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Operator\ReservasiController;
use App\Http\Controllers\Operator\PaketController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Login
Route::get('/customer/login', [AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'login'])->name('customer.login.post');

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

// DASHBOARD OPERATOR
Route::get('/operator/dashboard', function () {
    return view('Operator.dashboard');
});

// RESERVASI
Route::prefix('operator/reservasi')->name('operator.reservasi.')->group(function () {
    Route::get('/', [ReservasiController::class, 'index'])->name('index');
    Route::get('/create', [ReservasiController::class, 'create'])->name('create');
    Route::post('/store', [ReservasiController::class, 'store'])->name('store');
    Route::get('/show/{id}', [ReservasiController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [ReservasiController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ReservasiController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [ReservasiController::class, 'destroy'])->name('delete');
    Route::get('/print/{id}', [ReservasiController::class, 'print'])->name('print');
});

// PAKET
Route::prefix('operator/paket')->name('operator.paket.')->group(function () {
    Route::get('/', [PaketController::class, 'index'])->name('index');
    Route::get('/show/{id}', [PaketController::class, 'show'])->name('show');
});