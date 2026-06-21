<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'brand'])
            ->withCount('images')
            ->search($request->string('q')->toString())
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status')->toString() === 'active'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(['is_active' => true]),
            'categories' => Category::active()->orderBy('sort_order')->get(),
            'brands' => Brand::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['name_en']);
        $data['sku'] = $data['sku'] ?: $this->nextSku();
        $data['specifications'] = $this->decodeSpecifications($request->input('specifications_json'));
        unset($data['main_image'], $data['images'], $data['specifications_json']);

        if ($request->hasFile('main_image')) {
            $data['main_image_path'] = $request->file('main_image')->store('products', 'public');
        }

        $product = Product::create($data);
        $this->storeImages($request, $product);

        if (! $product->main_image_path && $product->images()->exists()) {
            $product->update(['main_image_path' => $product->images()->first()->image_path]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product->load('images'),
            'categories' => Category::orderBy('sort_order')->get(),
            'brands' => Brand::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product);
        $data['slug'] = $this->slug($data['slug'] ?? $product->slug, $data['name_en']);
        $data['sku'] = $data['sku'] ?: $product->sku ?: $this->nextSku();
        $data['specifications'] = $this->decodeSpecifications($request->input('specifications_json'));
        unset($data['main_image'], $data['images'], $data['specifications_json']);

        if ($request->hasFile('main_image')) {
            if ($product->main_image_path) {
                Storage::disk('public')->delete($product->main_image_path);
            }
            $data['main_image_path'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);
        $this->storeImages($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->main_image_path) {
            Storage::disk('public')->delete($product->main_image_path);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }

    public function destroyImage(Product $product, ProductImage $image): RedirectResponse
    {
        abort_unless($image->product_id === $product->id, 404);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('status', 'Product image deleted successfully.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')->whereNull('deleted_at')],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product)],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product)],
            'short_description_ar' => ['nullable', 'string'],
            'short_description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'specifications_json' => ['nullable', 'json'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'main_image' => ['nullable', 'image', 'max:4096'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string'],
            'meta_description_en' => ['nullable', 'string'],
        ]) + ['is_active' => false, 'is_featured' => false, 'stock_quantity' => 0];
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $index => $image) {
            $product->images()->create([
                'image_path' => $image->store('products/gallery', 'public'),
                'alt_text_ar' => $product->name_ar,
                'alt_text_en' => $product->name_en,
                'sort_order' => $index,
                'is_primary' => ! $product->images()->exists(),
            ]);
        }
    }

    private function decodeSpecifications(?string $json): ?array
    {
        if (! $json) {
            return null;
        }

        return json_decode($json, true, flags: JSON_THROW_ON_ERROR);
    }

    private function nextSku(): string
    {
        return 'IS-'.now()->format('ymdHis').'-'.Str::upper(Str::random(4));
    }

    private function slug(?string $slug, string $fallback): string
    {
        $value = Str::slug($slug ?: $fallback);

        return $value !== '' ? $value : Str::random(12);
    }
}
