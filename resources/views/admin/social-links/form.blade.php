@extends('layouts.admin')
@section('title', $socialLink->exists ? 'Edit Social Link' : 'New Social Link')
@section('page_title', $socialLink->exists ? 'Edit Social Link' : 'New Social Link')
@section('content')
<form class="admin-panel admin-form" method="POST" action="{{ $socialLink->exists ? route('admin.social-links.update', $socialLink) : route('admin.social-links.store') }}">@csrf @if($socialLink->exists) @method('PUT') @endif
<div class="form-grid"><label>Platform<input name="platform" value="{{ old('platform', $socialLink->platform) }}" required></label><label>Label<input name="label" value="{{ old('label', $socialLink->label) }}" required></label><label>URL<input name="url" value="{{ old('url', $socialLink->url) }}" required></label><label>Icon class<input name="icon" value="{{ old('icon', $socialLink->icon) }}"></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $socialLink->sort_order ?? 0) }}"></label></div><div class="check-grid"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $socialLink->is_active ?? true))> Active</label></div><button class="btn-primary" type="submit">Save Social Link</button></form>
@endsection
