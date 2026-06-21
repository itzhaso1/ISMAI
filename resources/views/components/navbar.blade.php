@php
    $locale = app()->getLocale();
    $nextLocale = $locale === 'ar' ? 'en' : 'ar';
    $siteName = data_get($publicSettings->get('site_name'), $locale, __('messages.brand'));
    $logoPath = data_get($publicSettings->get('logo'), 'path');
    $phone = collect($publicSettings->get('phone_numbers') ?? [data_get($publicSettings->get('phone'), 'value', '+'.config('services.whatsapp.number'))])->filter()->first();
@endphp
<header class="site-header" data-site-header>
    <div class="top-line">
        <span>{{ __('messages.hero.eyebrow') }}</span>
        <span>WhatsApp: {{ $phone }}</span>
    </div>

    <div class="nav-shell">
        <a class="brand-mark" href="{{ route('home') }}" aria-label="{{ $siteName }}">
            @if($logoPath)
                <img class="brand-logo" src="{{ asset('storage/'.$logoPath) }}" alt="{{ $siteName }}">
            @else
                <span class="brand-icon">IS</span>
            @endif
            <span class="brand-text">{{ $siteName }}</span>
        </a>

        <button class="nav-toggle" type="button" data-nav-toggle aria-controls="primary-nav" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="primary-nav" id="primary-nav" data-primary-nav>
            <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>{{ __('messages.nav.home') }}</a>
            <a href="{{ route('products.index') }}" @class(['active' => request()->routeIs('products.*')])>{{ __('messages.nav.products') }}</a>
            <a href="#category-strip">{{ __('messages.nav.categories') }}</a>
            <a href="{{ route('about') }}" @class(['active' => request()->routeIs('about')])>{{ __('messages.nav.about') }}</a>
            <a href="{{ route('contact') }}" @class(['active' => request()->routeIs('contact')])>{{ __('messages.nav.contact') }}</a>
        </nav>

        <form class="live-search" action="{{ route('products.index') }}" method="GET" data-live-search>
            <span class="search-icon">⌕</span>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.nav.search_placeholder') }}" autocomplete="off" data-search-input>
            <div class="search-results" data-search-results aria-live="polite"></div>
        </form>

        <div class="nav-actions">
            <a class="icon-button" href="{{ route('locale.switch', $nextLocale) }}">{{ __('messages.nav.language') }}</a>
            <button class="icon-button" type="button" data-theme-toggle aria-label="{{ __('messages.nav.theme') }}">◐</button>
            <a class="icon-button" href="#" aria-label="{{ __('messages.nav.cart') }}">🛒</a>
            @auth
                <a class="icon-button" href="{{ route('admin.dashboard') }}" aria-label="{{ __('messages.nav.account') }}">👤</a>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button class="link-button" type="submit">{{ __('messages.nav.logout') }}</button>
                </form>
            @else
                <a class="auth-link" href="{{ route('login') }}">{{ __('messages.nav.login') }}</a>
                <a class="auth-link filled" href="{{ route('register') }}">{{ __('messages.nav.register') }}</a>
            @endauth
        </div>
    </div>

    <x-mega-menu :categories="$navigationCategories" />
</header>
