<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/data', [PermissionController::class, 'getPermissionsData'])->name('permissions.getData');
    Route::get('permissions/datatable', [PermissionController::class, 'datatable'])->name('permissions.datatable');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{permission}/edit', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/data', [RoleController::class, 'getRolesData'])->name('roles.getData');
    Route::get('roles/datatable', [RoleController::class, 'datatable'])->name('roles.datatable');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}/edit', [RoleController::class, 'update'])->name('roles.update');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('list', [RoleController::class, 'showList'])->name('roles.list');
    Route::post('list', [RoleController::class, 'assignPermissions'])->name('roles.assign');


    // داشبورد (محافظت‌شده)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // نمایش داشبورد
        })->name('admin.dashboard');
    });
});
