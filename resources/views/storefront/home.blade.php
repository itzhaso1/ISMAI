@extends('layouts.app')

@section('title', __('messages.home.meta_title'))

@section('content')
    <x-hero-slider :sliders="$sliders" />

    @if(data_get($sections, 'featured_categories', true))
    <section class="section-shell">
        <div class="section-heading">
            <span>{{ __('messages.nav.categories') }}</span>
            <h2>{{ __('messages.home.featured_categories') }}</h2>
            <p>{{ __('messages.home.featured_categories_subtitle') }}</p>
        </div>
        <div class="category-carousel">
            @forelse($featuredCategories as $category)
                <article class="category-card">
                    <div class="category-card-image">
                        <img loading="lazy" src="{{ $category->image_path ? asset('storage/'.$category->image_path) : asset('images/category-placeholder.svg') }}" alt="{{ $category->localizedName() }}">
                    </div>
                    <div>
                        <h3>{{ $category->localizedName() }}</h3>
                        <p>{{ $category->children->pluck(app()->getLocale() === 'ar' ? 'name_ar' : 'name_en')->take(3)->join(' / ') }}</p>
                        <a href="{{ route('categories.show', $category) }}">{{ __('messages.home.view_products') }}</a>
                    </div>
                </article>
            @empty
                <article class="category-card placeholder-card">
                    <div>
                        <h3>{{ __('messages.home.featured_categories') }}</h3>
                        <p>{{ __('messages.home.featured_categories_subtitle') }}</p>
                        <a href="{{ route('products.index') }}">{{ __('messages.home.view_products') }}</a>
                    </div>
                </article>
            @endforelse
        </div>
    </section>
    @endif

    @if(data_get($sections, 'featured_products', true))
    <section class="section-shell muted-section">
        <div class="section-heading split-heading">
            <div>
                <span>{{ __('messages.nav.products') }}</span>
                <h2>{{ __('messages.home.featured_products') }}</h2>
                <p>{{ __('messages.home.featured_products_subtitle') }}</p>
            </div>
            <a class="section-link" href="{{ route('products.index') }}">{{ __('messages.home.view_products') }}</a>
        </div>
        <div class="product-grid">
            @forelse($featuredProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="empty-state">{{ __('messages.nav.search_empty') }}</div>
            @endforelse
        </div>
    </section>
    @endif

    @if(data_get($sections, 'brands', true))
    <section class="section-shell brands-section">
        <div class="section-heading">
            <span>{{ __('messages.home.brands') }}</span>
            <h2>{{ __('messages.home.brands') }}</h2>
            <p>{{ __('messages.home.brands_subtitle') }}</p>
        </div>
        <div class="brands-track">
            <div class="brands-runner">
                @forelse($brands->concat($brands) as $brand)
                    <a class="brand-card" href="{{ $brand->website_url ?: route('products.index', ['brand' => $brand->slug]) }}">
                        @if($brand->logo_path)
                            <img loading="lazy" src="{{ asset('storage/'.$brand->logo_path) }}" alt="{{ $brand->name }}">
                        @else
                            <span>{{ $brand->name }}</span>
                        @endif
                    </a>
                @empty
                    @foreach(['Atlas', 'ForgeMax', 'IronPro', 'SafeLine', 'VoltEdge', 'MechaTek'] as $brandName)
                        <span class="brand-card">{{ $brandName }}</span>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
    @endif
@endsection
