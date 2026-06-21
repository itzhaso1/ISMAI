@extends('layouts.admin')
@section('title', $socialLink->exists ? 'تعديل رابط تواصل' : 'إضافة رابط تواصل')
@section('page_title', $socialLink->exists ? 'تعديل رابط تواصل' : 'إضافة رابط تواصل')
@section('content')
<form class="admin-panel admin-form" method="POST" action="{{ $socialLink->exists ? route('admin.social-links.update', $socialLink) : route('admin.social-links.store') }}">@csrf @if($socialLink->exists) @method('PUT') @endif
<div class="form-grid"><label>المنصة<input name="platform" value="{{ old('platform', $socialLink->platform) }}" required></label><label>الاسم الظاهر<input name="label" value="{{ old('label', $socialLink->label) }}" required></label><label>الرابط<input name="url" value="{{ old('url', $socialLink->url) }}" required></label><label>أيقونة CSS<input name="icon" value="{{ old('icon', $socialLink->icon) }}"></label><label>ترتيب العرض<input type="number" name="sort_order" value="{{ old('sort_order', $socialLink->sort_order ?? 0) }}"></label></div><div class="check-grid"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $socialLink->is_active ?? true))> نشط</label></div><button class="btn-primary" type="submit">حفظ رابط التواصل</button></form>
@endsection
