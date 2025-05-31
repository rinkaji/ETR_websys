<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderItemController;
use App\Http\Controllers\AdminStockCardController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class, 'login']);
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Office request routes
    Route::get('/request/create', [RequestController::class, 'create'])->name('request.create');
    Route::post('/request', [RequestController::class, 'store'])->name('request.store');

    // Admin request management
    Route::get('/admin/requests', [RequestController::class, 'index'])->name('admin.requests');
    Route::post('/admin/requests/{request}/accept', [RequestController::class, 'accept'])->name('admin.requests.accept');
    Route::post('/admin/requests/{request}/reject', [RequestController::class, 'reject'])->name('admin.requests.reject');

    Route::get('/admin/history', [AdminController::class, 'history'])->name('admin.history');

    //Admin Ordered Items
    // Route::get('admin/orderedItems/{office?}', [AdminOrderItemController::class, 'showOrderedItems'])->name('admin.orderedItems');
    // Route::get('/admin/showSupplies', [AdminStockCardController::class, 'showSupplies'])->name('admin.stockCardList');
    Route::get('/admin/showStockCard/{item}/{description}/{unit}', [AdminStockCardController::class, 'showStockCard'])->name('admin.stockCard');


    Route::resource('admin', AdminController::class);
});
