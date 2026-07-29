<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoSection;

class SeoSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'title' => 'Top 10 Crackers Shop in Sivakasi',
                'content' => '<p>Jallikattu Crackers is a direct factory outlet and a leading Sivakasi Crackers online shopping store in Sivakasi. We promote the use of environmentally friendly Green Crackers Online in Sivakasi. We aim to provide high-quality Sivakasi crackers online with no malfunctions and excellent customer support. Jallikattu Crackers is the best Sivakasi online crackers shopping store, with 200 varieties of crackers. Buy online crackers from Sivakasi is the best option for purchasing online Sivakasi crackers for Diwali at the best rate.</p>',
                'position' => 'home_bottom_left',
            ],
            [
                'title' => 'Green Crackers Sivakasi',
                'content' => '<p>Jallikattu Crackers Sivakasi has been successfully operating for 13 years, both online and offline. In recent years, we have focused on producing eco-friendly green crackers with a significant impact at the best price.</p><p>Jallikattu Crackers is a celebrity online pattasu kadai sivakasi, Order pattasu online from us and create pattasu online shopping special for Diwali celebration. Order Diwali crackers at our online Sivakasi crackers shopping store. Jallikattu Crackers is a leading and famous cracker manufacturer, the premier online crackers shop in sivakasi.</p>',
                'position' => 'home_bottom_left',
            ]
        ];

        foreach ($sections as $section) {
            SeoSection::updateOrCreate(['title' => $section['title']], [
                'content' => $section['content'],
                'position' => $section['position'],
                'is_active' => 1,
            ]);
        }
    }
}
