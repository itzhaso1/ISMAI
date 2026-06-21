@extends('layouts.app')

@section('title', __('messages.admin.title'))

@section('content')
<section class="page-hero compact admin-hero">
    <h1>{{ __('messages.admin.title') }}</h1>
    <p>{{ __('messages.admin.subtitle') }}</p>
</section>
<section class="section-shell admin-grid">
    @foreach($stats as $label => $value)
        <article class="admin-stat">
            <span>{{ ucfirst($label) }}</span>
            <strong>{{ $value }}</strong>
        </article>
    @endforeach
</section>
@endsection
