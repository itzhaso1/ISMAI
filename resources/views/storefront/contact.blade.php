@extends('layouts.app')

@section('title', __('messages.nav.contact'))

@section('content')
@php($intro = data_get($publicSettings->get('contact_intro'), app()->getLocale(), __('messages.footer.contact').': +'.config('services.whatsapp.number')))
<section class="page-hero compact">
    <h1>{{ __('messages.nav.contact') }}</h1>
    <p>{{ $intro }}</p>
</section>
@endsection
