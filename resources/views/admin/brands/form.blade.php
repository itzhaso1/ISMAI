@extends('layouts.admin')
@section('title', $brand->exists ? 'Edit Brand' : 'New Brand')
@section('page_title', $brand->exists ? 'Edit Brand' : 'New Brand')
@section('content')
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ $brand->exists ? route('admin.brands.update', $brand) : route('admin.brands.store') }}">@csrf @if($brand->exists) @method('PUT') @endif
<div class="form-grid"><label>Name<input name="name" value="{{ old('name', $brand->name) }}" required></label><label>Slug<input name="slug" value="{{ old('slug', $brand->slug) }}"></label><label>Website URL<input name="website_url" value="{{ old('website_url', $brand->website_url) }}"></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $brand->sort_order ?? 0) }}"></label><label>Logo<input type="file" name="logo" accept="image/*"></label></div>
<div class="check-grid"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $brand->is_active ?? true))> Active</label></div><button class="btn-primary" type="submit">Save Brand</button></form>
@endsection
