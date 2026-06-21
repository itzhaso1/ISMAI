@extends('layouts.app')

@section('title', $product->localizedName())
@section('meta_description', $product->{app()->getLocale() === 'ar' ? 'meta_description_ar' : 'meta_description_en'} ?: $product->localizedShortDescription())

@section('content')
@php
    $whatsappText = rawurlencode(__('messages.product.whatsapp_message', ['product' => $product->localizedName()]).' '.route('products.show', $product));
    $whatsappUrl = 'https://wa.me/'.config('services.whatsapp.number').'?text='.$whatsappText;
@endphp
<section class="section-shell product-detail">
    <div class="product-gallery">
        <img class="main-product-image" src="{{ $product->main_image_path ? asset('storage/'.$product->main_image_path) : asset('images/product-placeholder.svg') }}" alt="{{ $product->localizedName() }}">
        <div class="thumb-row">
            @foreach($product->images as $image)
                <img loading="lazy" src="{{ asset('storage/'.$image->image_path) }}" alt="{{ app()->getLocale() === 'ar' ? $image->alt_text_ar : $image->alt_text_en }}">
            @endforeach
        </div>
    </div>
    <div class="product-info">
        <span class="eyebrow">{{ $product->category?->localizedName() }}</span>
        <h1>{{ $product->localizedName() }}</h1>
        <p>{{ $product->localizedShortDescription() }}</p>
        <div class="detail-price">{{ number_format((float) $product->price, 2) }}</div>
        <div class="product-actions large">
            <a class="btn-ghost" href="{{ route('contact') }}">{{ __('messages.product.contact') }}</a>
            <a class="btn-whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('messages.product.whatsapp') }}</a>
        </div>
        <div class="detail-panel">
            <h2>{{ __('messages.product.description') }}</h2>
            <p>{{ $product->{app()->getLocale() === 'ar' ? 'description_ar' : 'description_en'} }}</p>
        </div>
        @if($product->specifications)
            <div class="detail-panel specs">
                <h2>{{ __('messages.product.specifications') }}</h2>
                @foreach($product->specifications as $key => $value)
                    <div><strong>{{ $key }}</strong><span>{{ $value }}</span></div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section-shell muted-section">
    <div class="section-heading"><h2>{{ __('messages.product.similar') }}</h2></div>
    <div class="product-grid">
        @foreach($relatedProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endsection
