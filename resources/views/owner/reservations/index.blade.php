@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start mb-5">
        <div>
            <p class="text-muted text-uppercase small mb-2">
                Owner panel
            </p>

            <h1 class="display-6 fw-light mb-2">
                Appointments
            </h1>

            <p class="text-muted mb-0">
                Review and confirm client appointments.
            </p>
        </div>

        <a
            href="{{ route('owner.dashboard') }}"
            class="btn btn-outline-dark"
        >
            Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('reservation'))
        <div class="alert alert-danger">
            {{ $errors->first('reservation') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            @if ($reservations->isEmpty())

                <div class="p-5 text-center">
                    <h2 class="h5 fw-normal mb-2">
                        No appointments yet
                    </h2>

                    <p class="text-muted mb-0">
                        Client appointments will appear here.
                    </p>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Client</th>
                                <th class="py-3">Service</th>
                                <th class="py-3">Date and time</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Status</th>
                                <th class="px-4 py-3 text-end">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($reservations as $reservation)
                                @php
                                    $statusClass = match (
                                        $reservation->status
                                    ) {
                                        'confirmed' =>
                                            'text-bg-success',

                                        'completed' =>
                                            'text-bg-dark',

                                        'cancelled' =>
                                            'text-bg-danger',

                                        default =>
                                            'text-bg-secondary',
                                    };

                                    $appointmentStart =
                                        \Carbon\Carbon::parse(
                                            $reservation
                                                ->appointment_date
                                                ->format('Y-m-d')
                                            . ' '
                                            . $reservation->start_time
                                        );

                                    $canConfirm =
                                        $reservation->status ===
                                            'pending'
                                        && $appointmentStart
                                            ->isFuture();
                                @endphp

                                <tr>
                                    <td class="px-4 py-3">
                                        <strong>
                                            {{ $reservation->client->name }}
                                            {{ $reservation->client->surname }}
                                        </strong>

                                        <div class="small text-muted">
                                            {{ $reservation->client->email }}
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        {{ $reservation->service_name }}

                                        <div class="small text-muted">
                                            {{ $reservation->duration_minutes }}
                                            minutes
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        {{ $reservation
                                            ->appointment_date
                                            ->format('d.m.Y') }}

                                        <div class="small text-muted">
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
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        {{ number_format(
                                            (float)
                                                $reservation->total_price,
                                            2
                                        ) }}
                                        KM
                                    </td>

                                    <td class="py-3">
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst(
                                                $reservation->status
                                            ) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-end">
                                        @if ($canConfirm)
                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'owner.reservations.confirm',
                                                    $reservation
                                                ) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-dark"
                                                >
                                                    Confirm
                                                </button>
                                            </form>
                                        @else
                                            <span class="small text-muted">
                                                No action
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>
    </div>

</div>
@endsection