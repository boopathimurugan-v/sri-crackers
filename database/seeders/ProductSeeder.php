<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            return;
        }

        $products = [
            ['name' => 'Flower Pot Big Prime', 'mrp' => 1000, 'category' => 'Flower Pots', 'brand' => 'Ajanta'],
            ['name' => 'O-Yolo Super', 'mrp' => 1500, 'category' => 'Fancy', 'brand' => 'Sri Vijai'],
            ['name' => 'Mayajaal', 'mrp' => 2000, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['name' => 'Gypsy Golden Drops', 'mrp' => 800, 'category' => 'Fancy', 'brand' => 'Robin'],
            ['name' => 'Pinkie Pie', 'mrp' => 500, 'category' => 'Kids Crackers', 'brand' => 'Ajanta'],
            ['name' => 'Rope', 'mrp' => 300, 'category' => 'Kids Crackers', 'brand' => 'Sri Vijai'],
            ['name' => 'Blossom', 'mrp' => 1200, 'category' => 'Flower Pots', 'brand' => 'Yes Bro'],
            ['name' => 'Magic Wand', 'mrp' => 600, 'category' => 'Kids Crackers', 'brand' => 'Robin'],
            ['name' => 'Win Wheel Speed Mini', 'mrp' => 400, 'category' => 'Ground Chakkars', 'brand' => 'Ajanta'],
            ['name' => 'Win Wheel Speed Max', 'mrp' => 600, 'category' => 'Ground Chakkars', 'brand' => 'Sri Vijai'],
            ['name' => 'Win Wheel Speed Super', 'mrp' => 800, 'category' => 'Ground Chakkars', 'brand' => 'Yes Bro'],
            ['name' => 'Wire Chakkar Asok', 'mrp' => 500, 'category' => 'Ground Chakkars', 'brand' => 'Robin'],
            ['name' => 'Mini Pot', 'mrp' => 300, 'category' => 'Flower Pots', 'brand' => 'Ajanta'],
            ['name' => 'Trixx', 'mrp' => 400, 'category' => 'Bombs', 'brand' => 'Sri Vijai'],
            ['name' => 'God & Kings', 'mrp' => 2500, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['name' => 'Bubble', 'mrp' => 350, 'category' => 'Kids Crackers', 'brand' => 'Robin'],
            ['name' => 'Lemon Tree Ayyan', 'mrp' => 1100, 'category' => 'Fancy', 'brand' => 'Ajanta'],
            ['name' => 'Bingo Music', 'mrp' => 1400, 'category' => 'Fancy', 'brand' => 'Sri Vijai'],
            ['name' => 'Gold Feast', 'mrp' => 2200, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['name' => 'Clash of Clans', 'mrp' => 1800, 'category' => 'Fancy', 'brand' => 'Robin'],
        ];

        foreach ($products as $index => $prod) {
            $cat = $categories->where('name', $prod['category'])->first();
            $brand = $brands->where('name', $prod['brand'])->first();
            
            if (!$cat || !$brand) continue;

            $offer_price = $prod['mrp'] * 0.20; // 80% discount
            
            Product::updateOrCreate(['name' => $prod['name']], [
                'category_id' => $cat->id,
                'brand_id' => $brand->id,
                'slug' => Str::slug($prod['name']),
                'mrp' => $prod['mrp'],
                'offer_price' => $offer_price,
                'discount_percentage' => 80,
                'stock' => rand(50, 200),
                'rating' => 5.0,
                'is_best_seller' => $index < 8,
                'is_new_arrival' => $index >= 4 && $index < 8,
                'is_featured' => 1,
                'status' => 1,
                'is_active' => 1,
                'main_image' => 'https://images.unsplash.com/photo-1568283096533-0dd83573122e?auto=format&fit=crop&w=400&q=80',
                'image_path' => 'https://images.unsplash.com/photo-1568283096533-0dd83573122e?auto=format&fit=crop&w=400&q=80',
            ]);
        }
    }
}
