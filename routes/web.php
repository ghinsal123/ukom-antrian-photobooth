<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\BoothController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\LogController;

/*
|--------------------------------------------------------------------------
| OPERATOR
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Operator\LoginController as OperatorLoginController;
use App\Http\Controllers\Operator\AntrianController as OperatorAntrianController;
use App\Http\Controllers\Operator\LogController as OperatorLogController;
use App\Http\Controllers\Operator\BoothController as OperatorBoothController;
use App\Http\Controllers\Operator\PaketController as OperatorPaketController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Customer\LandingPageController;
use App\Http\Controllers\Customer\AntrianController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    // Admin Logged In
    Route::middleware('admin')->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Khusus staff
        Route::get('pengguna/staff', [PenggunaController::class, 'staff'])->name('pengguna.staff');
        
        // Khusus customer
        Route::get('pengguna/customer', [PenggunaController::class, 'customer'])->name('pengguna.customer');
        
        // CRUD Admin
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

    // Login
    Route::middleware('guest:operator')->group(function () {
        Route::get('login', [OperatorLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [OperatorLoginController::class, 'login'])->name('login.submit');
    });

    // Logged In
    Route::middleware('operator')->group(function () {

        Route::get('dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [OperatorLoginController::class, 'logout'])->name('logout');

        // PROFILE
        Route::middleware('operator')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Operator\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Operator\ProfileController::class, 'update'])->name('profile.update');
    });

        // ANTRIAN CRUD
        Route::prefix('antrian')->name('antrian.')->group(function () {

            Route::get('/', [OperatorAntrianController::class, 'index'])->name('index');
            Route::get('/create', [OperatorAntrianController::class, 'create'])->name('create');
            Route::post('/store', [OperatorAntrianController::class, 'store'])->name('store');

            Route::get('/detail/{id}', [OperatorAntrianController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [OperatorAntrianController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [OperatorAntrianController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [OperatorAntrianController::class, 'destroy'])->name('delete');

            // Barcode & Ticketing
            Route::get('/tiket/{id}', [OperatorAntrianController::class, 'tiket'])->name('tiket');
            Route::post('/scan', [OperatorAntrianController::class, 'scanBarcode'])->name('scan');

            // Manual complete
            Route::post('/{id}/complete', [OperatorAntrianController::class, 'complete'])->name('complete');
            Route::get('/cetak-pdf/{id}', [OperatorAntrianController::class, 'cetakPdf'])->name('cetakPdf');
            Route::patch('/{id}/cancel', [OperatorAntrianController::class, 'cancel'])->name('cancel');
             /*
            |--------------------------------------------------------------------------
            | STEP 1 DAN STEP 2
            |--------------------------------------------------------------------------
            */
            Route::get('/step1', [OperatorAntrianController::class, 'step1'])
                ->name('step1');

            Route::post('/step1', [OperatorAntrianController::class, 'step1Store'])
                ->name('step1.store');

            Route::get('/step2', [OperatorAntrianController::class, 'step2'])
                ->name('step2');

            Route::post('/step2', [OperatorAntrianController::class, 'step2Store'])
                ->name('step2.store');
                });

            // Booth
            Route::get('/booth', [OperatorBoothController::class, 'index'])->name('booth.index');
            Route::get('/booth/{id}', [OperatorBoothController::class, 'show'])->name('booth.show');

            // Paket
            Route::get('/paket', [OperatorPaketController::class, 'index'])->name('paket.index');
            Route::get('/paket/{id}', [OperatorPaketController::class, 'show'])->name('paket.show');

            // Laporan Log
            Route::get('/laporan', [OperatorLogController::class, 'index'])->name('log.index');
        });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {

    // Landing page untuk semua
    Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
    Route::get('landingpage', [LandingPageController::class, 'index'])->name('landingpage');

    // Auth Customer
    Route::get('login', [CustomerLoginController::class, 'showLogin'])->name('login');
    Route::post('login', [CustomerLoginController::class, 'login'])->name('login.submit');
    
    // Route Daftar
    Route::get('daftar', [CustomerLoginController::class, 'showDaftar'])->name('daftar');
    Route::post('daftar', [CustomerLoginController::class, 'daftar'])->name('daftar.submit');

    // Setelah Login
    Route::middleware('customer')->group(function () {
        Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');

        // Dashboard Customer
        Route::get('dashboard', [LandingPageController::class, 'index'])->name('dashboard');

        // Arsip
        Route::get('arsip', [LandingPageController::class, 'arsip'])->name('arsip');

        // Antrian Routes - PERBAIKAN DIBUAT DI SINI
        Route::prefix('antrian')->group(function () {
            Route::get('/', [AntrianController::class, 'create'])->name('antrian'); // Form buat antrian baru
            Route::post('/store', [AntrianController::class, 'store'])->name('antrian.store');
            
            // 🔥 ROUTE BARU - Check Availability (AJAX)
            Route::get('/check-availability', [AntrianController::class, 'checkAvailability'])->name('antrian.check');
            
            // 🔥 ROUTE BARU YANG DITAMBAHKAN (untuk GET /customer/antrian/{id})
            Route::get('/{id}', [AntrianController::class, 'show'])->name('antrian.show');
            
            // ROUTE DETAIL ANTRIAN
            Route::get('/{id}/detail', [AntrianController::class, 'detail'])->name('antrian.detail');
            
            // ROUTE EDIT ANTRIAN
            Route::get('/{id}/edit', [AntrianController::class, 'edit'])->name('antrian.edit');
            
            // 🔥 FIX: Route PUT harus menggunakan parameter {id}
            Route::put('/{id}', [AntrianController::class, 'update'])->name('antrian.update');
            
            // 🔥 FIX: Route DELETE harus menggunakan parameter {id}
            Route::delete('/{id}', [AntrianController::class, 'destroy'])->name('antrian.delete');
            
            // ROUTE TIKET
            Route::get('/{id}/tiket', [AntrianController::class, 'tiket'])->name('antrian.tiket');
        });

        // Profil
        Route::get('profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
        Route::put('profil/update', [ProfileController::class, 'update'])->name('profil.update');
    });
    
    // Route untuk update status antrian (biasanya dipanggil via AJAX)
    Route::get('/update-antrian-status', [LandingPageController::class, 'updateStatusAntrian'])
        ->name('update.antrian.status');
});

// Fallback route
Route::fallback(function () {
    return redirect()->route('customer.landingpage');
});