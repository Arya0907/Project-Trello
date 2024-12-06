<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('loginAuth');
});

Route::middleware(['isLogin'])->group(function () {
    Route::get('/landing_page', [LandingPageController::class, 'index'])->name('home');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit/{id}', [UserController::class, 'editUser'])->name('user.edit.profile');
    Route::put('/profile/update', [UserController::class, 'updateUser'])->name('user.update.profile');
    
    // Routes for 'user' role
    Route::middleware(['isUser'])->group(function () {
        Route::name('cart.')->prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::get('/create', [CartController::class, 'create'])->name('create');
            Route::get('/store/{id}', [CartController::class, 'store'])->name('store');
            Route::get('/{id}', [CartController::class, 'show'])->name('show');
            Route::patch('/{id}', [CartController::class, 'update'])->name('update');
            Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
            Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
        });
        
        Route::post('/orders/store/{id}', [OrderController::class, 'storeId'])->name('orders.store.id');
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    });

    // Routes for 'admin' role
    Route::middleware(['isAdmin'])->group(function () {
        // Routes for ItemController
       
        // Orders Routes for Admin
        Route::get('orders/admin', [OrderController::class, 'indexAdmin'])->name('orders.admin');
        Route::get('orders/export/excel', [OrderController::class, 'downloadExcel'])->name('orders.export.excel');
        
        // Routes for UserController
        Route::name('user.')->prefix('user')->group(function () {
            Route::get('/homeUser', [UserController::class, 'index'])->name('homeuser');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        });
    });

    // Routes for 'kasir' role
    Route::middleware(['isKasir'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/create/', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/order/struck/{id}', [OrderController::class, 'show'])->name('order.struck');
        Route::get('/order/pdf/{id}', [OrderController::class, 'downloadPdf'])->name('export.pdf');
    });

    Route::middleware(['isAdminOrKasir'])->group(function () {
        Route::name('item.')->prefix('item')->group(function () {
            Route::get('/landing_page', [LandingPageController::class, 'index'])->name('home');
            Route::get('/home', [ItemController::class, 'index'])->name('home.item');
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::post('/store', [ItemController::class, 'store'])->name('store');
            Route::get('/{id}', [ItemController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [ItemController::class, 'destroy'])->name('delete');
        });
    });
});

