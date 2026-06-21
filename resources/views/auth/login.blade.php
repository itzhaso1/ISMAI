@extends('layouts.app')

@section('title', __('messages.auth.login_title'))

@section('content')
<section class="auth-shell">
    <form class="auth-card" method="POST" action="{{ route('login.store') }}">
        @csrf
        <h1>{{ __('messages.auth.login_title') }}</h1>
        @if($errors->any())<div class="form-error">{{ $errors->first() }}</div>@endif
        <label>{{ __('messages.auth.email') }}<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <label>{{ __('messages.auth.password') }}<input type="password" name="password" required></label>
        <label class="check-row"><input type="checkbox" name="remember"> {{ __('messages.auth.remember') }}</label>
        <button class="btn-primary" type="submit">{{ __('messages.nav.login') }}</button>
        <a href="{{ route('password.request') }}">{{ __('messages.auth.forgot') }}</a>
    </form>
</section>
@endsection
