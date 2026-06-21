<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('storefront.home', [
            'sliders' => Slider::active()->orderBy('sort_order')->get(),
            'featuredCategories' => Category::active()
                ->whereNull('parent_id')
                ->where('is_featured', true)
                ->with(['children' => fn ($query) => $query->active()->withCount('products')->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->take(8)
                ->get(),
            'categories' => Category::active()
                ->whereNull('parent_id')
                ->with(['children' => fn ($query) => $query->active()->orderBy('sort_order')])
                ->orderBy('sort_order')
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
