@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('page_title', $category->exists ? 'Edit Category' : 'New Category')
@section('content')
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
@csrf @if($category->exists) @method('PUT') @endif
<div class="form-grid"><label>Arabic name<input name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required></label><label>English name<input name="name_en" value="{{ old('name_en', $category->name_en) }}" required></label><label>Slug<input name="slug" value="{{ old('slug', $category->slug) }}"></label><label>Parent<select name="parent_id"><option value="">Root category</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name_en }}</option>@endforeach</select></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"></label><label>Image<input type="file" name="image" accept="image/*"></label></div>
<div class="form-grid"><label>Arabic description<textarea name="description_ar">{{ old('description_ar', $category->description_ar) }}</textarea></label><label>English description<textarea name="description_en">{{ old('description_en', $category->description_en) }}</textarea></label></div>
<div class="check-grid"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Active</label><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $category->is_featured))> Featured</label></div>
<button class="btn-primary" type="submit">Save Category</button>
</form>
@endsection
