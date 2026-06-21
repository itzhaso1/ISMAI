<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->active()
            ->with(['category', 'brand'])
            ->search($request->string('q')->toString())
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category'))))
            ->when($request->filled('brand'), fn ($query) => $query->whereHas('brand', fn ($brand) => $brand->where('slug', $request->string('brand'))))
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->decimal('min_price')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->decimal('max_price')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('storefront.products.index', [
            'products' => $products,
            'categories' => Category::active()->whereNull('parent_id')->orderBy('sort_order')->get(),
            'brands' => Brand::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'brand', 'images']);

        return view('storefront.products.show', [
            'product' => $product,
            'relatedProducts' => Product::active()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->getKey())
                ->with(['category', 'brand'])
                ->take(6)
                ->get(),
        ]);
    }
}
