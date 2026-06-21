@extends('layouts.app')

@section('title', __('messages.nav.products'))

@section('content')
<section class="page-hero compact">
    <h1>{{ __('messages.nav.products') }}</h1>
    <p>{{ __('messages.home.featured_products_subtitle') }}</p>
</section>

<section class="section-shell catalog-layout">
    <aside class="filter-panel">
        <h2>{{ __('messages.product.filter') }}</h2>
        <form method="GET" action="{{ route('products.index') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.nav.search_placeholder') }}">
            <select name="category">
                <option value="">{{ __('messages.product.all_categories') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->localizedName() }}</option>
                @endforeach
            </select>
            <select name="brand">
                <option value="">{{ __('messages.product.all_brands') }}</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->name }}</option>
                @endforeach
            </select>
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('messages.product.price_from') }}">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('messages.product.price_to') }}">
            <button class="btn-primary" type="submit">{{ __('messages.product.apply') }}</button>
        </form>
    </aside>

    <div class="catalog-products">
        <div class="product-grid">
            @forelse($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="empty-state">{{ __('messages.nav.search_empty') }}</div>
            @endforelse
        </div>
        {{ $products->links() }}
    </div>
</section>
@endsection
