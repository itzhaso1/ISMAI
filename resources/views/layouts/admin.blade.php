@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<!doctype html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.admin.title'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <a class="brand-mark admin-brand" href="{{ route('admin.dashboard') }}"><span class="brand-icon">IS</span><span class="brand-text">Admin</span></a>
        <nav>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
            <a href="{{ route('admin.products.index') }}" @class(['active' => request()->routeIs('admin.products.*')])>Products</a>
            <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>Categories</a>
            <a href="{{ route('admin.brands.index') }}" @class(['active' => request()->routeIs('admin.brands.*')])>Brands</a>
            <a href="{{ route('admin.sliders.index') }}" @class(['active' => request()->routeIs('admin.sliders.*')])>Sliders</a>
            <a href="{{ route('admin.settings.edit') }}" @class(['active' => request()->routeIs('admin.settings.*')])>Site Settings</a>
            <a href="{{ route('admin.social-links.index') }}" @class(['active' => request()->routeIs('admin.social-links.*')])>Social Links</a>
            <a href="{{ route('admin.content-blocks.index') }}" @class(['active' => request()->routeIs('admin.content-blocks.*')])>Static Texts</a>
            <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>Users</a>
            <a href="{{ route('admin.orders.index') }}" @class(['active' => request()->routeIs('admin.orders.*')])>Orders</a>
            <a href="{{ route('home') }}">Storefront</a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <span class="eyebrow">ISMAI</span>
                <h1>@yield('page_title', __('messages.admin.title'))</h1>
            </div>
            <div class="nav-actions">
                <a class="icon-button" href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}">{{ __('messages.nav.language') }}</a>
                <button class="icon-button" type="button" data-theme-toggle>◐</button>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">@csrf<button class="icon-button" type="submit">{{ __('messages.nav.logout') }}</button></form>
            </div>
        </header>

        @if(session('status'))
            <div class="admin-alert success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="admin-alert error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
