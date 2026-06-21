@extends('layouts.app')

@section('title', __('messages.nav.about'))

@section('content')
<section class="page-hero compact">
    <h1>{{ __('messages.nav.about') }}</h1>
    <p>{{ __('messages.footer.description') }}</p>
</section>
@endsection
