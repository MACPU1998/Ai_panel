<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // داشبورد (محافظت‌شده)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // نمایش داشبورد
        })->name('admin.dashboard');
    });

    //Route User
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}/edit', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    //Route Role
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/data', [RoleController::class, 'getRolesData'])->name('roles.getData');
        Route::get('/datatable', [RoleController::class, 'datatable'])->name('roles.datatable');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{role}/update', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/list/{role}', [RoleController::class, 'showList'])->name('roles.list');
        Route::post('/list', [RoleController::class, 'assignPermissions'])->name('roles.assign');
    });

    //Route Permission
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/data', [PermissionController::class, 'getPermissionsData'])->name('permissions.getData');
        Route::get('/datatable', [PermissionController::class, 'datatable'])->name('permissions.datatable');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/{permission}/update', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    //Route Menu
    Route::prefix('menus')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menus.index');
        Route::get('/create', [MenuController::class, 'create'])->name('menus.create');
        Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/data', [MenuController::class, 'getMenuData'])->name('menus.getData');
        Route::get('/datatable', [MenuController::class, 'datatable'])->name('menus.datatable');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
        Route::put('/{menu}/update', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    });

});
