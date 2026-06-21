@extends('layouts.app')

@section('title', __('messages.nav.contact'))

@section('content')
<section class="page-hero compact">
    <h1>{{ __('messages.nav.contact') }}</h1>
    <p>{{ __('messages.footer.contact') }}: +{{ config('services.whatsapp.number') }}</p>
</section>
@endsection
