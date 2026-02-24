<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProductController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class , 'login']);
    Route::get('/register', [RegisterController::class , 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class , 'register']);
});

Route::post('/logout', [LoginController::class , 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->isOfficer()) {
            return redirect()->route('officer.dashboard');
        }
        return redirect()->route('customer.welcome');
    }
    return redirect()->route('login');
})->name('home');

// Customer routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/welcome', [ProductController::class , 'welcome'])->name('customer.welcome');
    Route::get('/lookbook', [ProductController::class , 'lookbook'])->name('customer.lookbook');
    Route::get('/our-story', [ProductController::class , 'story'])->name('customer.story');

    Route::get('/product/{id}', function ($id) {
            return "Product $id detail";
        }
        )->name('products.show');

        Route::get('/checkout', [CheckoutController::class , 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class , 'store'])->name('checkout.store');

        Route::get('/account', [AccountController::class , 'index'])->name('account.index');
        Route::get('/account/address/create', [AccountController::class , 'createAddress'])->name('address.create');
        Route::post('/account/address', [AccountController::class , 'storeAddress'])->name('address.store');
        Route::patch('/account/address/{address}/set-main', [AccountController::class , 'setMainAddress'])->name('address.set-main');
        Route::delete('/account/address/{address}', [AccountController::class , 'destroyAddress'])->name('address.destroy');

        Route::get('/order-status', [OrderController::class , 'status'])->name('order.status');
        Route::post('/order/{order}/upload-payment', [OrderController::class , 'uploadPayment'])->name('order.upload-payment');
        Route::post('/order/{order}/confirm-received', [OrderController::class , 'confirmReceived'])->name('order.confirm-received');

        Route::get('/shop/{category?}', [ProductController::class , 'index'])->name('products.index');
        Route::get('/product/{id}', [ProductController::class , 'show'])->name('products.show');

        Route::get('/cart', [CartController::class , 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class , 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class , 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class , 'destroy'])->name('cart.destroy');
    });

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'index'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class , 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class , 'create'])->name('admin.products.create');
    Route::post('/products', [AdminController::class , 'store'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class , 'destroy'])->name('admin.products.destroy');
    Route::put('/products/{id}', [AdminController::class , 'update'])->name('admin.products.update');
    Route::get('/orders', [AdminController::class , 'orders'])->name('admin.orders');
    Route::put('/orders/{id}/status', [AdminController::class , 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::put('/orders/{id}/shipment', [AdminController::class , 'updateOrderShipment'])->name('admin.orders.update-shipment');

    // Stock Management Routes
    Route::post('/products/{id}/add-stock', [AdminController::class , 'addStock'])->name('admin.products.add-stock');
    Route::get('/products/{id}/stock-history', [AdminController::class , 'getStockHistory'])->name('admin.products.stock-history');

    Route::get('/users', [AdminController::class , 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class , 'storeUser'])->name('admin.users.store');
    Route::delete('/users/{id}', [AdminController::class , 'destroyUser'])->name('admin.users.destroy');

    Route::get('/finance-report', [AdminController::class , 'financeReport'])->name('admin.finance-report');
});

// Officer routes
Route::middleware(['auth', 'role:officer'])->prefix('officer')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'index'])->name('officer.dashboard');
    Route::get('/products', [AdminController::class , 'products'])->name('officer.products');
    Route::get('/products/create', [AdminController::class , 'create'])->name('officer.products.create');
    Route::post('/products', [AdminController::class , 'store'])->name('officer.products.store');
    Route::delete('/products/{id}', [AdminController::class , 'destroy'])->name('officer.products.destroy');
    Route::put('/products/{id}', [AdminController::class , 'update'])->name('officer.products.update');
    Route::get('/orders', [AdminController::class , 'orders'])->name('officer.orders');
    Route::put('/orders/{id}/status', [AdminController::class , 'updateOrderStatus'])->name('officer.orders.update-status');
    Route::put('/orders/{id}/shipment', [AdminController::class , 'updateOrderShipment'])->name('officer.orders.update-shipment');

    // Stock Management Routes
    Route::post('/products/{id}/add-stock', [AdminController::class , 'addStock'])->name('officer.products.add-stock');
    Route::get('/products/{id}/stock-history', [AdminController::class , 'getStockHistory'])->name('officer.products.stock-history');

    Route::get('/users', [AdminController::class , 'users'])->name('officer.users');
    Route::post('/users', [AdminController::class , 'storeUser'])->name('officer.users.store');
    Route::delete('/users/{id}', [AdminController::class , 'destroyUser'])->name('officer.users.destroy');

    Route::get('/finance-report', [AdminController::class , 'financeReport'])->name('officer.finance-report');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('set-locale');
