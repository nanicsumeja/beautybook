@extends('layouts.app')

@section('body-class', 'employee-schedule-page')

@section('content')

<section class="employee-schedule-space">

    <div class="employee-schedule-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="employee-schedule-header">

            <div>

                <span class="schedule-eyebrow">
                    EMPLOYEE WORKSPACE
                </span>

                <h1>
                    My schedule
                </h1>

                <p>
                    View and manage your assigned appointments.
                </p>

            </div>

        </div>


        {{-- =====================================================
             TOOLBAR
        ====================================================== --}}
        <div class="schedule-toolbar">

            <div class="schedule-filters">

                <a
                    href="{{ route('employee.schedule.index', ['filter' => 'all']) }}"
                    class="schedule-filter {{
                        $filter === 'all'
                            ? 'active'
                            : ''
                    }}"
                >
                    ALL
                </a>


                <a
                    href="{{ route('employee.schedule.index', ['filter' => 'today']) }}"
                    class="schedule-filter {{
                        $filter === 'today'
                            ? 'active'
                            : ''
                    }}"
                >
                    TODAY
                </a>


                <a
                    href="{{ route('employee.schedule.index', ['filter' => 'future']) }}"
                    class="schedule-filter {{
                        $filter === 'future'
                            ? 'active'
                            : ''
                    }}"
                >
                    FUTURE
                </a>


                <a
                    href="{{ route('employee.schedule.index', ['filter' => 'completed']) }}"
                    class="schedule-filter {{
                        $filter === 'completed'
                            ? 'active'
                            : ''
                    }}"
                >
                    COMPLETED
                </a>


                <a
                    href="{{ route('employee.schedule.index', ['filter' => 'cancelled']) }}"
                    class="schedule-filter {{
                        $filter === 'cancelled'
                            ? 'active'
                            : ''
                    }}"
                >
                    CANCELLED
                </a>

            </div>


            {{-- =================================================
                 DATE FILTER
            ================================================== --}}
            <form
                method="GET"
                action="{{ route('employee.schedule.index') }}"
                class="schedule-date-filter"
            >

                <div>

                    <label for="date">
                        DATE
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date') }}"
                    >

                    <input
                        type="hidden"
                        name="filter"
                        value="{{ $filter }}"
                    >

                </div>


                <button type="submit">
                    FILTER
                </button>


                @if (request('date'))

                    <a
                        href="{{ route(
                            'employee.schedule.index',
                            ['filter' => $filter]
                        ) }}"
                        class="schedule-clear"
                    >
                        CLEAR
                    </a>

                @endif

            </form>

        </div>


        {{-- =====================================================
             EMPTY
        ====================================================== --}}
        @if ($reservations->isEmpty())

            <div class="schedule-empty">

                <span>
                    NO APPOINTMENTS
                </span>

                <h2>
                    Your schedule is clear.
                </h2>

                <p>

                    @if (request('date'))

                        You have no appointments for the selected date.

                    @else

                        You currently have no assigned appointments.

                    @endif

                </p>

            </div>


        @else


            {{-- =================================================
                 LIST
            ================================================== --}}
            <div class="schedule-list">

                <div class="schedule-list-header">

                    <span>
                        DATE & TIME
                    </span>

                    <span>
                        CLIENT
                    </span>

                    <span>
                        SERVICE
                    </span>

                    <span>
                        STATUS
                    </span>

                    <span></span>

                </div>


                @foreach ($reservations as $reservation)

                    @php

                        $statusClass = match ($reservation->status) {
                            'confirmed' => 'confirmed',
                            'completed' => 'completed',
                            'cancelled' => 'cancelled',
                            'pending' => 'pending',
                            default => 'default',
                        };

                    @endphp


                    <article class="schedule-row">


                        {{-- =========================================
                             DATE & TIME
                        ========================================== --}}
                        <div class="schedule-date-time">

                            <div class="schedule-date-block">

                                <strong>
                                    {{ $reservation->appointment_date->format('d') }}
                                </strong>

                                <span>
                                    {{
                                        strtoupper(
                                            $reservation
                                                ->appointment_date
                                                ->format('M')
                                        )
                                    }}
                                </span>

                            </div>


                            <div>

                                <span class="schedule-full-date">
                                    {{ $reservation->appointment_date->format('d.m.Y') }}
                                </span>

                                <strong class="schedule-time">

                                    {{ substr($reservation->start_time, 0, 5) }}

                                    –

                                    {{ substr($reservation->end_time, 0, 5) }}

                                </strong>

                            </div>

                        </div>



                        {{-- =========================================
                             CLIENT
                        ========================================== --}}
                        <div class="schedule-client">

                            <span>
                                CLIENT
                            </span>

                            <strong>

                                @if ($reservation->client)

                                    {{ $reservation->client->name }}
                                    {{ $reservation->client->surname }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>



                        {{-- =========================================
                             SERVICE
                        ========================================== --}}
                        <div class="schedule-service">

                            <span>
                                SERVICE
                            </span>

                            <strong>
                                {{ $reservation->service_name }}
                            </strong>

                        </div>



                        {{-- =========================================
                             STATUS
                        ========================================== --}}
                        <div>

                            <span class="schedule-status {{ $statusClass }}">

                                {{ strtoupper($reservation->status) }}

                            </span>

                        </div>



                        {{-- =========================================
                             ACTION
                        ========================================== --}}
                        <div class="schedule-action">

                            <a
                                href="{{ route(
                                    'employee.schedule.show',
                                    $reservation
                                ) }}"
                            >
                                VIEW
                                <span>→</span>
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — EMPLOYEE SCHEDULE
========================================================= */

