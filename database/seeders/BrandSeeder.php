<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Ajanta', 'logo' => 'https://via.placeholder.com/150x150?text=Ajanta'],
            ['name' => 'Sri Vijai', 'logo' => 'https://via.placeholder.com/150x150?text=Sri+Vijai'],
            ['name' => 'Yes Bro', 'logo' => 'https://via.placeholder.com/150x150?text=Yes+Bro'],
            ['name' => 'Robin', 'logo' => 'https://via.placeholder.com/150x150?text=Robin'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['name' => $brand['name']], [
                'slug' => Str::slug($brand['name']),
                'logo_path' => $brand['logo'],
                'description' => 'High quality crackers from ' . $brand['name'],
                'is_featured' => 1,
                'is_active' => 1,
            ]);
        }
    }
}
