<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\SiteSettingsManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct(private readonly SiteSettingsManager $settings)
    {
    }

    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::with(['parent'])->withCount(['children', 'products'])->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category(),
            'parents' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['name_en']);
        $data['image_path'] = $this->storeImage($request);
        unset($data['image']);

        Category::create($data);
        $this->settings->clearNavigationCache();

        return redirect()->route('admin.categories.index')->with('status', 'تم إنشاء القسم بنجاح.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', [
            'category' => $category,
            'parents' => Category::whereKeyNot($category->id)->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request, $category);
        $data['slug'] = $this->slug($data['slug'] ?? $category->slug, $data['name_en']);

        if ($imagePath = $this->storeImage($request, $category->image_path)) {
            $data['image_path'] = $imagePath;
        }
        unset($data['image']);

        $category->update($data);
        $this->settings->clearNavigationCache();

        return redirect()->route('admin.categories.index')->with('status', 'تم تحديث القسم بنجاح.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        abort_if($category->children()->exists() || $category->products()->exists(), 422, 'لا يمكن حذف القسم لأنه يحتوي على أقسام فرعية أو منتجات.');

        $category->delete();
        $this->settings->clearNavigationCache();

        return redirect()->route('admin.categories.index')->with('status', 'تم حذف القسم بنجاح.');
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category)],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + ['is_active' => false, 'is_featured' => false, 'sort_order' => 0];
    }

    private function storeImage(Request $request, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file('image')->store('categories', 'public');
    }

    private function slug(?string $slug, string $fallback): string
    {
        $value = Str::slug($slug ?: $fallback);

        return $value !== '' ? $value : Str::random(12);
    }
}
