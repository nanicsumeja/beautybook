@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Klijentski panel</h1>

    <p>Dobrodošli, {{ Auth::user()->name }}!</p>

    <p>Uloga: {{ Auth::user()->role }}</p>
    <a
    href="{{ route('client.services.index') }}"
    class="btn btn-dark"
>
    Browse services
</a>
<a
    href="{{ route('client.reservations.index') }}"
    class="btn btn-outline-dark"
>
    My appointments
</a>
</div>
@endsection