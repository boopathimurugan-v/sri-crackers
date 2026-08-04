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
            ['en' => 'Flower Pot Big Prime', 'ta' => 'பிளவர் பாட் பிக் ப்ரைம்', 'mrp' => 1000, 'category' => 'Flower Pots', 'brand' => 'Ajanta'],
            ['en' => 'O-Yolo Super', 'ta' => 'ஓ-யோலோ சூப்பர்', 'mrp' => 1500, 'category' => 'Fancy', 'brand' => 'Sri Vijai'],
            ['en' => 'Mayajaal', 'ta' => 'மாயாஜால்', 'mrp' => 2000, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['en' => 'Gypsy Golden Drops', 'ta' => 'ஜிப்சி கோல்டன் டிராப்ஸ்', 'mrp' => 800, 'category' => 'Fancy', 'brand' => 'Robin'],
            ['en' => 'Pinkie Pie', 'ta' => 'பிங்கி பை', 'mrp' => 500, 'category' => 'Kids Crackers', 'brand' => 'Ajanta'],
            ['en' => 'Rope', 'ta' => 'ரோப்', 'mrp' => 300, 'category' => 'Kids Crackers', 'brand' => 'Sri Vijai'],
            ['en' => 'Blossom', 'ta' => 'பிளாசம்', 'mrp' => 1200, 'category' => 'Flower Pots', 'brand' => 'Yes Bro'],
            ['en' => 'Magic Wand', 'ta' => 'மேஜிக் வாண்ட்', 'mrp' => 600, 'category' => 'Kids Crackers', 'brand' => 'Robin'],
            ['en' => 'Win Wheel Speed Mini', 'ta' => 'வின் வீல் ஸ்பீட் மினி', 'mrp' => 400, 'category' => 'Ground Chakkars', 'brand' => 'Ajanta'],
            ['en' => 'Win Wheel Speed Max', 'ta' => 'வின் வீல் ஸ்பீட் மேக்ஸ்', 'mrp' => 600, 'category' => 'Ground Chakkars', 'brand' => 'Sri Vijai'],
            ['en' => 'Win Wheel Speed Super', 'ta' => 'வின் வீல் ஸ்பீட் சூப்பர்', 'mrp' => 800, 'category' => 'Ground Chakkars', 'brand' => 'Yes Bro'],
            ['en' => 'Wire Chakkar Asok', 'ta' => 'வைர் சக்கர் அசோக்', 'mrp' => 500, 'category' => 'Ground Chakkars', 'brand' => 'Robin'],
            ['en' => 'Mini Pot', 'ta' => 'மினி பாட்', 'mrp' => 300, 'category' => 'Flower Pots', 'brand' => 'Ajanta'],
            ['en' => 'Trixx Atom Bomb', 'ta' => 'ட்ரிக்ஸ் ஆட்டம் பாம்', 'mrp' => 400, 'category' => 'Bombs', 'brand' => 'Sri Vijai'],
            ['en' => 'God & Kings', 'ta' => 'காட் & கிங்ஸ்', 'mrp' => 2500, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['en' => 'Bubble Sparklers', 'ta' => 'பபிள் ஸ்பார்க்லர்ஸ்', 'mrp' => 350, 'category' => 'Kids Crackers', 'brand' => 'Robin'],
            ['en' => 'Lemon Tree Ayyan', 'ta' => 'லெமன் ட்ரீ அய்யன்', 'mrp' => 1100, 'category' => 'Fancy', 'brand' => 'Ajanta'],
            ['en' => 'Bingo Music Sky Shot', 'ta' => 'பிங்கோ மியூசிக் ஸ்கை ஷாட்', 'mrp' => 1400, 'category' => 'Fancy', 'brand' => 'Sri Vijai'],
            ['en' => 'Gold Feast', 'ta' => 'கோல்ட் ஃபீஸ்ட்', 'mrp' => 2200, 'category' => 'Fancy', 'brand' => 'Yes Bro'],
            ['en' => 'Clash of Clans', 'ta' => 'கிளாஷ் ஆஃப் கிளான்ஸ்', 'mrp' => 1800, 'category' => 'Fancy', 'brand' => 'Robin'],
        ];

        foreach ($products as $index => $prod) {
            $cat = $categories->where('name', $prod['category'])->first();
            $brand = $brands->where('name', $prod['brand'])->first();
            
            if (!$cat || !$brand) continue;

            $offer_price = $prod['mrp'] * 0.20; // 80% discount
            $code = 'SC-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $slug = Str::slug($prod['en']);
            
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $prod['en'] . ' (' . $prod['ta'] . ')',
                    'product_name_en' => $prod['en'],
                    'product_name_ta' => $prod['ta'],
                    'product_code' => $code,
                    'category_id' => $cat->id,
                    'brand_id' => $brand->id,
                    'mrp' => $prod['mrp'],
                    'offer_price' => $offer_price,
                    'discount_percentage' => 80,
                    'stock' => rand(50, 200),
                    'unit' => 'Box',
                    'status' => 1,
                    'is_available' => 1,
                    'display_order' => $index + 1,
                ]
            );
        }
    }
}
