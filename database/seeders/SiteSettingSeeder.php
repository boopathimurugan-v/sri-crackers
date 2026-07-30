<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'website_name' => ' Sri Crackers',
            'logo' => 'https://via.placeholder.com/200x80?text=LOGO',
            'phone' => '+91 90950 43444',
            'phone_2' => '+91 90874 28871',
            'email' => 'sales@sivakasifireworks.com',
            'address' => '124/B, Sattur Road, Viswanatham, Sivakasi, Tamil Nadu - 626123',
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'pricelist_url' => '#',
            'footer_text' => '© ' . date('Y') . ' Sri Crackers. All Rights Reserved.',
            'announcement_text' => 'Where tradition meets brilliance — SRI CRACKERS presents an exclusive collection of authentic Sivakasi fireworks, crafted for unforgettable celebrations.',
        ]);
    }
}
