<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->group(function () {
    // Admin Auth Routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');


    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Categories
        Route::patch('categories/{category}/toggle-status', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
        
        // Products
        Route::patch('products/{product}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
        Route::patch('products/{product}/toggle-availability', [\App\Http\Controllers\Admin\ProductController::class, 'toggleAvailability'])->name('admin.products.toggle-availability');
        Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])->name('admin.products.restore');
        Route::delete('products/{id}/force-delete', [\App\Http\Controllers\Admin\ProductController::class, 'forceDelete'])->name('admin.products.force-delete');
        Route::delete('product-images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteGalleryImage'])->name('admin.products.gallery.destroy');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->names('admin.products');

        // Banners & Offers
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->names('admin.banners');
        Route::resource('festival-offers', \App\Http\Controllers\Admin\FestivalOfferController::class)->names('admin.festival-offers');
        Route::resource('combo-offers', \App\Http\Controllers\Admin\ComboOfferController::class)->names('admin.combo-offers');

        // Settings
        Route::get('/settings/index', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.index');
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

        // Orders & Invoices
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update'])->names('admin.orders');
        Route::get('invoices/{order_number}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('admin.invoices.show');
        Route::get('invoices/{order_number}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('admin.invoices.download');

        // Transactions (Payment History)
        Route::get('transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');
        
        // Contacts
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy'])->names('admin.contacts');
        
        // Newsletters
        Route::resource('newsletters', \App\Http\Controllers\Admin\NewsletterController::class)->only(['index', 'destroy'])->names('admin.newsletters');

        // Root admin route redirects to dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
    });
});
