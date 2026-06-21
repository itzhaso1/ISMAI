@props(['sliders'])
@php
    $locale = app()->getLocale();
    $fallbackSlides = collect([
        [
            'title_ar' => __('messages.hero.title'),
            'title_en' => __('messages.hero.title'),
            'subtitle_ar' => __('messages.hero.subtitle'),
            'subtitle_en' => __('messages.hero.subtitle'),
            'button_text_ar' => __('messages.hero.cta'),
            'button_text_en' => __('messages.hero.cta'),
            'button_url' => route('products.index'),
            'image_path' => null,
            'overlay_color' => 'rgba(8, 8, 12, .72)',
        ],
    ]);
    $slides = $sliders->isNotEmpty() ? $sliders : $fallbackSlides;
@endphp
<section class="hero-slider" data-hero-slider>
    <div class="hero-track">
        @foreach($slides as $index => $slide)
            @php
                $isArray = is_array($slide);
                $title = $isArray ? $slide['title_'.$locale] : $slide->{'title_'.$locale};
                $subtitle = $isArray ? $slide['subtitle_'.$locale] : $slide->{'subtitle_'.$locale};
                $buttonText = $isArray ? $slide['button_text_'.$locale] : $slide->{'button_text_'.$locale};
                $buttonUrl = $isArray ? $slide['button_url'] : $slide->button_url;
                $imagePath = $isArray ? $slide['image_path'] : $slide->image_path;
                $overlay = $isArray ? $slide['overlay_color'] : $slide->overlay_color;
                $imageUrl = $imagePath ? asset('storage/'.$imagePath) : null;
            @endphp
            <article class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="--overlay: {{ $overlay }}; {{ $imageUrl ? 'background-image: linear-gradient(var(--overlay), var(--overlay)), url('.$imageUrl.');' : '' }}">
                <div class="hero-content">
                    <span class="eyebrow">{{ __('messages.hero.eyebrow') }}</span>
                    <h1>{{ $title }}</h1>
                    <p>{{ $subtitle }}</p>
                    <div class="hero-actions">
                        <a class="btn-primary" href="{{ $buttonUrl ?: route('products.index') }}">{{ $buttonText ?: __('messages.hero.cta') }}</a>
                        <a class="btn-secondary" href="{{ route('contact') }}">{{ __('messages.hero.secondary_cta') }}</a>
                    </div>
                </div>
                <div class="hero-art" aria-hidden="true">
                    <span></span><span></span><span></span>
                </div>
            </article>
        @endforeach
    </div>
    <div class="hero-dots" data-hero-dots></div>
</section>
