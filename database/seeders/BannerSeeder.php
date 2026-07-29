<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Happy Diwali',
                'subtitle' => 'DIWALI SPECIAL DISCOUNT',
                'image_path' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1920&q=80',
                'discount_tag' => '80% OFF',
                'button_text' => 'Shop Now',
                'button_link' => '#',
                'sort_order' => 1,
                'status' => 1,
                'is_active' => 1,
            ]
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(['title' => $banner['title']], [
                'subtitle' => $banner['subtitle'],
                'image' => $banner['image_path'],
                'image_path' => $banner['image_path'],
                'discount_tag' => $banner['discount_tag'],
                'button_text' => $banner['button_text'],
                'link' => $banner['button_link'],
                'button_link' => $banner['button_link'],
                'sort_order' => $banner['sort_order'],
                'status' => $banner['status'],
                'is_active' => $banner['is_active'],
            ]);
        }
    }
}
