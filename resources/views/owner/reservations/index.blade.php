@extends('layouts.app')

@section('body-class', 'owner-appointments-page')
@section('main-class', 'owner-appointments-main')

@section('content')

@php
    $totalCount = $reservations->count();
    $pendingCount = $reservations->where('status', 'pending')->count();
    $confirmedCount = $reservations->where('status', 'confirmed')->count();
    $completedCount = $reservations->where('status', 'completed')->count();
    $cancelledCount = $reservations->where('status', 'cancelled')->count();
@endphp


<section class="owner-appointments-space">

    <div class="owner-appointments-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="owner-appointments-header">

            <div>

                <span class="owner-appointments-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Appointments
                </h1>

                <p>
                    Review, manage and confirm client appointments.
                </p>

            </div>


            <div class="owner-appointments-header-actions">

                <a
                    href="{{ route('owner.reservations.create') }}"
                    class="owner-new-appointment"
                >
                    + NEW APPOINTMENT
                </a>

                <a
                    href="{{ route('owner.dashboard') }}"
                    class="owner-back-dashboard"
                >
                    ← DASHBOARD
                </a>

            </div>

        </header>



        {{-- =====================================================
             MESSAGES
        ====================================================== --}}

        @if (session('success'))

            <div class="owner-appointment-message success">

                <span>✓</span>

                {{ session('success') }}

            </div>

        @endif


        @if ($errors->has('reservation'))

            <div class="owner-appointment-message error">

                <span>!</span>

                {{ $errors->first('reservation') }}

            </div>

        @endif



        {{-- =====================================================
             SUMMARY
        ====================================================== --}}

        <section class="owner-appointments-summary">

            <article>
                <span>TOTAL</span>
                <strong>{{ $totalCount }}</strong>
            </article>

            <article>
                <span>PENDING</span>
                <strong>{{ $pendingCount }}</strong>
            </article>

            <article>
                <span>CONFIRMED</span>
                <strong>{{ $confirmedCount }}</strong>
            </article>

            <article>
                <span>COMPLETED</span>
                <strong>{{ $completedCount }}</strong>
            </article>

            <article>
                <span>CANCELLED</span>
                <strong>{{ $cancelledCount }}</strong>
            </article>

        </section>



        {{-- =====================================================
             TOOLBAR
        ====================================================== --}}

        <section class="owner-appointments-toolbar">

            <label
                for="appointmentSearch"
                class="owner-appointments-search"
            >

                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
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


            <div class="owner-appointments-filters">

                <button
                    type="button"
                    class="active"
                    data-appointment-filter="all"
                >
                    ALL
                </button>

                <button
                    type="button"
                    data-appointment-filter="pending"
                >
                    PENDING
                </button>

                <button
                    type="button"
                    data-appointment-filter="confirmed"
                >
                    CONFIRMED
                </button>

                <button
                    type="button"
                    data-appointment-filter="completed"
                >
                    COMPLETED
                </button>

                <button
                    type="button"
                    data-appointment-filter="cancelled"
                >
                    CANCELLED
                </button>

            </div>

        </section>



        {{-- =====================================================
             EMPTY
        ====================================================== --}}

        @if ($reservations->isEmpty())

            <div class="owner-appointments-empty">

                <span>○</span>

                <h2>
                    No appointments yet.
                </h2>

                <p>
                    Client appointments will appear here.
                </p>

            </div>

        @else



            {{-- =================================================
                 LIST
            ================================================== --}}

            <section class="owner-appointments-list">

                <div class="owner-appointments-list-head">

                    <span>CLIENT</span>
                    <span>SERVICE</span>
                    <span>DATE & TIME</span>
                    <span>PRICE</span>
                    <span>STATUS</span>
                    <span>ACTION</span>

                </div>


                <div class="owner-appointments-list-body">

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
                            class="owner-appointment-row"
                            data-appointment-row
                            data-status="{{ $reservation->status }}"
                            data-search="{{ $searchValue }}"
                        >


                            {{-- CLIENT --}}
                            <div class="owner-appointment-client">

                                <div class="owner-appointment-avatar">
                                    {{
                                        mb_strtoupper(
                                            mb_substr(
                                                $reservation->client->name,
                                                0,
                                                1
                                            )
                                        )
                                    }}
                                </div>


                                <div>

                                    <span class="owner-mobile-label">
                                        CLIENT
                                    </span>

                                    <strong>
                                        {{ $clientName }}
                                    </strong>

                                    <small>
                                        {{ $reservation->client->email }}
                                    </small>

                                </div>

                            </div>



                            {{-- SERVICE --}}
                            <div class="owner-appointment-service">

                                <span class="owner-mobile-label">
                                    SERVICE
                                </span>

                                <strong>
                                    {{ $reservation->service_name }}
                                </strong>

                                <small>
                                    {{ $reservation->duration_minutes }}
                                    min
                                </small>

                            </div>



                            {{-- DATE --}}
                            <div class="owner-appointment-date">

                                <span class="owner-mobile-label">
                                    DATE & TIME
                                </span>

                                <strong>
                                    {{
                                        $reservation
                                            ->appointment_date
                                            ->format('d.m.Y')
                                    }}
                                </strong>

                                <small>
                                    {{
                                        substr(
                                            $reservation->start_time,
                                            0,
                                            5
                                        )
                                    }}
                                    –
                                    {{
                                        substr(
                                            $reservation->end_time,
                                            0,
                                            5
                                        )
                                    }}
                                </small>

                            </div>



                            {{-- PRICE --}}
                            <div class="owner-appointment-price">

                                <span class="owner-mobile-label">
                                    PRICE
                                </span>

                                <strong>
                                    {{
                                        number_format(
                                            (float) $reservation->total_price,
                                            2
                                        )
                                    }}
                                </strong>

                                <small>
                                    KM
                                </small>

                            </div>



                            {{-- STATUS --}}
                            <div class="owner-appointment-status-cell">

                                <span class="owner-mobile-label">
                                    STATUS
                                </span>

                                <span
                                    class="
                                        owner-appointment-status
                                        {{ $reservation->status }}
                                    "
                                >
                                    {{ strtoupper($reservation->status) }}
                                </span>

                            </div>



                            {{-- ACTION --}}
                            <div class="owner-appointment-action">

                                <span class="owner-mobile-label">
                                    ACTION
                                </span>


                                @if (
                                    in_array(
                                        $reservation->status,
                                        ['pending', 'confirmed']
                                    )
                                )

                                    <div class="owner-appointment-actions">


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
                                                    class="
                                                        owner-action-button
                                                        confirm
                                                    "
                                                >
                                                    CONFIRM
                                                </button>

                                            </form>

                                        @endif


                                        <a
                                            href="{{ route(
                                                'owner.reservations.edit',
                                                $reservation
                                            ) }}"
                                            class="
                                                owner-action-button
                                                edit
                                            "
                                        >
                                            EDIT
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'owner.reservations.cancel',
                                                $reservation
                                            ) }}"
                                            onsubmit="return confirm(
                                                'Are you sure you want to cancel this appointment?'
                                            );"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="
                                                    owner-action-button
                                                    cancel
                                                "
                                            >
                                                CANCEL
                                            </button>

                                        </form>

                                    </div>

                                @else

                                    <span class="owner-no-action">
                                        —
                                    </span>

                                @endif

                            </div>

                        </article>

                    @endforeach


                    <div
                        class="owner-appointments-no-results"
                        id="appointmentsNoResults"
                        hidden
                    >
                        No appointments match your search.
                    </div>

                </div>



                {{-- FOOTER --}}
                <footer class="owner-appointments-footer">

                    <span id="appointmentResultCount">

                        Showing {{ $totalCount }}

                        {{
                            $totalCount === 1
                                ? 'appointment'
                                : 'appointments'
                        }}

                    </span>


                    <a href="{{ route('owner.dashboard') }}">
                        BACK TO DASHBOARD →
                    </a>

                </footer>

            </section>

        @endif

    </div>

