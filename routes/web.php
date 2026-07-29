<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');
Route::get('/combos', [FrontendController::class, 'combos'])->name('combos');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

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
