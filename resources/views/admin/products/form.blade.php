@extends('layouts.admin')
@section('title', $product->exists ? 'تعديل منتج' : 'إضافة منتج')
@section('page_title', $product->exists ? 'تعديل منتج' : 'إضافة منتج')

@section('content')
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if($product->exists)
        @method('PUT')
    @endif

    <div class="form-grid">
        <label>الاسم بالعربية<input name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required></label>
        <label>الاسم بالإنجليزية<input name="name_en" value="{{ old('name_en', $product->name_en) }}" required></label>
        <label>الرابط المختصر<input name="slug" value="{{ old('slug', $product->slug) }}"></label>
        <label>SKU <small>اختياري</small><input name="sku" value="{{ old('sku', $product->sku) }}"></label>
        <label>القسم
            <select name="category_id" required>
                <option value="">اختر القسم</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name_ar }}</option>
                @endforeach
            </select>
        </label>
        <label>العلامة التجارية
            <select name="brand_id">
                <option value="">بدون براند</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                @endforeach
            </select>
        </label>
        <label>السعر<input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required></label>
        <label>سعر المقارنة<input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}"></label>
        <label>الكمية<input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"></label>
    </div>

    <div class="form-grid">
        <label>وصف قصير بالعربية<textarea name="short_description_ar">{{ old('short_description_ar', $product->short_description_ar) }}</textarea></label>
        <label>وصف قصير بالإنجليزية<textarea name="short_description_en">{{ old('short_description_en', $product->short_description_en) }}</textarea></label>
        <label>وصف كامل بالعربية<textarea name="description_ar">{{ old('description_ar', $product->description_ar) }}</textarea></label>
        <label>وصف كامل بالإنجليزية<textarea name="description_en">{{ old('description_en', $product->description_en) }}</textarea></label>
    </div>

    <div class="form-grid">
        <label>المواصفات بصيغة JSON
            <textarea name="specifications_json" placeholder='{"Material":"Steel","Warranty":"12 months"}'>{{ old('specifications_json', $product->specifications ? json_encode($product->specifications, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
            <small>استخدم كائن JSON مثل: {"Material":"Steel"}. لا تضع رقمًا منفردًا مثل 1.</small>
        </label>
        <label>الصورة الرئيسية<input type="file" name="main_image" accept="image/*"></label>
        <label>صور إضافية<input type="file" name="images[]" accept="image/*" multiple></label>
        <label>عنوان SEO بالعربية<input name="meta_title_ar" value="{{ old('meta_title_ar', $product->meta_title_ar) }}"></label>
        <label>عنوان SEO بالإنجليزية<input name="meta_title_en" value="{{ old('meta_title_en', $product->meta_title_en) }}"></label>
        <label>وصف SEO بالعربية<textarea name="meta_description_ar">{{ old('meta_description_ar', $product->meta_description_ar) }}</textarea></label>
        <label>وصف SEO بالإنجليزية<textarea name="meta_description_en">{{ old('meta_description_en', $product->meta_description_en) }}</textarea></label>
    </div>

    <div class="check-grid">
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> نشط</label>
        <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> مميز</label>
    </div>

    <button class="btn-primary" type="submit">حفظ المنتج</button>
</form>

@if($product->exists && $product->images->isNotEmpty())
    <section class="admin-panel">
        <h2>صور المنتج</h2>
        <div class="admin-gallery">
            @foreach($product->images as $image)
                <div>
                    <img src="{{ $image->url() }}" alt="">
                    <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('هل تريد حذف هذه الصورة؟')">حذف الصورة</button>
                    </form>
                </div>
            @endforeach
        </div>
    </section>
@endif
@endsection
