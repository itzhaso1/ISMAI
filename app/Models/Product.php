<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'sku',
        'name_ar',
        'name_en',
        'slug',
        'short_description_ar',
        'short_description_en',
        'description_ar',
        'description_en',
        'specifications',
        'price',
        'compare_at_price',
        'stock_quantity',
        'main_image_path',
        'is_active',
        'is_featured',
        'meta_title_ar',
        'meta_title_en',
        'meta_description_ar',
        'meta_description_en',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($term): void {
            $builder->where('name_ar', 'like', "%{$term}%")
                ->orWhere('name_en', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhereHas('category', function (Builder $categoryQuery) use ($term): void {
                    $categoryQuery->where('name_ar', 'like', "%{$term}%")
                        ->orWhere('name_en', 'like', "%{$term}%");
                });
        });
    }

    public function localizedName(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function localizedShortDescription(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return $locale === 'ar' ? $this->short_description_ar : $this->short_description_en;
    }

    public function mainImageUrl(): string
    {
        if (! $this->main_image_path) {
            return asset('images/product-placeholder.svg');
        }

        if (str_starts_with($this->main_image_path, 'images/') || str_starts_with($this->main_image_path, 'http')) {
            return asset($this->main_image_path);
        }

        return asset('storage/'.$this->main_image_path);
    }
}
