<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customer\AccountController;

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
    Route::get('/welcome', function () {
            return view('customer.welcome');
        }
        )->name('customer.welcome');

        Route::get('/product/{id}', function ($id) {
            return "Product $id detail";
        }
        )->name('products.show');

        Route::get('/checkout', function () {
            return view('customer.checkout.index');
        }
        )->name('checkout.index');

        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::get('/account/address/create', [AccountController::class, 'createAddress'])->name('address.create');
        Route::post('/account/address', [AccountController::class, 'storeAddress'])->name('address.store');

        Route::get('/order-status', function () {
            return view('customer.order.status');
        }
        )->name('order.status');

        Route::get('/products/{category?}', function (?string $category = null) {
            return "Products list $category";
        }
        )->name('products.index');    });

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'index'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class , 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class , 'create'])->name('admin.products.create');
    Route::post('/products', [AdminController::class , 'store'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class , 'destroy'])->name('admin.products.destroy');
    Route::put('/products/{id}', [AdminController::class , 'update'])->name('admin.products.update');
    Route::get('/orders', [AdminController::class , 'orders'])->name('admin.orders');
    Route::get('/users', [AdminController::class , 'users'])->name('admin.users');
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
    Route::get('/users', [AdminController::class , 'users'])->name('officer.users');
});
