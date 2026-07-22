<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');
Route::get('/combos', [FrontendController::class, 'combos'])->name('combos');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Dashboard
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Customer\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Customer\DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password', [\App\Http\Controllers\Customer\DashboardController::class, 'password'])->name('password');
    Route::post('/password', [\App\Http\Controllers\Customer\DashboardController::class, 'updatePassword'])->name('password.update');
    
    Route::resource('addresses', \App\Http\Controllers\Customer\AddressController::class)->except(['show']);
    
    Route::get('/orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_number}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
    Route::get('/invoices/{order_number}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{order_number}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    
    Route::get('/wishlist', [\App\Http\Controllers\Customer\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\Customer\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\Customer\WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/payment/process/{order_number}', [PaymentController::class, 'process'])->name('payment.process');
Route::post('/payment/callback/{transaction}', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('track-order');
Route::post('/track-order', [OrderTrackingController::class, 'track'])->name('track-order.post');

Route::get('/price-list', function () {
    return view('price-list');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});
