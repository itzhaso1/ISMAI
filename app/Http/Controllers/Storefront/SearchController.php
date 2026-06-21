<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request): JsonResponse
    {
        $term = trim($request->string('q')->toString());

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->with('category')
            ->search($term)
            ->limit(8)
            ->get()
            ->map(fn (Product $product) => [
                'name' => $product->localizedName(),
                'category' => $product->category?->localizedName(),
                'price' => number_format((float) $product->price, 2),
                'image' => $product->main_image_path ? asset('storage/'.$product->main_image_path) : asset('images/product-placeholder.svg'),
                'url' => route('products.show', $product),
            ]);

        return response()->json($products);
    }
}
