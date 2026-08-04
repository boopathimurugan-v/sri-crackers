<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'website_name' => 'SRI CRACKERS',
            'logo' => 'https://via.placeholder.com/200x80?text=SRI+CRACKERS',
            'phone' => '+91 90950 43444',
            'email' => 'support@sricrackers.com',
            'address' => '124/B, Sattur Road, Viswanatham, Sivakasi, Tamil Nadu - 626123',
            'instagram_url' => 'https://instagram.com',
            'footer_text' => 'Your Trusted Destination for Premium Sivakasi Fireworks',
            'announcement_text' => 'Premium Sivakasi Fireworks Since 1985 — SRI CRACKERS presents an exclusive collection of authentic Sivakasi fireworks, crafted for unforgettable celebrations.',
            'meta_title' => 'SRI CRACKERS | Premium Sivakasi Fireworks',
            'meta_description' => 'Buy Premium Sivakasi Crackers Online from SRI CRACKERS with the Best Festival Prices, Safe Packaging, and Fast Delivery.',
        ]);
    }
}
