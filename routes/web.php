<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('loginAuth');



Route::middleware(['isLogin'])->group(function () {
    Route::get('/landing_page', [LandingPageController::class, 'index'])->name('home');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['isAdmin'])->group(function () {
        // Routes for ItemController
        Route::name('item.')->prefix('item')->group(function () {
            Route::get('/homeshop', [ItemController::class, 'shopp'])->name('homeshop');
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::post('/store', [ItemController::class, 'store'])->name('store');
            Route::get('/', [ItemController::class, 'index'])->name('home');
            Route::get('/{id}', [ItemController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [ItemController::class, 'destroy'])->name('delete');
        });

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
});
