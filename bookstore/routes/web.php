<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use League\Glide\Server;
use Illuminate\Http\Request;

// Glide Image Route
Route::get('/img/{path}', function (Server $server, Request $request, $path) {
    return $server->getImageResponse($path, $request->all());
})->where('path', '.*');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/book/{slug}', [ShopController::class, 'show'])->name('book.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Dashboard (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Cart Routes (accessible to guests and authenticated users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/confirmation/{order}', [CartController::class, 'orderConfirmation'])->name('order.confirmation');
});