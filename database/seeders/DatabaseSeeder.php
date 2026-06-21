<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $categories = $this->seedCategories();
        $brands = $this->seedBrands();
        $this->seedProducts($categories, $brands);
        $this->seedSliders();
        $this->seedSettings();
        $this->seedSocialLinks();
    }

    private function seedUsers(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Store Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'locale' => 'ar',
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedCategories()
    {
        $rootCategories = collect([
            ['معدات السلامة', 'Safety Equipment', 'safety-equipment'],
            ['العدد الصناعية', 'Industrial Tools', 'industrial-tools'],
            ['قطع الغيار', 'Spare Parts', 'spare-parts'],
        ])->map(fn (array $item, int $index) => Category::updateOrCreate(
            ['slug' => $item[2]],
            [
                'parent_id' => null,
                'name_ar' => $item[0],
                'name_en' => $item[1],
                'description_ar' => 'قسم متخصص لمنتجات صناعية عالية الجودة مع خيارات متعددة.',
                'description_en' => 'A focused category for premium industrial products with multiple options.',
                'sort_order' => $index + 1,
                'is_active' => true,
                'is_featured' => true,
            ]
        ));

        $children = [
            'safety-equipment' => [
                ['خوذات ونظارات', 'Helmets & Goggles'],
                ['قفازات وأحذية', 'Gloves & Boots'],
            ],
            'industrial-tools' => [
                ['عدد يدوية', 'Hand Tools'],
                ['معدات قياس', 'Measurement Tools'],
            ],
            'spare-parts' => [
                ['محامل وسيور', 'Bearings & Belts'],
                ['فلاتر وصمامات', 'Filters & Valves'],
            ],
        ];

        foreach ($rootCategories as $category) {
            foreach ($children[$category->slug] as $index => [$nameAr, $nameEn]) {
                Category::updateOrCreate(
                    ['slug' => $category->slug.'-'.Str::slug($nameEn)],
                    [
                        'parent_id' => $category->id,
                        'name_ar' => $nameAr,
                        'name_en' => $nameEn,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                        'is_featured' => false,
                    ]
                );
            }
        }

        return $rootCategories;
    }

    private function seedBrands()
    {
        return collect(['Atlas Pro', 'ForgeMax', 'IronLine'])->map(fn (string $name, int $index) => Brand::updateOrCreate(
            ['slug' => Str::slug($name)],
            [
                'name' => $name,
                'website_url' => 'https://example.com/'.Str::slug($name),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]
        ));
    }

    private function seedProducts($categories, $brands): void
    {
        foreach (range(1, 10) as $index) {
            $category = $categories[($index - 1) % $categories->count()];
            $brand = $brands[($index - 1) % $brands->count()];
            $product = Product::updateOrCreate(
                ['sku' => 'IS-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT)],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'name_ar' => 'منتج صناعي احترافي '.$index,
                    'name_en' => 'Professional Industrial Product '.$index,
                    'slug' => 'professional-industrial-product-'.$index,
                    'short_description_ar' => 'منتج موثوق للاستخدام الصناعي اليومي مع أداء ثابت.',
                    'short_description_en' => 'A reliable product for daily industrial use with consistent performance.',
                    'description_ar' => 'وصف كامل للمنتج يشمل الاستخدامات والمميزات والمواصفات المناسبة للبيئات الصناعية عالية المتطلبات.',
                    'description_en' => 'Full product description covering use cases, advantages, and specifications for demanding industrial environments.',
                    'specifications' => [
                        'Material' => 'Industrial grade',
                        'Warranty' => '12 months',
                        'Origin' => 'Global',
                    ],
                    'price' => 120 + ($index * 35),
                    'compare_at_price' => $index % 2 === 0 ? 165 + ($index * 35) : null,
                    'stock_quantity' => 40 + $index,
                    'main_image_path' => 'images/product-placeholder.svg',
                    'is_active' => true,
                    'is_featured' => $index <= 9,
                    'meta_title_ar' => 'منتج صناعي احترافي '.$index,
                    'meta_title_en' => 'Professional Industrial Product '.$index,
                    'meta_description_ar' => 'منتج صناعي احترافي متوفر للطلب والتواصل السريع.',
                    'meta_description_en' => 'Professional industrial product available for fast inquiries and ordering.',
                ]
            );

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'sort_order' => 1],
                [
                    'image_path' => 'images/product-placeholder.svg',
                    'alt_text_ar' => $product->name_ar,
                    'alt_text_en' => $product->name_en,
                    'is_primary' => true,
                ]
            );
        }
    }

    private function seedSliders(): void
    {
        Slider::updateOrCreate(
            ['title_en' => 'Industrial power for modern teams'],
            [
                'title_ar' => 'قوة صناعية لفرق العمل الحديثة',
                'subtitle_ar' => 'معدات وعدد وقطع غيار جاهزة للطلب والتواصل السريع.',
                'subtitle_en' => 'Equipment, tools, and spare parts ready for fast ordering and communication.',
                'button_text_ar' => 'استعرض المنتجات',
                'button_text_en' => 'Browse Products',
                'button_url' => route('products.index', [], false),
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            ['general', 'site_name', ['ar' => 'إسماعي الصناعي', 'en' => 'ISMAI Industrial'], 'json'],
            ['contact', 'phone_numbers', ['+971500000000', '+971500000001'], 'array'],
            ['contact', 'email', ['value' => 'sales@example.com'], 'email'],
            ['contact', 'address', ['ar' => 'المنطقة الصناعية، الإمارات', 'en' => 'Industrial Area, UAE'], 'json'],
            ['footer', 'footer_description', ['ar' => 'متجر صناعي حديث للمعدات والعدد ومنتجات السلامة وقطع الغيار.', 'en' => 'A modern industrial store for equipment, tools, safety products, and spare parts.'], 'json'],
            ['homepage', 'homepage_sections', ['featured_categories' => true, 'featured_products' => true, 'brands' => true], 'json'],
            ['content', 'about_intro', ['label' => 'About Intro', 'ar' => 'نقدم حلولًا صناعية موثوقة للشركات والمصانع.', 'en' => 'We provide reliable industrial solutions for companies and factories.'], 'localized_text'],
            ['content', 'contact_intro', ['label' => 'Contact Intro', 'ar' => 'تواصل معنا للحصول على عرض سعر سريع.', 'en' => 'Contact us to receive a fast quotation.'], 'localized_text'],
        ];

        foreach ($settings as [$group, $key, $value, $type]) {
            Setting::updateOrCreate(['key' => $key], [
                'group' => $group,
                'value' => $value,
                'type' => $type,
                'is_public' => true,
            ]);
        }
    }

    private function seedSocialLinks(): void
    {
        foreach ([
            ['linkedin', 'LinkedIn', 'https://www.linkedin.com'],
            ['instagram', 'Instagram', 'https://www.instagram.com'],
            ['x', 'X', 'https://x.com'],
        ] as $index => [$platform, $label, $url]) {
            SocialLink::updateOrCreate(
                ['platform' => $platform],
                ['label' => $label, 'url' => $url, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
