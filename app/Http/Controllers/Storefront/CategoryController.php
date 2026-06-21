<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        abort_unless($category->is_active, 404);

        return view('storefront.categories.show', [
            'category' => $category->load(['children' => fn ($query) => $query->active()->orderBy('sort_order')]),
            'products' => Product::active()
                ->where('category_id', $category->id)
                ->with(['category', 'brand'])
                ->latest()
                ->paginate(12),
        ]);
    }
}
