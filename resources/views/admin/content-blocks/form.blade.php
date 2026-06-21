@extends('layouts.admin')
@section('title', $block->exists ? 'Edit Static Text' : 'New Static Text')
@section('page_title', $block->exists ? 'Edit Static Text' : 'New Static Text')
@section('content')
<form class="admin-panel admin-form" method="POST" action="{{ $block->exists ? route('admin.content-blocks.update', $block) : route('admin.content-blocks.store') }}">@csrf @if($block->exists) @method('PUT') @endif
<div class="form-grid"><label>Key<input name="key" value="{{ old('key', $block->key) }}" required></label><label>Label<input name="label" value="{{ old('label', data_get($block->value, 'label')) }}"></label><label>Arabic text<textarea name="value_ar">{{ old('value_ar', data_get($block->value, 'ar')) }}</textarea></label><label>English text<textarea name="value_en">{{ old('value_en', data_get($block->value, 'en')) }}</textarea></label></div><div class="check-grid"><label><input type="checkbox" name="is_public" value="1" @checked(old('is_public', $block->is_public ?? true))> Public</label></div><button class="btn-primary" type="submit">Save Text Block</button></form>
@endsection
