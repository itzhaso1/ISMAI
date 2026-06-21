@extends('layouts.admin')

@section('title', __('messages.admin.title'))
@section('page_title', __('messages.admin.title'))

@section('content')
<section class="admin-panel intro-panel">
    <p>{{ __('messages.admin.subtitle') }}</p>
</section>
<section class="admin-grid">
    @foreach($stats as $label => $value)
        <article class="admin-stat">
            <span>{{ ucfirst($label) }}</span>
            <strong>{{ $value }}</strong>
        </article>
    @endforeach
</section>
<section class="admin-panel">
    <h2>Quick actions</h2>
    <div class="admin-actions-grid">
        <a class="admin-action" href="{{ route('admin.products.create') }}">Add Product</a>
        <a class="admin-action" href="{{ route('admin.categories.create') }}">Add Category</a>
        <a class="admin-action" href="{{ route('admin.brands.create') }}">Add Brand</a>
        <a class="admin-action" href="{{ route('admin.sliders.create') }}">Add Slider</a>
        <a class="admin-action" href="{{ route('admin.settings.edit') }}">Edit Settings</a>
        <a class="admin-action" href="{{ route('admin.content-blocks.create') }}">Add Static Text</a>
    </div>
</section>
@endsection
