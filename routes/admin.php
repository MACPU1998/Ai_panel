<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\goodsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCurrencyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'index'])->name('index')->middleware('AdminAuthenticated');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::get('/edit', [AdminAuthController::class, 'edit'])->name('admin.edit');
    Route::put('/update', [AdminAuthController::class, 'update'])->name('admin.update');
    Route::get('/password/edit', [AdminAuthController::class, 'editPassword'])->name('admin.edit.password');
    Route::put('/password/update', [AdminAuthController::class, 'updatePassword'])->name('admin.update.password');
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
        Route::get('users/data', [UserController::class, 'getUsersData'])->name('users.getData');
        Route::get('/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        Route::get('/{admin}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{admin}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('password/{user}/edit', [UserController::class, 'editPassword'])->name('users.edit.password');
        Route::put('password/{user}/update', [UserController::class, 'updatePassword'])->name('users.update.password');
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

    //Route category
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/data', [CategoryController::class, 'getCategoryData'])->name('categories.getData');
        Route::get('/datatable', [CategoryController::class, 'datatable'])->name('categories.datatable');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    });

    //Route product currencies
    Route::prefix('product-currencies')->group(function () {
        Route::get('/', [ProductCurrencyController::class, 'index'])->name('productCurrencies.index');
        Route::get('/create', [ProductCurrencyController::class, 'create'])->name('productCurrencies.create');
        Route::post('/store', [ProductCurrencyController::class, 'store'])->name('productCurrencies.store');
        Route::get('/data', [ProductCurrencyController::class, 'getProductCurrencyData'])->name('productCurrencies.getData');
        Route::get('/datatable', [ProductCurrencyController::class, 'datatable'])->name('productCurrencies.datatable');
        Route::get('/{productCurrency}/edit', [ProductCurrencyController::class, 'edit'])->name('productCurrencies.edit');
        Route::put('/{productCurrency}/update', [ProductCurrencyController::class, 'update'])->name('productCurrencies.update');
        Route::delete('/{productCurrency}', [ProductCurrencyController::class, 'destroy'])->name('productCurrencies.destroy');

    });

    //Route products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/data', [ProductController::class, 'getProductData'])->name('products.getData');
        Route::get('/datatable', [ProductController::class, 'datatable'])->name('products.datatable');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    });

    //Route product attributes
    Route::prefix('product-attributes')->group(function () {
        Route::get('/', [ProductAttributeController::class, 'index'])->name('productAttributes.index');
        Route::get('/create', [ProductAttributeController::class, 'create'])->name('productAttributes.create');
        Route::post('/store', [ProductAttributeController::class, 'store'])->name('productAttributes.store');
        Route::get('/data', [ProductAttributeController::class, 'getProductAttributeData'])->name('productAttributes.getData');
        Route::get('/datatable', [ProductAttributeController::class, 'datatable'])->name('productAttributes.datatable');
        Route::get('/{productAttribute}/edit', [ProductAttributeController::class, 'edit'])->name('productAttributes.edit');
        Route::put('/{productAttribute}/update', [ProductAttributeController::class, 'update'])->name('productAttributes.update');
        Route::delete('/{productAttribute}', [ProductAttributeController::class, 'destroy'])->name('productAttributes.destroy');

    });

    //Route goods
    Route::prefix('goods')->group(function () {
        Route::get('/', [goodsController::class, 'index'])->name('goods.index');
        Route::get('/create', [goodsController::class, 'create'])->name('goods.create');
        Route::post('/store', [goodsController::class, 'store'])->name('goods.store');
        Route::get('/data', [goodsController::class, 'getGoodsData'])->name('goods.getData');
        Route::get('/datatable', [goodsController::class, 'datatable'])->name('goods.datatable');
        Route::get('/{goods}/edit', [goodsController::class, 'edit'])->name('goods.edit');
        Route::put('/{goods}/update', [goodsController::class, 'update'])->name('goods.update');
        Route::delete('/{goods}', [goodsController::class, 'destroy'])->name('goods.destroy');

    });

});
