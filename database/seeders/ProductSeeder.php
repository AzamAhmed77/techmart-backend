<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a default Demo User
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'مهندس أحمد',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Clear old products
        Product::truncate();

        // 3. Seed Realistic Products with beautiful high-res URLs
        $products = [
            [
                'name' => 'iPhone 16 Pro Max',
                'description' => 'أقوى هاتف ذكي من آبل مع شريحة A18 Pro، شاشة Super Retina XDR مقاس 6.9 بوصة، وهيكل تيتانيوم مصقول فائق المتانة.',
                'price' => 1199.99,
                'old_price' => 1299.99,
                'rating' => 4.9,
                'reviews_count' => 128,
                'category' => 'الهواتف الذكية',
                'image_url' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'stock' => 25,
            ],
            [
                'name' => 'Samsung Galaxy S25 Ultra',
                'description' => 'هاتف سامسونج الرائد المزود بقلم S-Pen مدمج، وكاميرا جبارة 200 ميجابكسل، وتقنيات الذكاء الاصطناعي Galaxy AI المتطورة.',
                'price' => 1249.99,
                'old_price' => 1399.00,
                'rating' => 4.8,
                'reviews_count' => 95,
                'category' => 'الهواتف الذكية',
                'image_url' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'stock' => 18,
            ],
            [
                'name' => 'MacBook Pro M3 Max',
                'description' => 'جهاز لابتوب للمحترفين بشاشة Liquid Retina XDR مقاس 16 بوصة، وذاكرة موحدة 36 جيجابايت لتشغيل أصعب برامج التصميم والبرمجة.',
                'price' => 2499.00,
                'old_price' => 2699.00,
                'rating' => 5.0,
                'reviews_count' => 64,
                'category' => 'الحواسيب المحمولة',
                'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'stock' => 12,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'سماعات رأس لاسلكية فاخرة رائدة في إلغاء الضوضاء النشط، مع صوت عالي الدقة وعمر بطارية يدوم حتى 30 ساعة.',
                'price' => 349.99,
                'old_price' => 399.99,
                'rating' => 4.7,
                'reviews_count' => 210,
                'category' => 'الصوتيات',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'stock' => 45,
            ],
            [
                'name' => 'Apple Watch Ultra 2',
                'description' => 'ساعة ذكية للمغامرات والرياضات الصعبة مع إطار تيتانيوم فائق القوة، وGPS دقيق مزدوج التردد، وسطوع شاشة 3000 شمعة.',
                'price' => 799.00,
                'old_price' => 849.00,
                'rating' => 4.9,
                'reviews_count' => 82,
                'category' => 'الساعات الذكية',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'stock' => 30,
            ],
            [
                'name' => 'Dell XPS 15 OLED',
                'description' => 'لابتوب نحيف وقوي بشاشة OLED مذهلة بدقة 3.5K ومعالج Intel Core i9 لإنشاء المحتوى وتطوير البرمجيات بأعلى أداء.',
                'price' => 1899.50,
                'old_price' => 2099.00,
                'rating' => 4.6,
                'reviews_count' => 47,
                'category' => 'الحواسيب المحمولة',
                'image_url' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'stock' => 15,
            ],
            [
                'name' => 'AirPods Pro (2nd Gen)',
                'description' => 'سماعات أذن لاسلكية مع ميزة الصوت المكاني المخصص، وإلغاء الضوضاء النشط بمقدار الضعف، ومقاومة الماء والغبار.',
                'price' => 229.00,
                'old_price' => 249.00,
                'rating' => 4.8,
                'reviews_count' => 312,
                'category' => 'الصوتيات',
                'image_url' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'stock' => 60,
            ],
            [
                'name' => 'iPad Pro M4 13-inch',
                'description' => 'الآيباد الأنحف على الإطلاق مع شاشة Ultra Retina XDR الثورية ومعالج M4 الخارق لدعم كافة التطبيقات الإبداعية.',
                'price' => 1299.00,
                'old_price' => 1399.00,
                'rating' => 4.9,
                'reviews_count' => 74,
                'category' => 'الأجهزة اللوحية',
                'image_url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'stock' => 20,
            ],
        ];

        foreach ($products as $item) {
            Product::create($item);
        }
    }
}
