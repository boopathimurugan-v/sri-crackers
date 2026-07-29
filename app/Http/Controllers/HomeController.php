<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SeoSection;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Settings (Cached for performance)
        $settings = Cache::rememberForever('site_settings', function () {
            $siteSettings = Setting::first();
            return $siteSettings ? $siteSettings->toArray() : [];
        });

        // 2. Banners
        $banners = Banner::where('is_active', 1)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        // 3. Featured Brands
        $brands = Brand::where('is_active', 1)
            ->where('is_featured', 1)
            ->get();

        $newArrivals = Product::with(['category', 'brand'])
            ->where('is_active', 1)
            ->where('status', 1)
            ->where('is_new_arrival', 1)
            ->take(8)
            ->get();

        // 5. Categories with eager loaded active products
        $categories = Category::with(['products' => function ($query) {
                $query->where('is_active', 1)->where('status', 1)->orderBy('sort_order');
            }])
            ->where('is_active', 1)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        // 6. SEO Sections
        $seoSections = SeoSection::where('is_active', 1)->get();

        return view('home', compact(
            'settings',
            'banners',
            'brands',

            'newArrivals',
            'categories',
            'seoSections'
        ));
    }
}
