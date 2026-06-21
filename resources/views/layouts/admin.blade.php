@php
    $locale = app()->getLocale();
    $dir = 'rtl';
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <a class="brand-mark admin-brand" href="{{ route('admin.dashboard') }}"><span class="brand-icon">IS</span><span class="brand-text">لوحة التحكم</span></a>
        <nav>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>الرئيسية</a>
            <a href="{{ route('admin.products.index') }}" @class(['active' => request()->routeIs('admin.products.*')])>المنتجات</a>
            <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>الأقسام</a>
            <a href="{{ route('admin.brands.index') }}" @class(['active' => request()->routeIs('admin.brands.*')])>العلامات التجارية</a>
            <a href="{{ route('admin.sliders.index') }}" @class(['active' => request()->routeIs('admin.sliders.*')])>السلايدر</a>
            <a href="{{ route('admin.settings.edit') }}" @class(['active' => request()->routeIs('admin.settings.*')])>إعدادات الموقع</a>
            <a href="{{ route('admin.social-links.index') }}" @class(['active' => request()->routeIs('admin.social-links.*')])>وسائل التواصل</a>
            <a href="{{ route('admin.content-blocks.index') }}" @class(['active' => request()->routeIs('admin.content-blocks.*')])>النصوص الثابتة</a>
            <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>المستخدمون</a>
            <a href="{{ route('admin.orders.index') }}" @class(['active' => request()->routeIs('admin.orders.*')])>الطلبات</a>
            <a href="{{ route('home') }}">عرض الموقع</a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <span class="eyebrow">ISMAI</span>
                <h1>@yield('page_title', 'لوحة التحكم')</h1>
            </div>
            <div class="nav-actions">
                <a class="icon-button" href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}">{{ __('messages.nav.language') }}</a>
                <button class="icon-button" type="button" data-theme-toggle>◐</button>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">@csrf<button class="icon-button" type="submit">تسجيل الخروج</button></form>
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
