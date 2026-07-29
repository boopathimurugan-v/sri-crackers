<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Ground Chakkars',
            'Flower Pots',
            'Bombs',
            'Fancy',
            'Rockets',
            'Gift Boxes',
            'Kids Crackers'
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(['name' => $category], [
                'slug' => Str::slug($category),
                'description' => 'Premium ' . $category . ' directly from Sivakasi factory.',
                'image_path' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=400&q=80',
                'sort_order' => $index + 1,
                'status' => 1,
                'is_active' => 1,
            ]);
        }
    }
}
