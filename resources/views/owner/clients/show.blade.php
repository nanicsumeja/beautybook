@extends('layouts.app')

@section('body-class', 'owner-client-profile-page')

@section('main-class', 'owner-client-profile-main')

@section('content')

<section class="owner-client-profile-space">

    <div class="owner-client-profile-shell">

        {{-- BACK --}}
        <div class="owner-client-profile-back-row">

            <a
                href="{{ route('owner.clients.index') }}"
                class="owner-client-profile-back"
            >
                ← BACK TO CLIENTS
            </a>

        </div>


        {{-- HEADER --}}
        <header class="owner-client-profile-header">

            <div>

                <span class="owner-client-profile-eyebrow">
                    CLIENT PROFILE
                </span>

                <h1>
                    {{ $client->name }}
                    {{ $client->surname }}
                </h1>

                <p>
                    Client profile and completed service history.
                </p>

            </div>


            <div class="owner-client-profile-avatar">
                {{
                    mb_strtoupper(
                        mb_substr(
                            $client->name,
                            0,
                            1
                        )
                    )
                }}
            </div>

        </header>


        <div class="owner-client-profile-grid">


            {{-- LEFT PROFILE CARD --}}
            <aside class="owner-client-profile-card">

                <div class="owner-client-profile-card-top">

                    <span>
                        CONTACT
                    </span>

                    <h2>
                        Client information
                    </h2>

                </div>


                <div class="owner-client-profile-contact">

                    <div>

                        <span>
                            EMAIL
                        </span>

                        <strong>
                            {{ $client->email }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            PHONE
                        </span>

                        <strong>
                            {{ $client->phone ?: '—' }}
                        </strong>

                    </div>

                </div>


                {{-- ACCOUNT STATUS --}}
                <div class="owner-client-profile-status">

                    <div>

                        <span>
                            ACCOUNT STATUS
                        </span>

                        <strong
                            class="{{
                                $client->is_active
                                    ? 'is-active'
                                    : 'is-inactive'
                            }}"
                        >
                            {{
                                $client->is_active
                                    ? 'ACTIVE'
                                    : 'INACTIVE'
                            }}
                        </strong>

                    </div>


                    <form
                        method="POST"
                        action="{{ route(
                            'owner.clients.toggle-active',
                            $client
                        ) }}"
                        onsubmit="return confirm(
                            '{{ $client->is_active
                                ? 'Are you sure you want to deactivate this client? They will no longer be able to log in.'
                                : 'Are you sure you want to activate this client?' }}'
                        )"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="{{
                                $client->is_active
                                    ? 'deactivate'
                                    : 'activate'
                            }}"
                        >
                            {{
                                $client->is_active
                                    ? 'DEACTIVATE CLIENT'
                                    : 'ACTIVATE CLIENT'
                            }}
                        </button>

                    </form>

                </div>


                {{-- SERVICE COUNT --}}
                <div class="owner-client-profile-note">

                    <span>
                        SERVICE HISTORY
                    </span>

                    <div class="owner-client-profile-note-value">

                        <strong>
                            {{ $completedReservations->count() }}
                        </strong>

                        <small>
                            completed
                            {{
                                $completedReservations->count() === 1
                                    ? 'service'
                                    : 'services'
                            }}
                        </small>

                    </div>

                </div>

            </aside>



            {{-- HISTORY --}}
            <section class="owner-client-history">

                <div class="owner-client-history-heading">

                    <div>

                        <span>
                            COMPLETED APPOINTMENTS
                        </span>

                        <h2>
                            Service history
                        </h2>

                    </div>


                    <strong>
                        {{ $completedReservations->count() }}
                    </strong>

                </div>



                @if ($completedReservations->isEmpty())

                    <div class="owner-client-history-empty">

                        <span>
                            ○
                        </span>

                        <h3>
                            No completed services yet.
                        </h3>

                        <p>
                            Completed appointments will appear here.
                        </p>

                    </div>

                @else


                    <div class="owner-client-history-head">

                        <span>DATE</span>
                        <span>SERVICE</span>
                        <span>EMPLOYEE</span>
                        <span>PRICE</span>
                        <span>STATUS</span>

                    </div>


                    <div class="owner-client-history-list">

                        @foreach ($completedReservations as $reservation)

                            <article class="owner-client-history-row">


                                {{-- DATE --}}
                                <div>

                                    <span class="owner-history-mobile-label">
                                        DATE
                                    </span>

                                    <strong>
                                        {{
                                            $reservation
                                                ->appointment_date
                                                ->format('d.m.Y')
                                        }}
                                    </strong>

                                </div>


                                {{-- SERVICE --}}
                                <div>

                                    <span class="owner-history-mobile-label">
                                        SERVICE
                                    </span>

                                    <strong>
                                        {{ $reservation->service_name }}
                                    </strong>


                                    @if ($reservation->employee_note)

                                        <small>
                                            {{ $reservation->employee_note }}
                                        </small>

                                    @endif

                                </div>


                                {{-- EMPLOYEE --}}
                                <div>

                                    <span class="owner-history-mobile-label">
                                        EMPLOYEE
                                    </span>

                                    <strong>

                                        @if ($reservation->employee)

                                            {{ $reservation->employee->name }}
                                            {{ $reservation->employee->surname }}

                                        @else

                                            —

                                        @endif

                                    </strong>

                                </div>


                                {{-- PRICE --}}
                                <div>

                                    <span class="owner-history-mobile-label">
                                        PRICE
                                    </span>

                                    <strong>
                                        {{
                                            number_format(
                                                (float) $reservation->total_price,
                                                2
                                            )
                                        }}
                                        KM
                                    </strong>

                                </div>


                                {{-- STATUS --}}
                                <div>

                                    <span class="owner-history-mobile-label">
                                        STATUS
                                    </span>

                                    <span class="owner-history-status">
                                        COMPLETED
                                    </span>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @endif

            </section>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER CLIENT PROFILE
