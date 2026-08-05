@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start mb-5">
        <div>
            <p class="text-muted text-uppercase small mb-2">
                BeautyBook
            </p>

            <h1 class="display-6 fw-light mb-2">
                Our services
            </h1>

            <p class="text-muted mb-0">
                Explore available salon services.
            </p>
        </div>

        <a
            href="{{ route('client.dashboard') }}"
            class="btn btn-outline-dark"
        >
            Back
        </a>
    </div>

    @if ($services->isEmpty())

        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <h2 class="h5 fw-normal mb-2">
                    No services available
                </h2>

                <p class="text-muted mb-0">
                    There are currently no active services.
                </p>
            </div>
        </div>

    @else

        <div class="row g-4">

            @foreach ($services as $service)
                <div class="col-md-6 col-lg-4">

                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="mb-4">
                                <p class="text-muted text-uppercase small mb-2">
                                    {{ $service->duration_minutes }} minutes
                                </p>

                                <h2 class="h4 fw-light mb-3">
                                    {{ $service->name }}
                                </h2>

                                @if ($service->description)
                                    <p class="text-muted mb-0">
                                        {{ $service->description }}
                                    </p>
                                @endif
                            </div>

                            <div
                                class="mt-auto pt-4 border-top
                                       d-flex justify-content-between
                                       align-items-center"
                            >
                                <strong class="fw-normal">
                                    {{ number_format(
                                        (float) $service->price,
                                        2
                                    ) }}
                                    KM
                                </strong>

                                <a
    href="{{ route(
        'client.reservations.create',
        $service
    ) }}"
    class="btn btn-sm btn-dark"
>
    Book appointment
</a>
                            </div>

                        </div>
                    </article>

                </div>
            @endforeach

        </div>

    @endif

</div>
@endsection