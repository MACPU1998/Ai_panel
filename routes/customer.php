<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;


Route::prefix('customer')->group(function () {

    Route::get('/login', [CustomerAuthController::class, 'index'])->name('customer.index')->middleware('CustomerAuthenticated')->addMeta(true, ["super admin:admin"]);
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login')->addMeta(true, ["super admin:admin"]);
    Route::get('/edit', [CustomerAuthController::class, 'edit'])->name('customer.edit')->addMeta(true, ["super admin:admin"]);
    Route::put('/update', [CustomerAuthController::class, 'update'])->name('customer.update')->addMeta(true, ["super admin:admin"]);
    Route::get('/password/edit', [CustomerAuthController::class, 'editPassword'])->name('customer.edit.password')->addMeta(true, ["super admin:admin"]);
    Route::put('/password/update', [CustomerAuthController::class, 'updatePassword'])->name('customer.update.password')->addMeta(true, ["super admin:admin"]);
    Route::get('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout')->addMeta(true, ["super admin:admin"]);

    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard')->addMeta(true, ["super admin:admin"]);
    });

    //Route Menu
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menus.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [MenuController::class, 'create'])->name('menus.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [MenuController::class, 'store'])->name('menus.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [MenuController::class, 'getMenuData'])->name('menus.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [MenuController::class, 'datatable'])->name('menus.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{menu}/update', [MenuController::class, 'update'])->name('menus.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy')->addMeta(true, ["super admin:admin"]);

    });

    //Route category
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [CategoryController::class, 'getCategoryData'])->name('categories.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [CategoryController::class, 'datatable'])->name('categories.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{category}/update', [CategoryController::class, 'update'])->name('categories.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->addMeta(true, ["super admin:admin"]);

    });


    //Route products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [ProductController::class, 'create'])->name('products.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [ProductController::class, 'store'])->name('products.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [ProductController::class, 'getProductData'])->name('products.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [ProductController::class, 'datatable'])->name('products.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('products.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->addMeta(true, ["super admin:admin"]);
        Route::get('/reset-filters', function () {
            session()->forget('product-filters');
            return redirect()->route('products.index');
        })->name('products.resetFilters');
    });


    //Route subProduct
    Route::prefix('sub-products')->group(function () {
        Route::get('/products/{id}/info', [SubProductController::class, 'getProductInfo'])->name('products.info')->addMeta(true, ["super admin:admin"]);
        Route::get('/', [SubProductController::class, 'index'])->name('subProducts.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [SubProductController::class, 'create'])->name('subProducts.create')->addMeta(true, ["super admin:admin"]);
        Route::get('/create-group', [SubProductController::class, 'createGroup'])->name('subProducts.create.group')->addMeta(true, ["super admin:admin"]);
        Route::get('/create-excel', [SubProductController::class, 'createExcel'])->name('subProducts.create.excel')->addMeta(true, ["super admin:admin"]);
      //  Route::post('/import-excel', [SubProductController::class, 'importExcel'])->name('subProducts.import.excel')->addMeta(true, ["super admin:admin"]);
        Route::get('/download-excel-sample', [SubProductController::class, 'downloadSampleExcel'])->name('subProducts.download.excel')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [SubProductController::class, 'store'])->name('subProducts.store')->addMeta(true, ["super admin:admin"]);
        Route::post('/store-group', [SubProductController::class, 'storeGroup'])->name('subProducts.store.group')->addMeta(true, ["super admin:admin"]);
        Route::post('/store-excel', [SubProductController::class, 'storeExcel'])->name('subProducts.store.excel')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [SubProductController::class, 'getSubProductData'])->name('subProducts.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [SubProductController::class, 'datatable'])->name('subProducts.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{subProduct}/edit', [SubProductController::class, 'edit'])->name('subProducts.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{subProduct}/update', [SubProductController::class, 'update'])->name('subProducts.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{subProduct}', [SubProductController::class, 'destroy'])->name('subProducts.destroy')->addMeta(true, ["super admin:admin"]);
        Route::get('/reset-filters', function () {
            session()->forget('sub-product-filters');
            return redirect()->route('subProducts.index');
        })->name('subProducts.resetFilters');

    });


    //Route customers
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [CustomerController::class, 'store'])->name('customers.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [CustomerController::class, 'getCustomersData'])->name('customers.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [CustomerController::class, 'datatable'])->name('customers.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{customer}/update', [CustomerController::class, 'update'])->name('customers.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy')->addMeta(true, ["super admin:admin"]);
        Route::get('/reset-filters', function () {
            session()->forget('customer-filters');
            return redirect()->route('customers.index');
        })->name('customers.resetFilters');

    });

    //Route setting
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [SettingController::class, 'create'])->name('settings.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [SettingController::class, 'store'])->name('settings.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [SettingController::class, 'getSettingsData'])->name('settings.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [SettingController::class, 'datatable'])->name('settings.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{setting}/update', [SettingController::class, 'update'])->name('settings.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy')->addMeta(true, ["super admin:admin"]);


    });


    //Route orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create')->addMeta(true, ["super admin:admin"]);
        Route::get('/preview/{customer}', [OrderController::class, 'preview'])->name('orders.preview')->addMeta(true, ["super admin:admin"]);
        Route::get('/cart-count/{customer}', [OrderController::class, 'cartCount'])->name('orders.cartCount');
        Route::post('/add-to-order', [OrderController::class, 'addToOrder'])->name('orders.add_to_order')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [OrderController::class, 'store'])->name('orders.store')->addMeta(true, ["super admin:admin"]);
        Route::post('/confirm-local', [OrderController::class, 'confirmLocal'])->addMeta(true);
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/data', [OrderController::class, 'getOrdersData'])->name('orders.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [OrderController::class, 'datatable'])->name('orders.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{order}/update', [OrderController::class, 'update'])->name('orders.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->addMeta(true, ["super admin:admin"]);
        Route::get('/reset-filters', function () {
            session()->forget('order-filters');
            return redirect()->route('orders.index');
        })->name('orders.resetFilters');
    });

    //Route setting
    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallets.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [WalletController::class, 'create'])->name('wallets.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [WalletController::class, 'store'])->name('wallets.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [WalletController::class, 'getWalletData'])->name('wallets.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [WalletController::class, 'datatable'])->name('wallets.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{wallet}/edit', [WalletController::class, 'edit'])->name('wallets.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{wallet}/update', [WalletController::class, 'update'])->name('wallets.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{wallet}', [WalletController::class, 'destroy'])->name('wallets.destroy')->addMeta(true, ["super admin:admin"]);

    });
    //Route setting
    Route::prefix('smarts')->group(function () {
        Route::get('/', [SmartController::class, 'index'])->name('smarts.index')->addMeta(true, ["super admin:admin"]);
        Route::post('/send', [SmartController::class, 'send'])->name('smarts.send');
    });


});
