@extends('layouts.app')

@section('content')

<div class="forgot-password-page">

    <a href="{{ url('/') }}" class="forgot-logo">
        BEAUTYBOOK
    </a>

    <a href="{{ route('login') }}" class="forgot-back">
        BACK
    </a>

    <div class="forgot-password-shell">

        <div class="forgot-password-form">

            <div class="forgot-heading">
                <span>BEAUTYBOOK ACCOUNT</span>

                <h1>Forgot password?</h1>

                <p>
                    Enter your email address and we'll send you
                    a link to reset your password.
                </p>
            </div>


            @if (session('status'))
                <div class="forgot-success">
                    {{ session('status') }}
                </div>
            @endif


            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="forgot-field">

                    <label for="email">
                        EMAIL ADDRESS
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror"
                        required
                        autocomplete="email"
                        autofocus
                    >

                    @error('email')
                        <span class="forgot-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <button type="submit" class="forgot-submit">
                    SEND RESET LINK
                </button>

            </form>


            <div class="forgot-login">

                <span>Remember your password?</span>

                <a href="{{ route('login') }}">
                    SIGN IN
                </a>

            </div>

        </div>

    </div>

</div>

@endsection