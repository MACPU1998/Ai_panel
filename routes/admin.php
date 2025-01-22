<?php

use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'guest'], function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    });
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // داشبورد (محافظت‌شده)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // نمایش داشبورد
        })->name('admin.dashboard');
    });
});
