@extends('layouts.admin')
@section('title', 'إعدادات الموقع')
@section('page_title', 'مدير إعدادات الموقع')
@section('content')
@php
    $phones = implode("\n", $settings->get('phone_numbers') ?? [data_get($settings->get('phone'), 'value')]);
    $sections = $settings->get('homepage_sections') ?? ['featured_categories' => true, 'featured_products' => true, 'brands' => true];
@endphp
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
<h2>هوية الموقع</h2><div class="form-grid"><label>اسم الموقع بالعربية<input name="site_name_ar" value="{{ old('site_name_ar', data_get($settings->get('site_name'), 'ar', __('messages.brand'))) }}" required></label><label>اسم الموقع بالإنجليزية<input name="site_name_en" value="{{ old('site_name_en', data_get($settings->get('site_name'), 'en', config('app.name'))) }}" required></label><label>اللوجو<input type="file" name="logo" accept="image/*"></label></div>
<h2>معلومات التواصل</h2><div class="form-grid"><label>أرقام الهاتف <small>كل رقم في سطر</small><textarea name="phone_numbers">{{ old('phone_numbers', $phones) }}</textarea></label><label>البريد الإلكتروني<input type="email" name="email" value="{{ old('email', data_get($settings->get('email'), 'value')) }}"></label><label>العنوان بالعربية<textarea name="address_ar">{{ old('address_ar', data_get($settings->get('address'), 'ar')) }}</textarea></label><label>العنوان بالإنجليزية<textarea name="address_en">{{ old('address_en', data_get($settings->get('address'), 'en')) }}</textarea></label></div>
<h2>الفوتر</h2><div class="form-grid"><label>محتوى الفوتر بالعربية<textarea name="footer_description_ar">{{ old('footer_description_ar', data_get($settings->get('footer_description'), 'ar', __('messages.footer.description'))) }}</textarea></label><label>محتوى الفوتر بالإنجليزية<textarea name="footer_description_en">{{ old('footer_description_en', data_get($settings->get('footer_description'), 'en', __('messages.footer.description'))) }}</textarea></label></div>
<h2>أقسام الصفحة الرئيسية</h2><div class="check-grid"><label><input type="checkbox" name="show_featured_categories" value="1" @checked(old('show_featured_categories', data_get($sections, 'featured_categories', true)))> إظهار الأقسام</label><label><input type="checkbox" name="show_featured_products" value="1" @checked(old('show_featured_products', data_get($sections, 'featured_products', true)))> إظهار المنتجات المميزة</label><label><input type="checkbox" name="show_brands" value="1" @checked(old('show_brands', data_get($sections, 'brands', true)))> إظهار العلامات التجارية</label></div>
<button class="btn-primary" type="submit">حفظ الإعدادات</button></form>
@endsection
