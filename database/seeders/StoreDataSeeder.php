<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\InAppNotification;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StoreDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Demo Users
        $demoUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'عزام أحمد', 'password' => Hash::make('password123'), 'email_verified_at' => now()]
        );
        $reviewer1 = User::firstOrCreate(['email' => 'sarah@example.com'], ['name' => 'سارة المنصور', 'password' => Hash::make('password123'), 'email_verified_at' => now()]);
        $reviewer2 = User::firstOrCreate(['email' => 'khalid@example.com'], ['name' => 'خالد العمري', 'password' => Hash::make('password123'), 'email_verified_at' => now()]);
        $reviewer3 = User::firstOrCreate(['email' => 'omar@example.com'], ['name' => 'عمر القحطاني', 'password' => Hash::make('password123'), 'email_verified_at' => now()]);
        $reviewer4 = User::firstOrCreate(['email' => 'fatima@example.com'], ['name' => 'فاطمة الزهراني', 'password' => Hash::make('password123'), 'email_verified_at' => now()]);

        // 2. Coupons
        Coupon::truncate();
        Coupon::insert([
            ['code' => 'TECH10', 'discount_percentage' => 10, 'max_discount_amount' => 100, 'min_order_amount' => 50, 'expires_at' => now()->addDays(60), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'WELCOME20', 'discount_percentage' => 20, 'max_discount_amount' => 150, 'min_order_amount' => 100, 'expires_at' => now()->addDays(90), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'VIP30', 'discount_percentage' => 30, 'max_discount_amount' => 300, 'min_order_amount' => 500, 'expires_at' => now()->addDays(30), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SUMMER15', 'discount_percentage' => 15, 'max_discount_amount' => 200, 'min_order_amount' => 200, 'expires_at' => now()->addDays(45), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. 1,075 Unique Non-Repetitive Products Across 10 Categories
        Product::truncate();
        $now = now();

        $categoriesCatalog = [
            'الهواتف الذكية' => [
                'img' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    // Apple
                    ['Apple iPhone 16 Pro Max 256GB تيتانيوم صحراوي', 1199, 'شريحة A18 Pro مع شاشة 6.9 بوصة وزر Camera Control وهيكل تيتانيوم مصقول.'],
                    ['Apple iPhone 16 Pro Max 512GB تيتانيوم طبيعي', 1399, 'كاميرا بدقة 48MP مع تقريب بصري 5x وبطارية تدوم حتى 33 ساعة تشغيل فيديو.'],
                    ['Apple iPhone 16 Pro Max 1TB تيتانيوم أسود فلكي', 1599, 'سعة 1 تيرابايت لتسجيل فيديو ProRes 4K 120fps مباشرة.'],
                    ['Apple iPhone 16 Pro 128GB تيتانيوم أبيض', 999, 'شاشة 6.3 بوصة Super Retina XDR بتردد 120Hz ProMotion وشريحة A18 Pro.'],
                    ['Apple iPhone 16 Pro 256GB تيتانيوم صحراوي', 1099, 'سعة 256 جيجابايت مع كاميرا Fusion 48MP وزر التقاط الكاميرا الجديد.'],
                    ['Apple iPhone 16 Pro 512GB تيتانيوم أسود', 1299, 'سعة تخزين واسعة للمصورين وصناع المحتوى مع معالجة صور ذكية.'],
                    ['Apple iPhone 16 Pro 1TB تيتانيوم طبيعي', 1499, 'الإصدار الأقصى لمصوري الفيديو بدقة سينمائية 4K بدون ضغط.'],
                    ['Apple iPhone 16 Plus 128GB أزرق كاريبي', 899, 'شاشة كبيرة 6.7 بوصة مع شريحة A18 وبطارية ممتازة تدوم طويلاً.'],
                    ['Apple iPhone 16 Plus 256GB أخضر تيل', 999, 'سعة 256GB مع زر Camera Control وكاميرا مزدوجة متطورة 48MP.'],
                    ['Apple iPhone 16 Plus 512GB وردي كوزميك', 1199, 'سعة قصوى في فئة البلس مع ألوان عصرية وزجاج ملون مدمج.'],
                    ['Apple iPhone 16 128GB أسود فاحم', 799, 'كاميرا 48MP Fusion مع زر Action Button ودعم Apple Intelligence.'],
                    ['Apple iPhone 16 256GB أبيض ناصع', 899, 'شريحة A18 مع ذاكرة 256 جيجابايت وسرعة ألعاب رسومية غير مسبوقة.'],
                    ['Apple iPhone 16 512GB أزرق كاريبي', 1099, 'سعة ضخمة 512GB للاحتفاظ بآلاف الصور والفيديوهات والتطبيقات.'],
                    ['Apple iPhone 15 Pro Max 256GB تيتانيوم أزرق', 949, 'شريحة A17 Pro الرائدة مع إطار تيتانيوم ومنفذ USB-C 10Gbps.'],
                    ['Apple iPhone 15 Pro 128GB تيتانيوم طبيعي', 799, 'كاميرا احترافية 48MP مع شاشة Always-On وسلاسة 120Hz.'],
                    ['Apple iPhone 15 128GB أخضر باستيل', 649, 'جزيرة Dynamic Island التفاعلية مع شريحة A16 Bionic وكاميرا 48MP.'],
                    ['Apple iPhone 15 Plus 256GB أصفر مشرق', 799, 'شاشة 6.7 بوصة مع بطارية تدوم يومين واستخدام مريح وخفيف.'],
                    ['Apple iPhone 14 128GB سماء الليل', 549, 'كاميرا مزدوجة متطورة مع نمط الحركة Action Mode ونمط السينما 4K.'],
                    ['Apple iPhone 14 Plus 128GB بنفسجي', 629, 'شاشة 6.7 بوصة مع عمر بطارية رائد ومعالج A15 Bionic السريع.'],
                    ['Apple iPhone 13 128GB أحمر منتج', 479, 'شريحة A15 Bionic مع شاشة Super Retina XDR ساطعة ومقاومة ماء IP68.'],
                    ['Apple iPhone SE 3rd Gen 128GB ضوء النجوم', 399, 'تصميم مدمج مع زر البصمة Touch ID وشريحة A15 Bionic واتصال 5G.'],

                    // Samsung
                    ['Samsung Galaxy S25 Ultra 256GB تيتانيوم رمادي', 1249, 'معالج Snapdragon 8 Elite مع قلم S-Pen مدمج وكاميرا 200MP وميزات Galaxy AI.'],
                    ['Samsung Galaxy S25 Ultra 512GB تيتانيوم أسود', 1399, 'ذاكرة 512GB مع 16 جيجا رام وشاشة Dynamic AMOLED 2X فائقة السطوع.'],
                    ['Samsung Galaxy S25 Ultra 1TB تيتانيوم فضي', 1659, 'النسخة الحصرية بسعة 1 تيرابايت للتصوير الاحترافي بدقة 8K.'],
                    ['Samsung Galaxy S25+ 256GB أزرق كحلي', 999, 'شاشة 6.7 بوصة بدقة QHD+ وبطارية 4900mAh مع شحن سريع 45W.'],
                    ['Samsung Galaxy S25+ 512GB رمادي رخامي', 1129, 'سعة 512GB مع أحدث تقنيات الذكاء الاصطناعي وشاشة 120Hz متكيفة.'],
                    ['Samsung Galaxy S25 128GB بنفسجي كوبالت', 799, 'حجم مدمج ومريح مع قوة Snapdragon 8 Elite وكاميرا ثلاثية متقدمة.'],
                    ['Samsung Galaxy S25 256GB أونيكس أسود', 859, 'سعة 256GB مع تصميم نحيف مسطح وشاشة Dynamic AMOLED 2X.'],
                    ['Samsung Galaxy S24 Ultra 256GB تيتانيوم أصفر', 999, 'شاشة مسطحة تماماً مضادة للانعكاس مع إطار تيتانيوم وقلم S-Pen.'],
                    ['Samsung Galaxy S24 Ultra 512GB تيتانيوم بنفسجي', 1149, 'كاميرا تقريب 50MP بدقة 5x بصري مع ترجمة فورية للمكالمات.'],
                    ['Samsung Galaxy S24+ 256GB أسود أونيكس', 799, 'شاشة 6.7 بوصة 120Hz مع 12 جيجا رام وتصميم مدرع Armor Aluminum.'],
                    ['Samsung Galaxy S24 FE 128GB أزرق ثلجي', 599, 'إصدار المعجبين بشاشة 6.7 بوصة 120Hz ومعالج Exynos 2400e القوي.'],
                    ['Samsung Galaxy S24 FE 256GB نعناعي أخضر', 659, 'سعة 256GB مع حزمة Galaxy AI الكاملة وكاميرا رئيسية 50MP.'],
                    ['Samsung Galaxy Z Fold 6 256GB فضي ميتاليك', 1799, 'هاتف قابل للطي بشاشة داخلية 7.6 بوصة وهيكل Armor Aluminum.'],
                    ['Samsung Galaxy Z Fold 6 512GB أزرق بحري', 1949, 'سعة 512GB للإنتاجية وتعدد المهام مع دعم قلم S-Pen وSamsung DeX.'],
                    ['Samsung Galaxy Z Fold 6 1TB أسود كربوني', 2249, 'النسخة الحصرية 1TB مع مساحة هائلة للعمل وتطبيقات سطح المكتب.'],
                    ['Samsung Galaxy Z Flip 6 256GB أصفر باستيل', 1049, 'شاشة خارجية FlexWindow مع كاميرا 50MP وبطارية أكبر 4000mAh.'],
                    ['Samsung Galaxy Z Flip 6 512GB فضي شادو', 1199, 'هاتف صدفي قابل للطي بسعة 512GB وتصميم مستقبلي أنيق.'],
                    ['Samsung Galaxy A55 5G 256GB ليموني رائع', 429, 'إطار معدني فاخر مع شاشة Super AMOLED 120Hz ومعالج Exynos 1480.'],
                    ['Samsung Galaxy A55 5G 128GB كحلي رائع', 379, 'حماية Knox Vault مع مقاومة ماء IP67 وكاميرا 50MP بمثبت OIS.'],
                    ['Samsung Galaxy A35 5G 128GB أزرق ثلجي', 329, 'شاشة 6.6 بوصة بمعدل 120Hz وكاميرا رئيسية 50MP وتصميم زجاجي.'],
                    ['Samsung Galaxy A25 5G 128GB أزرق داكن', 249, 'شاشة Super AMOLED بدقة FHD+ وسماعات استريو مع معالج Exynos 1280.'],
                    ['Samsung Galaxy A15 5G 128GB أزرق فاتح', 179, 'أفضل قيمة مع شاشة 90Hz AMOLED وبطارية 5000mAh وشحن 25W.'],
                    ['Samsung Galaxy A05s 128GB أسود مطفي', 129, 'شاشة 6.7 بوصة بدقة FHD+ مع معالج Snapdragon 680 وبطارية طويلة.'],

                    // Google Pixel
                    ['Google Pixel 9 Pro XL 256GB هازل رمادي', 1099, 'معالج Tensor G4 مع أفضل معالجة صور بالذكاء الاصطناعي وشاشة Super Actua.'],
                    ['Google Pixel 9 Pro XL 512GB بورسلين أبيض', 1249, 'شاشة 6.8 بوصة سطوع 3000 nit مع كاميرا تيليفوتو 5x وتحديثات 7 سنوات.'],
                    ['Google Pixel 9 Pro 128GB أوبسيديان أسود', 999, 'حجم مدمج 6.3 بوصة مع مواصفات فلاجشيب كاملة وكاميرا تيليفوتو 48MP.'],
                    ['Google Pixel 9 Pro 256GB وردي روز', 1099, 'سعة 256GB مع 16 جيجا رام وتكامل كامل مع Gemini Advanced الذكي.'],
                    ['Google Pixel 9 128GB وردي بيوني', 799, 'تصميم جديد مسطح الحواف مع معالج Tensor G4 وكاميرا 50MP فائقة الدقة.'],
                    ['Google Pixel 9 256GB شتوي أخضر', 899, 'سعة مضاعفة 256GB مع شاشة Actua OLED ساطعة وبطارية تدوم طوال اليوم.'],
                    ['Google Pixel 8a 128GB أزرق باي', 479, 'ميزات الذكاء الاصطناعي Best Take وMagic Audio Eraser بسعر اقتصادي.'],
                    ['Google Pixel 8a 256GB أوبسيديان أسود', 539, 'سعة 256GB مع شاشة 120Hz ومعالج Tensor G3 وتحديثات أمنية لسبع سنوات.'],
                    ['Google Pixel 8 Pro 128GB أزرق سماوي', 699, 'شاشة LTPO OLED 120Hz مع مستشعر حرارة مدمج وكاميرا ثلاثية متقدمة.'],
                    ['Google Pixel Fold 256GB أوبسيديان', 1399, 'هاتف جوجل القابل للطي بتصميم عريض مريح وتجربة أندرويد خام سلسة.'],

                    // Xiaomi & Poco
                    ['Xiaomi 14 Ultra 512GB أسود جلدي', 1199, 'مستشعر 1 بوصة Sony LYT-900 مع عدسات Leica الاحترافية وفتحة متغيرة f/1.63-f/4.0.'],
                    ['Xiaomi 14 Ultra 512GB أبيض تيتانيوم', 1199, 'هيكل تيتانيوم مع عدسات Leica الأربعة المعتمدة وتصوير فيديو 8K.'],
                    ['Xiaomi 14 Pro 256GB تيتانيوم رمادي', 899, 'شاشة منحنية 2K LTPO مع زجاج Longjing Glass وشحن سريع 120W.'],
                    ['Xiaomi 14 256GB أخضر زمردي', 699, 'حجم مدمج 6.36 بوصة بمعالج Snapdragon 8 Gen 3 وشحن 90W.'],
                    ['Xiaomi 14 512GB أسود كلاسيكي', 779, 'سعة ضخمة 512GB مع كاميرات Leica الثلاثية بدقة 50MP لكل عدسة.'],
                    ['Xiaomi 13T Pro 512GB أزرق ألبين جلدي', 599, 'كاميرات Leica مع شاشة CrystalRes 144Hz AMOLED وشحن 120W HyperCharge.'],
                    ['Xiaomi 13T 256GB أخضر مروج', 479, 'معالج Dimensity 8200-Ultra مع عدسات Leica ومقاومة ماء IP68.'],
                    ['Xiaomi Redmi Note 13 Pro+ 512GB أرجواني شفق', 399, 'كاميرا 200MP بمثبت OIS وشاشة منحنية 1.5K AMOLED ومقاومة IP68.'],
                    ['Xiaomi Redmi Note 13 Pro 256GB أخضر غابي', 289, 'معالج Snapdragon 7s Gen 2 مع كاميرا 200MP وبطارية 5100mAh.'],
                    ['Xiaomi Redmi Note 13 4G 128GB أسود كربوني', 179, 'شاشة AMOLED 120Hz بحواف نحيفة وكاميرا رئيسية 108MP.'],
                    ['Xiaomi Redmi 13C 128GB أزرق بحري', 119, 'شاشة 6.74 بوصة 90Hz وبطارية 5000mAh مع كاميرا 50MP بسعر اقتصادي.'],
                    ['Poco F6 Pro 512GB أبيض جليدي', 499, 'معالج Snapdragon 8 Gen 2 وشاشة 2K 120Hz وشحن سلكي 120W للألعاب.'],
                    ['Poco F6 Pro 1TB أسود شادو', 589, 'سعة 1 تيرابايت مع 16 جيجا رام لتخزين مئات الألعاب الثقيلة وتشغيلها بسلاسة.'],
                    ['Poco F6 256GB أسود تيتانيوم', 379, 'معالج Snapdragon 8s Gen 3 مع نظام تبريد LiquidCool 4.0 وشاشة 1.5K.'],
                    ['Poco X6 Pro 512GB أصفر بوكو جلد', 319, 'معالج Dimensity 8300-Ultra مع واجهة Xiaomi HyperOS وذاكرة UFS 4.0.'],
                    ['Poco X6 5G 256GB أبيض رخامي', 249, 'معالج Snapdragon 7s Gen 2 مع شاشة 120Hz Flow AMOLED وكاميرا 64MP OIS.'],
                    ['Poco M6 Pro 256GB أزرق بحري', 199, 'شاشة Flow AMOLED 120Hz مع كاميرا ثلاثية 64MP وشحن توربو 67W.'],

                    // OnePlus
                    ['OnePlus 12 256GB أخضر زمردي حريري', 799, 'معالج Snapdragon 8 Gen 3 وشاشة ProXDR بدقة 2K وكاميرا Hasselblad.'],
                    ['OnePlus 12 512GB أسود بركاني', 899, 'ذاكرة 16GB RAM مع تخزين 512GB وبطارية 5400mAh وشحن 100W SuperVOOC.'],
                    ['OnePlus 12R 256GB رمادي حديدي', 499, 'شاشة 1.5K LTPO 4.0 وبطارية عملاقة 5500mAh وشحن 100W سريع.'],
                    ['OnePlus 12R 128GB أزرق بارد', 449, 'معالج Snapdragon 8 Gen 2 الرائد مع شاشة 120Hz فائقة الاستجابة.'],
                    ['OnePlus Open 512GB أخضر إميرالد جلدي', 1499, 'أنحف وأخف هاتف طي بشاشات 2K بدون تجعيدة ملحوظة وكاميرات Hasselblad.'],
                    ['OnePlus Open 512GB أسود فوياجر', 1499, 'ظهر من الجلد النباتي الفاخر مع حماية Ceramic Guard ومفصلة خفيفة الوزن.'],
                    ['OnePlus Nord 4 256GB فضي ميركوري معدني', 399, 'تصميم هيكل معدني بالكامل من قطعة واحدة مع معالج Snapdragon 7+ Gen 3.'],
                    ['OnePlus Nord 4 512GB أسود أوبسيديان', 459, 'سعة 512GB مع 16 جيجا رام وتحديثات أندرويد لست سنوات قادمة.'],
                    ['OnePlus Nord CE4 256GB أخضر ماربل', 279, 'معالج Snapdragon 7 Gen 3 مع بطارية 5500mAh وشحن سريع 100W.'],
                    ['OnePlus Nord CE4 Lite 128GB أزرق فائق', 199, 'شاشة AMOLED 120Hz بسطوع 2100 nit وبطارية 5110mAh مع مكبرات استريو.'],

                    // Honor & Huawei
                    ['Honor Magic 6 Pro 512GB أسود ملكي', 949, 'كاميرا تيليفوتو 180MP وبطارية سيليكون كربون 5600mAh وزجاج NanoCrystal.'],
                    ['Honor Magic 6 Pro 512GB أخضر إيبي جلد', 949, 'ظهر جلدي فاخر مع Snapdragon 8 Gen 3 وتصنيف IP68 الأعلى لمقاومة الماء.'],
                    ['Honor Magic V3 512GB بني مخملي جلد', 1699, 'أنحف هاتف قابل للطي بسماكة 9.2 مم عند الإغلاق وبطارية 5150mAh.'],
                    ['Honor Magic V3 512GB أخضر حريري', 1699, 'شاشتان LTPO 120Hz بدعم قلم Magic-Pen على الشاشتين الداخلية والخارجية.'],
                    ['Honor 200 Pro 512GB أبيض قمر البدر', 599, 'نظام تصوير بورتريه سينمائي احترافي بالتعاون مع Studio Harcourt باريس.'],
                    ['Honor 200 Pro 512GB أسود محيطي', 599, 'معالج Snapdragon 8s Gen 3 وشحن سلكي 100W وشحن لاسلكي 66W.'],
                    ['Honor 200 256GB أسود زمردي', 399, 'شاشة حماية العين AMOLED بدون وميض 3840Hz مع كاميرا سيلفي 50MP.'],
                    ['Honor 90 256GB فضي ماسي', 319, 'كاميرا بدقة 200MP وشاشة منحنية 1.5K بأعلى تردد تعتيم للراحة البصرية.'],
                    ['Honor X9b 5G 256GB برتقالي جلد شروق', 279, 'شاشة غير قابلة للكسر بحماية Ultra-Bounce وبطارية جبارة 5800mAh.'],
                    ['Honor X8b 512GB أخضر بريق جلدي', 229, 'شاشة AMOLED بسطوع 2000 nit وكاميرا 108MP ومساحة تخزين هائلة 512GB.'],
                    ['Huawei Pura 70 Ultra 512GB أسود كلاسيك', 1399, 'كاميرا بمستشعر 1 بوصة بآلية تلسكوبية منبثقة وفتحة متغيرة وميزات XMAGE.'],
                    ['Huawei Pura 70 Pro 512GB أبيض ناصع', 999, 'كاميرا Super Focus Macro تيليفوتو للتصوير المجهري وشحن سلكي 100W.'],
                    ['Huawei Mate 60 Pro 512GB أخضر يشمي', 1099, 'أول هاتف باتصال قمر صناعي ثنائي الاتجاه وزجاج Kunlun Glass 2.'],
                    ['Huawei Nova 12 Pro 256GB أزرق جذاب', 479, 'كاميرا سيلفي مزدوجة 60MP مع تقريب بصري 2x وشحن سريع 100W.'],
                    ['Huawei Nova 12 SE 256GB أخضر نعناعي', 249, 'كاميرا بدقة 108MP بتصميم حلقة مدارية مزدوجة وشحن فائق 66W.'],

                    // Oppo & Vivo
                    ['Oppo Find X7 Ultra 512GB بني بحري جلد', 1199, 'أول هاتف بكاميرتين بيريسكوب مزدوجتين في العالم مع معالجة Hasselblad.'],
                    ['Oppo Reno 12 Pro 512GB فضي نجمي سائل', 529, 'تصميم انسيابي ثلاثي الأبعاد مع ميزات تحرير الصور AI Eraser 2.0.'],
                    ['Oppo Reno 12 256GB بني مات', 399, 'هيكل مدرع مقاوم للصدمات ورذاذ الماء مع شاشة AMOLED منحنية مريحة.'],
                    ['Oppo Reno 11F 5G 256GB أزرق محيطي', 279, 'حواف شاشة فائقة النحافة 120Hz مع حماية IP65 وكاميرا فائقة 64MP.'],
                    ['Oppo A79 5G 256GB أرجواني متوهج', 219, 'شاشة كبيرة FHD+ مع مكبرات صوت مزدوجة باستريو 300% فائق العلو.'],
                    ['Vivo X100 Pro 512GB برتقالي غروب جلد', 999, 'عدسة Zeiss APO تيليفوتو العائمة مع شريحة معالجة الصور Vivo V3.'],
                    ['Vivo X100 256GB أزرق سماوي', 749, 'معالج Dimensity 9300 الخارق مع كاميرات Zeiss T* المقاومة للتوهج.'],
                    ['Vivo V30 Pro 512GB أزرق متموج', 499, 'إضاءة Aura Light البورتريه الاحترافية الذكية مع عدسات Zeiss المعتمدة.'],
                    ['Vivo V30 256GB أخضر طاووسي', 379, 'أنحف هاتف ببطارية 5000mAh مع شحن فلاش 80W وتصميم مذهل.'],
                    ['Vivo Y200 5G 256GB برتقالي صحراوي جلد', 229, 'شاشة AMOLED 120Hz مع إضاءة Aura Light وتصميم فخم مقاوم للماء.'],

                    // Realme, Motorola, Sony, Nothing, Asus
                    ['Realme GT 6 512GB أخضر سائل سبيس', 549, 'شاشة بسطوع قياسي 6000 nit مع Snapdragon 8s Gen 3 وشحن 120W.'],
                    ['Realme GT 6T 256GB فضي سائل', 429, 'معالج Snapdragon 7+ Gen 3 مع شاشة 8T LTPO وبطارية 5500mAh.'],
                    ['Realme 12 Pro+ 512GB أزرق بحري جلد', 399, 'كاميرا بيريسكوب تيليفوتو مستوحاة من الساعات الفاخرة مع OIS.'],
                    ['Realme 12+ 5G 256GB أخضر رائد', 269, 'مستشعر Sony LYT-600 مع تثبيت بصري وتصميم جلدي مقاوم للبقع.'],
                    ['Realme C67 256GB أسود صخري', 149, 'كاميرا 108MP 3x In-sensor Zoom مع معالج Snapdragon 685 وكبسولة ذكية Mini Capsule.'],
                    ['Motorola Edge 50 Ultra 512GB خشب طبيعي', 899, 'ظهر مصنوع من الخشب الطبيعي الحقيقي مع شاشة pOLED 144Hz وشحن 125W.'],
                    ['Motorola Razr 50 Ultra 512GB أخضر ربيعي جلد', 999, 'أكبر شاشة غطاء خارجية مقاس 4.0 بوصة بتقنية LTPO 165Hz.'],
                    ['Motorola Edge 50 Pro 256GB بنفسجي لافندر', 549, 'شاشة معتمدة بألوان Pantone الحقيقية وشحن لاسلكي 50W ومقاومة IP68.'],
                    ['Motorola Edge 50 Fusion 256GB وردي مارشميلو', 349, 'شاشة منحنية 144Hz مع كاميرا Sony LYT-700C ومقاومة ماء كاملة IP68.'],
                    ['Motorola G84 5G 256GB أحمر فيفا ماجينتا', 219, 'شاشة pOLED 120Hz بمكبرات صوت Dolby Atmos وتصميم جلدي أنيق.'],
                    ['Sony Xperia 1 VI 256GB أسود بلاتينيوم', 1249, 'عدسة تقريب بصري مستمر حقيقي 85-170mm وشاشة OLED موفرة للطاقة.'],
                    ['Sony Xperia 5 V 128GB بلاتينيوم سيلفر', 849, 'فلاجشيب مدمج بمستشعر Exmor T الجديد وبطارية تدوم يومين كاملين.'],
                    ['Sony Xperia 10 VI 128GB أزرق ناعم', 399, 'وزن خفيف جداً 164 جرام مع بطارية 5000mAh ومقاومة ماء وغبار IP68.'],
                    ['Nothing Phone (2) 512GB رمادي غامق شفاف', 599, 'واجهة Glyph التفاعلية المضيئة مع نظام Nothing OS 2.5 وSnapdragon 8+ Gen 1.'],
                    ['Nothing Phone (2a) 256GB حليبي أبيض', 369, 'تصميم شفاف أيقوني مع معالج Dimensity 7200 Pro وكاميرتين 50MP.'],
                    ['Nothing Phone (2a) Plus 256GB فضي ميتاليك', 419, 'معالج Dimensity 7350 Pro مع كاميرا أمامية 50MP وشحن سريع 50W.'],
                    ['Asus ROG Phone 8 Pro 512GB أسود فانتوم', 1099, 'أقوى هاتف ألعاب بشاشة 165Hz ومصفوفة AniMe Vision LED المضيئة.'],
                    ['Asus Zenfone 11 Ultra 256GB أزرق سكاي لاين', 849, 'شاشة LTPO AMOLED 6.78 بوصة مع مثبت جيمبال ثلاثي المحاور 6-Axis.'],
                    ['ZTE Nubia Z60 Ultra 512GB إصدار ليلة النجوم', 749, 'شاشة كاملة حقيقية بدون ثقب للكاميرا وبطارية 6000mAh وثلاث كاميرات OIS.'],
                    ['ZTE RedMagic 9 Pro 512GB شفاف سبيشال', 899, 'مروحة تبريد ميكانيكية مدمجة بإضاءة RGB وظهر مسطح بالكامل بدون بروز.'],
                ]
            ],
            'الحواسيب المحمولة والمكتبية' => [
                'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    // 70 models
                    ['Apple MacBook Pro 16 M3 Max 36GB/1TB أسود فلكي', 2899, 'شاشة Liquid Retina XDR 16 بوصة مع معالج M3 Max بـ 16 نواة CPU و40 نواة GPU.'],
                    ['Apple MacBook Pro 16 M3 Max 48GB/1TB فضي', 3299, 'ذاكرة موحدة 48 جيجابايت لتطوير برمجيات الذكاء الاصطناعي والمونتاج السينمائي 8K.'],
                    ['Apple MacBook Pro 16 M3 Pro 36GB/512GB أسود فلكي', 2499, 'شريحة M3 Pro المتوازنة مع عمر بطارية أسطوري يصل إلى 22 ساعة عمل متواصل.'],
                    ['Apple MacBook Pro 14 M3 Max 36GB/1TB أسود فلكي', 2599, 'قوة M3 Max الكاملة في هيكل 14 بوصة مدمج وسهل الحمل والتنقل.'],
                    ['Apple MacBook Pro 14 M3 Pro 18GB/512GB فضي', 1999, 'شاشة XDR ساطعة حتى 1600 nit مع منافذ HDMI وقارئ SD Card وMagSafe 3.'],
                    ['Apple MacBook Pro 14 M3 16GB/512GB رمادي فلكي', 1599, 'معالج M3 السريع مع شاشة ProMotion 120Hz ومكبرات صوت استوديو بستة محركات.'],
                    ['Apple MacBook Air 15 M3 16GB/512GB سماء الليل', 1499, 'سماكة 11.5 مم فقط مع شاشة Liquid Retina 15.3 بوصة وتصميم بدون مراوح صامت تماماً.'],
                    ['Apple MacBook Air 15 M3 24GB/1TB ضوء النجوم', 1899, 'النسخة القصوى بذاكرة 24 جيجا وتخزين 1 تيرابايت لإنتاجية فائقة وسلاسة مطلقة.'],
                    ['Apple MacBook Air 13 M3 16GB/512GB رمادي فلكي', 1299, 'أفضل لابتوب خفيف بوزن 1.24 كجم مع دعم تشغيل شاشتين خارجيتين.'],
                    ['Apple MacBook Air 13 M3 8GB/256GB فضي', 999, 'الابتوب الأكثر شعبية في العالم بتصميم أنيق وبطارية تدوم 18 ساعة.'],
                    ['Apple MacBook Air 13 M2 16GB/256GB سماء الليل', 899, 'شريحة M2 القوية مع كاميرا FaceTime 1080p وشحن MagSafe السريع.'],
                    ['Apple Mac Studio M2 Ultra 64GB/1TB', 3999, 'وحش الحوسبة المكتبية مع معالج M2 Ultra بـ 24 نواة CPU و60 نواة GPU لتشغيل النماذج الضخمة.'],
                    ['Apple Mac Studio M2 Max 32GB/512GB', 1999, 'أداء احترافي في حجم مكتبي مدمج مع منافذ Thunderbolt 4 أمامية وخلفية.'],
                    ['Apple Mac mini M2 Pro 16GB/512GB', 1299, 'كمبيوتر مكتبي قوي جداً للمبرمجين وصناع المحتوى مع دعم 3 شاشات خارجية.'],
                    ['Apple Mac mini M2 8GB/256GB', 599, 'أرخص بوابة لنظام macOS بأداء خارق وكفاءة استهلاك طاقة استثنائية.'],
                    ['Apple iMac 24 M3 16GB/512GB أزرق سماوي', 1699, 'شاشة 4.5K Retina مدمجة مع معالج M3 وماوس ولوحة مفاتيح متناسقة بالألوان.'],
                    ['Apple iMac 24 M3 8GB/256GB أخضر تفاحي', 1299, 'تصميم مكتبي الكل-في-واحد فائق النحافة مع صوت مكاني Dolby Atmos.'],
                    ['Dell XPS 16 OLED 9640 Core Ultra 9 RTX 4070 32GB/1TB', 2699, 'شاشة 4K OLED تعمل باللمس مع معالج Intel Core Ultra 9 وتصميم مستقبلي بلوح لمس زجاجي.'],
                    ['Dell XPS 14 OLED 9440 Core Ultra 7 RTX 4050 32GB/1TB', 2199, 'شاشة 3.2K OLED 120Hz مع كرت رسومات منفصل في هيكل ألومنيوم فائق النحافة.'],
                    ['Dell XPS 13 9340 Core Ultra 7 16GB/512GB بلاتينيوم', 1399, 'وزن 1.17 كجم فقط مع شاشة InfinityEdge بدقة QHD+ ولوحة أزرار لمسية غير مرئية.'],
                    ['Dell Alienware m18 R2 i9-14900HX RTX 4090 64GB/2TB', 3799, 'أقوى لابتوب جيمنج من إيلين وير بشاشة 18 بوصة QHD+ 165Hz وتبريد سائل Element 31.'],
                    ['Dell Alienware x16 R2 Ultra 9 RTX 4080 32GB/1TB', 2899, 'لابتوب ألعاب فاخر بهيكل نحيف وإضاءة AlienFX RGB خلفية ولوحة مفاتيح ميكانيكية CherryMX.'],
                    ['Dell Alienware Aurora R16 Gaming Desktop i9 RTX 4080', 2599, 'كمبيوتر مكتبي جيمنج بتصميم Legend 3 الأنيق ونظام تدفق هواء هادئ جداً.'],
                    ['Dell Inspiron 16 Plus i7-13700H RTX 4060 16GB/1TB', 1249, 'لابتوب إنتاجي بشاشة 16 بوصة 2.5K 120Hz مخصص لصناع المحتوى والمهندسين.'],
                    ['Dell Latitude 7440 Ultralight i7 16GB/512GB', 1499, 'لابتوب أعمال خفيف جداً مصنوع من المغنيسيوم بوزن أقل من 1 كجم مع حماية vPro.'],
                    ['Dell G16 7630 Gaming i7 RTX 4060 16GB/1TB 240Hz', 1199, 'لابتوب ألعاب متين بشاشة QHD+ 240Hz وتبريد مستوحى من Alienware.'],
                    ['Dell Precision 5680 Mobile Workstation i7 RTX 3500 Ada', 3199, 'محطة عمل هندسية محمولة معتمدة لبرامج CAD و3D بموثوقية فائقة.'],
                    ['Lenovo ThinkPad X1 Carbon Gen 12 Ultra 7 32GB/1TB OLED', 1999, 'أيقونة لابتوبات الأعمال بهيكل ألياف الكربون الفاخر وشاشة 2.8K OLED 120Hz.'],
                    ['Lenovo ThinkPad T14s Gen 5 Snapdragon X Elite 32GB/1TB', 1699, 'معالج ARM Copilot+ PC فائق الكفاءة مع بطارية تدوم أكثر من 24 ساعة واتصال 5G.'],
                    ['Lenovo ThinkPad X1 2-in-1 Gen 9 Ultra 7 32GB/1TB Touch', 2149, 'حاسوب متحول متعدد الاستخدامات بقلم ذكي مغناطيسي وشاشة لمس OLED مضادة للتوهج.'],
                    ['Lenovo Legion Pro 7i Gen 9 i9-14900HX RTX 4090 32GB/2TB', 3199, 'شاشة 16 بوصة WQXGA 240Hz مع شريحة الذكاء الاصطناعي Lenovo LA-2X لتحسين الفريمات.'],
                    ['Lenovo Legion Pro 5i Gen 9 i7-14700HX RTX 4070 32GB/1TB', 1699, 'لابتوب الجيمنج الأكثر توازناً مع نظام تبريد Legion ColdFront 5.0 ومفاتيح TrueStrike.'],
                    ['Lenovo Legion Slim 5 16 AMD Ryzen 7 RTX 4060 16GB/1TB', 1299, 'أداء قوي في هيكل نحيف أنيق مناسب للجامعة والعمل واللعب في وقت واحد.'],
                    ['Lenovo Yoga Pro 9i 16 Ultra 9 RTX 4070 32GB/1TB Mini-LED', 2199, 'شاشة PureSight Pro Mini-LED بسطوع 1200 nit ودقة 3.2K للمصممين المحترفين.'],
                    ['Lenovo Yoga Book 9i ثنائي الشاشات 2x 13.3 OLED Ultra 7', 1999, 'حاسوب ثوري بشاشتين OLED كاملتين قابلتين للطي مع حامل متعدد الوضعيات وقلم ولوحة مفاتيح.'],
                    ['Lenovo Yoga Slim 7x Snapdragon X Elite 16GB/1TB OLED', 1199, 'لابتوب ذكاء اصطناعي فائق النحافة بسماكة 12.9 مم ووزن 1.28 كجم وشاشة 3K OLED.'],
                    ['Lenovo IdeaPad Pro 5i 16 Core Ultra 9 RTX 4050 32GB/1TB', 1149, 'قيمة استثنائية للمصممين مع شاشة 2.5K 120Hz وبطارية 84Wh ضخمة.'],
                    ['Lenovo LOQ 15 Gaming i7 RTX 4060 16GB/512GB', 899, 'أفضل قيمة مقابل السعر لعشاق ألعاب eSports مع لوحة مفاتيح ألعاب كاملة.'],
                    ['ASUS ROG Zephyrus G16 (2024) Ultra 9 RTX 4090 32GB/2TB OLED', 3299, 'أنحف لابتوب ألعاب فائق القوة بشاشة ROG Nebula OLED بدقة 2.5K بتردد 240Hz وإضاءة Slash Lighting.'],
                    ['ASUS ROG Zephyrus G14 (2024) Ryzen 9 RTX 4070 32GB/1TB OLED', 1999, 'حجم 14 بوصة مدمج بهيكل ألومنيوم CNC متكامل ووزن 1.5 كجم مع شاشة 3K OLED 120Hz.'],
                    ['ASUS ROG Strix SCAR 18 i9-14900HX RTX 4090 64GB/2TB Mini-LED', 3899, 'شاشة Mini-LED عملاقة 18 بوصة بسطوع 1100 nit وتردد 240Hz مع معدن سائل Conductonaut Extreme.'],
                    ['ASUS ROG Strix G16 i7-14650HX RTX 4060 16GB/1TB', 1399, 'تصميم جيمنج جريء بشريط إضاءة RGB محيطي وشاشة FHD+ 165Hz واستجابة 3ms.'],
                    ['ASUS ROG Flow Z13 Gaming Tablet i9 RTX 4060 16GB/1TB', 1799, 'جهاز تابلت ألعاب خارق بنظام Windows ولوحة مفاتيح قابلة للفصل ودعم كروت XG Mobile.'],
                    ['ASUS Zenbook Duo (2024) 2x 14 OLED Ultra 9 32GB/1TB', 1699, 'شاشتان OLED 3K 120Hz متطابقتان مع لوحة مفاتيح مغناطيسية قابلة للفصل وحامل مدمج.'],
                    ['ASUS Zenbook 14 OLED Ultra 7 16GB/1TB أزرق بوندر', 1049, 'لابتوب فاخر بوزن 1.2 كجم فقط وبطارية 75Wh تدوم 15 ساعة مع شاشة 3K 120Hz OLED.'],
                    ['ASUS ProArt P16 Ryzen AI 9 RTX 4070 64GB/2TB 4K OLED', 2699, 'لابتوب استوديو معتمد للمبدعين مع قرص تحكم مادي ASUS DialPad وشاشة 4K OLED لمس.'],
                    ['ASUS TUF Gaming A15 Ryzen 7 RTX 4060 16GB/512GB', 999, 'لابتوب ألعاب متين بمعيار الجيش الأمريكي MIL-STD-810H وبطارية 90Wh تدوم طويلاً.'],
                    ['HP Spectre x360 16 OLED Ultra 7 RTX 4050 32GB/1TB', 1799, 'حاسوب متحول فاخر بشاشة لمس 2.8K OLED وكاميرا ذكاء اصطناعي 9MP مع تعقب الوجه.'],
                    ['HP Spectre x360 14 OLED Ultra 7 16GB/1TB أسود نايت فال', 1449, 'تصميم بزوايا ماسية مقطوعة مع شاشة OLED بدقة 2.8K وقلم ذكي قابل للشحن مغناطيسياً.'],
                    ['HP Omen Transcend 14 OLED Ultra 9 RTX 4070 32GB/1TB', 1899, 'أخف لابتوب ألعاب 14 بوصة في العالم مع شاشة 2.8K 120Hz OLED وصوت HyperX المضبوط.'],
                    ['HP Omen 17 i9-14900HX RTX 4080 32GB/1TB QHD 240Hz', 2399, 'شاشة 17.3 بوصة واسعة مع لوحة مفاتيح ميكانيكية بصرية ونظام تبريد Omen Tempest Cooling.'],
                    ['HP Envy 16 i7-13700H RTX 4060 16GB/1TB WQXGA 120Hz', 1349, 'محطة عمل إبداعية بشاشة ملونة بدقة 100% sRGB وتبريد بغرفة بخار متقدمة.'],
                    ['HP Pavilion Plus 14 OLED Core Ultra 5 16GB/512GB', 799, 'شاشة 2.8K OLED فاخرة بأفضل سعر ممكن مع معالج Intel الجديد وميزات AI.'],
                    ['HP EliteBook 840 G10 i7 16GB/512GB ألومنيوم فضي', 1399, 'لابتوب أعمال احترافي مع حماية HP Wolf Security وميكروفونات مزدوجة بعزل ضوضاء بالذكاء الاصطناعي.'],
                    ['HP Victus 16 Gaming Ryzen 7 RTX 4060 16GB/1TB', 949, 'لابتوب جيمنج شبابي بشاشة 144Hz وتصميم انسيابي هادئ بدون بهرجة.'],
                    ['MSI Titan 18 HX i9-14900HX RTX 4090 128GB/4TB 4K 120Hz Mini-LED', 4999, 'أقوى حاسوب محمول في العالم بـ 128 جيجا رام وشاشة 4K Mini-LED ولوحة لمس RGB مضيئة.'],
                    ['MSI Raider GE78 HX i9-14900HX RTX 4080 32GB/2TB', 2699, 'شريط إضاءة Matrix RGB الأيقوني مع نظام تبريد Cooler Boost 5 وشاشة QHD+ 240Hz.'],
                    ['MSI Stealth 16 AI Studio Ultra 9 RTX 4070 32GB/1TB OLED', 2199, 'هيكل مصنوع من سبائك المغنيسيوم والألومنيوم بلون أزرق نجمي ووزن 1.99 كجم فقط.'],
                    ['MSI Creator Z17 HX Studio i9 RTX 4070 32GB/1TB QHD+ Touch', 2499, 'لابتوب احترافي بشاشة لمس تدعم قلم MSI Pen 2 مع استجابة ضغط لمسية فريدة.'],
                    ['MSI Katana 15 Gaming i7 RTX 4060 16GB/1TB 144Hz', 1049, 'سيف الجيمنج الحاد بأداء قوي ومفاتيح WASD مضيئة بسعر مناسب.'],
                    ['MSI Modern 14 Ultra 5 16GB/512GB رمادي كربوني', 599, 'لابتوب طلاب وموظفين خفيف الوزن مع شاشة FHD مريحة ومنفذ Type-C كامل.'],
                    ['Razer Blade 16 (2024) i9-14900HX RTX 4090 32GB/2TB OLED', 3999, 'شاشة OLED ثنائية الوضع الأولى في العالم (4K 120Hz / FHD 240Hz) بهيكل ألومنيوم مصقول.'],
                    ['Razer Blade 14 (2024) Ryzen 9 8945HS RTX 4070 32GB/1TB QHD+ 240Hz', 2399, 'لابتوب ألعاب مدمج 14 بوصة ببطارية 68Wh وطلاء مؤكسد مقاوم لبصمات الأصابع.'],
                    ['Razer Blade 18 (2024) i9-14900HX RTX 4090 64GB/2TB 4K 200Hz', 4499, 'شاشة 18 بوصة بدقة 4K بتردد 200Hz ومنفذ Thunderbolt 5 الجديد فائق السرعة 120Gbps.'],
                    ['Microsoft Surface Laptop 7 13.8" Snapdragon X Elite 16GB/512GB', 1199, 'شاشة PixelSense لمس مع بطارية تدوم 20 ساعة وكاميرا Studio Camera بالذكاء الاصطناعي.'],
                    ['Microsoft Surface Laptop 7 15" Snapdragon X Elite 32GB/1TB أسود', 1699, 'شاشة 15 بوصة رحبة بدقة 2496x1664 مع لوحة لمس Haptic Haptic touchpad.'],
                    ['Microsoft Surface Laptop Studio 2 i7 RTX 4060 32GB/1TB Touch', 2399, 'شاشة متحولة ثلاثية الوضعيات مع كرت رسومات قوي وقلم Slim Pen 2 المدمج.'],
                    ['Acer Predator Helios 16 i9-14900HX RTX 4080 32GB/1TB WQXGA 240Hz', 2199, 'مفاتيح MagClick الميكانيكية القابلة للتبديل ومروحتين AeroBlade 3D من الجيل الخامس.'],
                    ['Acer Swift Go 14 OLED Core Ultra 7 16GB/1TB فضي ناصع', 899, 'شاشة 2.8K 90Hz OLED مع كاميرا 1440p QHD وتقنية إزالة الضوضاء بالذكاء الاصطناعي.'],
                    ['Acer Nitro 16 Ryzen 7 7840HS RTX 4060 16GB/512GB', 1099, 'لابتوب ألعاب اقتصادي ممتاز بشاشة 165Hz ونظام تبريد بمعدن سائل.'],
                    ['Acer Aspire 5 15 i5 16GB/512GB رمادي ميتاليك', 549, 'لابتوب عملي للدراسة والمكتب مع أداء معتمد ومنافذ توصيل متعددة.'],
                    ['Samsung Galaxy Book 4 Ultra Core Ultra 9 RTX 4070 32GB/1TB Touch', 2399, 'شاشة Dynamic AMOLED 2X لمسية مضادة للانعكاس مع تكامل بيئي كامل مع هواتف Galaxy.'],
                    ['Samsung Galaxy Book 4 Pro 360 Core Ultra 7 16GB/1TB 2-in-1 Touch', 1649, 'لابتوب متحول بشاشة AMOLED وقلم S-Pen مدمج ووزن خفيف 1.66 كجم.'],
                    ['Samsung Galaxy Book 4 360 i7 16GB/512GB شاشة لمس', 1099, 'حاسوب متحول خفيف وعملي للرسم وتدوين الملاحظات وشاشة AMOLED رائعة.'],
                    ['Huawei MateBook X Pro (2024) Ultra 9 32GB/2TB Flexible OLED', 1899, 'وزن لا يصدق 980 جرام فقط بشاشة OLED مرنة 3.1K 120Hz وشحن توربو 90W.'],
                    ['Huawei MateBook 16s i9-13900H 32GB/1TB 2.5K Touchscreen', 1399, 'شاشة 16 بوصة بنسبة 3:2 الواسعة لمطالعة المستندات والأكواد البرمجية براحة تامة.'],
                    ['Huawei MateBook D 16 i7 16GB/1TB هوائي Metaline', 799, 'لوحة أرقام رقمية كاملة وهوائي Metaline لاتصال واي فاي قوي حتى 270 متراً.'],
                    ['LG Gram 17 (2024) Ultra 7 RTX 3050 32GB/1TB خفيف الوزن', 1799, 'أخف لابتوب 17 بوصة في العالم بوزن 1.37 كجم وبطارية ضخمة 90Wh.'],
                    ['LG Gram 16 Pro 2-in-1 Ultra 7 16GB/1TB شاشة لمس قلم Wacom', 1599, 'لابتوب متحول بشاشة لمس Wacom AES 2.0 المعتمدة للدقة الفنية.'],
                    ['Framework Laptop 16 Modular Ryzen 7 Radeon RX 7700S 32GB/1TB', 1899, 'لابتوب معياري قابل للترقية وتغيير كافة القطع والمنافذ ولوحة المفاتيح بنفسك.'],
                    ['Framework Laptop 13 Intel Core Ultra 7 16GB/512GB DIY Edition', 1199, 'لابتوب 13.5 بوصة قابل للتفكيك بالكامل والإصلاح بأبسط مفك براغي.'],
                ]
            ],
            'الأجهزة اللوحية والقارئات' => [
                'img' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Apple iPad Pro 13 M4 WiFi 256GB أسود فلكي', 1299, 'أنحف جهاز صنعته آبل بشاشة Ultra Retina XDR بتقنية OLED الترادفية المزدوجة ومعالج M4.'],
                    ['Apple iPad Pro 13 M4 WiFi 512GB فضي ناصع', 1499, 'سعة 512GB للمحترفين مع شاشة OLED ساطعة حتى 1600 nit ودعم قلم Apple Pencil Pro.'],
                    ['Apple iPad Pro 13 M4 Cellular 1TB زجاج نانو', 2099, 'زجاج Nano-Texture المضاد للتوهج مع اتصال 5G وشريحة M4 كاملة بـ 16GB RAM.'],
                    ['Apple iPad Pro 11 M4 WiFi 256GB أسود فلكي', 999, 'قوة شريحة M4 الخارقة في حجم 11 بوصة خفيف ومحمول للغاية للرسم والتصميم.'],
                    ['Apple iPad Pro 11 M4 WiFi 512GB فضي', 1199, 'شاشة Tandem OLED بدقة ألوان استثنائية لمونتاج الفيديو وتعديل الصور بدقة HDR.'],
                    ['Apple iPad Pro 11 M4 Cellular 256GB أسود', 1199, 'اتصال خلوي 5G فائق السرعة للعمل الميداني والإنتاجية أثناء السفر والتنقل.'],
                    ['Apple iPad Air 13 M2 128GB أزرق باستيل', 799, 'شاشة رحبة 13 بوصة Liquid Retina مع معالج M2 وتوافق تام مع Magic Keyboard.'],
                    ['Apple iPad Air 13 M2 256GB ضوء النجوم', 899, 'سعة 256GB للطلاب والمهندسين لتدوين المحاضرات والرسم وتشغيل التطبيقات الثقيلة.'],
                    ['Apple iPad Air 13 M2 512GB بنفسجي لافندر', 1099, 'مساحة تخزين هائلة مع معالجة ذكاء اصطناعي Neural Engine قوية في شريحة M2.'],
                    ['Apple iPad Air 11 M2 128GB رمادي فلكي', 599, 'أفضل تابلت متوازن للأداء والإنتاجية اليومية بمعالج M2 وكاميرا أمامية أفقية 12MP.'],
                    ['Apple iPad Air 11 M2 256GB أزرق', 699, 'سعة 256GB مع مكبرات صوت استريو أفقية وشحن سريع وبطارية تدوم طوال اليوم.'],
                    ['Apple iPad 10th Gen 64GB أصفر مشرق', 349, 'تصميم حديث بشاشة 10.9 بوصة بدون زر هوم مع منفذ USB-C وشريحة A14 Bionic.'],
                    ['Apple iPad 10th Gen 256GB أزرق سماوي', 499, 'سعة 256GB ممتازة للدراسة ومشاهدة المحتوى والألعاب الخفيفة.'],
                    ['Apple iPad 9th Gen 64GB رمادي فلكي', 249, 'أفضل تابلت اقتصادي مع زر البصمة ومقبس سماعات 3.5mm وشاشة Retina 10.2 بوصة.'],
                    ['Apple iPad mini 7 A17 Pro 128GB بنفسجي', 499, 'شاشة 8.3 بوصة مدمجة مع شريحة A17 Pro ودعم قلم Apple Pencil Pro وميزات AI.'],
                    ['Apple iPad mini 7 A17 Pro 256GB ضوء النجوم', 599, 'الدفتر الرقمي الأقوى في الجيب للطيارين والأطباء والمبدعين المتنقلين.'],
                    ['Samsung Galaxy Tab S10 Ultra 256GB رمادي قمري', 1199, 'شاشة Dynamic AMOLED 2X عملاقة 14.6 بوصة مع قلم S-Pen مضاد للماء ومعالج Dimensity 9300+.'],
                    ['Samsung Galaxy Tab S10 Ultra 512GB فضي بلاتيني', 1319, 'سعة 512GB مع شاشة مضادة للانعكاس وحماية Armor Aluminum IP68.'],
                    ['Samsung Galaxy Tab S10 Ultra 1TB 5G رمادي', 1699, 'النسخة الأعلى باتصال 5G وسعة 1TB مع وضع Samsung DeX وتجربة حاسوب كاملة.'],
                    ['Samsung Galaxy Tab S10+ 256GB رمادي قمري', 999, 'شاشة 12.4 بوصة AMOLED 120Hz مع ميزات Galaxy AI وقلم S-Pen مرفق مجاناً في العلبة.'],
                    ['Samsung Galaxy Tab S10+ 512GB فضي بلاتيني', 1119, 'سعة 512GB مع 12 جيجا رام وأربع مكبرات صوت مضبوطة من AKG تدعم Dolby Atmos.'],
                    ['Samsung Galaxy Tab S9 FE+ 128GB نعناعي أخضر', 599, 'شاشة 12.4 بوصة 90Hz مع مقاومة ماء وغبار IP68 وبطارية عملاقة 10090mAh.'],
                    ['Samsung Galaxy Tab S9 FE 128GB لافندر بنفسجي', 449, 'شاشة 10.9 بوصة مقاومة للماء مع قلم S-Pen بسعر منافس جداً للدراسة.'],
                    ['Samsung Galaxy Tab A9+ 128GB كحلي غامق', 269, 'شاشة 11 بوصة 90Hz مع 4 مكبرات صوت محيطية ومعالج Snapdragon 695 5G.'],
                    ['Samsung Galaxy Tab A9 64GB رمادي ميتاليك', 149, 'تابلت مدمج 8.7 بوصة خفيف ومثالي للقراءة والأطفال ومشاهدة مقاطع الفيديو.'],
                    ['Samsung Galaxy Tab Active 5 5G 128GB عسكري مقوى', 549, 'تابلت عملي فائق التحمل للصدمات والسقوط بمعيار MIL-STD-810H وبطارية قابلة للتبديل.'],
                    ['Microsoft Surface Pro 11 Copilot+ Snapdragon X Plus 256GB', 999, 'جهاز لوحي وحاسوب 2-في-1 بشاشة PixelSense 120Hz وبطارية تدوم طوال اليوم.'],
                    ['Microsoft Surface Pro 11 Copilot+ Snapdragon X Elite 512GB OLED', 1499, 'شاشة OLED مذهلة بنطاق ديناميكي واسع مع معالج X Elite بـ 12 نواة وقلم Slim Pen.'],
                    ['Microsoft Surface Pro 11 OLED 1TB بلاتينيوم 5G', 1999, 'الإصدار الأقصى مع شاشة OLED وسعة 1TB واتصال 5G سريع للغاية.'],
                    ['Microsoft Surface Go 4 128GB N200 ألومنيوم', 579, 'أصغر تابلت ويندوز محمول بشاشة 10.5 بوصة لمسية للشركات والمدارس.'],
                    ['Lenovo Tab P12 Pro 256GB رمادي عاصف', 549, 'شاشة 12.6 بوصة AMOLED 2K 120Hz مع قلم Lenovo Precision Pen 3 وأربع مكبرات JBL.'],
                    ['Lenovo Tab Extreme 256GB شاشة 14.5 بوصة 3K OLED', 999, 'شاشة سينمائية عملاقة 14.5 بوصة 3K 120Hz مع حامل مزدوج ولوحة مفاتيح وقلم.'],
                    ['Lenovo Legion Tab Y700 (2024) 256GB جيمنج', 449, 'تابلت ألعاب مدمج 8.8 بوصة 144Hz بمعالج Snapdragon 8 Gen 3 ومنفذين Type-C.'],
                    ['Lenovo Tab M11 128GB مع قلم ذكي', 199, 'شاشة 11 بوصة 90Hz مع قلم للكتابة والرسم وأربع سماعات Dolby Atmos بسعر اقتصادي.'],
                    ['OnePlus Pad 2 256GB رمادي نيمبوس', 549, 'شاشة 12.1 بوصة 3K بنسبة 7:5 المريحة مع معالج Snapdragon 8 Gen 3 و6 سماعات.'],
                    ['OnePlus Pad Go 128GB أخضر توين فوريست', 269, 'شاشة 11.35 بوصة 2.4K حماية للعين مع بطارية 8000mAh وشحن SuperVOOC.'],
                    ['Xiaomi Pad 6S Pro 12.4 256GB أسود جرافيت', 549, 'شاشة 12.4 بوصة 3K 144Hz مع معالج Snapdragon 8 Gen 2 وشحن خارق 120W.'],
                    ['Xiaomi Pad 6 128GB أزرق ميست', 329, 'شاشة 11 بوصة 144Hz WQHD+ بهيكل معدني كامل ومعالج Snapdragon 870.'],
                    ['Redmi Pad Pro 12.1 256GB أخضر نعناعي', 279, 'شاشة 12.1 بوصة 2.5K 120Hz مع معالج Snapdragon 7s Gen 2 وبطارية 10000mAh.'],
                    ['Redmi Pad SE 128GB بنفسجي لافندر', 169, 'شاشة 11 بوصة 90Hz مع 4 سماعات وبطارية 8000mAh للدراسة والترفيه.'],
                    ['Huawei MatePad Pro 13.2 256GB أسود ريشة', 899, 'أنحف وأخف تابلت 13 بوصة في العالم مع شاشة OLED مرنة بدون حواف وقلم NearLink.'],
                    ['Huawei MatePad 11.5S PaperMatte Edition 256GB', 449, 'شاشة بملمس الورق الحقيقي مضادة للانعكاس 144Hz مثالية للرسم بدون إجهاد للعين.'],
                    ['Huawei MatePad SE 11 128GB أزرق فضي', 179, 'تابلت عائلي بتصميم معدني أنيق وشاشة معتمدة لحماية العين من الضوء الأزرق.'],
                    ['Honor MagicPad 2 12.3 256GB أبيض قمري', 549, 'شاشة OLED 12.3 بوصة 3K 144Hz مع ميزات ذكاء اصطناعي لتحويل الصوت لنصوص.'],
                    ['Honor Pad 9 128GB رمادي فضائي مع كيبورد', 299, 'شاشة 12.1 بوصة 2.5K مع 8 مكبرات صوت محيطية وحافظة لوحة مفاتيح مرفقة.'],
                    ['Amazon Fire Max 11 64GB رمادي أكسيد', 229, 'شاشة 11 بوصة 2K زاهية مع مستشعر بصمة ومعالج ثماني النواة ودعم Alexa.'],
                    ['Amazon Fire HD 10 32GB أسود', 139, 'شاشة 10.1 بوصة 1080p FHD مع عمر بطارية 13 ساعة لتصفح وقراءة وبث الفيديو.'],
                    ['Amazon Kindle Paperwhite Signature Edition 32GB', 189, 'شاشة حبر إلكتروني 6.8 بوصة بدون توهج مع إضاءة دافئة قابلة للتعديل وشحن لاسلكي ومقاومة ماء.'],
                    ['Amazon Kindle Scribe 64GB مع قلم بريميوم', 399, 'أول قارئ كيندل بشاشة 10.2 بوصة 300ppi يتيح القراءة وتدوين الملاحظات على الكتب والمستندات.'],
                    ['Amazon Kindle Colorsoft Signature Edition 32GB ملون', 279, 'أول قارئ إلكتروني ملون من أمازون بتقنية Colorsoft لعرض أغلفة الكتب والكوميكس بالألوان.'],
                    ['Amazon Kindle 2024 الجيل الحادي عشر 16GB أخضر ماتشا', 109, 'أخف وأصغر قارئ كيندل بشاشة 300ppi عالية الوضوح وبطارية تدوم 6 أسابيع.'],
                    ['Kobo Clara Colour 16GB قارئ كتب ملون', 149, 'شاشة Kaleido 3 ملونة 6 بوصة مع مقاومة للماء IPX8 وتوافق واسع مع صيغ الكتب EPUB وPDF.'],
                    ['Kobo Libra Colour 32GB مع دعم القلم', 219, 'شاشة ملونة 7 بوصة مع أزرار تقليب صفحات مادية ودعم قلم Kobo Stylus 2 لتحديد النصوص.'],
                    ['Kobo Elipsa 2E 32GB دفتر وقارئ رقمي 10.3 بوصة', 399, 'شاشة 10.3 بوصة مصنوعة من بلاستيك معاد تدويره مع قلم Kobo Stylus 2 للكتابة الاحترافية.'],
                    ['Onyx Boox Note Air 3 C ملون 64GB مع قلم', 499, 'تابلت حبر إلكتروني ملون يعمل بنظام Android 12 مفتوح لتحميل تطبيقات Google Play.'],
                    ['Onyx Boox Palma قارئ إلكتروني بحجم الهاتف 128GB', 279, 'شاشة E-Ink 6.13 بوصة في حجم الهاتف الذكي مع كاميرا لمسح المستندات وأزرار صوت.'],
                    ['Onyx Boox Tab Ultra C Pro 128GB مع كاميرا', 649, 'شاشة 10.3 بوصة ملونة مع معالج ثماني النواة سريع وتكنولوجيا BSR لمنع التقطيع.'],
                    ['reMarkable Paper Pro 11.8 بوصة ملونة مع قلم Marker Plus', 649, 'أرقى دفتر رقمي في العالم بشاشة Canvas Color الملونة المبتكرة وإضاءة أمامية للقراءة ليلاً.'],
                    ['reMarkable 2 الدفتر الرقمي فائق النحافة 10.3 بوصة', 399, 'أنحف تابلت في العالم بسماكة 4.7 مم فقط بملمس ورق حقيقي مذهل للتركيز بدون مشتتات.'],
                    ['PocketBook Era 64GB قارئ إلكتروني مقاوم للماء', 239, 'شاشة E-Ink Carta 1200 مقاس 7 بوصة مع مكبر صوت مدمج لتشغيل الكتب الصوتية.'],
                ]
            ],
            'الساعات والأجهزة الذكية' => [
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Apple Watch Ultra 2 تيتانيوم طبيعي 49mm سوار Ocean أزرق', 799, 'شاشة سطوع 3000 nit مع زر إجراءات Action Button وGPS مزدوج التردد وبطارية حتى 72 ساعة.'],
                    ['Apple Watch Ultra 2 تيتانيوم أسود 49mm سوار Trail Loop', 849, 'هيكل تيتانيوم أسود مطلي بتقنية DLC الماسية المقاومة للخدش ومستشعر عمق للغوص.'],
                    ['Apple Watch Ultra 2 تيتانيوم 49mm سوار Alpine Loop برتقالي', 799, 'سوار مغامرات للمرتفعات مع مشبك G-hook تيتانيوم مخصص لتسلق الجبال.'],
                    ['Apple Watch Series 10 46mm تيتانيوم رمادي خلوي', 749, 'أنحف ساعة من آبل بهيكل تيتانيوم فضائي وزجاج ياقوتي وشاشة OLED عريضة الزوايا.'],
                    ['Apple Watch Series 10 46mm ألومنيوم أسود نفاث GPS', 429, 'لون Jet Black اللامع الأنيق مع شحن فائق السرعة يصل إلى 80% في 30 دقيقة.'],
                    ['Apple Watch Series 10 46mm ألومنيوم فضي GPS', 429, 'شاشة أكبر بنسبة 30% مع مكبر صوت مدمج لتشغيل الموسيقى ومستشعر انقطاع التنفس أثناء النوم.'],
                    ['Apple Watch Series 10 42mm ألومنيوم ذهبي وردي GPS', 399, 'حجم مدمج أنيق 42 مم بوزن خفيف وتتبع صحي دقيق يشمل تخطيط القلب ECG وقياس الحرارة.'],
                    ['Apple Watch Series 10 42mm تيتانيوم ذهبي خلوي', 699, 'هيكل تيتانيوم ذهبي مصقول كالمجوهرات مع اتصال خلوي eSIM بدون الحاجة لحمل الهاتف.'],
                    ['Apple Watch SE 2024 44mm ألومنيوم سماء الليل GPS', 279, 'أفضل قيمة للمستشعرات الصحية وتتبع التمارين وكشف حوادث السيارات وخدمة الطوارئ.'],
                    ['Apple Watch SE 2024 40mm ألومنيوم ضوء النجوم GPS', 249, 'حجم 40 مم خفيف ومريح للنوم وتتبع الدورة الشهرية والنشاط اليومي.'],
                    ['Samsung Galaxy Watch Ultra 47mm تيتانيوم رمادي LTE', 649, 'تصميم Cushion الفولاذي مع زر Quick Button ومقاومة ضغط 10ATM وتحمل حرارة قصوى.'],
                    ['Samsung Galaxy Watch Ultra 47mm تيتانيوم أبيض LTE', 649, 'إطار أبيض تيتانيوم مع سوار رياضي برتقالي وبطارية عملاقة تدوم 100 ساعة في وضع التوفير.'],
                    ['Samsung Galaxy Watch 7 44mm أخضر غابي Bluetooth', 329, 'معالج 3nm فائق السرعة مع مستشعر BioActive المحسن وقياس مؤشر منتجات AGEs الحيوية.'],
                    ['Samsung Galaxy Watch 7 44mm فضي LTE', 379, 'اتصال 4G LTE مستقل مع GPS مزدوج التردد L1+L5 لأعلى دقة تتبع في المدن المزدحمة.'],
                    ['Samsung Galaxy Watch 7 40mm كريمي بيج Bluetooth', 299, 'تصميم مدمج 40 مم مع نظام Wear OS 5 وواجهة One UI 6 Watch المدعومة بـ Galaxy AI.'],
                    ['Samsung Galaxy Watch 6 Classic 47mm أسود مع إطار دوار', 399, 'إطار دوار ميكانيكي كلاسيكي مع زجاج ياقوتي وشاشة AMOLED فائقة السطوع.'],
                    ['Samsung Galaxy Watch 6 Classic 43mm فضي ستانلس ستيل', 369, 'مظهر الساعات السويسرية الفاخرة مع حساسات ضغط الدم وتخطيط القلب وتحليل تكوين الجسم BIA.'],
                    ['Samsung Galaxy Watch FE 40mm أسود رياضي', 199, 'ساعة ذكية متكاملة بسعر اقتصادي مع زجاج ياقوتي Sapphire Crystal وتتبع أكثر من 100 تمرين.'],
                    ['Samsung Galaxy Ring خاتم ذكي تيتانيوم أسود', 399, 'خاتم ذكي خفيف يزن 2.3 جرام فقط لتتبع النوم والنبض والحرارة بدقة مستمرة بدون شاشة حتى 7 أيام.'],
                    ['Samsung Galaxy Ring خاتم ذكي تيتانيوم ذهبي', 399, 'طلاء تيتانيوم ذهبي فاخر مع مقاومة ماء 10ATM وعلبة شحن شفافة بإضاءة LED.'],
                    ['Garmin Fenix 8 AMOLED 47mm Sapphire تيتانيوم', 999, 'شاشة AMOLED ساطعة مع زجاج ياقوتي وميكروفون ومكبر صوت للمكالمات وخرائط TopoActive.'],
                    ['Garmin Fenix 8 Solar 51mm Sapphire شحن شمسي', 1099, 'بطارية تدوم حتى 48 يوماً بالشحن الشمسي مع حساسات غوص معتمدة حتى عمق 40 متراً.'],
                    ['Garmin Fenix 8 AMOLED 51mm DLC كربوني', 1099, 'الحجم الأكبر 51 مم مع كشاف LED مدمج متعدد الشدة وخرائط ملاحة عالمية مجانية.'],
                    ['Garmin Epix Pro Gen 2 Sapphire 47mm تيتانيوم', 899, 'شاشة AMOLED فائقة الوضوح مع مستشعر Elevate Gen 5 لمعدل نبضات القلب والجهد البدني.'],
                    ['Garmin Forerunner 965 AMOLED تيتانيوم أسود/أصفر', 599, 'ساعة العدائين والترايثلون الاحترافية بوزن خفيف وإطار تيتانيوم وخرائط ملونة مدمجة.'],
                    ['Garmin Forerunner 265 Music AMOLED 46mm أسود/أزرق', 449, 'شاشة AMOLED لمسية مع تقرير الصباح Morning Report وتخزين الموسيقى بدون هاتف.'],
                    ['Garmin Forerunner 165 Music AMOLED 43mm بنفسجي', 299, 'ساعة جري متخصصة مع خطط تدريب Garmin Coach التكيفية ومستشعر Pulse Ox للأكسجين.'],
                    ['Garmin Venu 3 45mm ستانلس ستيل أسود', 449, 'ساعة نمط حياة ذكية مع كشف القيلولة التلقائي وتدريب النوم ومكالمات بلوتوث من المعصم.'],
                    ['Garmin Venu 3S 41mm ذهبي ناعم مع سوار وردي', 449, 'حجم نسائي أنيق 41 مم مع ميزات صحة المرأة وتتبع طاقة الجسم Body Battery.'],
                    ['Garmin Instinct 2X Solar 50mm تكتيكية سوداء', 449, 'ساعة تكتيكية فائقة الصلابة مع شحن شمسي لا نهائي وكشاف LED مدمج بنمط أخضر للرؤية الليلية.'],
                    ['Garmin Enduro 3 51mm شحن شمسي للسباقات الفائقة', 899, 'بطارية تدوم حتى 320 ساعة في وضع الـ GPS مع حزام UltraFit نايلون فائق الخفة.'],
                    ['Garmin Approach S70 47mm للجولف مع خرائط 43,000 ملعب', 699, 'شاشة AMOLED مع ميزة Virtual Caddie لاقتراح المضارب وتحليل سرعة واتجاه الرياح.'],
                    ['Huawei Watch Ultimate إصدار المحيط الأزرق سيراميك', 749, 'مصنوعة من معدن الزركونيوم السائل فائق الصلابة مع مقاومة للغوص حتى 100 متر شاشة LTPO.'],
                    ['Huawei Watch Ultimate إصدار الرحلات الاستكشافية أسود', 699, 'وضع الاستكشاف الاحترافي مع علامات المواقع بدقة وGPS خماسي التردد المزدوج.'],
                    ['Huawei Watch 4 Pro Space Edition تيتانيوم DLC رمادي', 649, 'إطار من السيراميك النانوي بلونين مع ميزة الفحص الصحي الشامل لـ 7 مؤشرات في دقيقة واحدة.'],
                    ['Huawei Watch GT 4 46mm ستانلس ستيل فضي بحزام معدني', 299, 'تصميم ثماني الأضلاع الأنيق مع بطارية أسطورية تدوم 14 يوماً وتتبع السعرات الحرارية Stay Fit.'],
                    ['Huawei Watch GT 4 46mm أسود مع حزام فلورو إيلاستومر', 229, 'تصميم رياضي عصري مع تحليل انتظام ضربات القلب بموجات النبض PPG.'],
                    ['Huawei Watch GT 4 41mm ذهبي مع حزام ميلانيز مغناطيسي', 279, 'تصميم قلادة المجوهرات الفاخر بحجم 41 مم وبطارية تدوم 7 أيام متواصلة.'],
                    ['Huawei Watch Fit 3 43mm ألومنيوم وردي', 149, 'شاشة AMOLED مربعة 1.82 بوصة فائقة النحافة بسماكة 9.9 مم وتصميم يشبه Apple Watch.'],
                    ['Huawei Band 9 سوار ذكي خفيف أسود', 59, 'سوار لياقة فائق الخفة بوزن 14 جرام وتتبع نوم متقدم Huawei TruSleep 4.0 وبطارية أسبوعين.'],
                    ['Google Pixel Watch 3 45mm ألومنيوم أسود مات LTE', 449, 'شاشة Actua AMOLED مضاعفة السطوع حتى 2000 nit مع تتبع نبضات القلب فائق الدقة وتكامل Fitbit.'],
                    ['Google Pixel Watch 3 45mm فضي مع سوار بورسلين Bluetooth', 399, 'حجم 45 مم الأكبر مع بطارية تدوم 36 ساعة في وضع توفير الطاقة ومساعد Gemini الصوتي.'],
                    ['Google Pixel Watch 3 41mm ذهبي فاتح مع سوار هازل', 349, 'تصميم قبة زجاجية دائرية انسيابية مع كشف فقدان النبض التلقائي لطلب الطوارئ.'],
                    ['Amazfit T-Rex Ultra مغامرات ستانلس ستيل 316L', 399, 'مقاومة طين وحرارة عسكرية مع مقاومة غوص 30 متراً وشاشة AMOLED 1000 nit.'],
                    ['Amazfit Balance 46mm رمادي ميدنايت مع NFC', 229, 'شاشة AMOLED 1.5 بوصة مع قياس دهون وعضلات الجسم ومساعد الذكاء الاصطناعي Zepp Flow.'],
                    ['Amazfit Cheetah Pro 47mm تيتانيوم للعدائين', 299, 'هوائي GPS ثنائي الاستقطاب MaxTrack فائق الدقة مع خرائط غير متصلة بالإنترنت.'],
                    ['Amazfit GTR 4 46mm كلاسيك مع حزام جلدي', 189, 'شاشة AMOLED كبيرة مع 150 وضع رياضي وبطارية 14 يوماً ومكالمات بلوتوث.'],
                    ['Amazfit Bip 5 Unity 46mm ألومنيوم رمادي', 69, 'شاشة كبيرة 1.91 بوصة مع نظام Zepp OS 3.0 وميكروفون للمكالمات بسعر اقتصادي مذهل.'],
                    ['Polar Vantage V3 تيتانيوم مع حزامين', 599, 'مستشعرات Polar Elixir البيومترية المتقدمة مع تخطيط القلب ومستشعر SpO2 ودرجة حرارة الجلد.'],
                    ['Polar Grit X2 Pro Sapphire عسكرية فائقة القوة', 749, 'شاشة AMOLED محمية بزجاج ياقوتي مع خرائط طبوغرافية تفصيلية وبوصلة ثلاثية الأبعاد.'],
                    ['Suunto Race تيتانيوم 49mm شاشة AMOLED', 549, 'شاشة لمس 1.43 بوصة مع تاج رقمي للتمرير وبطارية 40 ساعة في أعلى دقة GPS.'],
                    ['Suunto Ocean ساعة غوص ورياضة AMOLED تيتانيوم', 899, 'كمبيوتر غوص لاسلكي معتمد يدعم أجهزة إرسال ضغط أسطوانة الغاز مع 95 وضع رياضي.'],
                    ['Withings ScanWatch 2 42mm هجينة ستانلس ستيل أسود', 349, 'عقارب ميكانيكية كلاسيكية مع شاشة OLED صغيرة وتخطيط قلب معتمد طبياً وبطارية 30 يوماً.'],
                    ['Withings ScanWatch Horizon 43mm غواص فاخرة كحلي', 499, 'إطار غوص دوار ستانلس ستيل مع مقاومة ماء 100 متر وتتبع أكسجين الدم ونبضات القلب.'],
                    ['Oura Ring Gen 3 خاتم ذكي Horizon تيتانيوم أسود مطفي', 399, 'خاتم التتبع الصحي الأكثر شهرة في العالم مع حساسات نبضات قلب NIRS ودرجة حرارة الجسم.'],
                    ['Oura Ring Gen 3 خاتم ذكي Heritage ذهبي وردي', 449, 'تصميم بحافة مسطحة أنيقة مع اشتراك تتبع النوم والجاهزية البدنية Readiness Score.'],
                    ['Whoop 4.0 سوار تتبع اللياقة بدون شاشة مع اشتراك سنة', 299, 'سوار الرياضيين المحترفين لقياس الإجهاد اليومي Strain والتعافي اليومي Recovery 24/7.'],
                    ['Fitbit Charge 6 سوار لياقة ذكي مع Google Apps أسود', 159, 'تكامل مع خرائط Google وGoogle Wallet وتخطيط قلب ECG وتتبع النوم المتقدم.'],
                    ['Fitbit Inspire 3 سوار خفيف للياقة ملون بنفسجي', 99, 'وزن خفيف جداً مع بطارية تدوم 10 أيام وتنبيهات معدل ضربات القلب المرتفع والمنخفض.'],
                    ['Fitbit Sense 2 ساعة صحية متقدمة بمستشعر التوتر cEDA', 249, 'مستشعر استجابة الجسم المستمرة cEDA لإدارة التوتر ونوبات القلق اليومية.'],
                ]
            ],
            'الصوتيات وأنظمة الصوت' => [
                'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Sony WH-1000XM5 عازلة للضوضاء أسود ملكي', 349, 'أفضل سماعات رأس عازلة للضوضاء في العالم بمعالجين V1 وQN1 المزدوجين وصوت LDAC Hi-Res.'],
                    ['Sony WH-1000XM5 فضي بلاتينيوم', 349, 'تصميم مريح وخفيف مع 8 ميكروفونات مدمجة وتتبع صوت التحدث للدردشة التلقائي Speak-to-Chat.'],
                    ['Sony WH-1000XM4 عازلة للضوضاء أسود قابل للطي', 279, 'التصميم الكلاسيكي القابل للطي مع صوت جهير Bass استثنائي وبطارية 30 ساعة وشحن سريع.'],
                    ['Sony ULT WEAR سماعات رأس جهير فائق أسود', 199, 'زر ULT مخصص لمضاعفة قوة الباس والصوت الحركي العميق في الحفلات مع عزل ضوضاء قوي.'],
                    ['Sony WF-1000XM5 سماعات أذن لاسلكية سوداء', 279, 'محرك Dynamic Driver X الجديد مع عزل ضوضاء بالذكاء الاصطناعي ومستشعرات التوصيل العظمي للمكالمات.'],
                    ['Sony LinkBuds S سماعات أذن مريحة خفيفة أبيض', 149, 'أصغر سماعات أذن لاسلكية مع ميزة التبديل الذكي التلقائي بين الصوت المحيطي والعزل التام.'],
                    ['Bose QuietComfort Ultra Headphones أسود مطفي', 429, 'تقنية الصوت الغامر المكاني Bose Immersive Audio الثورية مع عزل ضوضاء رائد عالمياً.'],
                    ['Bose QuietComfort Ultra Headphones أبيض سموك فاخر', 429, 'وسائد أذن من الجلد الصناعي الفاخر مع وضع CustomTune لضبط الصوت لشكل أذنك بدقة.'],
                    ['Bose QuietComfort Headphones أسود كلاسيك', 349, 'راحة ارتداء أسطورية لرحلات السفر الطويلة مع بطارية 24 ساعة وأنماط Quiet وAware.'],
                    ['Bose QuietComfort Ultra Earbuds سماعات أذن عازلة', 299, 'أقوى عزل ضوضاء نشط في سماعات الأذن اللاسلكية مع ثبات استثنائي في التمارين الرياضية.'],
                    ['Bose SoundLink Max مكبر صوت محمول عملاق أزرق', 399, 'صوت ستريو هادر وعميق مع حزام حمل جلدي ومقاومة ماء وغبار IP67 وبطارية 20 ساعة.'],
                    ['Bose SoundLink Flex Gen 2 محمول أسود', 149, 'تقنية PositionIQ لضبط الصوت تلقائياً حسب اتجاه المكبر مع مقاومة للغرق في الماء.'],
                    ['Bose Smart Ultra Soundbar مع Dolby Atmos أسود', 899, 'ساوند بار مسرحي منزلي مع 9 مكبرات صوت ونمط تعزيز الحوار بالذكاء الاصطناعي A.I. Dialogue.'],
                    ['Apple AirPods Max USB-C سماء الليل', 549, 'هيكل ألومنيوم مصقول مع شريحة H1 في كل جهة وصوت مكاني مخصص مع تتبع حركات الرأس.'],
                    ['Apple AirPods Max USB-C ضوء النجوم', 549, 'إطار شبكي محبوك يوزع الوزن مع زر التاج الرقمي الدوار الدقيق للتحكم بالصوت.'],
                    ['Apple AirPods Max USB-C أزرق كاريبي', 549, 'منفذ USB-C الجديد للشحن السريع مع جودة صوت Hi-Fi لا تضاهى وعزل ضوضاء نشط.'],
                    ['Apple AirPods Pro 2 USB-C مع علبة MagSafe', 249, 'شريحة H2 المتقدمة مع صوت تكيفي وعزل ضوضاء مضاعف واختبارات صحة السمع السريرية.'],
                    ['Apple AirPods 4 مع عزل الضوضاء النشط ANC', 179, 'تصميم مفتوح ومريح بدون سدادات سيليكون مع ميزة عزل الضوضاء والصوت التكيفي.'],
                    ['Apple AirPods 4 الإصدار القياسي', 129, 'شريحة H2 مع صوت مكاني مخصص وتصميم هوائي محسّن وعلبة شحن هي الأصغر حجماً.'],
                    ['Apple HomePod الجيل الثاني أسود ميدنايت', 299, 'مكبر صوت منزلي ذكي بصوت جهير عالي النقاء و5 مكبرات ترددات عالية مع Siri وMatter.'],
                    ['Apple HomePod mini أصفر مبهج', 99, 'صوت 360 درجة مذهل في حجم كروي مدمج مع تحكم ذكي بالمنزل عبر Siri ونظام Intercom.'],
                    ['Sennheiser Momentum 4 Wireless أسود ونحاسي', 299, 'صوت سينهايزر الأيقوني لعشاق الموسيقى مع بطارية تدوم 60 ساعة كاملة مع تشغيل العزل.'],
                    ['Sennheiser Momentum True Wireless 4 جرافيت', 299, 'دعم أحدث تقنيات aptX Lossless وAuracast لصوت لاسلكي نقي بجودة الاستوديو.'],
                    ['Sennheiser HD 660S2 سماعات رأس احترافية مفتوحة', 499, 'سماعات أوديوفايل مرجعية بمقاومة 300 أوم للمهندسين والموسيقيين في الاستوديو.'],
                    ['Sennheiser Accentum Plus Wireless أسود', 199, 'عزل ضوضاء هجين تكيفي مع أزرار لمسية وشحن سريع يمنح 5 ساعات تشغيل في 10 دقائق.'],
                    ['Sonos Era 300 مكبر صوت منزلي Dolby Atmos أسود', 449, '6 مكبرات صوت مدمجة مصممة خصيصاً لتوجيه الصوت في كافة الاتجاهات لصوت مكاني غامر.'],
                    ['Sonos Era 100 مكبر صوت ستريو مدمج أبيض', 249, 'صوت ستريو عالي الدقة مع معالج أسرع بنسبة 47% ومداخل Bluetooth وWiFi 6 وLine-In.'],
                    ['Sonos Move 2 مكبر صوت محمول ستريو أخضر زيتوني', 449, 'بطارية تدوم 24 ساعة مع ضبط صوتي تلقائي Trueplay ومقاومة كاملة للعوامل الجوية.'],
                    ['Sonos Roam 2 مكبر صوت مغامرات صغير أحمر', 179, 'حجم مدمج بوزن 430 جرام فقط مع مقاومة ماء IP67 وزر تشغيل منفصل وسهل الاقتران.'],
                    ['Sonos Arc ساوند بار سنمائي Dolby Atmos أسود', 799, 'ساوند بار رائد بـ 11 محركاً صوتياً عالياً لإنشاء مسرح منزلي ثلاثي الأبعاد فائق الواقعية.'],
                    ['Sonos Sub Gen 3 مضخم صوت لاسلكي أسود لامع', 749, 'مضخم باس جبار خالي من أي اهتزازات بفضل المحركين المتقابلين لإلغاء القوة الميكانيكية.'],
                    ['JBL Boombox 3 مكبر صوت عملاق بحزام أسود', 449, 'صوت JBL Original Pro الضخم مع صب ووفر مركزي مخصص وبطارية تدوم 24 ساعة مع باور بانك.'],
                    ['JBL PartyBox 310 مكبر حفلات متنقل بعجلات', 499, 'قوة 240 واط مع إضاءة ديناميكية متزامنة ومدخلات ميكروفون وجيتار وبطارية 18 ساعة.'],
                    ['JBL Charge 5 Wi-Fi مكبر صوت محمول أسود', 199, 'بث صوتي عالي الدقة عبر الواي فاي مع AirPlay وSpotify Connect ومقاومة ماء IP67.'],
                    ['JBL Flip 6 مكبر صوت أسطواني أحمر', 129, 'نظام مكبر صوت ثنائي الاتجاه يمنح وضوحاً مذهلاً في الترددات العالية وصوتاً عميقاً.'],
                    ['JBL Clip 4 مكبر صوت صغير بمشبك مدمج أزرق', 69, 'مشبك معدني مدمج لتثبيته في الحقيبة أو الدراجة مع تصميم بيضاوي مقاوم للماء والغبار.'],
                    ['JBL Tour One M2 سماعات رأس عازلة للضوضاء أسود', 299, 'عزل ضوضاء True Adaptive مع 4 ميكروفونات وتقنية Smart Ambient وبطارية 50 ساعة.'],
                    ['JBL Tour Pro 2 سماعات أذن بشاشة لمس ذكية', 249, 'أول علبة شحن ذكية في العالم بشاشة لمس 1.45 بوصة للتحكم في الإعدادات بدون فتح الهاتف.'],
                    ['Marshall Stanmore III مكبر صوت منزلي كلاسيكي أسود', 379, 'تصميم روك كلاسيكي بكسوة جلدية وشبك نحاسي مع صوت ستريو واسع يملأ الغرفة.'],
                    ['Marshall Acton III مكبر صوت ستريو مدمج بني', 279, 'أصغر مكبر صوت منزلي من مارشال مع مفاتيح تحكم نحاسية تناظرية للصوت والباس والتريبل.'],
                    ['Marshall Woburn III مكبر صوت منزلي جبار أسود', 579, 'أقوى مكبر من مارشال مع صب ووفر 6 بوصة ومدخل HDMI ARC للتوصيل المباشر بالتلفزيون.'],
                    ['Marshall Emberton II مكبر صوت محمول مقاوم للماء أسود/نحاسي', 169, 'صوت True Stereophonic المحيطي 360 درجة مع بطارية تدوم أكثر من 30 ساعة متواصلة.'],
                    ['Marshall Middleton مكبر صوت قوي مع حزام حمل', 299, 'صوت رباعي المحركات مع ميزة تجميع عدة مكبرات Stack Mode وحماية IP67 للغبار والماء.'],
                    ['Marshall Major IV سماعات رأس بلوتوث كلاسيكية بنية', 149, 'بطارية أسطورية تدوم 80 ساعة مع شحن لاسلكي وتصميم مفصلي قابل للطي بالكامل.'],
                    ['Marshall Motif II A.N.C. سماعات أذن لاسلكية سوداء', 199, 'تصميم عتيق فريد مع عزل ضوضاء نشط و30 ساعة تشغيل وبلاستيك معاد تدويره 70%.'],
                    ['Bowers & Wilkins Px8 سماعات أوديوفايل فاخرة جلد أونيكس', 699, 'محركات كربونية مائلة بدقة 40 مم مع جلد نابا الطبيعي وأذرع ألومنيوم مصبوبة لقمة الفخامة.'],
                    ['Bowers & Wilkins Px7 S2e سماعات رأس احترافية أزرق بحري', 399, 'معالجة صوتية محسنة بدقة 24-bit DSP مع 6 ميكروفونات لعزل ضوضاء ذكي ونقاء صوتي.'],
                    ['Bowers & Wilkins Pi7 S2 سماعات أذن لاسلكية كانفاس أبيض', 399, 'علبة شحن ذكية تدعم إعادة بث الصوت لاسلكياً من مقابس الطائرات وشاشات الترفيه.'],
                    ['Bowers & Wilkins Zeppelin مكبر صوت بيضاوي ذكي رمادي', 799, 'تصميم المنطاد الأيقوني مع صوت استريو عالي الدقة وتطبيق Bowers & Wilkins Music.'],
                    ['Bang & Olufsen Beoplay H95 سماعات فاخرة ذهبية', 899, 'أفخم سماعات في العالم بمحركات تيتانيوم وأقراص تحكم دوارة مصنوعة من الألومنيوم.'],
                    ['Bang & Olufsen Beosound A1 Gen 2 مكبر صوت دائري محمول أسود', 279, 'تصميم دنماركي نحيف مقاوم للماء مع 3 ميكروفونات مدمجة للمؤتمرات وبطارية 18 ساعة.'],
                    ['Bang & Olufsen Beoplay EX سماعات أذن مقاومة للماء أزرق بحري', 399, 'واجهة زجاجية تعمل باللمس مع محرك 9.2 مم ومقاومة غبار وماء كاملة بمعيار IP57.'],
                    ['Shure SM7B ميكروفون استوديو وبودكاست احترافي', 399, 'الميكروفون الأكثر شهرة في استوديوهات البث الصوتي ومحطات الراديو مع عزل كهرومغناطيسي.'],
                    ['Shure MV7+ ميكروفون بودكاست رقمي USB وXLR', 299, 'شريط LED لمسي مخصص مع معالج DSP مدمج وميزة Auto Level Mode لعزل صوت الغرفة.'],
                    ['Shure AONIC 50 Gen 2 سماعات رأس استوديو عازلة', 349, 'تقنية الصوت المكاني المحيطي مع دعم بروتوكول Snapdragon Sound وبطارية 45 ساعة.'],
                    ['Audio-Technica ATH-M50xBT2 سماعات استوديو بلوتوث', 199, 'نسخة البلوتوث من أشهر سماعات مراقبة صوتية في العالم مع محركات 45 مم وصوت دقيق.'],
                    ['Devialet Mania مكبر صوت ذكي محمول ستريو أسود', 790, 'تقنية المسح الصوتي للغرفة ASC لضبط الصوت الستريو تلقائياً مع 4 مكبرات و2 ووفر.'],
                    ['Devialet Phantom I 108dB مكبر صوت مسرحي هادر أبيض/ذهبي', 3200, 'قوة صوتية جبارة تبلغ 1100 واط مع صوت جهير يهز الأرجاء يصل إلى 14Hz بدون أي تشويش.'],
                ]
            ],
            'أجهزة الألعاب وملحقات الجيمنج' => [
                'img' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Sony PlayStation 5 Pro 2TB SSD كونسول ألعاب', 699, 'أقوى كونسول ألعاب بتقنية الترقية الطيفية الذكية PSSR وتتبع أشعة فائق ومعدل 60-120fps.'],
                    ['Sony PlayStation 5 Slim Disc Edition 1TB أبيض', 499, 'تصميم أنحف بنسبة 30% مع محرك أقراص Ultra HD Blu-ray قابل للفصل وسعة 1 تيرابايت.'],
                    ['Sony PlayStation 5 Slim Digital Edition 1TB أبيض', 449, 'نسخة رقمية بالكامل بدون محرك أقراص مع سرعة تحميل خارقة عبر وحدة SSD المخصصة.'],
                    ['PlayStation Portal مشغل الألعاب المحمول عن بعد لـ PS5', 199, 'شاشة 8 بوصة LCD بدقة 1080p بمعدل 60fps مع كافة ميزات يد DualSense اللمسية.'],
                    ['PlayStation VR2 نظارة الواقع الافتراضي للجيل الجديد', 549, 'شاشتان OLED بدقة 4K HDR ومجال رؤية 110 درجة وتتبع حركة العين وردود فعل لمسية في النظارة.'],
                    ['يد تحكم DualSense Edge اللاسلكية الاحترافية لـ PS5', 199, 'أذرع تحكم قابلة للتغيير وأزرار خلفية قابلة للبرمجة ومسافة ضغط مشغلات قابلة للتعديل.'],
                    ['يد تحكم DualSense اللاسلكية أسود ميدنايت', 74, 'مؤثرات حسية لمسية Haptic Feedback ومشغلات تكيفية ديناميكية مع ميكروفون مدمج.'],
                    ['يد تحكم DualSense اللاسلكية أحمر بركاني Volcanic Red', 79, 'لون ميتاليك لامع مستوحى من أعماق كوكب الأرض مع أزرار استجابة فائقة السرعة.'],
                    ['يد تحكم DualSense اللاسلكية فضي لامع Sterling Silver', 79, 'تشطيب معدني كلاسيكي فاخر يمنح يد التحكم مظهراً مستقبلياً جذاباً.'],
                    ['سماعة Pulse Elite اللاسلكية لـ PS5 بمحركات مغناطيسية', 149, 'محركات Planar Magnetic المستوحاة من الاستوديوهات مع ميكروفون مطوي بعزل ذكاء اصطناعي.'],
                    ['سماعات Pulse Explore اللاسلكية داخل الأذن لـ PS5', 199, 'صوت لاسلكي بدون فقدان للجودة عبر تقنية PlayStation Link مع علبة شحن منزلقة.'],
                    ['وحدة شحن يد التحكم المزدوجة DualSense Charging Station', 29, 'اشحن وحدتي تحكم DualSense في وقت واحد بسرعة وسهولة دون الحاجة لتوصيلها بالكونسول.'],
                    ['Xbox Series X 1TB كونسول أسود كلاسيك', 499, 'أقوى جهاز إكس بوكس بقوة معالجة 12 تيرافلوبس ودقة 4K حقيقية حتى 120 إطاراً في الثانية.'],
                    ['Xbox Series X 2TB Special Edition أسود جالاكسي', 599, 'إصدار خاص بسعة مضاعفة 2 تيرابايت وتصميم مرقط بالنجوم الفضية والأخضر الأيقوني.'],
                    ['Xbox Series S 1TB أبيض روبوت', 349, 'سعة 1 تيرابايت كاملة لتخزين عشرات الألعاب الرقمية مع ميزة Quick Resume للتبديل الفوري.'],
                    ['Xbox Series S 512GB أبيض رقمي', 299, 'أفضل قيمة للدخول إلى الجيل الجديد مع اشتراك Xbox Game Pass وألعاب الجيل القادم.'],
                    ['يد تحكم Xbox Elite Series 2 اللاسلكية سوداء', 179, 'عصي تحكم قابلة لتعديل الشد ومقابض مطاطية محيطية وبطارية تدوم حتى 40 ساعة قابلة للشحن.'],
                    ['يد تحكم Xbox Elite Series 2 Core بيضاء', 129, 'الهيكل الاحترافي الأساسي مع تخصيص المشغلات وحفظ الإعدادات المسبقة على اليد.'],
                    ['يد تحكم Xbox اللاسلكية أخضر فيلوسيتي Velocity Green', 64, 'لون أخضر نيون مميز مع ملمس محكم على أزرار الزناد والمصدات وعلبة خلفية.'],
                    ['يد تحكم Xbox اللاسلكية أزرق صدمة Shock Blue', 64, 'تصميم ثنائي اللون مع سطح خلفي أبيض وD-pad هجين للتحكم الدقيق في الألعاب القتالية.'],
                    ['Nintendo Switch OLED Edition أبيض ناصع', 349, 'شاشة OLED زاهية مقاس 7 بوصات مع حامل عريض قابل للتعديل ومنفذ LAN سلكي في القاعدة.'],
                    ['Nintendo Switch OLED Mario Red Edition أحمر ماريو', 349, 'تصميم أحمر بالكامل مخصص للبطل ماريو مع تفاصيل مخفية للعملات الذهبية خلف القاعدة.'],
                    ['Nintendo Switch OLED Zelda: Tears of the Kingdom Edition', 359, 'إصدار أسطوري بزخارف Hylian الذهبية وأيدي Joy-Con خضراء وذهبية حصرية.'],
                    ['Nintendo Switch Lite مرجاني وردي محمول', 199, 'جهاز ألعاب محمول مخصص للعب الفردي أثناء التنقل بوزن خفيف جداً وأزرار D-Pad كاملة.'],
                    ['Nintendo Switch Lite أزرق تركواز', 199, 'لون شبابي نابض بالحياة لتشغيل مكتبة ألعاب نينتندو سويتش التي تدعم الوضع المحمول.'],
                    ['يد تحكم Nintendo Switch Pro Controller اللاسلكية', 69, 'يد تحكم مريحة للغاية بمقابض ممتازة وبطارية أسطورية تدوم 40 ساعة ومستشعر NFC لـ Amiibo.'],
                    ['Steam Deck OLED 1TB كمبيوتر ألعاب محمول أسود', 649, 'شاشة HDR OLED 90Hz بسطوع 1000 nit مع زجاج محفور مضاد للتوهج وواي فاي 6E فائق السرعة.'],
                    ['Steam Deck OLED 512GB كمبيوتر ألعاب محمول', 549, 'بطارية أكبر بنسبة 50% مع مروحة تبريد أكبر وأهدأ لتشغيل مكتبة ألعاب Steam بالكامل في يدك.'],
                    ['ASUS ROG Ally X كمبيوتر ألعاب محمول 24GB RAM / 1TB SSD', 799, 'معالج AMD Ryzen Z1 Extreme مع بطارية عملاقة 80Wh ومنفذي USB-C ومقابض مريحة مطورة.'],
                    ['Lenovo Legion Go كمبيوتر ألعاب محمول بشاشات قابلة للفصل', 699, 'شاشة ضخمة 8.8 بوصة QHD+ 144Hz مع أيدي تحكم قابلة للفصل ووضع FPS Mode المبتكر.'],
                    ['MSI Claw A1M كمبيوتر ألعاب محمول Intel Core Ultra 7', 699, 'معالج Intel Core Ultra مع تقنية Intel XeSS لرفع جودة الرسوم وعصي تحكم Hall Effect مغناطيسية.'],
                    ['Logitech G CLOUD جهاز ألعاب سحابي محمول 7 بوصة', 349, 'شاشة FHD لمسية مع بطارية مذهلة تدوم 12+ ساعة لتشغيل Xbox Cloud Gaming وGeForce NOW.'],
                    ['Backbone One يد تحكم للهواتف الذكية إصدار PlayStation USB-C', 99, 'تحول هاتفك الآيفون أو الأندرويد إلى منصة ألعاب تشبه PS5 مع منفذ لسماعات الرأس 3.5mm.'],
                    ['Razer Kishi V2 Pro يد تحكم للهاتف مع اهتزاز HyperSense', 129, 'أزرار ميكرو سويتش دقيقة مع جسر تمديد متين وردود فعل لمسية غامرة في ألعاب الهاتف.'],
                    ['Samsung Odyssey OLED G9 49 بوصة شاشة ألعاب منحنية DQHD', 1399, 'شاشة عملاقة منحنية 1800R بدقة Dual QHD بتردد 240Hz وزمن استجابة 0.03ms مع Neo Quantum Pro.'],
                    ['Samsung Odyssey Ark 55 بوصة شاشة ألعاب عملاقة 4K 165Hz', 1999, 'شاشة 55 بوصة Mini-LED مع وضع Cockpit Mode للدوران الرأسي ومكبرات صوت بقوة 60 واط.'],
                    ['Samsung Odyssey Neo G8 32 بوصة 4K 240Hz Quantum Mini-LED', 1199, 'أول شاشة في العالم تجمع دقة 4K مع سرعة 240Hz وانحناء 1000R بسطوع 2000 nit.'],
                    ['LG UltraGear 45 بوصة OLED منحنية 240Hz 0.03ms WQHD', 1499, 'انحناء دراماتيكي 800R يحيط بمجال رؤيتك بالكامل مع شاشة OLED زاهية وسرعة خارقة.'],
                    ['LG UltraGear 32GS95UE 32 بوصة 4K OLED ثنائية التردد 240Hz/480Hz', 1199, 'التبديل بضغطة زر بين 4K 240Hz لروعة الرسوميات أو FHD 480Hz للألعاب التنافسية السريعة.'],
                    ['ASUS ROG Swift PG32UCDM 32 بوصة QD-OLED 4K 240Hz', 1299, 'لوحة QD-OLED من الجيل الثالث مع مشتت حراري مخصص مدمج لمنع التطبيع بدون مراوح مزعجة.'],
                    ['Alienware AW3423DWF 34 بوصة QD-OLED منحنية WQHD 165Hz', 899, 'تباين لا نهائي وتغطية ألوان سينمائية 99.3% DCI-P3 مع دعم AMD FreeSync Premium Pro.'],
                    ['Corsair K100 RGB لوحة مفاتيح ألعاب ميكانيكية بصرية OPX', 229, 'مفاتيح بصرية بسرعة استجابة 0.2ms ومعدل استقصاء خارق 4000Hz وعجلة iCUE متعددة الوظائف.'],
                    ['Corsair K70 MAX لوحة مفاتيح مغناطيسية بمفاتيح MGX قابلة للتعديل', 229, 'مفاتيح مغناطيسية تسمح بتحديد نقطة التفعيل لكل مفتاح بدقة من 0.4 مم إلى 3.6 مم.'],
                    ['Razer Huntsman V3 Pro لوحة مفاتيح تناظرية سريعة Analog Gen-2', 249, 'ميزة Rapid Trigger لإعادة الضغط الفوري على المفاتيح في ألعاب التصويب التنافسية مثل Valorant.'],
                    ['Razer BlackWidow V4 Pro لوحة مفاتيح ميكانيكية مع قرص تحكم', 229, 'إضاءة Underglow سفلية محيطية مع 8 مفاتيح ماكرو مخصصة ومفاتيح Razer Green أو Yellow.'],
                    ['Logitech G915 LIGHTSPEED لوحة مفاتيح لاسلكية منخفضة الارتفاع', 229, 'هيكل نحيف من سبائك الألومنيوم المستخدمة في الطائرات مع اتصال لاسلكي فائق السرعة 1ms.'],
                    ['Logitech G PRO X TKL LIGHTSPEED لوحة مفاتيح للاعبين المحترفين', 199, 'تصميم مدمج بدون لوحة أرقام مع أغطية مفاتيح PBT مزدوجة الحقن وحقيبة حمل صلبة.'],
                    ['SteelSeries Apex Pro TKL Gen 3 لوحة مفاتيح مغناطيسية OmniPoint 3.0', 239, 'أسرع لوحة مفاتيح مع شاشة OLED ذكية لعرض معلومات اللعبة وضبط الحساسية مباشرة.'],
                    ['Keychron Q3 Max لوحة مفاتيح ألعاب ميكانيكية لاسلكية مخصصة', 214, 'هيكل ألومنيوم CNC كامل مع حشوات امتصاص صوت متعددة الطبقات ومفاتيح قابلة للتبديل الساخن.'],
                    ['Razer DeathAdder V3 Pro ماوس ألعاب لاسلكي مريح 63g', 149, 'مستشعر Focus Pro 30K Optical ومفاتيح بصرية من الجيل الثالث مع بطارية تدوم 90 ساعة.'],
                    ['Razer Viper V3 Pro ماوس ألعاب لاسلكي للرياضات الإلكترونية 54g', 159, 'وزن خفيف للغاية 54 جرام مع دعم معدل استقصاء حقيقي 8000Hz اللاسلكي الفوري.'],
                    ['Razer Basilisk V3 Pro ماوس ألعاب لاسلكي قابل للتخصيص RGB', 159, 'عجلة التمرير الذكية HyperScroll Tilt Wheel مع 13 زراً قابلاً للبرمجة وشحن لاسلكي.'],
                    ['Logitech G PRO X SUPERLIGHT 2 ماوس ألعاب لاسلكي 60g', 159, 'مفاتيح هجينة LIGHTFORCE تجمع بين سرعة الاستجابة البصرية والملمس الميكانيكي المرضي.'],
                    ['Logitech G502 X PLUS ماوس ألعاب لاسلكي بإضاءة LIGHTSYNC RGB', 159, 'الأيقونة المعاد تصميمها مع مستشعر HERO 25K الدقيق وزر خفض الحساسية DPI Shift قابل للعكس.'],
                    ['SteelSeries Aerox 5 Wireless ماوس ألعاب خفيف متعدد الأزرار 74g', 139, 'تصميم بهيكل خلية النحل فائق الخفة مع حماية AquaBarrier المقاومة للماء والغبار IP54.'],
                    ['Finalmouse UltralightX ماوس كربوني مركب خفيف 31g', 189, 'أخف ماوس ألعاب في العالم مصنوع من ألياف الكربون المركبة بمعدل استقصاء 4000Hz.'],
                    ['HyperX Cloud III Wireless سماعة ألعاب لاسلكية بطارية 120 ساعة', 169, 'راحة رغوة الذاكرة الأسطورية مع صوت مكاني DTS Headphone:X وميكروفون 10 مم متبلور.'],
                    ['Razer BlackShark V2 Pro (2024) سماعة ألعاب للرياضات الإلكترونية', 199, 'ميكروفون HyperClear Super Wideband عريض النطاق مع مشغلات TriForce Titanium 50mm.'],
                    ['Audeze Maxwell سماعة ألعاب لاسلكية Planar Magnetic للكونسول والـ PC', 299, 'محركات مسطحة ضخمة 90 مم مع بطارية تدوم 80 ساعة وعزل ضوضاء للميكروفون بالذكاء الاصطناعي.'],
                ]
            ],
            'الكاميرات ومعدات التصوير' => [
                'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Sony Alpha A7 IV كاميرا فل فريم احترافية Body', 2499, 'مستشعر Exmor R بدقة 33 ميجابكسل مع تركيز فوري بالذكاء الاصطناعي وتصوير 4K 60p 10-bit 4:2:2.'],
                    ['Sony Alpha A7R V كاميرا فل فريم فائقة الدقة 61MP Body', 3899, 'شريحة معالجة AI مخصصة للتعرف على البشر والمركبات مع مثبت بصري داخل الهيكل 8 وقفات.'],
                    ['Sony Alpha A7C II كاميرا فل فريم مدمجة 33MP Body فضي', 2199, 'أصغر كاميرا فل فريم احترافية بوزن 514 جرام فقط مع شاشة مفصلية بالكامل ومثبت مدمج.'],
                    ['Sony Alpha A6700 كاميرا APS-C رائدة 26MP Body', 1399, 'تركيز تلقائي بالذكاء الاصطناعي مع تصوير فيديو 4K 120fps وسرعة التقاط 11fps للصور.'],
                    ['Sony ZV-E1 كاميرا فل فريم لصناع المحتوى والفلوج Body', 2199, 'مستشعر فل فريم 12MP فائق الحساسية للضوء مع ميزة التأطير التلقائي Auto Framing بالذكاء الاصطناعي.'],
                    ['Sony ZV-E10 II كاميرا فلوج APS-C مع عدسة 16-50mm', 999, 'مستشعر 26MP مع تصوير 4K 60p بدون قص وزر Cinematic Vlog للقطات السينمائية الفورية.'],
                    ['Sony FX3 كاميرا سينمائية كاملة الإطار بخط Cinema Line', 3999, 'تبريد مروحي داخلي للتسجيل المستمر بدون انقطاع مع مقبض صوت XLR ومؤشرات Tally ضوئية.'],
                    ['Sony FX30 كاميرا سينمائية Super 35 بخط Cinema Line مع مقبض XLR', 2199, 'كاميرا سينمائية مدمجة بدقة 4K 120fps مع دعم ملفات LUTs ومقاييس الألوان الاحترافية S-Cinetone.'],
                    ['Canon EOS R5 Mark II كاميرا فل فريم 45MP مع تصوير 8K 60p RAW', 4299, 'معالج Accelerated Capture مع تركيز Eye Control AF بالعين وتصوير حركة مستمر 30fps.'],
                    ['Canon EOS R6 Mark II كاميرا فل فريم 24.2MP Body', 2499, 'سرعة تصوير خارقة تصل إلى 40fps مع الغالق الإلكتروني وفيديو 4K 60p غير مقتطع من دقة 6K.'],
                    ['Canon EOS R8 كاميرا فل فريم خفيفة الوزن 24.2MP Body', 1499, 'أخف كاميرا فل فريم من كانون بوزن 461 جرام مع تركيز Dual Pixel CMOS AF II المتطور.'],
                    ['Canon EOS R50 كاميرا ميرورليس للمبتدئين مع عدسة 18-45mm', 799, 'كاميرا خفيفة وسهلة الاستخدام مع شاشة لمس متحركة وتصوير 4K 30p بدون اقتصاص.'],
                    ['Canon EOS R100 كاميرا ميرورليس اقتصادية مع عدسة 18-45mm', 599, 'الخيار المثالي للترقية من كاميرا الهاتف الذكي مع مستشعر APS-C كبير بدقة 24.1MP.'],
                    ['Canon PowerShot V10 كاميرا جيب مخصصة للفلوج والبث المباشر', 429, 'حامل مدمج وميكروفونات ستريو كبيرة وعدسة عريضة 19 مم مع سهولة البث المباشر على يوتيوب.'],
                    ['Nikon Z8 كاميرا ميرورليس احترافية 45.7MP Body', 3999, 'قوة كاميرا Z9 الرائدة في هيكل أصغر بنسبة 30% مع تصوير 8.3K 60p N-RAW بدون غالق ميكانيكي.'],
                    ['Nikon Z6 III كاميرا فل فريم بمستشعر شبه مكدس 24.5MP', 2499, 'معين منظر إلكتروني ساطع جداً 4000 nit مع تسجيل فيديو داخلي 6K 60p N-RAW وتركيز فائق.'],
                    ['Nikon Zf كاميرا فل فريم بتصميم كلاسيكي ريترو أسود', 1999, 'هيكل مصنوع من سبائك المغنيسيوم مع أقراص تحكم نحاسية محفورة ومثبت بصري جبار 8 وقفات.'],
                    ['Nikon Zfc كاميرا APS-C بتصميم كلاسيكي أنيق فضي/أسود مع عدسة 16-50mm', 1099, 'تصميم مستوحى من كاميرا نيكون FM2 الأسطورية مع شاشة سيلفي ومنافذ USB-C حديثة.'],
                    ['Nikon Z30 كاميرا فلوج وصناع المحتوى مع عدسة 16-50mm', 849, 'تسجيل فيديو 4K مستمر حتى 125 دقيقة مع ضوء أحمر للتسجيل وميكروفون ستريو مدمج.'],
                    ['Fujifilm X100VI كاميرا مدمجة فاخرة 40.2MP فضي كلاسيك', 1599, 'الطلب الأول عالمياً بمستشعر X-Trans 5 HR ومثبت داخلي IBIS و20 وضعاً لمحاكاة الأفلام السينمائية.'],
                    ['Fujifilm X100VI كاميرا مدمجة فاخرة 40.2MP أسود مطفي', 1599, 'إصدار أسود أنيق بالكامل بعدسة ثابتة 23mm F2 الحادة ومعين منظر هجين بصري وإلكتروني.'],
                    ['Fujifilm X-T5 كاميرا تصوير فوتوغرافي ميرورليس 40.2MP Body فضي', 1699, 'ثلاثة أقراص تحكم علوية كلاسيكية مع شاشة قابلة للإمالة في ثلاثة اتجاهات ومثبت 7 وقفات.'],
                    ['Fujifilm X-T50 كاميرا ميرورليس خفيفة 40.2MP مع قرص محاكاة الأفلام', 1399, 'أول كاميرا بقرص مخصص لاختيار Film Simulation مع مثبت صورة مدمج في هيكل خفيف.'],
                    ['Fujifilm X-S20 كاميرا هجينة للصور والفيديو مع بطارية عملاقة Body', 1299, 'تصوير فيديو 6.2K 30p مع وضع Vlog Mode المخصص ومقبض مريح وبطارية تدوم ضعف الوقت.'],
                    ['Fujifilm GFX 100 II كاميرا ميديوم فورمات متوسطة الحجم 102MP Body', 7499, 'مستشعر عملاق بحجم 44x33 مم يمنح عمق ميدان ساحر وتفاصيل خارقة وتصوير فيديو 8K 30p.'],
                    ['Panasonic Lumix S5 IIX كاميرا فل فريم للفيديو الأسود غير اللامع', 2199, 'تركيز هجين Phase Hybrid AF مع تسجيل فيديو ProRes داخلي وبث مباشر سلكي ولاسلكي.'],
                    ['Panasonic Lumix GH7 كاميرا مايكرو فور ثيردز سينمائية احترافية', 2199, 'تسجيل داخلي ProRes RAW وتسجيل صوت 32-bit float مع مروحة تبريد داخلية مدمجة.'],
                    ['Leica Q3 كاميرا مدمجة كاملة الإطار 60MP مع عدسة Summilux 28mm f/1.7', 5995, 'قمة الحرفية الألمانية بهيكل ألومنيوم فاخر وشاشة مائلة وتصوير فيديو 8K وشحن لاسلكي.'],
                    ['DJI Mavic 3 Pro طائرة درون احترافية بنظام ثلاثي الكاميرات مع ريموت RC', 2199, 'كاميرا Hasselblad 4/3 رئيسية مع كاميرتي تقريب 70mm و166mm وتحليق يصل إلى 43 دقيقة.'],
                    ['DJI Air 3 درون بكاميرتين رئيسيتين مزدوجتين 4K HDR مع Fly More Combo', 1549, 'كاميرا عريضة وكاميرا تيليفوتو 3x بدقة 48MP مع تجنب عوائق في جميع الاتجاهات وبطارية 46 دقيقة.'],
                    ['DJI Mini 4 Pro طائرة درون خفيفة أقل من 249g مع ريموت شاشة DJI RC 2', 959, 'تصوير رأسي حقيقي True Vertical لـ TikTok ومستشعرات أمان محيطية ونقل فيديو O4 لمسافة 20 كم.'],
                    ['DJI Mini 3 درون خفيف الوزن 249g مع Fly More Combo', 699, 'أفضل درون اقتصادي مع تصوير 4K HDR وبطاريات إضافية وحقيبة ومروحة بديلة.'],
                    ['DJI Avata 2 درون سباق FPV مع نظارات Goggles 3 وMotion Controller', 999, 'تجربة طيران غامرة من منظور الشخص الأول مع تصوير 4K 60fps فائق الثبات وحماية مراوح مدمجة.'],
                    ['DJI Osmo Pocket 3 Creator Combo كاميرا جيب بمستشعر 1 بوصة', 669, 'شاشة لمس دوارة 2 بوصة مع ميكروفون لاسلكي DJI Mic 2 وبطارية إضافية وتثبيت جيمبال ثلاثي.'],
                    ['DJI Osmo Action 4 Adventure Combo كاميرا حركة بمستشعر كبير 1/1.3', 399, 'أداء ليلي رائع مع 3 بطاريات مقاومة للتجمد وقضيب تمديد 1.5 متر وغوص حتى 18 متراً بدون حافظة.'],
                    ['GoPro HERO 13 Black كاميرا حركة احترافية 5.3K 60fps', 399, 'عدسات ذكية HB-Series قابلة للتبديل مع تثبيت HyperSmooth 6.0 وبطارية Enduro مطورة.'],
                    ['GoPro HERO 13 Black Creator Edition حزمة صناع المحتوى الكاملة', 599, 'مقبض بطارية Volta مع ميكروفون Media Mod وإضاءة Light Mod لتحويل الكاميرا لاستوديو محمول.'],
                    ['GoPro HERO كاميرا حركة صغيرة جداً وخفيفة 4K', 199, 'أصغر وأخف كاميرا 4K من جوبرو بوزن 86 جرام فقط وشاشة لمسية ومقاومة ماء حتى 5 أمتار.'],
                    ['Insta360 X4 كاميرا 360 درجة بدقة 8K مع واقي عدسات قابل للفصل', 499, 'تصوير فيديو كروي 360 درجة بدقة 8K 30fps مع عصا سيلفي غير مرئية وتعديل زوايا المشاهد لاحقاً.'],
                    ['Insta360 Ace Pro 2 كاميرا أكشن ذكاء اصطناعي بعدسات Leica وشاشتين', 449, 'شريحة معالجة مزدوجة Dual AI Chip مع مستشعر 8K وشاشة لمس قابلة للقلب 2.5 بوصة لمشاهدة السيلفي.'],
                    ['Insta360 GO 3S كاميرا إبهام صغيرة 4K مغناطيسية بيضاء', 399, 'كاميرا بحجم الإبهام تثبت على القبعة أو الصدر بمغناطيس قوي مع علبة Action Pod الذكية.'],
                    ['Rode Wireless PRO نظام ميكروفون لاسلكي بميزة التسجيل الداخلي 32-bit Float', 399, 'جهازا إرسال وجهاز استقبال مع تسجيل احتياطي داخلي بدون تشويش ومزامنة Timecode وميكروفوني Lavalier.'],
                    ['DJI Mic 2 نظام ميكروفونات لاسلكية ذكية 2TX + 1RX مع علبة شحن', 349, 'تسجيل صوتي 32-bit float مع عزل ضوضاء ذكي بالذكاء الاصطناعي وتوصيل مباشر بالهواتف والكاميرات.'],
                    ['Hollyland Lark Max نظام ميكروفونات استوديو لاسلكية احترافية', 249, 'تقنية MaxTimbre الصوتية مع تخزين داخلي 8GB لكل مرسل وإلغاء ضوضاء بيئية بضغطة زر.'],
                    ['Elgato Stream Deck MK.2 جهاز تحكم للبث والمونتاج بـ 15 مفتاح LCD', 149, '15 مفتاح LCD ملون قابل للتخصيص للتحكم في برامج البث مثل OBS وتطبيقات الصوت والمونتاج.'],
                    ['Elgato Stream Deck + مع 8 أزرار LCD و4 أقراص تحكم دوارة وشريط لمس', 199, 'التحكم الكامل في مستويات الصوت والإضاءة والكاميرا مع شريط لمسي تفاعلي وأقراص تناظرية.'],
                    ['Elgato Facecam Pro كاميرا ويب احترافية 4K 60fps بمستشعر سوني', 299, 'أول كاميرا ويب في العالم تسجل 4K 60fps بدون ضغط مع عدسة زجاجية استوديو 21 مم f/2.0.'],
                    ['Elgato Key Light إضاءة استوديو احترافية 2800 لومن مع حامل مكتب', 199, 'إضاءة جانبية ناعمة تحمي العينين مع تحكم بالواي فاي في درجة حرارة اللون من 2900K إلى 7000K.'],
                    ['DJI RS 4 Pro مثبت جيمبال كاميرات احترافية من ألياف الكربون', 869, 'أذرع ألياف كربون تتحمل وزناً حتى 4.5 كجم مع أقفال محاور آلية من الجيل الثاني وتتبع LiDAR.'],
                    ['DJI RS 4 مثبت جيمبال خفيف للكاميرات الميرورليس وزن 3 كجم', 549, 'تثبيت رأسي أصلي للجيل الثاني مع مفتاح تبديل الأنماط وشاشة لمس OLED ملونة.'],
                ]
            ],
            'الشاشات وأجهزة العرض' => [
                'img' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Apple Studio Display 27 بوصة 5K زجاج قياسي مع حامل قابل للإمالة', 1599, 'شاشة ريتينا 5K بدقة 5120x2880 مع كاميرا 12MP فائقة الاتساع و6 مكبرات صوت استوديو.'],
                    ['Apple Studio Display 27 بوصة 5K زجاج نانو تكسشر مضاد للتوهج', 1899, 'زجاج بتقنية نانو مجهرية تشتت الانعكاسات مع حامل قابل لتعديل الارتفاع والإمالة.'],
                    ['Apple Pro Display XDR 32 بوصة 6K شاشة مرجعية للمحترفين', 4999, 'شاشة 6K Retina بسطوع مستمر 1000 nit وذروة 1600 nit وتباين 1,000,000:1.'],
                    ['LG UltraFine 27 بوصة 5K شاشة مخصصة لأجهزة Mac بمنفذ Thunderbolt 3', 1299, 'شاشة 5K مع تغطية 99% P3 ومكبرات صوت استريو وميكروفون وكاميرا مدمجة وشحن 94W.'],
                    ['LG DualUp 28 بوصة شاشة بنسبة أبعاد 16:18 فريدة Ergo Stand', 699, 'مساحة شاشتين مقاس 21.5 بوصة مكدستين رأسياً فوق بعضهما مع ذراع تثبيت احترافي على المكتب.'],
                    ['LG UltraGear 32GS95UE 32 بوصة OLED 4K 240Hz أو FHD 480Hz', 1199, 'شاشة OLED ثنائية التردد الأولى في العالم مع صوت Pixel Sound مدمج مباشرة في اللوحة.'],
                    ['LG UltraGear 27GS95QE 27 بوصة OLED 2K 240Hz 0.03ms', 799, 'شاشة ألعاب OLED مدمجة وسريعة مع تباين لا نهائي وتوافق كامل مع G-SYNC وFreeSync.'],
                    ['Dell UltraSharp U3224KB 32 بوصة 6K IPS Black مع كاميرا 4K مدمجة', 2499, 'شاشة 6K استثنائية بدقة 6144x3456 مع منافذ Thunderbolt 4 وشبكة 2.5GbE وقاعدة توصيل.'],
                    ['Dell UltraSharp U2724DE 27 بوصة QHD 120Hz IPS Black مع Thunderbolt', 649, 'معدل تحديث 120Hz فائق السلاسة مع تباين 2000:1 ومستشعر سطوع تلقائي للعين.'],
                    ['Dell UltraSharp U3824DW 38 بوصة شاشة منحنية WQHD+ مخصصة للإنتاجية', 1199, 'شاشة عريضة 3840x1600 مع ميزة KVM للتحكم في حاسوبين بلوحة مفاتيح وماوس واحدة.'],
                    ['Dell UltraSharp U4323QE 43 بوصة 4K تتيح تقسيم الشاشة إلى 4 شاشات FHD', 999, 'شاشة عملاقة 43 بوصة تتيح عرض محتوى 4 حواسيب مختلفة في نفس الوقت دون حواف.'],
                    ['Samsung ViewFinity S9 27 بوصة 5K مع كاميرا 4K SlimFit وتطبيق Smart Hub', 1299, 'شاشة 5K بطلاء مطفي مضاد للانعكاس ومعايرة ذكية للألوان عبر الهاتف ومنفذ Thunderbolt 4.'],
                    ['Samsung Smart Monitor M8 32 بوصة 4K شاشة وتلفزيون ذكي أخضر ربيعي', 699, 'شاشة إنتاجية وتلفزيون ذكي يعمل بنظام Tizen لمشاهدة Netflix وYouTube بدون تشغيل الحاسوب.'],
                    ['Samsung Odyssey Neo G9 57 بوصة شاشة ألعاب ثنائية الـ 4K بتردد 240Hz', 2299, 'أول شاشة في العالم بدقة Dual UHD 7680x2160 مع إضاءة Quantum Mini-LED وانحناء 1000R.'],
                    ['Samsung Odyssey OLED G8 34 بوصة منحنية WQHD 175Hz مع معالج Neo Quantum', 999, 'هيكل معدني نحيف جداً بسمك 3.9 مم مع إضاءة CoreSync خلفية تفاعلية مذهلة.'],
                    ['BenQ PD3220U 32 بوصة 4K للمصممين مع Thunderbolt 3 ومفتاح Hotkey Puck', 1099, 'ألوان دقيقة معتمدة CalMAN وPantone مع وضع M-Book لمطابقة ألوان أجهزة ماك بوك تماماً.'],
                    ['BenQ PD2706U 27 بوصة 4K شاشة للمصممين مع حامل Ergo Arm وUSB-C 90W', 599, 'ذراع تحكم ميكانيكي مريح لتعديل الارتفاع والتدوير مع تغطية 95% DCI-P3 وشحن اللابتوب.'],
                    ['BenQ SW321C 32 بوصة 4K شاشة احترافية للمصورين مع غطاء حماية وشاشة Paper Color', 1999, 'لوحة ART مضادة للانعكاس تماماً مع تغطية 99% Adobe RGB وبرنامج المعايرة العتادية.'],
                    ['ASUS ProArt PA32UCG-K 32 بوصة 4K 120Hz Mini-LED بسطوع 1600 nit', 2999, 'أول شاشة في العالم بدقة 4K HDR 120Hz مع 1152 منطقة تعتيم محلي لمعالجة أفلام HDR.'],
                    ['ASUS ProArt PA279CRV 27 بوصة 4K للمصممين ومنتجي الفيديو بمنفذ USB-C 96W', 499, 'شاشة 4K معتمدة من Calman مع قاعدة رفيعة مدمجة ومنافذ DisplayPort Daisy-chaining.'],
                    ['ViewSonic ColorPro VP2786-4K 27 بوصة مع عجلة ColorPro Wheel المادية', 999, 'عجلة تحكم مادية للمعايرة المباشرة والتحكم في أدوات Adobe Photoshop وPremiere.'],
                    ['Philips Evnia 34M2C8600 34 بوصة QD-OLED منحنية 175Hz مع Ambiglow', 999, 'إضاءة Ambiglow المحيطية تضيء الجدار الخلفي بألوان اللعبة الحية مع لوحة QD-OLED فائقة التباين.'],
                    ['Samsung The Freestyle Gen 2 بروجكتر ذكي محمول 1080p مع Gaming Hub', 599, 'عرض سينمائي حتى 100 بوصة مع ضبط تلقائي للزوايا والتركيز وصوت محيطي 360 درجة.'],
                    ['Anker Nebula Capsule 3 Laser بروجكتر ليزر بحجم علبة المشروبات 1080p', 699, 'تقنية ليزر ساطعة 300 ANSI Lumen مع Google TV وبطارية مدمجة تدوم حتى 2.5 ساعة.'],
                    ['XGIMI Horizon Ultra 4K بروجكتر ليزر وهجين منزلي مع Dolby Vision', 1699, 'أول بروجكتر منزلي طويل المدى يدعم Dolby Vision مع صوت Harman Kardon بقوة 24 واط.'],
                    ['XGIMI MoGo 2 Pro بروجكتر محمول ذكي 1080p بحجم راحة اليد', 399, 'تصحيح تلقائي للصورة دون مقاطعة العرض مع مكبرات صوت مزدوجة وبث محتوى سلس.'],
                    ['Formovie Theater 4K بروجكتر ليزر ثلاثي فائق القصر UST مع Dolby Vision', 2999, 'يوضع على بعد 20 سم من الجدار لعرض شاشة عملاقة 150 بوصة مع صوت Bowers & Wilkins.'],
                    ['BenQ X3100i بروجكتر ألعاب 4K 4LED بسطوع 3300 لومن وزمن استجابة 4ms', 2399, 'مخصص لأجهزة PS5 وXbox Series X مع تغطية 100% DCI-P3 وأوضاع ألعاب مخصصة.'],
                    ['Epson Home Cinema 5050UB بروجكتر مسرح منزلي 4K PRO-UHD مع عدسة متحركة', 2999, 'تباين استثنائي بفضل تقنية UltraBlack مع إمكانية إزاحة العدسة بمحرك كهربائي عالي الدقة.'],
                    ['JMGO N1 Ultra 4K بروجكتر ليزر ثلاثي مع جيمبال دوران مدمج 360 درجة', 1999, 'قاعدة جيمبال مدمجة تتيح توجيه العرض نحو السقف أو أي جدار بسلاسة وسطوع 2200 CVIA.'],
                ]
            ],
            'الإكسسوارات وبنوك الطاقة' => [
                'img' => 'https://images.unsplash.com/photo-1622445262464-84b24e40623a?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Anker 737 Power Bank GaNPrime 140W سعة 24,000mAh', 129, 'شاحن متنقل فائق السرعة 140 واط بشاشة ملونة تفاعلية تعرض تفاصيل الطاقة وحرارة البطارية.'],
                    ['Anker Prime Power Bank سعة 27,650mAh بقوة 250W ثلاثي المنافذ', 179, 'أقوى باور بانك من أنكر يشحن جهازين ماك بوك برو معاً بأقصى سرعة مع تطبيق للتحكم.'],
                    ['Anker Prime 6-in-1 محطة شحن مكتبية ذكية 140W مع شاشة رقمية', 109, 'محطة شحن مكتبية رفيعة تشمل منفذي كهرباء AC و4 منافذ USB لشحن كافة أجهزتك.'],
                    ['Anker Nano 3 شاحن جداري مدمج 30W بتقنية GaN بنفسجي', 22, 'شاحن صغير للغاية بحجم شاحن آبل القديم 5W لكنه يقدم قوة 30W لشحن الآيفون والآيباد.'],
                    ['Anker MagGo Power Bank 10,000mAh بمعيار Qi2 اللاسلكي 15W', 89, 'شاحن مغناطيسي لاسلكي سريع 15 واط متوافق مع MagSafe مع شاشة جانبية وحامل مدمج.'],
                    ['Ugreen Nexode 300W شاحن مكتبي جبار بـ 5 منافذ GaN Fast Charger', 199, 'شاحن عملاق بقوة 300 واط مع منفذ رئيسي بقوة 140 واط يشحن لابتوبات الألعاب والمحمول.'],
                    ['Ugreen Nexode 100W شاحن حائط رباعي المنافذ GaN رمادي', 59, 'شاحن سفر مدمج يشحن 3 هواتف ولابتوب في نفس الوقت بقابس قابل للطي.'],
                    ['Ugreen 145W Power Bank سعة 25,000mAh لشحن الحواسيب المحمولة', 99, 'شاحن متنقل عالي السعة مخصص للابتوبات Dell XPS وMacBook مع شاشة LED للنسبة.'],
                    ['Belkin BoostCharge Pro محطة شحن لاسلكي مغناطيسية 3 في 1 MagSafe 15W', 149, 'شحن رسمي سريع للآيفون وساعة Apple Watch وسماعات AirPods بتصميم شجرة T أنيق.'],
                    ['Belkin BoostCharge Pro شاحن حائط 140W رباعي المنافذ بمنفذين USB-C وUSB-A', 119, 'توزيع طاقة ذكي PPS يوفر الشحن الأمثل لكل جهاز متصل بأمان وحماية حرارية.'],
                    ['Baseus Blade 100W باور بانك فائق النحافة سعة 20,000mAh', 89, 'سمك نحيف يبلغ 18 مم فقط يوضع بسهولة داخل حقيبة اللابتوب مع شاشة رقمية تفصيلية.'],
                    ['Baseus Nomos محطة شحن لاسلكي 8 في 1 مع كيبل مدمج وشاشة', 129, 'شاحن لاسلكي مغناطيسي مع قاعدة توصيل USB ومنافذ شحن سريعة وكيبل منسحب.'],
                    ['Apple Magic Keyboard مع Touch ID ولوحة أرقام أسود', 199, 'لوحة مفاتيح أبل اللاسلكية الأنيقة بفتح قفل ببصمة الإصبع وهيكل ألومنيوم أسود فلكي.'],
                    ['Apple Magic Mouse ماوس لاسلكي بسطح لمسي متعدد أسود فلكي', 99, 'سطح زجاجي يدعم الإيماءات المتعددة والتمرير الانسيابي في كافة الاتجاهات.'],
                    ['Apple Magic Trackpad لوحة لمسية لاسلكية Force Touch سوداء', 149, 'مساحة لمس زجاجية عريضة تمنحك نفس تجربة تراك باد الماك بوك على الكمبيوتر المكتبي.'],
                    ['Apple Pencil Pro قلم آبل الجديد مع ميزة الضغط والتدوير والاهتزاز اللمسي', 129, 'مستشعر ضغط متطور في المقبض مع جيروسكوب لتدوير الفرشاة واستجابة لمسية ذكية.'],
                    ['Apple Pencil USB-C قلم آبل بدقة متناهية وشحن سلكي', 79, 'مثالي لتدوين الملاحظات والرسم مع دقة بكسلية وحساسية إمالة وتثبيت مغناطيسي.'],
                    ['Samsung S-Pen Creator Edition قلم سامسونج المطور للرسم', 99, 'قلم مصمم للفنانين برأسين قابلين للتبديل ومسكة مريحة ودرجات حساسية ضغط 4096.'],
                    ['CalDigit TS4 قاعدة توصيل Thunderbolt 4 بـ 18 منفذاً وشحن 98W', 399, 'أقوى قاعدة توصيل في العالم تدعم شاشات 8K ومنافذ صوتية وبطاقات SD وشبكة 2.5GbE.'],
                    ['OWC Thunderbolt Go Dock قاعدة توصيل بمحول طاقة مدمج بدون محول خارجي', 299, 'قاعدة توصيل Thunderbolt 4 لا تحتاج محول كهرباء خارجي ثقيل ومثالية للمكاتب والسفر.'],
                    ['Satechi Aluminum Stand & Hub لقاعدة Mac Mini مع فتحة SSD NVMe', 99, 'قاعدة ألومنيوم أنيقة ترفع جهاز الماك ميني وتضيف منافذ أمامية مع مساحة لتركيب هارد SSD.'],
                    ['HyperDrive Gen2 قاعدة توصيل USB-C بـ 16 منفذاً للأجهزة المحمولة', 249, 'منافذ شاشات مزدوجة 4K 60Hz مع منافذ صوت بصرية ومنافذ USB سريعة 10Gbps.'],
                    ['Samsung T9 Portable SSD سعة 4TB هارد ديسك خارجي فائق السرعة 2000MB/s', 399, 'سرعة قراءة وكتابة تصل إلى 2000 ميجابايت/ثانية عبر منفذ USB 3.2 Gen 2x2 مع حماية سقوط 3 أمتار.'],
                    ['Samsung T7 Shield Portable SSD سعة 2TB مقاوم للماء والصدمات أزرق', 199, 'غلاف مطاطي متين مع مقاومة للماء والغبار IP65 وسرعة 1050MB/s متوافق مع الهواتف والحواسيب.'],
                    ['SanDisk Extreme PRO Portable SSD سعة 4TB سرعة 2000MB/s', 379, 'هيكل ألومنيوم مدمج يعمل كمشتت حراري مع حلقة كربينية للتثبيت في حزام الأمان.'],
                    ['SanDisk Professional PRO-BLADE هارد خارجي معياري 2TB مع هيكل ألومنيوم', 279, 'نظام تخزين سحابي محلي يسمح بتبديل كبسولات الذاكرة Mag بسرعة فائقة لصناع الفيديو.'],
                    ['WD Black P40 Game Drive SSD سعة 2TB بإضاءة RGB مخصصة', 219, 'محرك أقراص مخصص للألعاب مع إضاءة RGB سفلية وسرعة 2000MB/s لتقليل أوقات التحميل.'],
                    ['Crucial X10 Pro Portable SSD سعة 4TB بحجم راحة اليد 2100MB/s', 349, 'أصغر هارد SSD خارجي سريع في العالم مصنوع من الألومنيوم المؤكسد بوزن 42 جرام فقط.'],
                    ['Kingston XS2000 Portable SSD سعة 2TB بحجم فلاشة الجيب', 189, 'سرعة 2000MB/s بحجم فائق الصغر مع غطاء حماية مطاطي مرفق ضد الصدمات.'],
                    ['Keychron Q1 Max لوحة مفاتيح ميكانيكية لاسلكية مخصصة 75% CNC', 209, 'هيكل ألومنيوم كامل مع اتصال 2.4G وبلوتوث ومفاتيح Gateron Jupiter المشحمة مسبقاً.'],
                    ['Keychron Q3 Max لوحة مفاتيح ميكانيكية TKL لاسلكية مع مقبض دوار', 214, 'تصميم Tenkeyless احترافي مع حشوات Acoustic Foam لعزل الصوت وصوت ضغطات فاخر.'],
                    ['Keychron K2 Pro لوحة مفاتيح ميكانيكية مدمجة متوافقة مع Mac/Windows', 109, 'لوحة مفاتيح تدعم تخصيص البرامج عبر QMK/VIA مع أغطية مفاتيح OSA PBT.'],
                    ['NuPhy Air75 V2 لوحة مفاتيح ميكانيكية لاسلكية فائقة النحافة 75%', 129, 'أنحف لوحة مفاتيح ميكانيكية بمعدل استقصاء 1000Hz ومفاتيح Gateron منخفضة الارتفاع.'],
                    ['Logitech MX Master 3S ماوس لاسلكي احترافي رمادي فلكي', 99, 'عجلة التمرير الكهرومغناطيسية MagSpeed تمرر 1000 سطر في ثانية ونقرات صامتة 90%.'],
                    ['Logitech MX Master 3S ماوس لاسلكي احترافي أبيض فاتح Pale Gray', 99, 'مستشعر 8K DPI Darkfield يعمل بدقة على أي سطح حتى الزجاج الشفاف.'],
                    ['Logitech MX Anywhere 3S ماوس لاسلكي متنقل للعمل والسفر', 79, 'حجم مدمج ومريح مع نقرات هادئة وبطارية تدوم 70 يوماً وزر تبديل بين 3 أجهزة.'],
                    ['Logitech MX Mechanical Mini لوحة مفاتيح لاسلكية بمفاتيح Tactile Quiet', 149, 'مفاتيح ميكانيكية منخفضة الارتفاع مع إضاءة ذكية تضيء بمجرد اقتراب يديك منها.'],
                    ['Logitech Craft لوحة مفاتيح متطورة مع قرص تحكم إبداعي دوار Crown', 199, 'قرص تحكم سياقي يتكيف مع البرنامج المستخدم في Photoshop وExcel لتعديل القيم بدقة.'],
                    ['Logitech Ergo K860 لوحة مفاتيح مريحة مقسومة هندسياً لدعم المعصم', 129, 'تصميم منحني ومقسوم مع وسادة راحة لليد مبطنة تقلل إجهاد عضلات المعصم بنسبة 54%.'],
                    ['Logitech MX Vertical ماوس رأسي مريح بزاوية 57 درجة', 99, 'وضعية المصافحة الطبيعية تقلل الضغط على العضلات مع مستشعر 4000 DPI عالي الدقة.'],
                    ['Blue Yeti X ميكروفون مكثف USB احترافي للبث الصوتي مع مصفوفة رباعية', 169, 'مقياس إضاءة LED ذكي مع برنامج Blue VO!CE لمؤثرات صوتية استوديو ونقاء صوتي فائق.'],
                    ['Razer Seiren V3 Chroma ميكروفون USB بإضاءة RGB تفاعلية مع البث', 129, 'مستشعر كتم صوت يعمل باللمس مع إضاءة تتفاعل مع ألعاب البث وتنبيهات المتابعين.'],
                    ['Elgato Wave:3 ميكروفون مكثف رقمي USB مع برنامج خلط الصوت Wave Link', 149, 'تقنية Clipguard لمنع تشويه الصوت عند الصراخ مع محول صوتي 24-bit 96kHz.'],
                    ['Satechi Trio Wireless Charging Pad محطة شحن لاسلكي ثلاثية قابلة للطي', 119, 'شحن سريع ومتزامن لجهاز آيفون وساعة أبل وسماعات إيربودز بسطح جلدي فاخر.'],
                    ['Nomad Base One Max محطة شحن معدنية ثقيلة MagSafe مع زجاج فاخر', 150, 'هيكل معدني صلب يزن نصف كيلو غرام يمنع تحرك الشاحن مع زجاج مقوى راقٍ.'],
                    ['Spigen ArcField حامل شحن لاسلكي مغناطيسي 15W Qi2 مع مروحة تبريد', 69, 'شحن مغناطيسي سريع مع مروحة تبريد مدمجة لحماية بطارية الهاتف من السخونة أثناء الشحن.'],
                    ['Twelve South HiRise 3 Deluxe محطة شحن لاسلكية 3 في 1 مكسوة بالجلد', 149, 'قاعدة عمودية موفرة للمساحة مكسوة بجلد ناعم لشحن الأجهزة في غرفة النوم أو المكتب.'],
                    ['Peak Design Travel Tripod حامل كاميرا وهواتف من ألياف الكربون', 649, 'أكثر حامل ثلاثي مدمج في العالم بحجم زجاجة ماء عند الطي مع رأس كروي فائق الدقة.'],
                ]
            ],
            'الأجهزة المنزلية الذكية' => [
                'img' => 'https://images.unsplash.com/photo-1558002038-1055907df827?w=600&auto=format&fit=crop&q=80',
                'models' => [
                    ['Dyson Purifier Hot+Cool Gen1 جهاز تنقية وتدفئة وتبريد ذكي HP10', 599, 'فلتر HEPA H13 يلتقط 99.95% من الجسيمات الدقيقة والغبار مع تدفئة وتبريد مروحي بدون شفرات.'],
                    ['Dyson Purifier Big+Quiet Formaldehyde جهاز تنقية هواء للصالات الكبيرة BP03', 999, 'تنقية هواء هادئة جداً لمساحات تصل إلى 100 متر مربع مع كشف وتدمير غاز الفورمالديهايد.'],
                    ['Dyson V15 Detect Absolute مكنسة لاسلكية ذكية مع ليزر كشف الغبار', 749, 'ليزر أخضر مدمج يظهر الجزيئات غير المرئية على الأرضيات وشاشة LCD تحسب حجم الغبار.'],
                    ['Dyson Gen5detect أحدث مكنسة لاسلكية بقوة شفط جبارة 280AW', 949, 'أقوى مكنسة لاسلكية بفلترة HEPA كاملة للجهاز تحبس 99.99% من الفيروسات وبطارية 70 دقيقة.'],
                    ['Dyson 360 Vis Nav مكنسة روبوتية ذكية برؤية 360 درجة وشفط مضاعف', 1199, 'كاميرا بانورامية علوية مع معالج ذكاء اصطناعي وذراع جانبي منبثق لتنظيف الحواف بدقة.'],
                    ['Dyson Supersonic Nural مجفف شعر ذكي بمستشعرات حماية فروة الرأس', 499, 'مستشعر Time-of-Flight يقيس المسافة تلقائياً لتثبيت الحرارة عند 55 درجة مئوية على الرأس.'],
                    ['Dyson Airwrap Complete Long جهاز تصفيف الشعر المتعدد بالهواء نيكل/نحاسي', 599, 'تجعيد وتمويج وتمليس الشعر دون حرارة مفرطة باستخدام تأثير كواندا Coanda الهوائي.'],
                    ['Roborock S8 MaxV Ultra مكنسة روبوتية ذكية مع قاعدة غسيل بماء ساخن 60°C', 1799, 'ذراع روبوتية FlexiArm للزوايا وقوة شفط 10,000Pa ومساعد صوتي Rocky مدمج بدون إنترنت.'],
                    ['Roborock S8 Pro Ultra مكنسة روبوتية مع تجفيف وتفريغ وغسيل ذاتي كامل', 1399, 'نظام فرش مزدوجة DuoRoller ومسح صوتي VibraRise 2.0 بتردد 3000 هزة في الدقيقة.'],
                    ['Roborock Qrevo MaxV مكنسة روبوتية مع ممسحتين دوارتين بمدى ممتد', 999, 'ممسحتان دوارتان بسرعة 200 دورة بالدقيقة مع إعادة غسيل الممسحة أوتوماتيكياً بالماء الحار.'],
                    ['Dreame L20 Ultra مكنسة وممسحة روبوتية بتقنية MopExtend الحصرية', 1099, 'تمتد الممسحة تلقائياً للوصول أسفل الأثاث والزوايا الضيقة مع إزالة الممسحة عند صعود السجاد.'],
                    ['Dreame X40 Ultra مكنسة روبوتية خارقة بقوة شفط 12,000Pa', 1499, 'أقوى شفط في العالم مع كاميرا AI لتجنب 120 نوعاً من العوائق المنزلية وقاعدة تنظيف ذاتي.'],
                    ['Ecovacs Deebot X2 Omni مكنسة روبوتية مربعة فائقة النحافة', 1199, 'تصميم مربع ينظف الحواف بنسبة 99.77% مع ملاحة ليزرية مدمجة داخل الهيكل.'],
                    ['iRobot Roomba Combo j9+ مكنسة وممسحة روبوتية مع ذراع رفع تلقائي', 999, 'ترفع الممسحة بالكامل فوق الروبوت لمنع بلل السجاد مع قاعدة تفريغ أوساخ وتعبئة مياه تكفي 30 يوماً.'],
                    ['Philips Hue White & Color Ambiance باقة البداية مع 4 لمبات وجسر ذكي E27', 199, '16 مليون لون مع مزامنة الإضاءة مع الأفلام والموسيقى والألعاب وتوافق مع Apple Home وAlexa.'],
                    ['Philips Hue Play Gradient Lightstrip شريط إضاءة خلف التلفزيون 65 بوصة', 249, 'تدرج لوني سلس في وقت واحد يطابق ألوان شاشة التلفزيون في الوقت الفعلي لتجربة سينمائية.'],
                    ['Philips Hue Play HDMI Sync Box 8K جهاز مزامنة الإضاءة مع شاشات 8K وHDMI 2.1', 349, 'يزامن أضواء Hue مع ألعاب PS5 وXbox وأفلام Apple TV بدقة 8K 60Hz أو 4K 120Hz.'],
                    ['Philips Hue Festavia أضواء شريطية ذكية متدلية للزينة والديكور 20 متراً', 219, '250 نقطة LED صغيرة ذكية لإنشاء أجواء احتفالية وساحرة داخل المنزل أو في الحديقة الخارجية.'],
                    ['Philips Hue Smart Motion Sensor مستشعر حركة لاسلكي ذكي للإضاءة', 44, 'يشغل الأضواء تلقائياً عند الدخول ويضبط شدتها حسب ضوء النهار الطبيعي المتاح في الغرفة.'],
                    ['Apple HomePod الجيل الثاني مكبر صوت منزلي ومركز تحكم ذكي أبيض', 299, 'مستشعرات مدمجة للحرارة والرطوبة مع دعم بروتوكول Matter والتعرف على أصوات إنذار الدخان.'],
                    ['Apple HomePod mini برتقالي نابض بالحياة', 99, 'مركز تحكم منزلي متكامل يدعم شبكة Thread لتوصيل كافة ملحقات المنزل الذكي باستقرار وسرعة.'],
                    ['Google Nest Hub Max شاشة منزلية ذكية 10 بوصات مع كاميرا Nest مدمجة', 229, 'مكالمات فيديو Google Meet مع تأطير تلقائي والتحكم باللمس والصوت في كافة أجهزة المنزل.'],
                    ['Google Nest Hub 2nd Gen شاشة ذكية مع ميزة تتبع النوم بدون أجهزة قابلة للارتداء', 99, 'تقنية Soli الرادارية تحلل حركة ونومك بجانب السرير بدقة مع صوت محسن بنسبة 50% باص.'],
                    ['Google Nest Audio مكبر صوت ذكي عالي النقاء بمساعد Google الصوتي', 99, 'صوت يملأ الغرفة مع وضوح مذهل في الترددات المتوسطة والعالية وموالفة صوتية تتكيف مع البيئة.'],
                    ['Google Nest Mini مكبر صوت ذكي صغير يثبت على الحائط رمادي', 49, 'مساعد صوتي ذكي يتيح طلب الأخبار والموسيقى والتحكم بالمصابيح والأقفال بسهولة.'],
                    ['Google Nest Wifi Pro نظام واي فاي شبكي 6E ثلاثي التغطية لمساحة 600 متر', 399, 'سرعات فائقة مع نطاق 6GHz النظيف لربط مئات الأجهزة الذكية المنزلية بدون أي بطء.'],
                    ['Google Nest Learning Thermostat الجيل الرابع مع مستشعر حرارة إضافي', 279, 'شاشة زجاجية بدون حواف تتعلم درجات الحرارة المفضلة وتوفر في فاتورة التكييف تلقائياً.'],
                    ['Amazon Echo Show 15 شاشة ذكية جدارية 15.6 بوصة مع تجربة Fire TV مدمجة', 279, 'شاشة عرض عائلية ذكية مع لوحات ويدجت للملاحظات والتقويم وبث مسلسلاتك المفضلة.'],
                    ['Amazon Echo Show 10 الجيل الثالث شاشة ذكية دوارة تتبع حركتك 10 بوصات', 249, 'شاشة تتحرك معك تلقائياً أثناء مكالمات الفيديو أو الطبخ في المطبخ مع كاميرا 13MP.'],
                    ['Amazon Echo Show 8 الجيل الثالث مع صوت مكاني وكاميرا مركزية', 149, 'صوت مكاني غامر مع موزع أجهزة منزلية ذكية مدمج يدعم بروتوكولات Zigbee وThread وMatter.'],
                    ['Amazon Echo Studio أقوى مكبر صوت ذكي بتقنية Dolby Atmos وSpatial Audio', 219, '5 مكبرات صوت اتجاهية تخلق مسرحاً صوتياً ثلاثي الأبعاد مع محول DAC عالي الدقة 24-bit.'],
                    ['Amazon Echo Dot الجيل الخامس مع ساعة رقمية مدمجة وشاشة LED زرقاء', 59, 'شاشة LED تعرض الوقت ودرجة الحرارة وعناوين الأغاني مع صوت أكثر وضوحاً وباس أقوى.'],
                    ['Ring Video Doorbell Pro 2 جرس باب ذكي بفيديو عالي الدقة ورؤية ثلاثية الأبعاد', 249, 'فيديو بدقة 1536p HD من الرأس حتى أخمص القدمين مع استشعار حركة راداري 3D Motion.'],
                    ['Ring Battery Doorbell Plus جرس باب لاسلكي ببطارية قابلة للإزالة', 179, 'رؤية عمودية كاملة لرؤية الطرود المتروكة عند الباب مع وضوح فائق وعمر بطارية مديد.'],
                    ['Ring Floodlight Cam Wired Pro كاميرا مراقبة مع كشافين قويين وإنذار', 249, 'كشافان LED ساطعان بقوة 2000 لومن مع صفارة إنذار 110dB وصوت ثنائي الاتجاه بنقاء فائق.'],
                    ['Ring Stick Up Cam Pro كاميرا مراقبة داخلية وخارجية لاسلكية', 179, 'تثبت في أي مكان بفضل البطارية القابلة للشحن مع فيديو HDR ورؤية ليلية ملونة.'],
                    ['Aqara Smart Lock U100 قفل باب ذكي ببصمة الإصبع ودعم Apple Home Key', 189, 'افتح باب منزلك بلمسة من ساعة Apple Watch أو iPhone حتى لو نفدت بطارية الهاتف.'],
                    ['Aqara Smart Lock U200 يدعم بروتوكول Matter وThread بدون تغيير الكالون', 249, 'يثبت فوق قفل الباب الحالي من الداخل في دقائق مع لوحة مفاتيح خارجية ببصمة الإصبع.'],
                    ['Aqara Camera Hub G3 كاميرا مراقبة ذكية مع موزع Zigbee والتعرف على الوجوه', 109, 'دقة 2K 1296p مع تتبع للحيوانات الأليفة والبشر والتحكم بالإيماءات اليدوية بالذكاء الاصطناعي.'],
                    ['Aqara Presence Sensor FP2 مستشعر وجود بشري راداري مليمتر Wave مدمج', 82, 'يحدد موقع الأشخاص في الغرفة بدقة حتى أثناء النوم أو الجلوس بدون حركة لتقسيم الغرفة لمناطق.'],
                    ['Aqara Water Leak Sensor مستشعر تسريب المياه الذكي اللاسلكي', 19, 'يطلق إنذاراً فورياً ويرسل تنبيهاً لهاتفك عند كشف أي تسريب مياه لحماية الأرضيات والأثاث.'],
                    ['TP-Link Tapo C225 كاميرا مراقبة ذكية 2K QHD دوارة مع غطاء خصوصية مادي', 69, 'تدوير 360 درجة مع وضع خصوصية مادي يغطي العدسة بالكامل وكشف بكاء الأطفال وحركة الحيوانات.'],
                    ['TP-Link Tapo C425 كاميرا مراقبة خارجية لاسلكية ببطارية تدوم 300 يوم', 119, 'قاعدة مغناطيسية سهلة التركيب مع دقة 2K QHD ورؤية ليلية ملونة ومقاومة ماء IP66.'],
                    ['TP-Link Tapo P110 فيش ذكي لقياس استهلاك الطاقة مع حماية حرارية', 19, 'تحكم في تشغيل الأجهزة الكهربائية عن بعد وجدولتها مع مراقبة استهلاك الكهرباء لحظة بلحظة.'],
                    ['SwitchBot Curtain 3 محرك ذكي لفتح وإغلاق الستائر تلقائياً بدون فك', 89, 'يركب على مسار الستائر في ثوانٍ لفتحها وإغلاقها بصوت هادئ جداً 25dB مع حساس شمسي اختياري.'],
                    ['SwitchBot Hub 2 موزع ذكي يدعم Matter مع شاشة لقياس الحرارة والرطوبة', 69, 'يحول أجهزتك القديمة التي تعمل بالريموت كنترول إلى أجهزة ذكية متوافقة مع Apple Home وGoogle.'],
                    ['Yale Assure Lock 2 Touch قفل ذكي ببصمة الإصبع وبلوتوث وواي فاي أسود', 259, 'تصميم مدمج وأنيق بدون مفاتيح مع لوحة أرقام لمسية وبصمة سريعة ومشاركة أكواد مؤقتة للضيوف.'],
                    ['Nanoleaf Shapes Hexagons باقة البداية 9 ألواح إضاءة سداسية ذكية للجدار', 199, 'ألواح إضاءة لمسية تفاعلية تتزامن مع الموسيقى وشاشة الألعاب مع ملايين الألوان والتأثيرات.'],
                    ['Nanoleaf Lines 60° باقة البداية 9 خطوط إضاءة LED خلفية ذكية', 199, 'خطوط إضاءة معمارية مستقبلية تضيء الجدار بزوايا هندسية مبهرة وتحكم عبر Matter وThread.'],
                    ['Level Lock+ قفل باب ذكي غير مرئي مدمج بالكامل داخل الباب Apple Home Keys', 329, 'القفل الذكي الوحيد الذي يختفي بالكامل داخل الباب دون أي مظهر خارجي لأجهزة إلكترونية.'],
                    ['Arlo Pro 5S 2K كاميرا مراقبة لاسلكية متطورة مع بطارية طويلة المدى', 199, 'اتصال واي فاي ثنائي النطاق مع فيديو 2K HDR فائق الوضوح وكشاف مدمج وصفارة إنذار.'],
                    ['Netatmo Smart Weather Station محطة طقس ذكية داخلية وخارجية تقيس جودة الهواء', 179, 'تقيس درجة الحرارة والرطوبة ونسبة غاز CO2 ومستوى الضوضاء داخل المنزل وخارجه بدقة.'],
                ]
            ],
        ];

        $productsBatch = [];
        $globalId = 0;

        foreach ($categoriesCatalog as $categoryName => $catInfo) {
            $defaultImg = $catInfo['img'];
            foreach ($catInfo['models'] as $model) {
                $globalId++;
                $name = $model[0];
                $price = (float)$model[1];
                $desc = $model[2];
                $img = isset($model[3]) && !empty($model[3]) ? $model[3] : $this->getProductImage($name, $categoryName, $globalId, $defaultImg);

                $hasDiscount = ($globalId % 3 == 0 || $globalId % 7 == 0);
                $oldPrice = $hasDiscount ? round($price * (1.10 + (($globalId % 15) / 100)), 2) : null;
                $rating = round(4.2 + (($globalId % 9) / 10), 1);
                if ($rating > 5.0) $rating = 5.0;

                $reviewsCount = 15 + (($globalId * 7) % 350);
                $stock = 5 + (($globalId * 13) % 95);
                $isFeatured = ($globalId % 10 == 0);

                $productsBatch[] = [
                    'name' => $name,
                    'description' => $desc,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'rating' => $rating,
                    'reviews_count' => $reviewsCount,
                    'category' => $categoryName,
                    'image_url' => $img,
                    'is_featured' => $isFeatured,
                    'stock' => $stock,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($productsBatch, 100) as $chunk) {
            Product::insert($chunk);
        }

        // 4. Reviews
        Review::truncate();
        $reviewers = [$reviewer1->id, $reviewer2->id, $reviewer3->id, $reviewer4->id];
        $comments = [
            'منتج مذهل وتجربة استخدام استثنائية! التوصيل سريع والتغليف فاخر وأصلي 100%.',
            'الجودة لا غبار عليها، أنصح الجميع باقتنائه بدون أي تردد. يستحق كل ريال.',
            'ممتاز جداً ويلبي الاحتياجات بالكامل. الأداء والجودة فوق كل التوقعات.',
            'أفضل سعر مقارنة بالسوق المحلي. الدعم الفني والمتجر تعاملهم راقي وسريع.',
            'شحن فائق السرعة وصل خلال يوم واحد فقط! المنتج تحفة فنية بكل تفاصيله.',
            'استخدمته لمدة شهر والأداء ممتاز بدون أي مشاكل. أنصح به بشدة.',
            'تصميم راقي وخامات ممتازة. يبدو أغلى بكثير من سعره الفعلي.',
            'هدية رائعة قدمتها لأخي وأعجبه جداً. التغليف كان فاخراً ومناسب للهدايا.',
        ];

        $reviewsBatch = [];
        $sampleProducts = Product::take(80)->get();
        foreach ($sampleProducts as $p) {
            $numReviews = 2 + ($p->id % 3);
            for ($r = 0; $r < $numReviews; $r++) {
                $reviewsBatch[] = [
                    'user_id' => $reviewers[($p->id + $r) % count($reviewers)],
                    'product_id' => $p->id,
                    'rating' => ($p->id % 4 == 0) ? 4 : 5,
                    'comment' => $comments[($p->id + $r) % count($comments)],
                    'created_at' => now()->subDays(($p->id + $r) % 30),
                    'updated_at' => now()->subDays(($p->id + $r) % 30),
                ];
            }
        }
        Review::insert($reviewsBatch);

        // 5. In-App Notifications
        InAppNotification::truncate();
        InAppNotification::insert([
            ['user_id' => $demoUser->id, 'title' => 'مرحباً بك في TECH MART! 🎉', 'message' => 'استمتع بخصم 20% على طلبك الأول باستخدام كود WELCOME20 عبر أكثر من 1,000 منتج.', 'type' => 'promo', 'is_read' => false, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $demoUser->id, 'title' => 'عروض الصيف الكبرى! 🔥', 'message' => 'خصومات حصرية تصل إلى 30% على الهواتف والأجهزة المحمولة والسماعات لفترة محدودة.', 'type' => 'promo', 'is_read' => false, 'created_at' => now()->subHours(3), 'updated_at' => now()->subHours(3)],
            ['user_id' => $demoUser->id, 'title' => 'كتالوج ضخم جديد 🚀', 'message' => 'تم إضافة أكثر من 1,000 منتج فريد من أقوى العلامات التجارية العالمية في جميع الأقسام.', 'type' => 'general', 'is_read' => true, 'created_at' => now()->subDay(), 'updated_at' => now()->subDay()],
        ]);

        // 6. Addresses
        UserAddress::truncate();
        UserAddress::insert([
            ['user_id' => $demoUser->id, 'title' => 'المنزل', 'recipient_name' => 'عزام أحمد', 'phone' => '+966 50 123 4567', 'city' => 'الرياض', 'street' => 'طريق الملك فهد، حي النخيل', 'details' => 'مبنى 4، الدور الثاني، شقة 203', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $demoUser->id, 'title' => 'العمل', 'recipient_name' => 'عزام أحمد', 'phone' => '+966 50 123 4567', 'city' => 'الرياض', 'street' => 'طريق التخصصي، حي العليا', 'details' => 'برج الأعمال الذكي، الدور 12', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Schema::enableForeignKeyConstraints();
    }

    private function getProductImage(string $name, string $categoryName, int $id, string $fallback): string
    {
        $n = mb_strtolower($name, 'UTF-8');

        // Apple iPhones
        if (str_contains($n, 'iphone 16 pro') || str_contains($n, '16 pro')) {
            $imgs = [
                'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        } elseif (str_contains($n, 'iphone 16') || str_contains($n, 'iphone 15') || str_contains($n, 'iphone 14') || str_contains($n, 'iphone')) {
            $imgs = [
                'https://images.unsplash.com/photo-1575695342320-d2d2d2f9b73f?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Samsung Galaxy
        if (str_contains($n, 'samsung galaxy s25') || str_contains($n, 's25 ultra') || str_contains($n, 's24 ultra') || str_contains($n, 'galaxy s')) {
            $imgs = [
                'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1567581935884-3349723552ca?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        } elseif (str_contains($n, 'fold') || str_contains($n, 'flip')) {
            $imgs = [
                'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        } elseif (str_contains($n, 'galaxy a') || str_contains($n, 'samsung')) {
            $imgs = [
                'https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Google Pixel
        if (str_contains($n, 'pixel')) {
            $imgs = [
                'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Xiaomi / Poco / OnePlus / Honor / Huawei / Redmi
        if (str_contains($n, 'xiaomi') || str_contains($n, 'poco') || str_contains($n, 'oneplus') || str_contains($n, 'honor') || str_contains($n, 'huawei') || str_contains($n, 'redmi')) {
            $imgs = [
                'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // MacBooks & Apple Laptops
        if (str_contains($n, 'macbook') || str_contains($n, 'mac') || str_contains($n, 'imac')) {
            $imgs = [
                'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Laptops - Dell, Asus, Lenovo, HP, MSI, ROG, Legion
        if (str_contains($n, 'dell') || str_contains($n, 'asus') || str_contains($n, 'lenovo') || str_contains($n, 'thinkpad') || str_contains($n, 'rog') || str_contains($n, 'legion') || str_contains($n, 'xps') || str_contains($n, 'alienware') || str_contains($n, 'حاسوب') || str_contains($n, 'لابتوب')) {
            $imgs = [
                'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Smartwatches
        if (str_contains($n, 'watch') || str_contains($n, 'ساعة') || str_contains($n, 'garmin') || str_contains($n, 'fitbit')) {
            $imgs = [
                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Headphones & Audio
        if (str_contains($n, 'airpods') || str_contains($n, 'sony wh') || str_contains($n, 'headphone') || str_contains($n, 'earbuds') || str_contains($n, 'bose') || str_contains($n, 'marshall') || str_contains($n, 'سماعة') || str_contains($n, 'صوت')) {
            $imgs = [
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1608156639585-b3a032ef9689?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Gaming Consoles & Controllers
        if (str_contains($n, 'ps5') || str_contains($n, 'playstation') || str_contains($n, 'xbox') || str_contains($n, 'nintendo') || str_contains($n, 'dualsense') || str_contains($n, 'controller') || str_contains($n, 'يد تحكم') || str_contains($n, 'ألعاب')) {
            $imgs = [
                'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1629760946220-5693ee4c46ac?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Cameras & Drones
        if (str_contains($n, 'camera') || str_contains($n, 'canon') || str_contains($n, 'nikon') || str_contains($n, 'sony a') || str_contains($n, 'dji') || str_contains($n, 'gopro') || str_contains($n, 'كاميرا') || str_contains($n, 'طائرة')) {
            $imgs = [
                'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1508614589041-895b88991e3e?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Tablets & iPads
        if (str_contains($n, 'ipad') || str_contains($n, 'tablet') || str_contains($n, 'لوحي') || str_contains($n, 'تابلت')) {
            $imgs = [
                'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&auto=format&fit=crop&q=80',
            ];
            return $imgs[$id % count($imgs)];
        }

        // Smart Home & Displays & General Gadgets
        $smartHomeImgs = [
            'https://images.unsplash.com/photo-1558002038-1055907df827?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1550009158-9effb6ba7326?w=600&auto=format&fit=crop&q=80',
        ];
        return $smartHomeImgs[$id % count($smartHomeImgs)];
    }
}
