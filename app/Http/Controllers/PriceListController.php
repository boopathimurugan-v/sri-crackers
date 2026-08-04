<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PriceListController extends Controller
{
    public function index()
    {
        $productsDb = Product::with('category')
            ->where('status', 1)
            ->where('is_available', 1)
            ->orderBy('category_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        $categories = Category::where('status', 1)->pluck('name')->toArray();

        $allProducts = $productsDb->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->formatted_name,
                'product_code' => $product->product_code ?? $product->sku ?? ('SRI-' . str_pad($product->id, 3, '0', STR_PAD_LEFT)),
                'category' => $product->category ? $product->category->name : 'General',
                'price' => (float)$product->offer_price,
                'original_price' => (float)$product->mrp,
                'discount' => $product->mrp > $product->offer_price ? round((($product->mrp - $product->offer_price) / $product->mrp) * 100) . '%' : null,
                'stock' => $product->stock,
                'unit' => $product->unit ?? 'Box',
                'image_icon' => '🎆',
            ];
        })->toArray();

        return view('price-list', compact('allProducts', 'categories'));
    }

    public function downloadPdf()
    {
        $settings = Setting::first();
        
        $companyName = $settings->website_name ?? 'SRI CRACKERS';
        $companyAddress = $settings->address ?? 'Sivakasi, Tamil Nadu, India';
        $companyPhone = $settings->phone ?? '+91 98765 43210';
        $companyEmail = $settings->email ?? 'info@sricrackers.com';
        $companyLogo = public_path('images/logo.png'); // Fallback check in view if exists

        $currentDate = Carbon::now()->format('d-m-Y');

        $products = Product::with('category')
            ->where('status', 1)
            ->where('is_available', 1)
            ->orderBy('category_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        // Group products by Category Name
        $groupedProducts = $products->groupBy(function ($product) {
            return $product->category ? $product->category->name : 'General Fireworks';
        });

        $pdf = Pdf::loadView('pdf.price-list', [
            'companyName' => $companyName,
            'companyAddress' => $companyAddress,
            'companyPhone' => $companyPhone,
            'companyEmail' => $companyEmail,
            'companyLogo' => file_exists($companyLogo) ? $companyLogo : null,
            'currentDate' => $currentDate,
            'groupedProducts' => $groupedProducts,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'SRI-CRACKERS-PRICE-LIST.pdf', [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
