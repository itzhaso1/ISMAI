@php
    $locale = app()->getLocale();
    $siteName = data_get($publicSettings->get('site_name'), $locale, __('messages.brand'));
    $phone = data_get($publicSettings->get('phone'), 'value', '+'.config('services.whatsapp.number'));
    $email = data_get($publicSettings->get('email'), 'value', 'sales@example.com');
@endphp
<footer class="site-footer">
    <div class="footer-grid">
        <div>
            <a class="brand-mark footer-brand" href="{{ route('home') }}"><span class="brand-icon">IS</span><span class="brand-text">{{ $siteName }}</span></a>
            <p>{{ __('messages.footer.description') }}</p>
        </div>
        <div>
            <h3>{{ __('messages.footer.quick_links') }}</h3>
            <a href="{{ route('home') }}">{{ __('messages.nav.home') }}</a>
            <a href="{{ route('products.index') }}">{{ __('messages.nav.products') }}</a>
            <a href="{{ route('about') }}">{{ __('messages.nav.about') }}</a>
            <a href="{{ route('contact') }}">{{ __('messages.nav.contact') }}</a>
        </div>
        <div>
            <h3>{{ __('messages.footer.contact') }}</h3>
            <span>{{ $phone }}</span>
            <span>{{ $email }}</span>
            <div class="social-links">
                @forelse($socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank" rel="noopener">{{ $link->label }}</a>
                @empty
                    <a href="#">LinkedIn</a><a href="#">Instagram</a><a href="#">X</a>
                @endforelse
            </div>
        </div>
        <div>
            <h3>{{ __('messages.footer.newsletter') }}</h3>
            <p>{{ __('messages.footer.newsletter_hint') }}</p>
            <form class="newsletter-form">
                <input type="email" placeholder="{{ __('messages.footer.email_placeholder') }}">
                <button type="button">{{ __('messages.footer.subscribe') }}</button>
            </form>
        </div>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} {{ $siteName }}. {{ __('messages.footer.rights') }}</div>
</footer>
