<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// Breeze redirects here after login — send admins to panel, users to home
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

Route::get('/katalog', [ProductController::class, 'index'])->name('katalog');
Route::get('/katalog/{product:slug}', [ProductController::class, 'show'])->name('detail.produk');

Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('detail.artikel');

// --- Cart & Checkout (auth required) ---
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/riwayat', [OrderController::class, 'history'])->name('riwayat');
    Route::get('/riwayat/{order}', [OrderController::class, 'orderDetail'])->name('order.detail');
    Route::get('/riwayat/{order}/lacak', [OrderController::class, 'track'])->name('order.track');

    Route::post('/produk/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// --- Breeze Auth Routes ---
require __DIR__.'/auth.php';

// --- Admin Routes (must be logged in + admin role) ---
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/produk', [AdminProductController::class, 'index'])->name('produk');
        Route::get('/produk/create', [AdminProductController::class, 'create'])->name('produk.create');
        Route::post('/produk', [AdminProductController::class, 'store'])->name('produk.store');
        Route::get('/produk/{product}/edit', [AdminProductController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{product}', [AdminProductController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('produk.destroy');

        // Articles
        Route::get('/artikel', [AdminArticleController::class, 'index'])->name('artikel');
        Route::get('/artikel/create', [AdminArticleController::class, 'create'])->name('artikel.create');
        Route::post('/artikel', [AdminArticleController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{article}/edit', [AdminArticleController::class, 'edit'])->name('artikel.edit');
        Route::put('/artikel/{article}', [AdminArticleController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('artikel.destroy');

        // Users
        Route::get('/pengguna', [AdminUserController::class, 'index'])->name('pengguna');
        Route::get('/pengguna/create', [AdminUserController::class, 'create'])->name('pengguna.create');
        Route::post('/pengguna', [AdminUserController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{user}/edit', [AdminUserController::class, 'edit'])->name('pengguna.edit');
        Route::put('/pengguna/{user}', [AdminUserController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('pengguna.destroy');

        // Transactions
        Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
        Route::get('/transaksi/{order}', [TransactionController::class, 'show'])->name('transaksi.detail');
        Route::patch('/transaksi/{order}/status', [TransactionController::class, 'updateStatus'])->name('transaksi.status');
    });
