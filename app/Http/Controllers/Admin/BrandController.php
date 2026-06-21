<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(): View
    {
        return view('admin.brands.index', [
            'brands' => Brand::withCount('products')->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.brands.form', ['brand' => new Brand()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['name']);
        $data['logo_path'] = $this->storeLogo($request);
        unset($data['logo']);

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('status', 'تم إنشاء العلامة التجارية بنجاح.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $data = $this->validated($request, $brand);
        $data['slug'] = $this->slug($data['slug'] ?? $brand->slug, $data['name']);

        if ($logoPath = $this->storeLogo($request, $brand->logo_path)) {
            $data['logo_path'] = $logoPath;
        }
        unset($data['logo']);

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('status', 'تم تحديث العلامة التجارية بنجاح.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        abort_if($brand->products()->exists(), 422, 'لا يمكن حذف العلامة التجارية لأنها تحتوي على منتجات.');

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('status', 'تم حذف العلامة التجارية بنجاح.');
    }

    private function validated(Request $request, ?Brand $brand = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($brand)],
            'logo' => ['nullable', 'image', 'max:4096'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => false, 'sort_order' => 0];
    }

    private function storeLogo(Request $request, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile('logo')) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file('logo')->store('brands', 'public');
    }

    private function slug(?string $slug, string $fallback): string
    {
        $value = Str::slug($slug ?: $fallback);

        return $value !== '' ? $value : Str::random(12);
    }
}
