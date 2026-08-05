@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start mb-5">
        <div>
            <p class="text-muted text-uppercase small mb-2">
                BeautyBook
            </p>

            <h1 class="display-6 fw-light mb-2">
                My appointments
            </h1>

            <p class="text-muted mb-0">
                Review your salon appointments.
            </p>
        </div>

        <a
            href="{{ route('client.services.index') }}"
            class="btn btn-dark"
        >
            Book appointment
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if ($errors->has('reservation'))
    <div class="alert alert-danger">
        {{ $errors->first('reservation') }}
    </div>
@endif
        </div>
    @endif

    @if ($reservations->isEmpty())

        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">

                <h2 class="h5 fw-normal mb-2">
                    No appointments yet
                </h2>

                <p class="text-muted mb-4">
                    Choose a service and book your first appointment.
                </p>

                <a
                    href="{{ route('client.services.index') }}"
                    class="btn btn-dark"
                >
                    Browse services
                </a>

            </div>
        </div>

    @else

        <div class="row g-4">

            @foreach ($reservations as $reservation)
                <div class="col-md-6">

                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">

                            <div
                                class="d-flex justify-content-between
                                       align-items-start gap-3 mb-4"
                            >
                                <div>
                                    <p
                                        class="text-muted text-uppercase
                                               small mb-2"
                                    >
                                        {{ $reservation
                                            ->appointment_date
                                            ->format('d.m.Y') }}
                                    </p>

                                    <h2 class="h4 fw-light mb-0">
                                        {{ $reservation->service_name }}
                                    </h2>
                                </div>

                               @php
    $statusClass = match ($reservation->status) {
        'confirmed' => 'text-bg-success',
        'completed' => 'text-bg-dark',
        'cancelled' => 'text-bg-danger',
        default => 'text-bg-secondary',
    };
@endphp

<span class="badge {{ $statusClass }}">
    {{ ucfirst($reservation->status) }}
</span>
                            </div>

                            <div class="border-top pt-3">
                                <p class="mb-2">
                                    <strong class="fw-normal">Time:</strong>

                                    {{ substr(
                                        $reservation->start_time,
                                        0,
                                        5
                                    ) }}

                                    –

                                    {{ substr(
                                        $reservation->end_time,
                                        0,
                                        5
                                    ) }}
                                </p>

                                <p class="mb-2">
                                    <strong class="fw-normal">
                                        Duration:
                                    </strong>

                                    {{ $reservation->duration_minutes }}
                                    minutes
                                </p>

                                <p class="mb-0">
                                    <strong class="fw-normal">Price:</strong>

                                    {{ number_format(
                                        (float) $reservation->total_price,
                                        2
                                    ) }}
                                    KM
                                </p>
                                @php
    $appointmentStart = \Carbon\Carbon::parse(
        $reservation->appointment_date->format('Y-m-d')
            . ' '
            . $reservation->start_time
    );

    $canCancel =
        in_array(
            $reservation->status,
            ['pending', 'confirmed'],
            true
        )
        && $appointmentStart->isFuture();
@endphp

@if ($canCancel)
    <form
        method="POST"
        action="{{ route(
            'client.reservations.cancel',
            $reservation
        ) }}"
        class="mt-4"
        onsubmit="return confirm(
            'Are you sure you want to cancel this appointment?'
        )"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn btn-sm btn-outline-danger"
        >
            Cancel appointment
        </button>
    </form>
@endif
                            </div>

                        </div>
                    </article>

                </div>
            @endforeach

        </div>

    @endif

</div>
@endsection