.employee-schedule-page {
    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   APP
========================================================= */

.employee-schedule-page #app {
    display: flex;

    width: 100%;

    min-height: 100svh;

    flex-direction: column;

    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   NAVBAR — EXACTLY LIKE EMPLOYEE DASHBOARD
========================================================= */

.employee-schedule-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background:
        #efebe6 !important;

    border: 0 !important;

    box-shadow: none !important;

    font-family:
        'Montserrat',
        sans-serif !important;
}


.employee-schedule-page .navbar .container,
.employee-schedule-page .navbar .container-fluid {
    min-height: 66px;
}


/* BEAUTYBOOK */

.employee-schedule-page .navbar-brand {
    color:
        #272522 !important;

    font-family:
        'Montserrat',
        sans-serif !important;

    font-weight: 400 !important;

    letter-spacing:
        -0.035em !important;
}


/* DASHBOARD / MY SCHEDULE / CLIENTS */

.employee-schedule-page .navbar .nav-link,
.employee-schedule-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-family:
        'Montserrat',
        sans-serif !important;

    font-size:
        0.82rem !important;

    font-weight:
        300 !important;

    letter-spacing:
        normal !important;
}


.employee-schedule-page .navbar .nav-link:hover,
.employee-schedule-page .navbar .nav-link.active,
.employee-schedule-page .navbar .dropdown-toggle:hover,
.employee-schedule-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}


/* USER DROPDOWN */

.employee-schedule-page .navbar .dropdown-menu {
    margin-top: 8px;

    padding:
        7px
        0;

    background:
        #f4f0ec;

    border:
        1px solid rgba(46,42,38,0.11);

    border-radius: 0;

    box-shadow:
        0 12px 30px rgba(46,42,38,0.07);

    font-family:
        'Montserrat',
        sans-serif;
}


.employee-schedule-page .navbar .dropdown-item {
    padding:
        8px
        16px;

    color:
        #4b4743;

    font-family:
        'Montserrat',
        sans-serif;

    font-size:
        0.72rem;

    font-weight:
        300;
}


.employee-schedule-page .navbar .dropdown-item:hover,
.employee-schedule-page .navbar .dropdown-item:focus {
    background:
        #e8dfda;

    color:
        #292724;
}


/* =========================================================
   SHORT DESKTOP — SAME AS DASHBOARD
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .employee-schedule-page .navbar {
        flex-basis: 58px;

        min-height: 58px;
    }


    .employee-schedule-page .navbar .container,
    .employee-schedule-page .navbar .container-fluid {
        min-height: 58px;
    }

}

/* LOGO */

