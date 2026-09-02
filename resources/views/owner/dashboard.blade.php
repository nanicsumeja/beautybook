@extends('layouts.app')

@section('body-class', 'owner-dashboard-page')

@section('main-class', 'owner-dashboard-main')

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



<section class="owner-dashboard-space">

    <div class="owner-dashboard-shell">

        {{-- HEADER --}}

        <header class="owner-dashboard-header">

            <div>

                <span class="owner-dashboard-eyebrow">

                    OWNER WORKSPACE

                </span>

                <h1>

                    Welcome back,

                    {{ Auth::user()->name }}

                </h1>

                <p>

                    Salon overview and management.

                </p>

            </div>



            <div class="owner-dashboard-date">

                <span>

                    TODAY

                </span>

                <strong>

                    {{ now()->format('d.m.Y') }}

                </strong>

            </div>

        </header>



        {{-- TOP STATS --}}

        <section class="owner-summary-grid">

            <article class="owner-summary-card">

                <span>SERVICES</span>

                <strong>{{ $servicesCount }}</strong>

                <small>Total services</small>

            </article>

            <article class="owner-summary-card">

                <span>ACTIVE</span>

                <strong>{{ $activeServicesCount }}</strong>

                <small>Active services</small>

            </article>

            <article class="owner-summary-card">

                <span>EMPLOYEES</span>

                <strong>{{ $employeesCount }}</strong>

                <small>Team members</small>

            </article>

            <article class="owner-summary-card accent">

                <span>PENDING</span>

                <strong>{{ $pendingCount }}</strong>

                <small>Appointments</small>

            </article>

        </section>



        <div class="owner-dashboard-grid">



            {{-- APPOINTMENT STATUS --}}

            <section class="owner-card owner-status-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            APPOINTMENTS

                        </span>

                        <h2>

                            Status overview

                        </h2>

                    </div>

                    <a href="{{ route('owner.reservations.index') }}">

                        VIEW ALL →

                    </a>

                </div>



                <div class="owner-status-content">

                    <div

                        @class([

                            'owner-status-ring',

                            'is-empty' => $totalReservations === 0,

                        ])

                        style="

                            --pending-end: {{ $pendingEnd }}deg;

                            --confirmed-end: {{ $confirmedEnd }}deg;

                            --completed-end: {{ $completedEnd }}deg;

                        "

                    >

                        <div class="owner-status-ring-inner">

                            <strong>

                                {{ $totalReservations }}

                            </strong>

                            <span>

                                TOTAL

                            </span>

                        </div>

                    </div>



                    <div class="owner-status-list">

                        <div>

                            <span class="owner-status-dot pending"></span>

                            <p>

                                Pending

                            </p>

                            <strong>

                                {{ $pendingCount }}

                            </strong>

                        </div>



                        <div>

                            <span class="owner-status-dot confirmed"></span>

                            <p>

                                Confirmed

                            </p>

                            <strong>

                                {{ $confirmedCount }}

                            </strong>

                        </div>



                        <div>

                            <span class="owner-status-dot completed"></span>

                            <p>

                                Completed

                            </p>

                            <strong>

                                {{ $completedCount }}

                            </strong>

                        </div>



                        <div>

                            <span class="owner-status-dot cancelled"></span>

                            <p>

                                Cancelled

                            </p>

                            <strong>

                                {{ $cancelledCount }}

                            </strong>

                        </div>

                    </div>

                </div>

            </section>



            {{-- QUICK ACTIONS --}}

            <section class="owner-card owner-actions-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            QUICK ACTIONS

                        </span>

                        <h2>

                            Manage salon

                        </h2>

                    </div>

                </div>



                <div class="owner-action-list">

                    <a href="{{ route('owner.services.create') }}">

                        <div>

                            <span>01</span>

                            <strong>

                                Add service

                            </strong>

                        </div>

                        <b>↗</b>

                    </a>



                    <a href="{{ route('owner.employees.create') }}">

                        <div>

                            <span>02</span>

                            <strong>

                                Add employee

                            </strong>

                        </div>

                        <b>↗</b>

                    </a>



                    <a href="{{ route('owner.reservations.index') }}">

                        <div>

                            <span>03</span>

                            <strong>

                                Review appointments

                            </strong>

                        </div>

                        <b>↗</b>

                    </a>

                </div>

            </section>



            {{-- UPCOMING APPOINTMENTS --}}

            <section class="owner-card owner-upcoming-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            UPCOMING

                        </span>

                        <h2>

                            Next appointments

                        </h2>

                    </div>

                    <a href="{{ route('owner.reservations.index') }}">

                        VIEW ALL →

                    </a>

                </div>



                <div class="owner-upcoming-list">

                    @forelse (

                        $upcomingReservations as $reservation

                    )

                        <article class="owner-upcoming-row">

                            <div class="owner-upcoming-client">

                                <div class="owner-client-avatar">

                                    {{

                                        strtoupper(

                                            substr(

                                                $reservation->client->name,

                                                0,

                                                1

                                            )

                                        )

                                    }}

                                </div>

                                <div>

                                    <strong>

                                        {{ $reservation->client->name }}

                                        {{ $reservation->client->surname }}

                                    </strong>

                                    <span>

                                        {{ $reservation->service_name }}

                                    </span>

                                </div>

                            </div>



                            <div class="owner-upcoming-date">

                                <strong>

                                    {{

                                        $reservation

                                            ->appointment_date

                                            ->format('d.m.')

                                    }}

                                </strong>

                                <span>

                                    {{

                                        substr(

                                            $reservation->start_time,

                                            0,

                                            5

                                        )

                                    }}

                                </span>

                            </div>



                            <span

                                class="

                                    owner-reservation-status

                                    {{ $reservation->status }}

                                "

                            >

                                {{ strtoupper($reservation->status) }}

                            </span>

                        </article>

                    @empty

                        <div class="owner-empty">

                            No upcoming appointments.

                        </div>

                    @endforelse

                </div>

            </section>



            {{-- SYSTEM STATUS --}}

            <section class="owner-card owner-system-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            SYSTEM STATUS

                        </span>

                        <h2>

                            Current state

                        </h2>

                    </div>

                </div>



                <div class="owner-system-state">

                    <div class="owner-system-main-status">

                        <div>

                            <span>

                                STATUS

                            </span>

                            <strong>

                                @if ($warningCount === 0)

                                    Operational

                                @else

                                    Attention required

                                @endif

                            </strong>

                        </div>



                        @if ($warningCount === 0)

                            <span class="owner-system-badge operational">

                                OPERATIONAL

                            </span>

                        @else

                            <span class="owner-system-badge warning">

                                ATTENTION

                            </span>

                        @endif

                    </div>



                    <div class="owner-system-metrics">

                        <div>

                            <span>ACTIVE SERVICES</span>

                            <strong>{{ $activeServicesCount }}</strong>

                        </div>

                        <div>

                            <span>EMPLOYEES</span>

                            <strong>{{ $employeesCount }}</strong>

                        </div>

                        <div>

                            <span>APPOINTMENTS</span>

                            <strong>{{ $totalReservations }}</strong>

                        </div>

                        <div>

                            <span>WARNINGS</span>

                            <strong>{{ $warningCount }}</strong>

                        </div>

                    </div>

                </div>

            </section>



            {{-- WARNINGS --}}

            <section class="owner-card owner-warnings-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            WARNINGS

                        </span>

                        <h2>

                            Requires attention

                        </h2>

                    </div>

                </div>



                @if ($warningCount === 0)

                    <div class="owner-no-warnings">

                        <span>✓</span>

                        <div>

                            <strong>

                                Everything looks good.

                            </strong>

                            <p>

                                No system warnings at this time.

                            </p>

                        </div>

                    </div>

                @else

                    <div class="owner-warning-list">



                        @if ($pendingAppointments > 0)

                            <div>

                                <span>

                                    Pending appointments

                                </span>

                                <strong>

                                    {{ $pendingAppointments }}

                                </strong>

                            </div>

                        @endif



                        @if ($employeesWithoutWorkingHours > 0)

                            <div>

                                <span>

                                    Employees without working hours

                                </span>

                                <strong>

                                    {{ $employeesWithoutWorkingHours }}

                                </strong>

                            </div>

                        @endif



                        @if ($servicesWithoutEmployees > 0)

                            <div>

                                <span>

                                    Services without assigned employees

                                </span>

                                <strong>

                                    {{ $servicesWithoutEmployees }}

                                </strong>

                            </div>

                        @endif



                        @if ($failedPayments > 0)

                            <div>

                                <span>

                                    Failed payments

                                </span>

                                <strong>

                                    {{ $failedPayments }}

                                </strong>

                            </div>

                        @endif



                        @if ($appointmentsWithoutEmployees > 0)

                            <div>

                                <span>

                                    Appointments without assigned employees

                                </span>

                                <strong>

                                    {{ $appointmentsWithoutEmployees }}

                                </strong>

                            </div>

                        @endif

                    </div>

                @endif

            </section>



            {{-- RECENT ACTIVITY --}}

            <section class="owner-card owner-activity-card">

                <div class="owner-card-heading">

                    <div>

                        <span>

                            RECENT ACTIVITY

                        </span>

                        <h2>

                            Latest activity

                        </h2>

                    </div>

                </div>



                <div class="owner-activity-list">

                    @forelse ($recentActivities as $activity)

                        <article class="owner-activity-row">

                            <div class="owner-activity-main">

                                <span class="owner-activity-marker"></span>

                                <div>

                                    <strong>

                                        {{ $activity->description }}

                                    </strong>

                                    <small>

                                        @if ($activity->user)

                                            {{ $activity->user->name }}

                                            {{ $activity->user->surname }}

                                            ·

                                        @endif

                                        {{

                                            $activity

                                                ->created_at

                                                ->diffForHumans()

                                        }}

                                    </small>

                                </div>

                            </div>



                            <span class="owner-activity-badge">

                                {{

                                    strtoupper(

                                        str_replace(

                                            '_',

                                            ' ',

                                            $activity->action

                                        )

                                    )

                                }}

                            </span>

                        </article>

                    @empty

                        <div class="owner-empty">

                            No activity has been recorded yet.

                        </div>

                    @endforelse

                </div>

            </section>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

    .owner-dashboard-page {

        background: #f3efea;

    }

    .owner-dashboard-main {

        background: #f3efea;

    }

    .owner-dashboard-space {

        min-height: calc(100vh - 62px);

        padding: 24px 0 40px;

        background:

            radial-gradient(

                circle at 93% 5%,

                rgba(190, 151, 140, 0.13),

                transparent 23%

            ),

            #f3efea;

        color: #211d1a;

        font-family: 'Montserrat', sans-serif;

    }

    .owner-dashboard-shell {

        width: min(1180px, calc(100% - 48px));

        margin: 0 auto;

    }



    /* HEADER */

    .owner-dashboard-header {

        display: flex;

        align-items: flex-end;

        justify-content: space-between;

        gap: 30px;

        padding-bottom: 17px;

        margin-bottom: 16px;

        border-bottom: 1px solid rgba(33, 29, 26, 0.12);

    }

    .owner-dashboard-eyebrow {

        display: block;

        margin-bottom: 5px;

        font-size: 0.53rem;

        font-weight: 500;

        letter-spacing: 0.2em;

        color: #9e766a;

    }

    .owner-dashboard-header h1 {

        margin: 0 0 4px;

        font-size: clamp(2rem, 3.8vw, 3rem);

        font-weight: 300;

        letter-spacing: -0.045em;

    }

    .owner-dashboard-header p {

        margin: 0;

        font-size: 0.68rem;

        color: #7d746e;

    }

    .owner-dashboard-date {

        text-align: right;

    }

    .owner-dashboard-date span {

        display: block;

        margin-bottom: 4px;

        font-size: 0.43rem;

        letter-spacing: 0.15em;

        color: #a08378;

    }

    .owner-dashboard-date strong {

        font-size: 0.73rem;

        font-weight: 500;

    }



    /* TOP STATS */

    .owner-summary-grid {

        display: grid;

        grid-template-columns: repeat(4, 1fr);

        gap: 8px;

        margin-bottom: 16px;

    }

    .owner-summary-card {

        min-height: 91px;

        padding: 16px 18px;

        background: #faf7f3;

        border: 1px solid rgba(33, 29, 26, 0.08);

    }

    .owner-summary-card.accent {

        background: #edd8d0;

        border-color: #d8c2bb;

    }

    .owner-summary-card > span {

        display: block;

        margin-bottom: 4px;

        font-size: 0.43rem;

        letter-spacing: 0.14em;

        color: #98786d;

    }

    .owner-summary-card.accent > span {

        color: #e8d5cf;

    }

    .owner-summary-card strong {

        display: block;

        margin-bottom: 1px;

        font-size: 1.65rem;

        font-weight: 300;

        line-height: 1;

    }

    .owner-summary-card small {

        font-size: 0.52rem;

        color: #d6c6bb;

    }

    .owner-summary-card.accent small {

        color: #65534c;

    }



    /* MAIN GRID */

    .owner-dashboard-grid {

        display: grid;

        grid-template-columns: repeat(12, 1fr);

        gap: 12px;

        align-items: start;

    }

    .owner-card {

        background: #faf7f3;

        border: 1px solid rgba(33, 29, 26, 0.08);

        min-width: 0;

    }

    .owner-status-card {

        grid-column: span 7;

    }

    .owner-actions-card {

        grid-column: span 5;

        background: #eee4dc;

        color: #332925;

        border-color: rgba(95, 72, 64, 0.12);

    }

    .owner-upcoming-card {

        grid-column: span 7;

    }

    .owner-system-card {

        grid-column: span 5;

    }

    .owner-warnings-card {

        grid-column: span 5;

    }

    .owner-activity-card {

        grid-column: span 7;

    }



    /* CARD HEADING */

    .owner-card-heading {

        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 18px;

        padding: 18px 20px;

        border-bottom: 1px solid rgba(33, 29, 26, 0.09);

    }

    .owner-actions-card .owner-card-heading {

        border-color: rgba(95, 72, 64, 0.16);

    }

    .owner-card-heading > div > span {

        display: block;

        margin-bottom: 4px;

        font-size: 0.44rem;

        letter-spacing: 0.15em;

        color: #9f7d72;

    }

    .owner-actions-card .owner-card-heading > div > span {

        color: #8f685d;

    }

    .owner-actions-card .owner-card-heading h2 {

        color: #332925;

    }

    .owner-card-heading h2 {

        margin: 0;

        font-size: 1.05rem;

        font-weight: 400;

    }

    .owner-card-heading > a {

        color: #211d1a;

        text-decoration: none;

        font-size: 0.43rem;

        font-weight: 500;

        letter-spacing: 0.12em;

        white-space: nowrap;

    }

    .owner-card-heading > a:hover {

        color: #9d7063;

    }



    /* STATUS CHART */

    .owner-status-content {

        display: grid;

        grid-template-columns: 0.85fr 1.15fr;

        align-items: center;

        gap: 22px;

        padding: 22px;

    }

    .owner-status-ring {

        width: 142px;

        height: 142px;

        margin: auto;

        padding: 13px;

        border-radius: 50%;

        background:

            conic-gradient(

                #c9aa70 0deg var(--pending-end),

                #8c9d86 var(--pending-end)

                    var(--confirmed-end),

                #292522 var(--confirmed-end)

                    var(--completed-end),

                #c98678 var(--completed-end)

                    360deg

            );

    }

    .owner-status-ring.is-empty {

        background: #e4ddd7;

    }

    .owner-status-ring-inner {

        width: 100%;

        height: 100%;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background: #faf7f3;

    }

    .owner-status-ring-inner strong {

        font-size: 1.7rem;

        font-weight: 300;

        line-height: 1;

    }

    .owner-status-ring-inner span {

        margin-top: 5px;

        font-size: 0.42rem;

        letter-spacing: 0.14em;

        color: #8d8179;

    }

    .owner-status-list {

        display: flex;

        flex-direction: column;

    }

    .owner-status-list > div {

        display: grid;

        grid-template-columns: 9px 1fr auto;

        gap: 10px;

        align-items: center;

        padding: 9px 0;

        border-bottom: 1px solid rgba(33,29,26,0.08);

    }

    .owner-status-list > div:last-child {

        border-bottom: 0;

    }

    .owner-status-list p {

        margin: 0;

        font-size: 0.62rem;

    }

    .owner-status-list strong {

        font-size: 0.67rem;

        font-weight: 500;

    }

    .owner-status-dot {

        width: 7px;

        height: 7px;

        border-radius: 50%;

    }

    .owner-status-dot.pending {

        background: #c9aa70;

    }

    .owner-status-dot.confirmed {

        background: #8c9d86;

    }

    .owner-status-dot.completed {

        background: #292522;

    }

    .owner-status-dot.cancelled {

        background: #c98678;

    }



    /* QUICK ACTIONS */

    .owner-action-list {

        padding: 5px 20px 15px;

    }

    .owner-action-list a {

        min-height: 60px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        color: #332925;

        text-decoration: none;

        border-bottom: 1px solid rgba(95, 72, 64, 0.16);

        transition:

            background 0.2s ease,

            padding 0.2s ease;

    }

    .owner-action-list a:last-child {

        border-bottom: 0;

    }

    .owner-action-list a > div {

        display: flex;

        align-items: center;

        gap: 14px;

    }

    .owner-action-list a div span {

        font-size: 0.43rem;

        letter-spacing: 0.1em;

        color: #8c6257;

    }

    .owner-action-list a strong {

        font-size: 0.65rem;

        font-weight: 500;

        color: #332925;

    }

    .owner-action-list a b {

        font-size: 0.95rem;

        font-weight: 300;

        color: #8c6257;

        transition: transform 0.2s ease;

    }

    .owner-action-list a:hover {

        background: rgba(255, 255, 255, 0.20);

        padding-left: 8px;

        padding-right: 8px;

    }

    .owner-action-list a:hover b {

        transform: translate(2px, -2px);

    }



    /* UPCOMING */

    .owner-upcoming-list {

        padding: 0 20px;

    }

    .owner-upcoming-row {

        display: grid;

        grid-template-columns: 1fr auto auto;

        gap: 18px;

        align-items: center;

        min-height: 68px;

        border-bottom: 1px solid rgba(33,29,26,0.08);

    }

    .owner-upcoming-row:last-child {

        border-bottom: 0;

    }

    .owner-upcoming-client {

        display: flex;

        align-items: center;

        gap: 11px;

        min-width: 0;

    }

    .owner-client-avatar {

        width: 35px;

        height: 35px;

        flex-shrink: 0;

        display: grid;

        place-items: center;

        background: #dec7bd;

        font-size: 0.72rem;

    }

    .owner-upcoming-client strong {

        display: block;

        margin-bottom: 2px;

        font-size: 0.62rem;

        font-weight: 500;

    }

    .owner-upcoming-client span {

        display: block;

        font-size: 0.5rem;

        color: #8b8078;

    }

    .owner-upcoming-date {

        text-align: right;

    }

    .owner-upcoming-date strong {

        display: block;

        font-size: 0.62rem;

        font-weight: 500;

    }

    .owner-upcoming-date span {

        display: block;

        margin-top: 2px;

        font-size: 0.49rem;

        color: #8a7e77;

    }

    .owner-reservation-status {

        display: inline-flex;

        justify-content: center;

        min-width: 78px;

        padding: 6px 8px;

        font-size: 0.39rem;

        font-weight: 500;

        letter-spacing: 0.09em;

    }

    .owner-reservation-status.pending {

        background: #eee2c9;

        color: #866d3f;

    }

    .owner-reservation-status.confirmed {

        background: #dfe7dc;

        color: #52684f;

    }

    .owner-reservation-status.completed {

        background: #211d1a;

        color: #fff;

    }

    .owner-reservation-status.cancelled {

        background: #ead8d4;

        color: #8b554c;

    }



    /* SYSTEM */

    .owner-system-state {

        padding: 20px;

    }

    .owner-system-main-status {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding-bottom: 17px;

        border-bottom: 1px solid rgba(33,29,26,0.09);

    }

    .owner-system-main-status > div > span {

        display: block;

        margin-bottom: 4px;

        font-size: 0.43rem;

        letter-spacing: 0.13em;

        color: #9e7c72;

    }

    .owner-system-main-status > div > strong {

        font-size: 0.67rem;

        font-weight: 500;

    }

    .owner-system-badge {

        padding: 6px 8px;

        font-size: 0.38rem;

        font-weight: 500;

        letter-spacing: 0.1em;

    }

    .owner-system-badge.operational {

        background: #dfe7dc;

        color: #53684f;

    }

    .owner-system-badge.warning {

        background: #eee2c9;

        color: #876e3f;

    }

    .owner-system-metrics {

        display: grid;

        grid-template-columns: 1fr 1fr;

    }

    .owner-system-metrics > div {

        padding: 15px 0;

        border-bottom: 1px solid rgba(33,29,26,0.08);

    }

    .owner-system-metrics > div:nth-child(odd) {

        padding-right: 15px;

        border-right: 1px solid rgba(33,29,26,0.08);

    }

    .owner-system-metrics > div:nth-child(even) {

        padding-left: 15px;

    }

    .owner-system-metrics span {

        display: block;

        margin-bottom: 3px;

        font-size: 0.39rem;

        letter-spacing: 0.11em;

        color: #927d74;

    }

    .owner-system-metrics strong {

        font-size: 1rem;

        font-weight: 300;

    }



    /* WARNINGS */

    .owner-warning-list {

        padding: 0 20px;

    }

    .owner-warning-list > div {

        min-height: 48px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        border-bottom: 1px solid rgba(33,29,26,0.08);

    }

    .owner-warning-list > div:last-child {

        border-bottom: 0;

    }

    .owner-warning-list span {

        font-size: 0.58rem;

    }

    .owner-warning-list strong {

        min-width: 25px;

        height: 25px;

        display: grid;

        place-items: center;

        background: #ead8d4;

        color: #92594e;

        font-size: 0.52rem;

        font-weight: 500;

    }

    .owner-no-warnings {

        display: flex;

        align-items: center;

        gap: 13px;

        padding: 22px;

    }

    .owner-no-warnings > span {

        width: 34px;

        height: 34px;

        display: grid;

        place-items: center;

        flex-shrink: 0;

        background: #dfe7dc;

        color: #53684f;

    }

    .owner-no-warnings strong {

        display: block;

        margin-bottom: 2px;

        font-size: 0.62rem;

        font-weight: 500;

    }

    .owner-no-warnings p {

        margin: 0;

        font-size: 0.51rem;

        color: #8a7e77;

    }



    /* ACTIVITY */

    .owner-activity-list {

        padding: 0 20px;

    }

    .owner-activity-row {

        min-height: 61px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        border-bottom: 1px solid rgba(33,29,26,0.08);

    }

    .owner-activity-row:last-child {

        border-bottom: 0;

    }

    .owner-activity-main {

        display: flex;

        align-items: center;

        gap: 11px;

        min-width: 0;

    }

    .owner-activity-marker {

        width: 6px;

        height: 6px;

        flex-shrink: 0;

        border-radius: 50%;

        background: #c59d91;

    }

    .owner-activity-main strong {

        display: block;

        margin-bottom: 3px;

        font-size: 0.59rem;

        font-weight: 500;

    }

    .owner-activity-main small {

        display: block;

        font-size: 0.46rem;

        color: #91857e;

    }

    .owner-activity-badge {

        max-width: 110px;

        padding: 5px 7px;

        background: #eee5df;

        font-size: 0.36rem;

        letter-spacing: 0.08em;

        text-align: center;

    }



    /* EMPTY */

    .owner-empty {

        padding: 25px 0;

        text-align: center;

        font-size: 0.57rem;

        color: #8b817a;

    }



    /* RESPONSIVE */

    @media (max-width: 900px) {

        .owner-summary-grid {

            grid-template-columns: repeat(2, 1fr);

        }

        .owner-status-card,

        .owner-actions-card,

        .owner-upcoming-card,

        .owner-system-card,

        .owner-warnings-card,

        .owner-activity-card {

            grid-column: span 12;

        }

    }



    @media (max-width: 575px) {

        .owner-dashboard-space {

            padding: 21px 0 32px;

        }

        .owner-dashboard-shell {

            width: calc(100% - 24px);

        }

        .owner-dashboard-header {

            flex-direction: column;

            align-items: flex-start;

        }

        .owner-dashboard-date {

            text-align: left;

        }

        .owner-summary-grid {

            grid-template-columns: 1fr 1fr;

        }

        .owner-status-content {

            grid-template-columns: 1fr;

        }

        .owner-upcoming-row {

            grid-template-columns: 1fr auto;

        }

        .owner-reservation-status {

            grid-column: 1 / -1;

            justify-self: flex-start;

        }

        .owner-system-metrics {

            grid-template-columns: 1fr;

        }

        .owner-system-metrics > div:nth-child(odd),

        .owner-system-metrics > div:nth-child(even) {

            padding-left: 0;

            padding-right: 0;

            border-right: 0;

        }

        .owner-activity-row {

            align-items: flex-start;

            flex-direction: column;

            padding: 13px 0;

            gap: 8px;

        }

    }

</style>

@endpush