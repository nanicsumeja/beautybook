@extends('layouts.app')

@section(
    'body-class',
    'salon-admin-page salon-appointments-page'
)

@section('main-class', 'salon-appointments-main')

@section('content')
@php
    $totalCount = $reservations->count();
    $pendingCount = $reservations->where('status', 'pending')->count();
    $confirmedCount = $reservations->where('status', 'confirmed')->count();
    $completedCount = $reservations->where('status', 'completed')->count();
    $cancelledCount = $reservations->where('status', 'cancelled')->count();
@endphp

<div class="salon-appointments-shell">

    <section class="salon-appointments-panel">

        <header class="salon-appointments-header">
            <div>
                <p class="salon-appointments-eyebrow">
                    OWNER WORKSPACE
                </p>

                <h1>Appointments</h1>

                <p class="salon-appointments-description">
                    Review and confirm client appointments.
                </p>
            </div>

            <a
                href="{{ route('owner.dashboard') }}"
                class="salon-appointments-back"
            >
                ← Dashboard
            </a>
        </header>

        @if (session('success'))
            <div class="salon-appointment-message success">
                <span>✓</span>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('reservation'))
            <div class="salon-appointment-message error">
                <span>!</span>
                {{ $errors->first('reservation') }}
            </div>
        @endif

        <div class="salon-appointments-summary">
            <div>
                <span>Total</span>
                <strong>{{ $totalCount }}</strong>
            </div>

            <div>
                <span>Pending</span>
                <strong>{{ $pendingCount }}</strong>
            </div>

            <div>
                <span>Confirmed</span>
                <strong>{{ $confirmedCount }}</strong>
            </div>

            <div>
                <span>Completed</span>
                <strong>{{ $completedCount }}</strong>
            </div>

            <div>
                <span>Cancelled</span>
                <strong>{{ $cancelledCount }}</strong>
            </div>
        </div>

        <div class="salon-appointments-toolbar">

            <label
                for="appointmentSearch"
                class="salon-appointments-search"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>

                <input
                    type="search"
                    id="appointmentSearch"
                    placeholder="Search client or service"
                    autocomplete="off"
                >
            </label>

            <div class="salon-appointments-filters">
                <button
                    type="button"
                    class="active"
                    data-appointment-filter="all"
                >
                    All
                </button>

                <button
                    type="button"
                    data-appointment-filter="pending"
                >
                    Pending
                </button>

                <button
                    type="button"
                    data-appointment-filter="confirmed"
                >
                    Confirmed
                </button>

                <button
                    type="button"
                    data-appointment-filter="completed"
                >
                    Completed
                </button>

                <button
                    type="button"
                    data-appointment-filter="cancelled"
                >
                    Cancelled
                </button>
            </div>

        </div>

        @if ($reservations->isEmpty())

            <div class="salon-appointments-empty">
                <span>○</span>

                <h2>No appointments yet</h2>

                <p>
                    Client appointments will appear here.
                </p>
            </div>

        @else

            <div class="salon-appointments-table">

                <div class="salon-appointments-table-head">
                    <span>Client</span>
                    <span>Service</span>
                    <span>Date and time</span>
                    <span>Price</span>
                    <span>Status</span>
                    <span>Action</span>
                </div>

                <div class="salon-appointments-table-body">

                    @foreach ($reservations as $reservation)
                        @php
                            $appointmentStart = \Carbon\Carbon::parse(
                                $reservation->appointment_date
                                    ->format('Y-m-d')
                                . ' '
                                . $reservation->start_time
                            );

                            $canConfirm =
                                $reservation->status === 'pending'
                                && $appointmentStart->isFuture();

                            $clientName =
                                $reservation->client->name
                                . ' '
                                . $reservation->client->surname;

                            $searchValue = mb_strtolower(
                                $clientName
                                . ' '
                                . $reservation->client->email
                                . ' '
                                . $reservation->service_name
                            );
                        @endphp

                        <article
                            class="salon-appointment-row"
                            data-appointment-row
                            data-status="{{ $reservation->status }}"
                            data-search="{{ $searchValue }}"
                        >

                            <div class="salon-appointment-client">
                                <span class="salon-appointment-avatar">
                                    {{ mb_strtoupper(
                                        mb_substr(
                                            $reservation->client->name,
                                            0,
                                            1
                                        )
                                    ) }}
                                </span>

                                <div>
                                    <strong>{{ $clientName }}</strong>

                                    <small>
                                        {{ $reservation->client->email }}
                                    </small>
                                </div>
                            </div>

                            <div
                                class="salon-appointment-service"
                                data-label="Service"
                            >
                                <strong>
                                    {{ $reservation->service_name }}
                                </strong>

                                <small>
                                    {{ $reservation->duration_minutes }}
                                    minutes
                                </small>
                            </div>

                            <div
                                class="salon-appointment-date"
                                data-label="Date and time"
                            >
                                <strong>
                                    {{ $reservation
                                        ->appointment_date
                                        ->format('d.m.Y') }}
                                </strong>

                                <small>
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
                                </small>
                            </div>

                            <div
                                class="salon-appointment-price"
                                data-label="Price"
                            >
                                <strong>
                                    {{ number_format(
                                        (float) $reservation->total_price,
                                        2
                                    ) }}
                                </strong>

                                <small>KM</small>
                            </div>

                            <div
                                class="salon-appointment-status-cell"
                                data-label="Status"
                            >
                                <span
                                    class="salon-appointment-status
                                           {{ $reservation->status }}"
                                >
                                    <i></i>

                                    {{ ucfirst(
                                        $reservation->status
                                    ) }}
                                </span>
                            </div>

                            <div class="salon-appointment-action">
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

                                        <button type="submit">
                                            Confirm
                                        </button>
                                    </form>
                                @else
                                    <span>No action</span>
                                @endif
                            </div>

                        </article>
                    @endforeach

                    <div
                        class="salon-appointments-no-results"
                        id="appointmentsNoResults"
                        hidden
                    >
                        No appointments match your search.
                    </div>

                </div>

                <footer class="salon-appointments-table-footer">
                    <span id="appointmentResultCount">
                        Showing {{ $totalCount }}
                        {{ $totalCount === 1
                            ? 'appointment'
                            : 'appointments' }}
                    </span>

                    <a href="{{ route('owner.dashboard') }}">
                        Back to dashboard
                    </a>
                </footer>

            </div>

        @endif

    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.getElementById('appointmentSearch');

    const rows = Array.from(
        document.querySelectorAll('[data-appointment-row]')
    );

    const buttons = Array.from(
        document.querySelectorAll(
            '[data-appointment-filter]'
        )
    );

    const resultCount =
        document.getElementById('appointmentResultCount');

    const noResults =
        document.getElementById('appointmentsNoResults');

    if (!searchInput || rows.length === 0) {
        return;
    }

    let activeFilter = 'all';

    const updateAppointments = () => {
        const query = searchInput.value
            .trim()
            .toLowerCase();

        let visibleCount = 0;

        rows.forEach((row) => {
            const matchesSearch =
                row.dataset.search.includes(query);

            const matchesStatus =
                activeFilter === 'all'
                || row.dataset.status === activeFilter;

            const visible =
                matchesSearch && matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        if (resultCount) {
            resultCount.textContent =
                `Showing ${visibleCount} `
                + (
                    visibleCount === 1
                        ? 'appointment'
                        : 'appointments'
                );
        }

        if (noResults) {
            noResults.hidden = visibleCount !== 0;
        }
    };

    searchInput.addEventListener(
        'input',
        updateAppointments
    );

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter =
                button.dataset.appointmentFilter;

            buttons.forEach((item) => {
                item.classList.toggle(
                    'active',
                    item === button
                );
            });

            updateAppointments();
        });
    });
});
</script>
@endsection