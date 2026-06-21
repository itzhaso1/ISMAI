@extends('layouts.admin')
@section('title', $block->exists ? 'تعديل نص ثابت' : 'إضافة نص ثابت')
@section('page_title', $block->exists ? 'تعديل نص ثابت' : 'إضافة نص ثابت')
@section('content')
<form class="admin-panel admin-form" method="POST" action="{{ $block->exists ? route('admin.content-blocks.update', $block) : route('admin.content-blocks.store') }}">@csrf @if($block->exists) @method('PUT') @endif
<div class="form-grid"><label>المفتاح<input name="key" value="{{ old('key', $block->key) }}" required></label><label>الاسم الإداري<input name="label" value="{{ old('label', data_get($block->value, 'label')) }}"></label><label>النص بالعربية<textarea name="value_ar">{{ old('value_ar', data_get($block->value, 'ar')) }}</textarea></label><label>النص بالإنجليزية<textarea name="value_en">{{ old('value_en', data_get($block->value, 'en')) }}</textarea></label></div><div class="check-grid"><label><input type="checkbox" name="is_public" value="1" @checked(old('is_public', $block->is_public ?? true))> عام</label></div><button class="btn-primary" type="submit">حفظ النص</button></form>
@endsection
