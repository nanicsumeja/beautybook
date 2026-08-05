@extends('layouts.app')

@section('body-class', 'salon-admin-page')
@section('main-class', 'salon-admin-main')

@section('content')
@php
    $chartTotal = max($totalReservations, 1);

    $pendingEnd =
        ($pendingCount / $chartTotal) * 360;

    $confirmedEnd =
        $pendingEnd +
        (($confirmedCount / $chartTotal) * 360);

    $completedEnd =
        $confirmedEnd +
        (($completedCount / $chartTotal) * 360);
@endphp

<div class="salon-admin-shell">

    <section class="salon-admin-panel">

        <header class="salon-admin-header">

            <div>
                <p class="salon-admin-eyebrow">
                    OWNER DASHBOARD
                </p>

                <h1>
                    Welcome back,
                    {{ Auth::user()->name }}
                </h1>
            </div>

            <div class="salon-admin-date">
                <span>Today</span>
                <strong>{{ now()->format('d.m.Y') }}</strong>
            </div>

        </header>

        <div class="salon-admin-grid">

            {{-- OVERVIEW --}}
            <section class="salon-admin-card admin-overview">

                <div class="admin-section-heading">
                    <div>
                        <span>Overview</span>
                        <small>Salon activity</small>
                    </div>
                </div>

                <div class="admin-stat-strip">

                    <div class="admin-stat">
                        <strong>{{ $servicesCount }}</strong>
                        <span>Services</span>
                    </div>

                    <div class="admin-stat">
                        <strong>{{ $activeServicesCount }}</strong>
                        <span>Active</span>
                    </div>

                    <div class="admin-stat">
                        <strong>{{ $employeesCount }}</strong>
                        <span>Employees</span>
                    </div>

                    <div class="admin-stat">
                        <strong>{{ $pendingCount }}</strong>
                        <span>Pending</span>
                    </div>

                </div>

                <div class="admin-overview-note">
                    <span class="admin-live-dot"></span>

                    <p>
                        Salon management is active and ready.
                    </p>
                </div>

            </section>

            {{-- STATUS CHART --}}
            <section class="salon-admin-card admin-status">

                <div class="admin-section-heading">
                    <div>
                        <span>Appointments</span>
                        <small>Status overview</small>
                    </div>

                    <a href="{{ route('owner.reservations.index') }}">
                        View all
                    </a>
                </div>

                <div class="admin-status-content">

                    <div
                        @class([
                            'admin-status-ring',
                            'is-empty' => $totalReservations === 0,
                        ])
                        style="
                            --pending-end:
                                {{ $pendingEnd }}deg;

                            --confirmed-end:
                                {{ $confirmedEnd }}deg;

                            --completed-end:
                                {{ $completedEnd }}deg;
                        "
                    >
                        <div class="admin-status-ring-center">
                            <strong>{{ $totalReservations }}</strong>
                            <span>Total</span>
                        </div>
                    </div>

                    <div class="admin-status-legend">

                        <div>
                            <span class="status-dot pending"></span>
                            <p>Pending</p>
                            <strong>{{ $pendingCount }}</strong>
                        </div>

                        <div>
                            <span class="status-dot confirmed"></span>
                            <p>Confirmed</p>
                            <strong>{{ $confirmedCount }}</strong>
                        </div>

                        <div>
                            <span class="status-dot completed"></span>
                            <p>Completed</p>
                            <strong>{{ $completedCount }}</strong>
                        </div>

                        <div>
                            <span class="status-dot cancelled"></span>
                            <p>Cancelled</p>
                            <strong>{{ $cancelledCount }}</strong>
                        </div>

                    </div>

                </div>

            </section>

            {{-- UPCOMING APPOINTMENTS --}}
            <section class="salon-admin-card admin-appointments">

                <div class="admin-section-heading">
                    <div>
                        <span>Upcoming appointments</span>
                        <small>Next client visits</small>
                    </div>

                    <a href="{{ route('owner.reservations.index') }}">
                        View all
                    </a>
                </div>

                <div class="admin-appointment-list">

                    @forelse (
                        $upcomingReservations as $reservation
                    )
                        <div class="admin-appointment-row">

                            <div class="admin-client">
                                <span class="admin-client-avatar">
                                    {{ strtoupper(
                                        substr(
                                            $reservation->client->name,
                                            0,
                                            1
                                        )
                                    ) }}
                                </span>

                                <div>
                                    <strong>
                                        {{ $reservation->client->name }}
                                        {{ $reservation->client->surname }}
                                    </strong>

                                    <small>
                                        {{ $reservation->service_name }}
                                    </small>
                                </div>
                            </div>

                            <div class="admin-appointment-time">
                                <strong>
                                    {{ $reservation
                                        ->appointment_date
                                        ->format('d.m.') }}
                                </strong>

                                <small>
                                    {{ substr(
                                        $reservation->start_time,
                                        0,
                                        5
                                    ) }}
                                </small>
                            </div>

                            <span
                                class="admin-status-badge
                                    {{ $reservation->status }}"
                            >
                                {{ ucfirst(
                                    $reservation->status
                                ) }}
                            </span>

                        </div>
                    @empty
                        <div class="admin-empty-state">
                            No upcoming appointments.
                        </div>
                    @endforelse

                </div>

            </section>

            {{-- QUICK ACTIONS --}}
            <section class="salon-admin-card admin-actions">

                <div class="admin-section-heading">
                    <div>
                        <span>Quick actions</span>
                        <small>Common tasks</small>
                    </div>
                </div>

                <div class="admin-action-list">

                    <a
                        href="{{ route(
                            'owner.services.create'
                        ) }}"
                    >
                        <span class="admin-action-icon">
                            +
                        </span>

                        <strong>Add service</strong>

                        <span class="admin-action-arrow">
                            ↗
                        </span>
                    </a>

                    <a
                        href="{{ route(
                            'owner.employees.create'
                        ) }}"
                    >
                        <span class="admin-action-icon">
                            +
                        </span>

                        <strong>Add employee</strong>

                        <span class="admin-action-arrow">
                            ↗
                        </span>
                    </a>

                    <a
                        href="{{ route(
                            'owner.reservations.index'
                        ) }}"
                    >
                        <span class="admin-action-icon">
                            ·
                        </span>

                        <strong>Review appointments</strong>

                        <span class="admin-action-arrow">
                            ↗
                        </span>
                    </a>

                </div>

            </section>

        </div>

    </section>

</div>
@endsection