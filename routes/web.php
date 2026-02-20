<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;

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
        if (auth()->user()->isAdmin() || auth()->user()->isOfficer()) {
            return redirect()->route('admin.dashboard');
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

        Route::get('/account', function () {
            return view('customer.account.index');
        }
        )->name('account.index');

        Route::get('/account/address/create', function () {
            return view('customer.account.address.create');
        }
        )->name('address.create');

        Route::post('/account/address', function () {
            return redirect()->route('account.index')->with('success', ' Berhasil menambahkan alamat baru');
        }
        )->name('address.store');

        Route::get('/order-status', function () {
            return view('customer.order.status');
        }
        )->name('order.status');

        Route::get('/products/{category?}', function (?string $category = null) {
            return "Products list $category";
        }
        )->name('products.index');    });

// Admin & Officer routes
Route::middleware(['auth', 'role:admin,officer'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'index'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class , 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class , 'create'])->name('admin.products.create');
    Route::post('/products', [AdminController::class , 'store'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminController::class , 'destroy'])->name('admin.products.destroy');
    Route::put('/products/{id}', [AdminController::class , 'update'])->name('admin.products.update');
    Route::get('/orders', [AdminController::class , 'orders'])->name('admin.orders');
    Route::get('/users', [AdminController::class , 'users'])->name('admin.users');
});
