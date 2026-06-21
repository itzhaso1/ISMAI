@extends('layouts.app')

@section('title', $category->localizedName())

@section('content')
<section class="page-hero compact">
    <h1>{{ $category->localizedName() }}</h1>
    <p>{{ app()->getLocale() === 'ar' ? $category->description_ar : $category->description_en }}</p>
</section>
<section class="section-shell">
    @if($category->children->isNotEmpty())
        <div class="category-pills inline-pills">
            @foreach($category->children as $child)
                <a href="{{ route('categories.show', $child) }}">{{ $child->localizedName() }}</a>
            @endforeach
        </div>
    @endif
    <div class="product-grid">
        @forelse($products as $product)
            <x-product-card :product="$product" />
        @empty
            <div class="empty-state">{{ __('messages.nav.search_empty') }}</div>
        @endforelse
    </div>
    {{ $products->links() }}
</section>
@endsection
