@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel vlasnice</h1>

    <p>Dobrodošli, {{ Auth::user()->name }}!</p>

    <p>Uloga: {{ Auth::user()->role }}</p>
</div>
@endsection