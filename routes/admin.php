<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}/edit', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // داشبورد (محافظت‌شده)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // نمایش داشبورد
        })->name('admin.dashboard');
    });
});
