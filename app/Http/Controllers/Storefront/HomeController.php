<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Services\SiteSettingsManager;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly SiteSettingsManager $settings)
    {
    }

    public function __invoke(): View
    {
        $sections = $this->settings->value('homepage_sections', [
            'featured_categories' => true,
            'featured_products' => true,
            'brands' => true,
        ]);

        return view('storefront.home', [
            'sections' => $sections,
            'sliders' => Slider::active()->orderBy('sort_order')->get(),
            'featuredCategories' => Category::active()
                ->whereNull('parent_id')
                ->where('is_featured', true)
                ->with(['children' => fn ($query) => $query->active()->withCount('products')->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->take(8)
                ->get(),
            'featuredProducts' => Product::active()
                ->featured()
                ->with(['category', 'brand', 'images'])
                ->latest()
                ->take(9)
                ->get(),
            'brands' => Brand::active()->orderBy('sort_order')->get(),
        ]);
    }
}
