<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Store Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'locale' => 'ar',
            ]
        );

        $categories = collect([
            ['معدات السلامة', 'Safety Equipment', 'safety-equipment'],
            ['العدد الصناعية', 'Industrial Tools', 'industrial-tools'],
            ['قطع الغيار', 'Spare Parts', 'spare-parts'],
            ['معدات الكهرباء', 'Electrical Equipment', 'electrical-equipment'],
        ])->map(fn ($item, $index) => Category::updateOrCreate(
            ['slug' => $item[2]],
            [
                'name_ar' => $item[0],
                'name_en' => $item[1],
                'description_ar' => 'قسم متخصص لمنتجات صناعية عالية الجودة.',
                'description_en' => 'A focused category for high-quality industrial products.',
                'sort_order' => $index + 1,
                'is_active' => true,
                'is_featured' => true,
            ]
        ));

        foreach ($categories as $category) {
            foreach (['Premium', 'Standard', 'Accessories'] as $childIndex => $suffix) {
                Category::updateOrCreate(
                    ['slug' => $category->slug.'-'.Str::slug($suffix)],
                    [
                        'parent_id' => $category->id,
                        'name_ar' => $category->name_ar.' '.$suffix,
                        'name_en' => $category->name_en.' '.$suffix,
                        'sort_order' => $childIndex + 1,
                        'is_active' => true,
                    ]
                );
            }
        }

        $brands = collect(['Atlas Pro', 'ForgeMax', 'IronLine', 'VoltEdge'])->map(fn ($name, $index) => Brand::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'sort_order' => $index + 1, 'is_active' => true]
        ));

        foreach (range(1, 9) as $index) {
            $category = $categories[($index - 1) % $categories->count()];
            $brand = $brands[($index - 1) % $brands->count()];
            Product::updateOrCreate(
                ['sku' => 'IS-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT)],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'name_ar' => 'منتج صناعي احترافي '.$index,
                    'name_en' => 'Professional Industrial Product '.$index,
                    'slug' => 'professional-industrial-product-'.$index,
                    'short_description_ar' => 'منتج موثوق للاستخدام الصناعي اليومي مع أداء ثابت.',
                    'short_description_en' => 'A reliable product for daily industrial use with consistent performance.',
                    'description_ar' => 'وصف كامل للمنتج يشمل الاستخدامات والمميزات والمواصفات المناسبة للبيئات الصناعية.',
                    'description_en' => 'Full product description covering use cases, advantages, and specifications for industrial environments.',
                    'specifications' => ['Material' => 'Industrial grade', 'Warranty' => '12 months', 'Origin' => 'Global'],
                    'price' => 120 + ($index * 35),
                    'stock_quantity' => 50,
                    'is_active' => true,
                    'is_featured' => true,
                    'meta_title_ar' => 'منتج صناعي احترافي '.$index,
                    'meta_title_en' => 'Professional Industrial Product '.$index,
                ]
            );
        }

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

        foreach ([
            ['general', 'site_name', ['ar' => 'إسماعي الصناعي', 'en' => 'ISMAI Industrial'], 'json'],
            ['contact', 'phone', ['value' => '+971500000000'], 'text'],
            ['contact', 'email', ['value' => 'sales@example.com'], 'email'],
        ] as [$group, $key, $value, $type]) {
            Setting::updateOrCreate(['key' => $key], compact('group', 'value', 'type') + ['is_public' => true]);
        }

        foreach (['LinkedIn', 'Instagram', 'X'] as $index => $platform) {
            SocialLink::updateOrCreate(
                ['platform' => strtolower($platform)],
                ['label' => $platform, 'url' => '#', 'sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
