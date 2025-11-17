<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Operator\LoginController as OperatorLoginController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Operator\AntrianController;
use App\Http\Controllers\Admin\PenggunaController;


Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        // ⬇⬇ FIXED HERE
        Route::resource('pengguna', PenggunaController::class)->names('pengguna');
    });

});

/*
|--------------------------------------------------------------------------
| OPERATOR
|--------------------------------------------------------------------------
*/
Route::prefix('operator')->name('operator.')->group(function () {

    // Guest (belum login)
    Route::middleware('guest:operator')->group(function () {
        Route::get('login', [OperatorLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [OperatorLoginController::class, 'login'])->name('login.submit');
    });

    // Sudah login
    Route::middleware('operator')->group(function () {

        // DASHBOARD
        Route::get('dashboard', fn () => view('operator.dashboard'))->name('dashboard');
        Route::post('logout', [OperatorLoginController::class, 'logout'])->name('logout');

        /*
        |--------------------------------------------------------------------------
        | ANTRIAN (CRUD)
        |--------------------------------------------------------------------------
        */
        Route::prefix('antrian')->name('antrian.')->group(function () {

            Route::get('/', [AntrianController::class, 'index'])->name('index');
            Route::get('/create', [AntrianController::class, 'create'])->name('create');
            Route::post('/store', [AntrianController::class, 'store'])->name('store');

            Route::get('/show/{id}', [AntrianController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [AntrianController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [AntrianController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [AntrianController::class, 'destroy'])->name('delete');
        });

    });

});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {

    Route::middleware('guest:customer')->group(function () {
        Route::get('login', [CustomerLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [CustomerLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('customer')->group(function () {
        Route::get('dashboard', [CustomerLoginController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');

        Route::get('antrian', fn () => view('Customer.antrian'))->name('antrian');
        Route::get('activity/{id}', fn () => view('Customer.detail'))->name('activity.detail');
        Route::get('activity/{id}/edit', fn () => view('Customer.edit'))->name('activity.edit');
        Route::get('activity/{id}/delete', fn () => view('Customer.hapus'))->name('activity.delete');
    });
});
