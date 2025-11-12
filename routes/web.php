<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Customer\AuthController;

Route::get('/customer/login', [AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'login'])->name('customer.login.post');
