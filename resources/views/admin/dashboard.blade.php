@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('page_title', 'لوحة التحكم')

@section('content')
@php
    $labels = [
        'products' => 'المنتجات',
        'categories' => 'الأقسام',
        'brands' => 'العلامات التجارية',
        'sliders' => 'السلايدر',
        'orders' => 'الطلبات',
        'users' => 'المستخدمون',
        'settings' => 'الإعدادات',
        'social links' => 'وسائل التواصل',
    ];
@endphp
<section class="admin-panel intro-panel">
    <p>من هنا يمكنك التحكم الكامل بالمنتجات، الأقسام، السلايدر، العلامات التجارية، الفوتر، إعدادات الموقع، الطلبات، والمستخدمين بدون تعديل الكود.</p>
</section>
<section class="admin-grid">
    @foreach($stats as $label => $value)
        <article class="admin-stat">
            <span>{{ $labels[$label] ?? $label }}</span>
            <strong>{{ $value }}</strong>
        </article>
    @endforeach
</section>
<section class="admin-panel">
    <h2>إجراءات سريعة</h2>
    <div class="admin-actions-grid">
        <a class="admin-action" href="{{ route('admin.products.create') }}">إضافة منتج</a>
        <a class="admin-action" href="{{ route('admin.categories.create') }}">إضافة قسم</a>
        <a class="admin-action" href="{{ route('admin.brands.create') }}">إضافة علامة تجارية</a>
        <a class="admin-action" href="{{ route('admin.sliders.create') }}">إضافة سلايدر</a>
        <a class="admin-action" href="{{ route('admin.settings.edit') }}">تعديل الإعدادات</a>
        <a class="admin-action" href="{{ route('admin.content-blocks.create') }}">إضافة نص ثابت</a>
    </div>
</section>
@endsection
