@extends('layouts.admin')
@section('title', 'Site Settings')
@section('page_title', 'Site Settings Manager')
@section('content')
@php
    $phones = implode("\n", $settings->get('phone_numbers') ?? [data_get($settings->get('phone'), 'value')]);
    $sections = $settings->get('homepage_sections') ?? ['featured_categories' => true, 'featured_products' => true, 'brands' => true];
@endphp
<form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
<h2>Identity</h2><div class="form-grid"><label>Arabic site name<input name="site_name_ar" value="{{ old('site_name_ar', data_get($settings->get('site_name'), 'ar', __('messages.brand'))) }}" required></label><label>English site name<input name="site_name_en" value="{{ old('site_name_en', data_get($settings->get('site_name'), 'en', config('app.name'))) }}" required></label><label>Logo<input type="file" name="logo" accept="image/*"></label></div>
<h2>Contact</h2><div class="form-grid"><label>Phone numbers <small>one per line</small><textarea name="phone_numbers">{{ old('phone_numbers', $phones) }}</textarea></label><label>Email<input type="email" name="email" value="{{ old('email', data_get($settings->get('email'), 'value')) }}"></label><label>Arabic address<textarea name="address_ar">{{ old('address_ar', data_get($settings->get('address'), 'ar')) }}</textarea></label><label>English address<textarea name="address_en">{{ old('address_en', data_get($settings->get('address'), 'en')) }}</textarea></label></div>
<h2>Footer</h2><div class="form-grid"><label>Arabic footer content<textarea name="footer_description_ar">{{ old('footer_description_ar', data_get($settings->get('footer_description'), 'ar', __('messages.footer.description'))) }}</textarea></label><label>English footer content<textarea name="footer_description_en">{{ old('footer_description_en', data_get($settings->get('footer_description'), 'en', __('messages.footer.description'))) }}</textarea></label></div>
<h2>Homepage Sections</h2><div class="check-grid"><label><input type="checkbox" name="show_featured_categories" value="1" @checked(old('show_featured_categories', data_get($sections, 'featured_categories', true)))> Featured categories</label><label><input type="checkbox" name="show_featured_products" value="1" @checked(old('show_featured_products', data_get($sections, 'featured_products', true)))> Featured products</label><label><input type="checkbox" name="show_brands" value="1" @checked(old('show_brands', data_get($sections, 'brands', true)))> Brands slider</label></div>
<button class="btn-primary" type="submit">Save Site Settings</button></form>
@endsection
