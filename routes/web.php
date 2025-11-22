<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\BoothController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Operator\LoginController as OperatorLoginController;
use App\Http\Controllers\Operator\AntrianController as OperatorAntrianController;
use App\Http\Controllers\Operator\LogController as OperatorLogController;
use App\Http\Controllers\Operator\BoothController as OperatorBoothController;
use App\Http\Controllers\Operator\PaketController as OperatorPaketController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Customer\AntrianController as CustomerAntrianController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\AntrianController; 

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
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        // ⬇⬇ FIXED HERE
        Route::resource('pengguna', PenggunaController::class)->names('pengguna');
        Route::resource('booth', BoothController::class)->names('booth');
        Route::resource('paket', PaketController::class)->names('paket');
        Route::resource('log', LogController::class)->names('log');
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
        Route::get('dashboard', [OperatorDashboardController::class, 'index'])
        ->name('dashboard');
        Route::post('logout', [OperatorLoginController::class, 'logout'])->name('logout');

        /*
        |--------------------------------------------------------------------------
        | ANTRIAN (CRUD)
        |--------------------------------------------------------------------------
        */
        Route::prefix('antrian')->name('antrian.')->group(function () {

            Route::get('/', [OperatorAntrianController::class, 'index'])->name('index');
            Route::get('/create', [OperatorAntrianController::class, 'create'])->name('create');
            Route::post('/store', [OperatorAntrianController::class, 'store'])->name('store');

            Route::get('/detail/{id}', [OperatorAntrianController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [OperatorAntrianController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [OperatorAntrianController::class, 'update'])->name('update');

            Route::delete('/delete/{id}', [OperatorAntrianController::class, 'destroy'])->name('delete');
        });

        // JADWAL
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');

        // Booth
        Route::get('/booth', [OperatorBoothController::class, 'index'])->name('booth.index');
        Route::get('/booth/{id}', [OperatorBoothController::class, 'show'])->name('booth.show');

        // Paket
        Route::get('/paket', [OperatorPaketController::class, 'index'])->name('paket.index');
        Route::get('/paket/{id}', [OperatorPaketController::class, 'show'])->name('paket.show');

        // Logs
        Route::get('/laporan', [OperatorLogController::class, 'index'])
            ->name('log.index')
            ->middleware('operator'); 

    });

});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->name('customer.')->group(function () {

    // AUTH LOGIN
    Route::middleware('guest:customer')->group(function () {
        Route::get('login', [CustomerLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [CustomerLoginController::class, 'login'])->name('login.submit');
    });

    // CUSTOMER AUTHENTICATED
    Route::middleware('customer')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');

        // CREATE
        Route::get('antrian', [AntrianController::class, 'create'])->name('antrian');
        Route::post('antrian/store', [AntrianController::class, 'store'])->name('antrian.store');

        // DETAIL
        Route::get('antrian/{id}/detail', [AntrianController::class, 'detail'])->name('antrian.detail');

        // EDIT + UPDATE
        Route::get('antrian/{id}/edit', [AntrianController::class, 'edit'])->name('antrian.edit');
        Route::put('antrian/{id}', [AntrianController::class, 'update'])->name('antrian.update');

        // DELETE
        Route::delete('antrian/{id}', [AntrianController::class, 'destroy'])->name('antrian.delete');
    });
});
