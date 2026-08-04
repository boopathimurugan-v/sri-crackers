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
            'name' => $product->formatted_name,
            'english_name' => $product->english_name,
            'tamil_name' => $product->tamil_name,
            'product_code' => $product->product_code ?? $product->sku ?? 'SRI-' . str_pad($product->id, 3, '0', STR_PAD_LEFT),
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
        $categoriesList = [
            [
                'id' => 1,
                'name' => 'Festival Combo Packs',
                'slug' => 'festival-combo-packs',
                'description' => 'Curated mega celebration packs with multi-firework assortments for all family grand events.',
                'image' => asset('images/3d/combos.png'),
                'count' => '45+ Items',
                'badge' => 'Bestseller 💥',
                'tag' => 'Grand Savings'
            ],
            [
                'id' => 2,
                'name' => 'Premium Collection',
                'slug' => 'premium-collection',
                'description' => 'Exclusive royal grade fireworks with intense colors and high-altitude luxury light displays.',
                'image' => asset('images/3d/premium.png'),
                'count' => '28+ Items',
                'badge' => 'Royal Grade 👑',
                'tag' => 'Exclusive'
            ],
            [
                'id' => 3,
                'name' => 'Gift Boxes',
                'slug' => 'gift-boxes',
                'description' => 'Luxury handcrafted velvet and gold embossed gift hampers perfect for festival gifting.',
                'image' => asset('images/3d/gift_boxes.png'),
                'count' => '15+ Hampers',
                'badge' => 'Luxury Gift 🎁',
                'tag' => 'Popular'
            ],
            [
                'id' => 4,
                'name' => 'Sparklers',
                'slug' => 'sparklers',
                'description' => 'Dazzling gold, electric blue, and sparkling crimson hand sparklers with long burn time.',
                'image' => asset('images/3d/sparklers.png'),
                'count' => '32+ Varieties',
                'badge' => 'Extra Bright ✨',
                'tag' => 'Classic'
            ],
            [
                'id' => 5,
                'name' => 'Flower Pots',
                'slug' => 'flower-pots',
                'description' => 'High fountain golden showers, crackling glitter, and multi-color giant fountains.',
                'image' => asset('images/3d/flower_pots.png'),
                'count' => '24+ Types',
                'badge' => 'Mega Fountain ⛲',
                'tag' => 'Family Fav'
            ],
            [
                'id' => 6,
                'name' => 'Ground Chakkars',
                'slug' => 'ground-chakkars',
                'description' => 'Fast spinning gold ring wheels, whistling chakras, and high-speed multi-stage spinners.',
                'image' => asset('images/3d/chakkars.png'),
                'count' => '18+ Types',
                'badge' => 'High Speed 🌀',
                'tag' => 'Vibrant'
            ],
            [
                'id' => 7,
                'name' => 'Rockets',
                'slug' => 'rockets',
                'description' => 'Precision high-altitude whistle rockets with palm tree, gold willow, and strobe effects.',
                'image' => asset('images/3d/rockets.png'),
                'count' => '20+ Models',
                'badge' => 'High Altitude 🚀',
                'tag' => 'Thrilling'
            ],
            [
                'id' => 8,
                'name' => 'Sky Shots',
                'slug' => 'sky-shots',
                'description' => 'Spectacular 12 to 240 multi-shot repeaters painting the night sky with grand colors.',
                'image' => asset('images/3d/sky_shots.png'),
                'count' => '35+ Repeaters',
                'badge' => 'Multi Shot 🎆',
                'tag' => 'Night Show'
            ],
            [
                'id' => 9,
                'name' => 'Kids Collection',
                'slug' => 'kids-collection',
                'description' => '100% low-noise, eco-safe, smoke-controlled delight crackers designed for young ones.',
                'image' => asset('images/3d/kids.png'),
                'count' => '25+ Safe Items',
                'badge' => 'Safe & Fun 🎈',
                'tag' => 'Green Crackers'
            ],
            [
                'id' => 10,
                'name' => 'Bulk Orders',
                'slug' => 'bulk-orders',
                'description' => 'Factory wholesale pricing for community events, corporate orders, and large celebrations.',
                'image' => asset('images/3d/bulk.png'),
                'count' => 'Custom Crate',
                'badge' => 'Up to 75% OFF 🏷️',
                'tag' => 'Wholesale'
            ]
        ];

        $categories = Category::where('status', 1)->pluck('name');
        
        $allProducts = Product::with('category')->where('status', 1)->where('is_available', 1)->get()->map(function ($p) {
            return $this->mapProduct($p);
        })->toArray();

        return view('categories', compact('categoriesList', 'categories', 'allProducts'));
    }

    public function combos()
    {
        $combos = ComboOffer::where('status', 1)->orderBy('sort_order')->get()->map(function ($c) {
            return $this->mapCombo($c);
        })->toArray();

        return view('combos', compact('combos'));
    }
}
