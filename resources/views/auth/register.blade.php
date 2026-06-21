@extends('layouts.app')

@section('title', __('messages.auth.register_title'))

@section('content')
<section class="auth-shell">
    <form class="auth-card" method="POST" action="{{ route('register.store') }}">
        @csrf
        <h1>{{ __('messages.auth.register_title') }}</h1>
        @if($errors->any())<div class="form-error">{{ $errors->first() }}</div>@endif
        <label>{{ __('messages.auth.name') }}<input type="text" name="name" value="{{ old('name') }}" required></label>
        <label>{{ __('messages.auth.email') }}<input type="email" name="email" value="{{ old('email') }}" required></label>
        <label>{{ __('messages.auth.phone') }}<input type="text" name="phone" value="{{ old('phone') }}"></label>
        <label>{{ __('messages.auth.password') }}<input type="password" name="password" required></label>
        <label>{{ __('messages.auth.password_confirmation') }}<input type="password" name="password_confirmation" required></label>
        <button class="btn-primary" type="submit">{{ __('messages.nav.register') }}</button>
    </form>
</section>
@endsection
