<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ComboOffer;
use App\Models\FestivalOffer;

class FrontendController extends Controller
{
    private function mapProduct($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category ? $product->category->name : 'Uncategorized',
            'price' => (float)$product->offer_price,
            'original_price' => (float)$product->mrp,
            'discount' => $product->mrp > $product->offer_price ? round((($product->mrp - $product->offer_price) / $product->mrp) * 100) . '%' : null,
            'image_icon' => '🎆', // Default fallback
            'image_path' => $product->main_image,
            'stock' => $product->stock,
            'unit' => $product->unit,
            'is_available' => $product->is_available,
        ];
    }

    private function mapCombo($combo)
    {
        return [
            'id' => $combo->id,
            'name' => $combo->title,
            'category' => 'Combo Packs',
            'price' => (float)$combo->price,
            'original_price' => (float)$combo->price + 500, // Dummy original price as DB doesn't have it
            'discount' => null,
            'image_icon' => '📦', // Default fallback
            'image_path' => $combo->image,
            'items_included' => 20, // Dummy as DB doesn't have it
            'stock' => 100, // Dummy as DB doesn't have it
            'featured' => true,
        ];
    }

    public function home()
    {
        $banner = Banner::where('status', 1)->orderBy('sort_order')->first();
        
        $categories = Category::where('status', 1)->pluck('name');
        
        $allProductsDb = Product::with('category')->where('status', 1)->where('is_available', 1)->get();
        $allProducts = $allProductsDb->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();
        
        $featuredProducts = $allProductsDb->where('featured', 1)->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();
        
        $latestProducts = $allProductsDb->sortByDesc('created_at')->take(4)->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();
        
        $trendingProducts = $allProductsDb->where('trending', 1)->take(4)->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();

        $combosDb = ComboOffer::where('status', 1)->orderBy('sort_order')->get();
        $combos = $combosDb->map(function ($c) {
            return $this->mapCombo($c);
        })->toArray();
        
        $festivalOffers = FestivalOffer::where('status', 1)->orderBy('sort_order')->get();

        return view('home', compact(
            'banner', 
            'categories', 
            'allProducts', 
            'featuredProducts', 
            'latestProducts', 
            'trendingProducts', 
            'combos', 
            'festivalOffers'
        ));
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->pluck('name');
        
        $allProducts = Product::with('category')->where('status', 1)->where('is_available', 1)->get()->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();

        return view('categories', compact('categories', 'allProducts'));
    }

    public function combos()
    {
        $combos = ComboOffer::where('status', 1)->orderBy('sort_order')->get()->map(function ($c) {
            return $this->mapCombo($c);
        })->toArray();

        return view('combos', compact('combos'));
    }
}