========================================================= */

.owner-client-profile-page {
    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   APP
========================================================= */

.owner-client-profile-page #app {
    display: flex;
    width: 100%;
    min-height: 100svh;
    flex-direction: column;

    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-client-profile-main {
    background: #f3efea;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-client-profile-page .navbar {
    position: relative;
    z-index: 50;

    flex: 0 0 66px;
    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background: #efebe6 !important;

    border: 0 !important;
    box-shadow: none !important;
}


.owner-client-profile-page .navbar .container,
.owner-client-profile-page .navbar .container-fluid {
    min-height: 66px;
}


.owner-client-profile-page .navbar-brand {
    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.owner-client-profile-page .navbar .nav-link,
.owner-client-profile-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-size: 0.82rem;

    font-weight: 300;
}


.owner-client-profile-page .navbar .nav-link:hover,
.owner-client-profile-page .navbar .nav-link.active,
.owner-client-profile-page .navbar .dropdown-toggle:hover,
.owner-client-profile-page .navbar .dropdown-toggle:focus {
    color: #292724 !important;
}



/* =========================================================
   PAGE
========================================================= */

.owner-client-profile-space {
    min-height:
        calc(100vh - 66px);

    padding:
        25px
        0
        40px;

    background:
        radial-gradient(
            circle at 92% 5%,
            rgba(190,151,140,0.12),
            transparent 24%
        ),
        #f3efea;

    color: #292724;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-client-profile-shell {
    width:
        min(
            1140px,
            calc(100% - 48px)
        );

    margin:
        0 auto;
}



/* =========================================================
   BACK
========================================================= */

.owner-client-profile-back-row {
    margin-bottom: 14px;
}


.owner-client-profile-back {
    color: #6f655f;

    text-decoration: none;

    font-size: 0.55rem;

    font-weight: 500;

    letter-spacing: 0.11em;

    transition:
        color 0.2s ease;
}


.owner-client-profile-back:hover {
    color: #a87f73;
}



/* =========================================================
   HEADER
========================================================= */

.owner-client-profile-header {
    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 25px;

    margin-bottom: 18px;

    padding-bottom: 17px;

    border-bottom:
        1px solid rgba(46,42,38,0.12);
}


.owner-client-profile-eyebrow {
    display: block;

    margin-bottom: 5px;

    color: #a0796d;

    font-size: 0.60rem;

    font-weight: 500;

    letter-spacing: 0.19em;
}


.owner-client-profile-header h1 {
    margin:
        0
        0
        5px;

    font-size:
        clamp(
            2rem,
            4vw,
            3rem
        );

    font-weight: 300;

    letter-spacing:
        -0.045em;
}


.owner-client-profile-header p {
    margin: 0;

    color: #81766f;

    font-size: 0.74rem;

    font-weight: 300;
}


.owner-client-profile-avatar {
    width: 56px;
    height: 56px;

    display: grid;

    place-items: center;

    flex-shrink: 0;

    background: #dec7bd;

    border:
        1px solid rgba(92,68,61,0.08);

    color: #624a43;

    font-size: 1.05rem;

    font-weight: 400;
}



/* =========================================================
   MAIN GRID
========================================================= */

.owner-client-profile-grid {
    display: grid;

    grid-template-columns:
        minmax(280px, 0.76fr)
        minmax(0, 1.24fr);

    gap: 14px;

    align-items: start;
}



/* =========================================================
   PROFILE CARD
========================================================= */

.owner-client-profile-card {
    overflow: hidden;

    background: #eee5df;

    border:
        1px solid rgba(46,42,38,0.09);

    color: #292724;
}


.owner-client-profile-card-top {
    padding:
        20px
        21px
        17px;

    background: #e6d4cd;

    border-bottom:
        1px solid rgba(46,42,38,0.08);
}


.owner-client-profile-card-top span {
    display: block;

    margin-bottom: 4px;

    color: #986f64;

    font-size: 0.54rem;

    font-weight: 500;

    letter-spacing: 0.14em;
}


.owner-client-profile-card-top h2 {
    margin: 0;

    color: #332d2a;

    font-size: 1.12rem;

    font-weight: 300;
}



/* =========================================================
   CONTACT
========================================================= */

.owner-client-profile-contact {
    padding:
        5px
        21px;
}


.owner-client-profile-contact > div {
    padding:
        16px
        0;

    border-bottom:
        1px solid rgba(46,42,38,0.09);
}


.owner-client-profile-contact > div:last-child {
    border-bottom: 0;
}


.owner-client-profile-contact span {
    display: block;

    margin-bottom: 5px;

    color: #a18176;

    font-size: 0.53rem;

    font-weight: 500;

    letter-spacing: 0.11em;
}


.owner-client-profile-contact strong {
    display: block;

    overflow-wrap: anywhere;

    color: #4f4844;

    font-size: 0.68rem;

    font-weight: 500;
}



/* =========================================================
   ACCOUNT STATUS
========================================================= */

.owner-client-profile-status {
    margin:
        4px
        21px
        0;

    padding:
        17px
        0
        18px;

    border-top:
        1px solid rgba(46,42,38,0.09);
}


.owner-client-profile-status > div {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 13px;
}


.owner-client-profile-status > div > span {
    color: #92766c;

    font-size: 0.53rem;

    font-weight: 500;

    letter-spacing: 0.11em;
}


.owner-client-profile-status > div > strong {
    display: inline-flex;

    align-items: center;

    min-height: 26px;

    padding:
        0
        9px;

    font-size: 0.49rem;

    font-weight: 500;

    letter-spacing: 0.08em;
}


.owner-client-profile-status .is-active {
    background: #dce5d8;

    color: #586b55;
}


.owner-client-profile-status .is-inactive {
    background: #ead5d1;

    color: #87564e;
}


.owner-client-profile-status form {
    margin: 0;
}


.owner-client-profile-status button {
    width: 100%;

    min-height: 37px;

    border: 1px solid;

    background: transparent;

    font-family: inherit;

    font-size: 0.53rem;

    font-weight: 500;

    letter-spacing: 0.1em;

    cursor: pointer;

    transition:
        background 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease;
}


.owner-client-profile-status button.deactivate {
    border-color:
        rgba(165,103,91,0.30);

    color: #9b6258;
}


.owner-client-profile-status button.deactivate:hover {
    background: #9b6258;

    border-color: #9b6258;

    color: #fff;
}


.owner-client-profile-status button.activate {
    border-color:
        rgba(101,127,97,0.30);

    color: #657b61;
}


.owner-client-profile-status button.activate:hover {
    background: #71866f;

    border-color: #71866f;

    color: #fff;
}



/* =========================================================
   HISTORY COUNT
========================================================= */

.owner-client-profile-note {
    margin:
        0
        21px
        21px;

    padding:
        15px
        16px;

    background: #f4ede8;

    border:
        1px solid rgba(46,42,38,0.07);
}


.owner-client-profile-note > span {
    display: block;

    margin-bottom: 8px;

    color: #a27b70;

    font-size: 0.52rem;

    font-weight: 500;

    letter-spacing: 0.12em;
}


.owner-client-profile-note-value {
    display: flex;

    align-items: flex-end;

    gap: 9px;
}


.owner-client-profile-note strong {
    display: block;

    color: #3c3531;

    font-size: 1.8rem;

    font-weight: 300;

    line-height: 0.9;
}


.owner-client-profile-note small {
    display: block;

    padding-bottom: 1px;

    color: #8e817a;

    font-size: 0.58rem;
}



/* =========================================================
   HISTORY CARD
========================================================= */

.owner-client-history {
    background: #faf7f3;

    border:
        1px solid rgba(46,42,38,0.08);
}


.owner-client-history-heading {
    min-height: 73px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding:
        16px
        20px;

    border-bottom:
        1px solid rgba(46,42,38,0.09);
}


.owner-client-history-heading span {
    display: block;

    margin-bottom: 4px;

    color: #9f776b;

    font-size: 0.54rem;

    font-weight: 500;

    letter-spacing: 0.13em;
}


.owner-client-history-heading h2 {
    margin: 0;

    font-size: 1.08rem;

    font-weight: 300;
}


.owner-client-history-heading > strong {
    min-width: 30px;

    height: 30px;

    display: grid;

    place-items: center;

    background: #eee3dc;

    color: #765f57;

    font-size: 0.65rem;

    font-weight: 500;
}



/* =========================================================
   HISTORY HEADER
========================================================= */

.owner-client-history-head {
    display: grid;

    grid-template-columns:
        0.75fr
        1.25fr
        1fr
        0.7fr
        0.75fr;

    gap: 15px;

    padding:
        11px
        20px;

    background: #e9e0da;

    color: #554b46;

    border-bottom:
        1px solid rgba(46,42,38,0.08);
}


.owner-client-history-head span {
    font-size: 0.50rem;

    font-weight: 500;

    letter-spacing: 0.11em;
}



/* =========================================================
   HISTORY ROW
========================================================= */

.owner-client-history-row {
    display: grid;

    grid-template-columns:
        0.75fr
        1.25fr
        1fr
        0.7fr
        0.75fr;

    gap: 15px;

    align-items: center;

    min-height: 71px;

    padding:
        12px
        20px;

    border-bottom:
        1px solid rgba(46,42,38,0.08);

    transition:
        background 0.15s ease;
}


.owner-client-history-row:last-child {
    border-bottom: 0;
}


.owner-client-history-row:hover {
    background: #f3ebe6;
}


.owner-client-history-row strong {
    display: block;

    color: #514a45;

    font-size: 0.65rem;

    font-weight: 500;

    line-height: 1.45;
}


.owner-client-history-row small {
    display: block;

    margin-top: 4px;

    color: #93877f;

    font-size: 0.57rem;

    line-height: 1.45;
}



/* =========================================================
   HISTORY STATUS
========================================================= */

.owner-history-status {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 78px;

    padding:
        6px
        8px;

    background: #dce5d8;

    color: #586b55;

    font-size: 0.49rem;

    font-weight: 500;

    letter-spacing: 0.08em;
}


.owner-history-mobile-label {
    display: none;
}



/* =========================================================
   EMPTY
========================================================= */

.owner-client-history-empty {
    padding:
        70px
        25px;

    text-align: center;
}


.owner-client-history-empty > span {
    display: block;

    margin-bottom: 7px;

    color: #b48d82;

    font-size: 1.4rem;

    font-weight: 300;
}


.owner-client-history-empty h3 {
    margin:
        0
        0
        5px;

    font-size: 1.12rem;

    font-weight: 300;
}


.owner-client-history-empty p {
    margin: 0;

    color: #887d76;

    font-size: 0.68rem;
}



/* =========================================================
   SHORT DESKTOP — SAME NAVBAR
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-client-profile-page .navbar {
        flex-basis: 58px;
        min-height: 58px;
    }


    .owner-client-profile-page .navbar .container,
    .owner-client-profile-page .navbar .container-fluid {
        min-height: 58px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .owner-client-profile-grid {
        grid-template-columns: 1fr;
    }

}



/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 760px) {

    .owner-client-history-head {
        display: none;
    }


    .owner-client-history-row {
        grid-template-columns:
            1fr
            1fr;

        padding:
            17px
            20px;
    }


    .owner-history-mobile-label {
        display: block;

        margin-bottom: 4px;

        color: #9f8075;

        font-size: 0.50rem;

        letter-spacing: 0.1em;
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .owner-client-profile-space {
        padding:
            21px
            0
            32px;
    }


    .owner-client-profile-shell {
        width:
            calc(100% - 24px);
    }


    .owner-client-profile-header {
        align-items: flex-start;
    }


    .owner-client-profile-avatar {
        width: 47px;
        height: 47px;
    }


    .owner-client-history-row {
        grid-template-columns: 1fr;

        gap: 13px;
    }

}

</style>

@endpush