<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Customer Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scan', [HomeController::class, 'scan'])->name('scan');
Route::post('/search-code', [HomeController::class, 'searchByCode'])->name('search.code');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/payment/{orderNumber}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/confirm/{orderNumber}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// Admin Routes (Simple Protection with Middleware)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::post('categories/{category}/toggle', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle');
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::get('products/{product}/qr-download', [AdminProductController::class, 'downloadQR'])->name('products.qr.download');
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

// Admin Login Route (Simple)
Route::get('/admin/login', function() {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'password' => 'required'
    ]);
    
    // Simple password check (hardcoded for now)
    if ($request->password === 'admin123') {
        session(['is_admin' => true]);
        return redirect()->route('admin.dashboard');
    }
    
    return back()->with('error', 'Invalid password!');
})->name('admin.login.post');

Route::post('/admin/logout', function() {
    session()->forget('is_admin');
    return redirect()->route('home');
})->name('admin.logout');