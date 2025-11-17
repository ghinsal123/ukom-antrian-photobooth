<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Operator\LoginController as OperatorLoginController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\AntrianController;
use App\Http\Controllers\Customer\DashboardController;





Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest (belum login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    // Authenticated
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| OPERATOR
|--------------------------------------------------------------------------
*/
Route::prefix('operator')->name('operator.')->group(function () {

    Route::middleware('guest:operator')->group(function () {
        Route::get('login', [OperatorLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [OperatorLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('operator')->group(function () {
        Route::get('dashboard', fn () => view('operator.dashboard'))->name('dashboard');
        Route::post('logout', [OperatorLoginController::class, 'logout'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/


Route::get('/login', function () {
    return redirect()->route('customer.login');
})->name('login');

Route::get('/', function () {
    return redirect()->route('customer.login');
});

Route::prefix('customer')->name('customer.')->group(function () {

    Route::middleware('guest:customer')->group(function () {
        Route::get('login', [CustomerLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [CustomerLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('customer')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');

        Route::get('antrian', fn () => view('Customer.antrian'))->name('antrian');
       Route::post('antrian/store', [AntrianController::class, 'store'])->name('antrian.store');

        Route::get('activity/{id}', fn ($id) => view('Customer.detail', compact('id')))->name('activity.detail');
        Route::get('activity/{id}/edit', fn ($id) => view('Customer.edit', compact('id')))->name('activity.edit');

        Route::delete('activity/{id}/delete', [DashboardController::class, 'delete'])->name('activity.delete');
    });
});