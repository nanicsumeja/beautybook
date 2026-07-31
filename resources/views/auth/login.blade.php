@extends('layouts.app')

@section('body-class', 'lux-auth-page')
@section('main-class', '')

@section('content')

<section class="lux-login">

    <img
        src="{{ asset('images/beauty-hero.png') }}"
        alt=""
        class="lux-login-background"
    >

    <div class="lux-login-overlay"></div>

    <a href="{{ route('welcome') }}" class="lux-login-logo">
        BEAUTYBOOK
    </a>

    <a href="{{ route('welcome') }}" class="lux-back">
         BACK
    </a>

    <div class="lux-login-form">

        <div class="lux-login-heading">
            <span>SIGN IN</span>
            <h2>Welcome back.</h2>
        </div>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="lux-field">

                <label for="username">
                    USERNAME
                </label>

                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    required
                    autofocus
                >

                @error('username')
                    <span class="lux-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="lux-field">

                <label for="password">
                    PASSWORD
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <span class="lux-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="lux-login-options">

                <label class="lux-remember">

                    <input
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <span>Remember me</span>

                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif

            </div>


            <button type="submit" class="lux-submit">
                SIGN IN
            </button>


            @if (Route::has('register'))

                <div class="lux-register">

                    <span>New here?</span>

                    <a href="{{ route('register') }}">
                        CREATE ACCOUNT
                    </a>

                </div>

            @endif

        </form>

    </div>

    

</section>

@endsection