</section>



<script>

document.addEventListener('DOMContentLoaded', () => {

    const searchInput =
        document.getElementById(
            'appointmentSearch'
        );


    const rows =
        Array.from(
            document.querySelectorAll(
                '[data-appointment-row]'
            )
        );


    const buttons =
        Array.from(
            document.querySelectorAll(
                '[data-appointment-filter]'
            )
        );


    const resultCount =
        document.getElementById(
            'appointmentResultCount'
        );


    const noResults =
        document.getElementById(
            'appointmentsNoResults'
        );


    if (!searchInput || rows.length === 0) {
        return;
    }


    let activeFilter = 'all';


    const updateAppointments = () => {

        const query =
            searchInput.value
                .trim()
                .toLowerCase();


        let visibleCount = 0;


        rows.forEach((row) => {

            const matchesSearch =
                row.dataset.search.includes(
                    query
                );


            const matchesStatus =
                activeFilter === 'all'
                || row.dataset.status
                    === activeFilter;


            const visible =
                matchesSearch
                && matchesStatus;


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

            noResults.hidden =
                visibleCount !== 0;

        }

    };


    searchInput.addEventListener(
        'input',
        updateAppointments
    );


    buttons.forEach((button) => {

        button.addEventListener(
            'click',
            () => {

                activeFilter =
                    button.dataset
                        .appointmentFilter;


                buttons.forEach((item) => {

                    item.classList.toggle(
                        'active',
                        item === button
                    );

                });


                updateAppointments();

            }
        );

    });

});

</script>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER APPOINTMENTS
========================================================= */

.owner-appointments-page {
    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   APP
========================================================= */

.owner-appointments-page #app {
    display: flex;

    width: 100%;

    min-height: 100svh;

    flex-direction: column;

    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-appointments-main {
    background: #efebe6;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-appointments-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background:
        #efebe6 !important;

    border:
        0 !important;

    box-shadow:
        none !important;

    font-family:
        'Montserrat',
        sans-serif !important;
}


.owner-appointments-page .navbar .container,
.owner-appointments-page .navbar .container-fluid {
    min-height: 66px;
}


/* BEAUTYBOOK */

.owner-appointments-page .navbar-brand {
    color:
        #272522 !important;

    font-family:
        'Montserrat',
        sans-serif !important;

    font-weight:
        400 !important;

    letter-spacing:
        -0.035em !important;
}


/* NAV LINKS */

.owner-appointments-page .navbar .nav-link,
.owner-appointments-page .navbar .dropdown-toggle {
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


.owner-appointments-page .navbar .nav-link:hover,
.owner-appointments-page .navbar .nav-link.active,
.owner-appointments-page .navbar .dropdown-toggle:hover,
.owner-appointments-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}


/* =========================================================
   DROPDOWN
========================================================= */

.owner-appointments-page .navbar .dropdown-menu {
    margin-top:
        8px;

    padding:
        7px
        0;

    background:
        #f4f0ec;

    border:
        1px solid rgba(46,42,38,0.11);

    border-radius:
        0;

    box-shadow:
        0 12px 30px rgba(46,42,38,0.07);

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-appointments-page .navbar .dropdown-item {
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


.owner-appointments-page .navbar .dropdown-item:hover,
.owner-appointments-page .navbar .dropdown-item:focus {
    background:
        #e8dfda;

    color:
        #292724;
}



/* =========================================================
   PAGE
========================================================= */

.owner-appointments-space {
    min-height:
        calc(100vh - 66px);

    padding:
        26px
        0
        40px;

    background:
        radial-gradient(
            circle at 93% 5%,
            rgba(200,165,153,0.13),
            transparent 23%
        ),
        #efebe6;

    color:
        #292724;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-appointments-shell {
    width:
        min(
            1220px,
            calc(100% - 48px)
        );

    margin:
        0
        auto;
}



/* =========================================================
   HEADER
========================================================= */

.owner-appointments-header {
    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        28px;

    padding-bottom:
        17px;

    margin-bottom:
        17px;

    border-bottom:
        1px solid rgba(46,42,38,0.14);
}


.owner-appointments-eyebrow {
    display:
        block;

    margin-bottom:
        5px;

    font-size:
        0.64rem;

    font-weight:
        500;

    letter-spacing:
        0.20em;

    color:
        #a87f73;
}


.owner-appointments-header h1 {
    margin:
        0
        0
        4px;

    color:
        #292724;

    font-size:
        clamp(
            2rem,
            4vw,
            3.1rem
        );

    font-weight:
        300;

    letter-spacing:
        -0.045em;
}


.owner-appointments-header p {
    margin:
        0;

    color:
        #7f756f;

    font-size:
        0.76rem;

    font-weight:
        300;
}


.owner-appointments-header-actions {
    display:
        flex;

    align-items:
        center;

    gap:
        13px;
}



/* =========================================================
   NEW APPOINTMENT
========================================================= */

.owner-new-appointment {
    min-height:
        39px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        0
        14px;

    background:
        #292724;

    border:
        1px solid #292724;

    color:
        #fff;

    text-decoration:
        none;

    font-size:
        0.58rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;

    transition:
        background 0.25s ease,
        border-color 0.25s ease,
        transform 0.25s ease;
}


.owner-new-appointment:hover {
    background:
        #a87f73;

    border-color:
        #a87f73;

    color:
        #fff;

    transform:
        translateY(-1px);
}


.owner-back-dashboard {
    color:
        #292724;

    text-decoration:
        none;

    font-size:
        0.57rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;

    transition:
        color 0.25s ease;
}


.owner-back-dashboard:hover {
    color:
        #a87f73;
}



/* =========================================================
   MESSAGES
========================================================= */

.owner-appointment-message {
    margin-bottom:
        15px;

    padding:
        12px
        14px;

    display:
        flex;

    align-items:
        center;

    gap:
        9px;

    border-left:
        3px solid;

    font-size:
        0.69rem;
}


.owner-appointment-message.success {
    background:
        #e2e9df;

    border-color:
        #789073;

    color:
        #52644e;
}


.owner-appointment-message.error {
    background:
        #ead8d4;

    border-color:
        #a7665b;

    color:
        #804f47;
}



/* =========================================================
   SUMMARY
========================================================= */

.owner-appointments-summary {
    display:
        grid;

    grid-template-columns:
        repeat(5,1fr);

    gap:
        7px;

    margin-bottom:
        16px;
}


.owner-appointments-summary article {
    padding:
        13px
        15px;

    border:
        1px solid rgba(46,42,38,0.08);

    color:
        #403b37;

    transition:
        transform 0.2s ease,
        border-color 0.2s ease;
}


.owner-appointments-summary article:hover {
    transform:
        translateY(-1px);

    border-color:
        rgba(46,42,38,0.16);
}


/* TOTAL */

.owner-appointments-summary article:nth-child(1) {
    background:
        #f7f2ed;

    color:
        #4b4540;
}


/* PENDING */

.owner-appointments-summary article:nth-child(2) {
    background:
        #eee3ca;

    color:
        #725f3f;
}


/* CONFIRMED */

.owner-appointments-summary article:nth-child(3) {
    background:
        #dce5d8;

    color:
        #51634e;
}


/* COMPLETED */

.owner-appointments-summary article:nth-child(4) {
    background:
        #ddd2cc;

    color:
        #5f514b;
}


/* CANCELLED */

.owner-appointments-summary article:nth-child(5) {
    background:
        #ead5d1;

    color:
        #87564e;
}


.owner-appointments-summary span {
    display:
        block;

    margin-bottom:
        3px;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.13em;

    opacity:
        0.75;
}


.owner-appointments-summary strong {
    font-size:
        1.25rem;

    font-weight:
        400;
}



/* =========================================================
   TOOLBAR
========================================================= */

.owner-appointments-toolbar {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        15px;

    margin-bottom:
        12px;
}



/* =========================================================
   SEARCH
========================================================= */

.owner-appointments-search {
    width:
        min(
            350px,
            100%
        );

    height:
        39px;

    display:
        flex;

    align-items:
        center;

    gap:
        9px;

    padding:
        0
        12px;

    border:
        1px solid rgba(46,42,38,0.14);

    background:
        #faf7f3;
}


.owner-appointments-search svg {
    width:
        14px;

    height:
        14px;

    fill:
        none;

    stroke:
        #8c7f78;

    stroke-width:
        1.5;
}


.owner-appointments-search input {
    width:
        100%;

    border:
        0;

    outline:
        none;

    background:
        transparent;

    color:
        #292724;

    font-family:
        inherit;

    font-size:
        0.70rem;
}



/* =========================================================
   FILTERS
========================================================= */

.owner-appointments-filters {
    display:
        flex;

    gap:
        4px;

    flex-wrap:
        wrap;
}


.owner-appointments-filters button {
    min-height:
        32px;

    padding:
        0
        10px;

    border:
        1px solid rgba(46,42,38,0.13);

    background:
        transparent;

    color:
        #776d67;

    font-family:
        inherit;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.09em;

    cursor:
        pointer;

    transition:
        background 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease;
}


.owner-appointments-filters button.active {
    background:
        #292724;

    border-color:
        #292724;

    color:
        #fff;
}


.owner-appointments-filters button:hover {
    background:
        #a87f73;

    border-color:
        #a87f73;

    color:
        #fff;
}



/* =========================================================
   LIST
========================================================= */

.owner-appointments-list {
    background:
        #faf7f3;

    border:
        1px solid rgba(46,42,38,0.08);
}


.owner-appointments-list-head {
    display:
        grid;

    grid-template-columns:
        1.3fr
        1fr
        0.95fr
        0.55fr
        0.65fr
        1.25fr;

    gap:
        18px;

    padding:
        12px
        18px;

    background:
        #e9e0da;

    color:
        #292724;
}


.owner-appointments-list-head span {
    font-size:
        0.53rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.owner-appointment-row {
    display:
        grid;

    grid-template-columns:
        1.3fr
        1fr
        0.95fr
        0.55fr
        0.65fr
        1.25fr;

    gap:
        18px;

    align-items:
        center;

    min-height:
        72px;

    padding:
        11px
        18px;

    border-bottom:
        1px solid rgba(46,42,38,0.08);

    transition:
        background 0.15s ease;
}


.owner-appointment-row:last-child {
    border-bottom:
        0;
}


.owner-appointment-row:hover {
    background:
        #f3ebe6;
}



/* =========================================================
   CLIENT
========================================================= */

.owner-appointment-client {
    display:
        flex;

    align-items:
        center;

    gap:
        11px;

    min-width:
        0;
}


.owner-appointment-avatar {
    width:
        36px;

    height:
        36px;

    flex-shrink:
        0;

    display:
        grid;

    place-items:
        center;

    background:
        #dec7bd;

    color:
        #5f463f;

    font-size:
        0.72rem;
}


.owner-appointment-client strong,
.owner-appointment-service strong,
.owner-appointment-date strong,
.owner-appointment-price strong {
    display:
        block;

    color:
        #35312e;

    font-size:
        0.70rem;

    font-weight:
        500;
}


.owner-appointment-client small,
.owner-appointment-service small,
.owner-appointment-date small,
.owner-appointment-price small {
    display:
        block;

    margin-top:
        3px;

    color:
        #8c817a;

    font-size:
        0.59rem;
}


.owner-mobile-label {
    display:
        none;
}



/* =========================================================
   STATUS
========================================================= */

.owner-appointment-status {
    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    min-width:
        76px;

    padding:
        6px
        7px;

    font-size:
        0.51rem;

    font-weight:
        500;

    letter-spacing:
        0.08em;
}


/* PENDING */

.owner-appointment-status.pending {
    background:
        #eee3ca;

    color:
        #725f3f;
}


/* CONFIRMED */

.owner-appointment-status.confirmed {
    background:
        #dce5d8;

    color:
        #51634e;
}


/* COMPLETED */

.owner-appointment-status.completed {
    background:
        #ddd2cc;

    color:
        #5f514b;
}


/* CANCELLED */

.owner-appointment-status.cancelled {
    background:
        #ead5d1;

    color:
        #87564e;
}



/* =========================================================
   ACTIONS
========================================================= */

.owner-appointment-actions {
    display:
        flex;

    align-items:
        center;

    gap:
        4px;

    flex-wrap:
        wrap;
}


.owner-appointment-actions form {
    margin:
        0;
}


.owner-action-button {
    min-height:
        27px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        0
        7px;

    border:
        1px solid #292724;

    background:
        transparent;

    color:
        #292724;

    text-decoration:
        none;

    font-family:
        inherit;

    font-size:
        0.50rem;

    font-weight:
        500;

    letter-spacing:
        0.07em;

    cursor:
        pointer;

    transition:
        background 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease;
}


/* CONFIRM */

.owner-action-button.confirm {
    background:
        #292724;

    color:
        #fff;
}


.owner-action-button.confirm:hover {
    background:
        #73816e;

    border-color:
        #73816e;

    color:
        #fff;
}


/* EDIT */

.owner-action-button.edit:hover {
    background:
        #d8b8ad;

    border-color:
        #d8b8ad;

    color:
        #292724;
}


/* CANCEL */

.owner-action-button.cancel {
    border-color:
        #b4786d;

    color:
        #9b6258;
}


.owner-action-button.cancel:hover {
    background:
        #9b6258;

    border-color:
        #9b6258;

    color:
        #fff;
}


.owner-no-action {
    color:
        #aaa09a;

    font-size:
        0.70rem;
}



/* =========================================================
   FOOTER
========================================================= */

.owner-appointments-footer {
    min-height:
        44px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    padding:
        0
        18px;

    border-top:
        1px solid rgba(46,42,38,0.08);

    font-size:
        0.59rem;

    color:
        #81766f;
}


.owner-appointments-footer a {
    color:
        #292724;

    text-decoration:
        none;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;

    transition:
        color 0.2s ease;
}


.owner-appointments-footer a:hover {
    color:
        #a87f73;
}



/* =========================================================
   EMPTY
========================================================= */

.owner-appointments-empty {
    padding:
        70px
        30px;

    background:
        #faf7f3;

    border:
        1px solid rgba(46,42,38,0.08);

    text-align:
        center;
}


.owner-appointments-empty > span {
    display:
        block;

    margin-bottom:
        7px;

    color:
        #b69186;

    font-size:
        1.5rem;

    font-weight:
        300;
}


.owner-appointments-empty h2 {
    margin:
        0
        0
        6px;

    color:
        #292724;

    font-size:
        1.3rem;

    font-weight:
        300;
}


.owner-appointments-empty p {
    margin:
        0;

    color:
        #81766f;

    font-size:
        0.69rem;
}



/* =========================================================
   NO RESULTS
========================================================= */

.owner-appointments-no-results {
    padding:
        28px;

    text-align:
        center;

    color:
        #81766f;

    font-size:
        0.68rem;
}



/* =========================================================
   SHORT DESKTOP — SAME NAVBAR AS EMPLOYEE
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-appointments-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .owner-appointments-page .navbar .container,
    .owner-appointments-page .navbar .container-fluid {
        min-height:
            58px;
    }

}



/* =========================================================
   RESPONSIVE — TABLET
========================================================= */

@media (max-width: 1050px) {

    .owner-appointments-list-head {
        display:
            none;
    }


    .owner-appointment-row {
        grid-template-columns:
            repeat(3,1fr);

        gap:
            15px;

        padding:
            18px;
    }


    .owner-mobile-label {
        display:
            block;

        margin-bottom:
            4px;

        color:
            #9d8076;

        font-size:
            0.52rem;

        letter-spacing:
            0.10em;
    }

}



/* =========================================================
   RESPONSIVE — SMALL TABLET
========================================================= */

@media (max-width: 780px) {

    .owner-appointments-header {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .owner-appointments-toolbar {
        align-items:
            stretch;

        flex-direction:
            column;
    }


    .owner-appointments-search {
        width:
            100%;
    }


    .owner-appointments-summary {
        grid-template-columns:
            repeat(2,1fr);
    }


    .owner-appointments-summary article:first-child {
        grid-column:
            span 2;
    }


    .owner-appointment-row {
        grid-template-columns:
            1fr
            1fr;
    }

}



/* =========================================================
   RESPONSIVE — MOBILE
========================================================= */

@media (max-width: 575px) {

    .owner-appointments-space {
        padding:
            21px
            0
            32px;
    }


    .owner-appointments-shell {
        width:
            calc(100% - 24px);
    }


    .owner-appointments-header-actions {
        width:
            100%;

        flex-direction:
            column;

        align-items:
            stretch;
    }


    .owner-new-appointment {
        width:
            100%;
    }


    .owner-back-dashboard {
        text-align:
            center;
    }


    .owner-appointments-filters {
        display:
            grid;

        grid-template-columns:
            repeat(2,1fr);
    }


    .owner-appointment-row {
        grid-template-columns:
            1fr;

        gap:
            13px;
    }


    .owner-appointments-footer {
        padding:
            13px
            18px;

        align-items:
            flex-start;

        flex-direction:
            column;
    }

}

</style>

@endpush