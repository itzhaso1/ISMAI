@props(['product'])
@php
    $whatsappText = rawurlencode(__('messages.product.whatsapp_message', ['product' => $product->localizedName()]).' '.route('products.show', $product));
    $whatsappUrl = 'https://wa.me/'.config('services.whatsapp.number').'?text='.$whatsappText;
@endphp
<article class="product-card">
    <a class="product-media" href="{{ route('products.show', $product) }}">
        <img loading="lazy" src="{{ $product->main_image_path ? asset('storage/'.$product->main_image_path) : asset('images/product-placeholder.svg') }}" alt="{{ $product->localizedName() }}">
        @if($product->brand)
            <span>{{ $product->brand->name }}</span>
        @endif
    </a>
    <div class="product-body">
        <a href="{{ route('products.show', $product) }}"><h3>{{ $product->localizedName() }}</h3></a>
        <p>{{ $product->localizedShortDescription() }}</p>
        <div class="product-price">{{ number_format((float) $product->price, 2) }}</div>
        <div class="product-actions">
            <a class="btn-ghost" href="{{ route('contact') }}">{{ __('messages.product.contact') }}</a>
            <a class="btn-whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">{{ __('messages.product.whatsapp') }}</a>
        </div>
    </div>
</article>
