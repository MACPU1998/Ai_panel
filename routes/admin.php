<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCurrencyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {


    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.index')
        ->middleware('AdminAuthenticated');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');

    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/profile/edit', [AdminAuthController::class, 'edit'])->name('admin.edit');

        Route::put('/profile/update', [AdminAuthController::class, 'update'])->name('admin.update');

        Route::get('/profile/password/edit', [AdminAuthController::class, 'editPassword'])->name('admin.edit.password');

        Route::put('/profile/password/update', [AdminAuthController::class, 'updatePassword'])->name('admin.update.password');


        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });

    Route::prefix('admins')->name('admins.')
        ->middleware(['auth:admin', 'role:super-admin,admin'])
        ->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('index');

            Route::get('/data', [AdminController::class, 'getAdminsData'])->name('data');

            Route::get('/create', [AdminController::class, 'create'])->name('create');

            Route::post('/store', [AdminController::class, 'store'])->name('store');

            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');

            Route::put('/{admin}/update', [AdminController::class, 'update'])->name('update');
            Route::get('/datatable', [UserController::class, 'datatable'])->name('datatable');
        });

    // user
    Route::prefix('users')->name('users.')->middleware('auth:admin')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('index');

        Route::get('/create', [UserController::class, 'create'])->name('create');

        Route::post('/store', [UserController::class, 'store'])->name('store');

        Route::get('/data', [UserController::class, 'getUsersData'])->name('getData');

        Route::get('/datatable', [UserController::class, 'datatable'])->name('datatable');

        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');

        Route::put('/{user}/update', [UserController::class, 'update'])->name('update');

        Route::get('/password/{user}/edit', [UserController::class, 'editPassword'])->name('edit.password');

        Route::put('/password/{user}/update', [UserController::class, 'updatePassword'])->name('update.password');

        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
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
        Route::post('/store', [SubProductController::class, 'store'])->name('subProducts.store')->addMeta(true, ["super admin:admin"]);
        Route::post('/store-group', [SubProductController::class, 'storeGroup'])->name('subProducts.store.group')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [SubProductController::class, 'getSubProductData'])->name('subProducts.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [SubProductController::class, 'datatable'])->name('subProducts.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{subProduct}/edit', [SubProductController::class, 'edit'])->name('subProducts.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{subProduct}/update', [SubProductController::class, 'update'])->name('subProducts.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{subProduct}', [SubProductController::class, 'destroy'])->name('subProducts.destroy')->addMeta(true, ["super admin:admin"]);

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


    });


    //Route orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index')->addMeta(true, ["super admin:admin"]);
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create')->addMeta(true, ["super admin:admin"]);
        Route::get('/preview/{customer}', [OrderController::class, 'preview'])->name('orders.preview')->addMeta(true, ["super admin:admin"]);
        //Route::get('/cart-count/{customer}', [OrderController::class, 'cartCount'])->name('orders.cart_count')->addMeta(true, ["super admin:admin"]);
        Route::post('/add-to-order', [OrderController::class, 'addToOrder'])->name('orders.add_to_order')->addMeta(true, ["super admin:admin"]);
        Route::post('/store', [OrderController::class, 'store'])->name('orders.store')->addMeta(true, ["super admin:admin"]);
        Route::post('/finalize', [OrderController::class, 'finalizeOrder'])->name('orders.finalize')->addMeta(true, ["super admin:admin"]);
        Route::get('/data', [OrderController::class, 'getOrdersData'])->name('orders.getData')->addMeta(true, ["super admin:admin"]);
        Route::get('/datatable', [OrderController::class, 'datatable'])->name('orders.datatable')->addMeta(true, ["super admin:admin"]);
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->addMeta(true, ["super admin:admin"]);
        Route::put('/{order}/update', [OrderController::class, 'update'])->name('orders.update')->addMeta(true, ["super admin:admin"]);
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->addMeta(true, ["super admin:admin"]);

    });

    // Route صندوقدار
    Route::prefix('cashier')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('cashier.index')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::get('/search-products', [CashierController::class, 'searchProducts'])->name('cashier.search_products')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::post('/add-to-cart', [CashierController::class, 'addToCart'])->name('cashier.add_to_cart')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::post('/update-cart-item', [CashierController::class, 'updateCartItem'])->name('cashier.update_cart_item')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::delete('/remove-cart-item', [CashierController::class, 'removeCartItem'])->name('cashier.remove_cart_item')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::get('/cart/{customerId}', [CashierController::class, 'getCart'])->name('cashier.get_cart')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::post('/register-customer', [CashierController::class, 'registerCustomer'])->name('cashier.register_customer')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::post('/checkout', [CashierController::class, 'checkout'])->name('cashier.checkout')->addMeta(true, ["super admin:admin", "cashier:admin"]);
        Route::get('/search-customers', [CashierController::class, 'searchCustomers'])->name('cashier.search_customers')->addMeta(true, ["super admin:admin", "cashier:admin"]);
    });

});
