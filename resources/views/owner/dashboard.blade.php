@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="mb-5">
        <p class="text-muted text-uppercase small mb-2">
            Owner panel
        </p>

        <h1 class="display-6 fw-light mb-2">
            Welcome, {{ auth()->user()->name }}.
        </h1>

        <p class="text-muted mb-0">
            Manage your salon services and business information.
        </p>
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <p class="text-muted text-uppercase small mb-3">
                        Total services
                    </p>

                    <h2 class="display-5 fw-light mb-0">
                        {{ $servicesCount }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <p class="text-muted text-uppercase small mb-3">
                        Active services
                    </p>

                    <h2 class="display-5 fw-light mb-0">
                        {{ $activeServicesCount }}
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <p class="text-muted text-uppercase small mb-3">
                        Inactive services
                    </p>

                    <h2 class="display-5 fw-light mb-0">
                        {{ $inactiveServicesCount }}
                    </h2>

                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

            <div
                class="d-flex flex-column flex-md-row
                       justify-content-between align-items-md-center gap-4"
            >
                <div>
                    <p class="text-muted text-uppercase small mb-2">
                        Service management
                    </p>

                    <h2 class="h3 fw-light mb-2">
                        Services
                    </h2>

                    <p class="text-muted mb-0">
                        Add, edit, activate or remove salon services.
                    </p>
                </div>

                <a
                    href="{{ route('owner.services.index') }}"
                    class="btn btn-dark px-4 py-3"
                >
                    Manage services
                </a>
                <a
    href="{{ route('owner.reservations.index') }}"
    class="btn btn-outline-dark px-4 py-3"
>
    Manage appointments
</a>
            </div>

        </div>
    </div>

</div>
@endsection