<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCurrencyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.index')->middleware('AdminAuthenticated')->addMeta(true, ["super admin:admin"]);
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login')->addMeta(true, ["super admin:admin"]);
    Route::get('/edit', [AdminAuthController::class, 'edit'])->name('admin.edit')->addMeta(true, ["super admin:admin"]);
    Route::put('/update', [AdminAuthController::class, 'update'])->name('admin.update')->addMeta(true, ["super admin:admin"]);
    Route::get('/password/edit', [AdminAuthController::class, 'editPassword'])->name('admin.edit.password')->addMeta(true, ["super admin:admin"]);
    Route::put('/password/update', [AdminAuthController::class, 'updatePassword'])->name('admin.update.password')->addMeta(true, ["super admin:admin"]);
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->addMeta(true, ["super admin:admin"]);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard')->addMeta(true, ["super admin:admin"]);
    });

    //Route User
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [UserController::class, 'store'])->name('users.store')->addMeta(true, ["super admin:admin"]);
        Route::get('users/data', [UserController::class, 'getUsersData'])->name('users.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [UserController::class, 'datatable'])->name('users.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{admin}/edit', [UserController::class, 'edit'])->name('users.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{admin}/update', [UserController::class, 'update'])->name('users.update')->addMeta(true, ["super admin:admin"]);
        Route::get('password/{admin}/edit', [UserController::class, 'editPassword'])->name('users.edit.password')->addMeta(true, ["super admin:admin"]);
        Route::put('password/{admin}/update', [UserController::class, 'updatePassword'])->name('users.update.password')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{admin}', [UserController::class, 'destroy'])->name('users.destroy')->addMeta(true, ["super admin:admin"]);
    });

    //Route Role
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [RoleController::class, 'getRolesData'])->name('roles.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [RoleController::class, 'datatable'])->name('roles.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{role}/update', [RoleController::class, 'update'])->name('roles.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->addMeta(true, ["super admin:admin"]);
        Route::get('/list/{role}', [RoleController::class, 'showList'])->name('roles.list')->addMeta(true, ["super admin:admin"]);
        Route::post('/list', [RoleController::class, 'assignPermissions'])->name('roles.assign')->addMeta(true, ["super admin:admin"]);
    });

    //Route Permission
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [PermissionController::class, 'getPermissionsData'])->name('permissions.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [PermissionController::class, 'datatable'])->name('permissions.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{permission}/update', [PermissionController::class, 'update'])->name('permissions.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->addMeta(true, ["super admin:admin"]);
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

    //Route product currencies
    Route::prefix('product-currencies')->group(function () {
        Route::get('/', [ProductCurrencyController::class, 'index'])->name('productCurrencies.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [ProductCurrencyController::class, 'create'])->name('productCurrencies.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [ProductCurrencyController::class, 'store'])->name('productCurrencies.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [ProductCurrencyController::class, 'getProductCurrencyData'])->name('productCurrencies.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [ProductCurrencyController::class, 'datatable'])->name('productCurrencies.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{productCurrency}/edit', [ProductCurrencyController::class, 'edit'])->name('productCurrencies.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{productCurrency}/update', [ProductCurrencyController::class, 'update'])->name('productCurrencies.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{productCurrency}', [ProductCurrencyController::class, 'destroy'])->name('productCurrencies.destroy')->addMeta(true, ["super admin:admin"]);

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

    //Route product attributes
    Route::prefix('product-attributes')->group(function () {
        Route::get('/', [ProductAttributeController::class, 'index'])->name('productAttributes.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [ProductAttributeController::class, 'create'])->name('productAttributes.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [ProductAttributeController::class, 'store'])->name('productAttributes.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [ProductAttributeController::class, 'getProductAttributeData'])->name('productAttributes.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [ProductAttributeController::class, 'datatable'])->name('productAttributes.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{productAttribute}/edit', [ProductAttributeController::class, 'edit'])->name('productAttributes.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{productAttribute}/update', [ProductAttributeController::class, 'update'])->name('productAttributes.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{productAttribute}', [ProductAttributeController::class, 'destroy'])->name('productAttributes.destroy')->addMeta(true, ["super admin:admin"]);

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
    Route::prefix('warehouses')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('warehouses.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/warehouses/{warehouse}', [WarehouseController::class, 'show'])->name('warehouses.show')->addMeta(true, ["super admin:admin"]);
        Route::post('/transfer-sub-products', [WarehouseController::class, 'transferSubProducts'])
            ->name('warehouses.transferSubProducts');
        Route::get('/create', [WarehouseController::class, 'create'])->name('warehouses.create')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [WarehouseController::class, 'store'])->name('warehouses.store')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [WarehouseController::class, 'getWarehousesData'])->name('warehouses.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [WarehouseController::class, 'datatable'])->name('warehouses.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{warehouse}/update', [WarehouseController::class, 'update'])->name('warehouses.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy')->addMeta(true, ["super admin:admin"]);

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
