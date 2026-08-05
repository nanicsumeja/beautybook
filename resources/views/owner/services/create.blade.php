@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 760px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-1">SERVICES</p>
            <h1 class="h3 mb-0">Add new service</h1>
        </div>

        <a
            href="{{ route('owner.services.index') }}"
            class="btn btn-outline-dark"
        >
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form
                method="POST"
                action="{{ route('owner.services.store') }}"
                novalidate
            >
                @csrf

                @include('owner.services._form')

                <button type="submit" class="btn btn-dark px-4">
                    Save service
                </button>
            </form>

        </div>
    </div>

</div>
@endsection