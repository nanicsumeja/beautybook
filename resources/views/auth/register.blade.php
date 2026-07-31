@extends('layouts.app')

@section('body-class', 'campaign-register-page')
@section('main-class', '')

@section('content')

<section class="campaign-register">

    <!-- HEADER -->
    <a href="{{ route('welcome') }}" class="campaign-logo">
        BEAUTYBOOK
    </a>

    <a href="{{ route('welcome') }}" class="campaign-back">
        ← BACK
    </a>


    <!-- LIJEVA STRANA / FORMA -->
    <div class="campaign-form-side">

        <div class="campaign-form">

            <header class="campaign-heading">
                <span>JOIN BEAUTYBOOK</span>
                <h1>Create account.</h1>
            </header>


            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf


                <div class="campaign-row">

                    <div class="campaign-field">
                        <label for="name">FIRST NAME</label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            oninvalid="this.setCustomValidity('Please fill out this field.')"
                            oninput="this.setCustomValidity('')"    
                        >

                        @error('name')
                            <span class="campaign-error">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="campaign-field">
                        <label for="surname">LAST NAME</label>

                        <input
                            id="surname"
                            type="text"
                            name="surname"
                            value="{{ old('surname') }}"
                            required
                            oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                        >

                        @error('surname')
                            <span class="campaign-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>


                <div class="campaign-field">
                    <label for="username">USERNAME</label>

                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                    >

                    @error('username')
                        <span class="campaign-error">{{ $message }}</span>
                    @enderror
                </div>


                <div class="campaign-field">
                    <label for="email">EMAIL</label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                    >
                

                    @error('email')
                        <span class="campaign-error">{{ $message }}</span>
                    @enderror
                </div>


                <div class="campaign-field">
                    <label for="phone">PHONE</label>

                    <input
                        id="phone"
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                    >

                    @error('phone')
                        <span class="campaign-error">{{ $message }}</span>
                    @enderror
                </div>


                <div class="campaign-row">

                    <div class="campaign-field">
                        <label for="password">PASSWORD</label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                        >

                        @error('password')
                            <span class="campaign-error">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="campaign-field">
                        <label for="password-confirm">
                            CONFIRM PASSWORD
                        </label>

                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            required
                            oninvalid="this.setCustomValidity('Please fill out this field.')"
oninput="this.setCustomValidity('')"
                        >
                    </div>

                </div>


                <button type="submit" class="campaign-submit">
                    CREATE ACCOUNT
                </button>


                <div class="campaign-signin">
                    <span>Already have an account?</span>

                    <a href="{{ route('login') }}">
                        SIGN IN
                    </a>
                </div>

            </form>

        </div>

    </div>


    <!-- DESNA CAMPAIGN FOTOGRAFIJA -->
<div class="campaign-floating-visual">
    <img
        src="{{ asset('images/register-beauty.png') }}"
        alt="BeautyBook"
    >
</div>
</div>

</section>

@endsection