.employee-schedule-page .navbar-brand {
    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


/* LINKS */

.employee-schedule-page .navbar .nav-link,
.employee-schedule-page .navbar .dropdown-toggle {
    color:
        rgba(48, 45, 42, 0.67) !important;

    font-size: 0.82rem;

    font-weight: 300;

    transition:
        color 0.25s ease;
}


.employee-schedule-page .navbar .nav-link:hover,
.employee-schedule-page .navbar .nav-link.active,
.employee-schedule-page .navbar .dropdown-toggle:hover,
.employee-schedule-page .navbar .dropdown-toggle:focus {
    color: #292724 !important;
}


/* DROPDOWN */

.employee-schedule-page .navbar .dropdown-menu {
    margin-top: 8px;

    padding:
        7px
        0;

    background: #f4f0ec;

    border:
        1px solid rgba(46,42,38,0.11);

    border-radius: 0;

    box-shadow:
        0 12px 30px rgba(46,42,38,0.07);
}


.employee-schedule-page .navbar .dropdown-item {
    padding:
        8px
        16px;

    color: #4b4743;

    font-size: 0.72rem;

    font-weight: 300;

    transition:
        background 0.2s ease,
        color 0.2s ease;
}


.employee-schedule-page .navbar .dropdown-item:hover,
.employee-schedule-page .navbar .dropdown-item:focus {
    background: #e8dfda;

    color: #292724;
}


/* MOBILE TOGGLER */

.employee-schedule-page .navbar-toggler {
    padding:
        5px
        7px;

    border:
        1px solid rgba(46,42,38,0.14);

    border-radius: 0;

    box-shadow: none !important;
}


.employee-schedule-page .navbar-toggler:focus {
    box-shadow: none !important;
}



/* =========================================================
   PAGE
========================================================= */

.employee-schedule-space {
    min-height:
        calc(100vh - 66px);

    padding:
        28px
        0
        40px;

    background:

        radial-gradient(
            circle at 90% 5%,
            rgba(191, 151, 139, 0.12),
            transparent 24%
        ),

        #f3efea;

    color: #211d1a;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   SHELL
========================================================= */

.employee-schedule-shell {
    width:
        min(
            1180px,
            calc(100% - 48px)
        );

    margin:
        0
        auto;
}



/* =========================================================
   HEADER
========================================================= */

.employee-schedule-header {
    margin-bottom: 20px;

    padding-bottom: 17px;

    border-bottom:
        1px solid rgba(33,29,26,0.12);
}


.schedule-eyebrow {
    display: block;

    margin-bottom: 6px;

    font-size: 0.56rem;

    font-weight: 500;

    letter-spacing: 0.2em;

    color: #a27a6d;
}


.employee-schedule-header h1 {
    margin:
        0
        0
        5px;

    font-size:
        clamp(
            2rem,
            4vw,
            3.1rem
        );

    font-weight: 300;

    letter-spacing:
        -0.045em;
}


.employee-schedule-header p {
    margin: 0;

    font-size: 0.74rem;

    color: #7d746e;
}



/* =========================================================
   TOOLBAR
========================================================= */

.schedule-toolbar {
    display: flex;

    justify-content: space-between;

    align-items: flex-end;

    gap: 22px;

    margin-bottom: 18px;
}


.schedule-filters {
    display: flex;

    flex-wrap: wrap;

    gap: 6px;
}


.schedule-filter {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 38px;

    padding:
        0
        14px;

    background: #faf7f3;

    border:
        1px solid rgba(33,29,26,0.13);

    color: #211d1a;

    text-decoration: none;

    font-size: 0.5rem;

    font-weight: 500;

    letter-spacing: 0.13em;

    transition: 0.2s ease;
}


.schedule-filter:hover,
.schedule-filter.active {
    background: #211d1a;

    border-color: #211d1a;

    color: #fff;
}



/* =========================================================
   DATE FILTER
========================================================= */

.schedule-date-filter {
    display: flex;

    align-items: flex-end;

    gap: 7px;
}


.schedule-date-filter label {
    display: block;

    margin-bottom: 5px;

    font-size: 0.47rem;

    letter-spacing: 0.14em;

    color: #92796f;
}


.schedule-date-filter input {
    height: 38px;

    padding:
        0
        11px;

    border:
        1px solid rgba(33,29,26,0.16);

    background: #faf7f3;

    color: #211d1a;

    font-family: inherit;

    font-size: 0.65rem;

    outline: none;
}


.schedule-date-filter button,
.schedule-clear {
    height: 38px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding:
        0
        13px;

    border:
        1px solid #211d1a;

    background: #211d1a;

    color: #fff;

    text-decoration: none;

    font-family: inherit;

    font-size: 0.48rem;

    font-weight: 500;

    letter-spacing: 0.12em;
}


.schedule-clear {
    background: transparent;

    color: #211d1a;
}



/* =========================================================
   LIST
========================================================= */

.schedule-list {
    background: #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);
}


.schedule-list-header {
    display: grid;

    grid-template-columns:
        1.25fr
        1fr
        1.15fr
        0.7fr
        0.45fr;

    gap: 20px;

    padding:
        13px
        22px;

    background: #211d1a;

    color: #cbbeb8;
}


.schedule-list-header span {
    font-size: 0.46rem;

    letter-spacing: 0.14em;
}


.schedule-row {
    display: grid;

    grid-template-columns:
        1.25fr
        1fr
        1.15fr
        0.7fr
        0.45fr;

    gap: 20px;

    align-items: center;

    padding:
        16px
        22px;

    border-bottom:
        1px solid rgba(33,29,26,0.09);

    transition:
        background 0.15s ease;
}


.schedule-row:last-child {
    border-bottom: 0;
}


.schedule-row:hover {
    background: #f3ebe6;
}



/* =========================================================
   DATE
========================================================= */

.schedule-date-time {
    display: flex;

    align-items: center;

    gap: 14px;
}


.schedule-date-block {
    width: 44px;

    height: 52px;

    flex-shrink: 0;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    background: #dec7bd;
}


.schedule-date-block strong {
    font-size: 1.1rem;

    font-weight: 400;

    line-height: 1;
}


.schedule-date-block span {
    margin-top: 3px;

    font-size: 0.43rem;

    letter-spacing: 0.12em;
}


.schedule-full-date {
    display: block;

    margin-bottom: 3px;

    font-size: 0.5rem;

    color: #8d817a;
}


.schedule-time {
    font-size: 0.72rem;

    font-weight: 500;
}



/* =========================================================
   CONTENT
========================================================= */

.schedule-client span,
.schedule-service span {
    display: none;
}


.schedule-client strong,
.schedule-service strong {
    font-size: 0.68rem;

    font-weight: 500;
}



/* =========================================================
   STATUS
========================================================= */

.schedule-status {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 82px;

    padding:
        7px
        9px;

    font-size: 0.45rem;

    font-weight: 500;

    letter-spacing: 0.1em;
}


.schedule-status.confirmed {
    background: #dfe7dc;

    color: #52684f;
}


.schedule-status.completed {
    background: #211d1a;

    color: #fff;
}


.schedule-status.cancelled {
    background: #ead8d4;

    color: #8d554b;
}


.schedule-status.pending {
    background: #eee2c9;

    color: #8a6f3f;
}


.schedule-status.default {
    background: #e5e0dc;

    color: #706761;
}



/* =========================================================
   ACTION
========================================================= */

.schedule-action {
    text-align: right;
}


.schedule-action a {
    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: #211d1a;

    text-decoration: none;

    font-size: 0.48rem;

    font-weight: 500;

    letter-spacing: 0.12em;
}


.schedule-action a:hover {
    color: #9d7063;
}



/* =========================================================
   EMPTY
========================================================= */

.schedule-empty {
    padding:
        70px
        30px;

    background: #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);

    text-align: center;
}


.schedule-empty > span {
    display: block;

    margin-bottom: 7px;

    font-size: 0.5rem;

    letter-spacing: 0.16em;

    color: #a27a6d;
}


.schedule-empty h2 {
    margin:
        0
        0
        7px;

    font-size: 1.45rem;

    font-weight: 300;
}


.schedule-empty p {
    margin: 0;

    font-size: 0.67rem;

    color: #7c736d;
}



/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .schedule-toolbar {
        align-items: flex-start;

        flex-direction: column;
    }


    .schedule-list-header {
        display: none;
    }


    .schedule-row {
        grid-template-columns:
            1.25fr
            1fr;
    }


    .schedule-client span,
    .schedule-service span {
        display: block;

        margin-bottom: 4px;

        font-size: 0.44rem;

        letter-spacing: 0.12em;

        color: #9c8177;
    }


    .schedule-action {
        text-align: left;
    }

}



@media (max-width: 575px) {

    .employee-schedule-space {
        padding:
            22px
            0
            32px;
    }


    .employee-schedule-shell {
        width:
            calc(100% - 24px);
    }


    .schedule-date-filter {
        width: 100%;

        flex-wrap: wrap;
    }


    .schedule-date-filter > div {
        width: 100%;
    }


    .schedule-date-filter input {
        width: 100%;
    }


    .schedule-row {
        grid-template-columns:
            1fr;

        gap: 13px;

        padding: 18px;
    }


    .schedule-list-header {
        display: none;
    }

}

</style>

@endpush