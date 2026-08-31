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
        
        // Orders & Invoices
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy'])->names('admin.orders');
        Route::get('invoices/{order_number}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('admin.invoices.show');
        Route::get('invoices/{order_number}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('admin.invoices.download');

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

        // Offers (Banners & Combo Offers)
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->names('admin.banners');
        Route::resource('combo-offers', \App\Http\Controllers\Admin\ComboOfferController::class)->names('admin.combo-offers');

        // Customers Module
        Route::patch('customers/{customer}/toggle-block', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleBlock'])->name('admin.customers.toggle-block');
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->names('admin.customers');

        // Configuration
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

        // Stock Entry Module
        Route::get('stock-entries', [\App\Http\Controllers\Admin\StockEntryController::class, 'index'])->name('admin.stock-entries.index');
        Route::post('stock-entries', [\App\Http\Controllers\Admin\StockEntryController::class, 'store'])->name('admin.stock-entries.store');

        // UPI Payment System & Rotation Settings
        Route::patch('upi/{upi}/toggle-status', [\App\Http\Controllers\Admin\UpiAccountController::class, 'toggleStatus'])->name('admin.upi.toggle-status');
        Route::post('upi/{upi}/reset-collection', [\App\Http\Controllers\Admin\UpiAccountController::class, 'resetCollection'])->name('admin.upi.reset-collection');
        Route::post('upi/reset-all-collections', [\App\Http\Controllers\Admin\UpiAccountController::class, 'resetAllCollections'])->name('admin.upi.reset-all-collections');
        Route::resource('upi', \App\Http\Controllers\Admin\UpiAccountController::class)->names('admin.upi');

        // Settings
        Route::get('/settings/index', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.index');
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

        // Transactions (Payment History)
        Route::get('transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');

        // Root admin route redirects to dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
    });
});
