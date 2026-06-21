@extends('layouts.app')

@section('title', __('messages.auth.forgot_title'))

@section('content')
<section class="auth-shell">
    <form class="auth-card" method="POST" action="{{ route('password.email') }}">
        @csrf
        <h1>{{ __('messages.auth.forgot_title') }}</h1>
        @if(session('status'))<div class="form-success">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="form-error">{{ $errors->first() }}</div>@endif
        <label>{{ __('messages.auth.email') }}<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <button class="btn-primary" type="submit">{{ __('messages.auth.send_reset') }}</button>
    </form>
</section>
@endsection
