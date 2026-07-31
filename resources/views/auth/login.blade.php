@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Prijava
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Korisničko ime -->
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">
                                Korisničko ime
                            </label>

                            <div class="col-md-6">
                                <input
                                    id="username"
                                    type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    name="username"
                                    value="{{ old('username') }}"
                                    required
                                    autocomplete="username"
                                    autofocus
                                >

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Lozinka -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                Lozinka
                            </label>

                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Zapamti me -->
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >

                                    <label class="form-check-label" for="remember">
                                        Zapamti me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Dugme -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Prijavi se
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Zaboravili ste lozinku?
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection