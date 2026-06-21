@extends('layouts.admin')
@section('title', $category->exists ? 'تعديل قسم' : 'إضافة قسم')
@section('page_title', $category->exists ? 'تعديل قسم' : 'إضافة قسم')
@section('content')
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
@csrf @if($category->exists) @method('PUT') @endif
<div class="form-grid"><label>الاسم بالعربية<input name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required></label><label>الاسم بالإنجليزية<input name="name_en" value="{{ old('name_en', $category->name_en) }}" required></label><label>الرابط المختصر<input name="slug" value="{{ old('slug', $category->slug) }}"></label><label>القسم الأب<select name="parent_id"><option value="">قسم رئيسي</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name_ar }}</option>@endforeach</select></label><label>ترتيب العرض<input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"></label><label>صورة القسم<input type="file" name="image" accept="image/*"></label></div>
<div class="form-grid"><label>الوصف بالعربية<textarea name="description_ar">{{ old('description_ar', $category->description_ar) }}</textarea></label><label>الوصف بالإنجليزية<textarea name="description_en">{{ old('description_en', $category->description_en) }}</textarea></label></div>
<div class="check-grid"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> نشط</label><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $category->is_featured))> مميز في الرئيسية</label></div>
<button class="btn-primary" type="submit">حفظ القسم</button>
</form>
@endsection
