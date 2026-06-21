@extends('layouts.app')

@section('title', __('messages.nav.about'))

@section('content')
@php($intro = data_get($publicSettings->get('about_intro'), app()->getLocale(), __('messages.footer.description')))
<section class="page-hero compact">
    <h1>{{ __('messages.nav.about') }}</h1>
    <p>{{ $intro }}</p>
</section>
@endsection
