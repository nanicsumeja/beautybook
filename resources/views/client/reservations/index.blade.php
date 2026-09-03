@extends('layouts.app')

@section('body-class', 'client-appointments-page')

@section('main-class', '')

@section('content')

<section class="appointments-space">

    <div class="appointments-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="appointments-header">

            <h1>
                My appointments
            </h1>

            <a
                href="{{ route('client.services.index') }}"
                class="appointments-book-button"
            >
                <span>BOOK APPOINTMENT</span>
                <span>→</span>
            </a>

        </header>


        {{-- =====================================================
             MESSAGES
        ====================================================== --}}

        @if (session('success'))

            <div class="appointments-alert appointments-alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if ($errors->has('reservation'))

            <div class="appointments-alert appointments-alert-error">
                {{ $errors->first('reservation') }}
            </div>

        @endif


        @if ($errors->has('payment'))

            <div class="appointments-alert appointments-alert-error">
                {{ $errors->first('payment') }}
            </div>

        @endif



        {{-- =====================================================
             EMPTY STATE
        ====================================================== --}}

        @if ($reservations->isEmpty())

            <div class="appointments-empty">

                <span class="appointments-empty-label">
                    NO APPOINTMENTS YET
                </span>

                <h2>
                    Your next visit starts here.
                </h2>

                <p>
                    Choose a service and book your first appointment.
                </p>

                <a
                    href="{{ route('client.services.index') }}"
                    class="appointments-empty-button"
                >
                    <span>EXPLORE SERVICES</span>
                    <span>→</span>
                </a>

            </div>

        @else

            {{-- =================================================
                 APPOINTMENTS LIST
            ================================================== --}}
            <div class="appointments-list">

                @foreach ($reservations as $reservation)

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


                        $statusClass = match ($reservation->status) {
                            'confirmed' => 'appointment-status-confirmed',
                            'completed' => 'appointment-status-completed',
                            'cancelled' => 'appointment-status-cancelled',
                            default => 'appointment-status-pending',
                        };


                        $paymentClass = match ($reservation->payment_status) {
                            'paid' => 'payment-status-paid',
                            'failed' => 'payment-status-failed',
                            'refunded' => 'payment-status-refunded',
                            default => 'payment-status-pending',
                        };

                    @endphp


                    <article class="appointment-row">


                        {{-- =====================================
                             DATE
                        ====================================== --}}
                        <div class="appointment-date">

                            <span class="appointment-day">
                                {{
                                    $reservation
                                        ->appointment_date
                                        ->format('d')
                                }}
                            </span>

                            <div class="appointment-date-copy">

                                <strong>
                                    {{
                                        strtoupper(
                                            $reservation
                                                ->appointment_date
                                                ->format('M')
                                        )
                                    }}
                                </strong>

                                <small>
                                    {{
                                        $reservation
                                            ->appointment_date
                                            ->format('Y')
                                    }}
                                </small>

                            </div>

                        </div>



                        {{-- =====================================
                             SERVICE
                        ====================================== --}}
                        <div class="appointment-service">

                            <span class="appointment-overline">
                                SERVICE
                            </span>

                            <h2>
                                {{ $reservation->service_name }}
                            </h2>

                            <div class="appointment-statuses">

                                <span
                                    class="appointment-status {{ $statusClass }}"
                                >
                                    {{ strtoupper($reservation->status) }}
                                </span>

                                <span
                                    class="payment-status {{ $paymentClass }}"
                                >
                                    {{
                                        strtoupper(
                                            $reservation->payment_status
                                        )
                                    }}
                                </span>

                            </div>

                        </div>



                        {{-- =====================================
                             DETAILS
                        ====================================== --}}
                        <div class="appointment-details">

                            <div>

                                <span>
                                    TIME
                                </span>

                                <strong>
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
                                </strong>

                            </div>


                            <div>

                                <span>
                                    DURATION
                                </span>

                                <strong>
                                    {{ $reservation->duration_minutes }} min
                                </strong>

                            </div>


                            <div>

                                <span>
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

                        </div>



                        {{-- =====================================
                             PAYMENT
                        ====================================== --}}
                        <div class="appointment-payment">

                            <span class="appointment-overline">
                                ADVANCE
                            </span>

                            <strong>
                                {{
                                    number_format(
                                        (float) $reservation->advance_amount,
                                        2
                                    )
                                }}
                                KM
                            </strong>


                            @if (
                                $reservation->status === 'pending'
                                && in_array(
                                    $reservation->payment_status,
                                    ['unpaid', 'failed'],
                                    true
                                )
                            )

                                <a
                                    href="{{ route(
                                        'client.reservations.payment',
                                        $reservation
                                    ) }}"
                                    class="appointment-pay-button"
                                >
                                    <span>PAY NOW</span>
                                    <span>→</span>
                                </a>

                            @endif

                        </div>



                        {{-- =====================================
                             CANCEL
                        ====================================== --}}
                        <div class="appointment-actions">

                            @if ($canCancel)

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'client.reservations.cancel',
                                        $reservation
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Are you sure you want to cancel this appointment?'
                                    )"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="appointment-cancel-button"
                                    >
                                        CANCEL
                                    </button>

                                </form>

                            @else

                                <span class="appointment-actions-empty">
                                    —
                                </span>

                            @endif

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
   BEAUTYBOOK — MY APPOINTMENTS
========================================================= */

.client-appointments-page {
    --appointments-bg: #efebe6;
    --appointments-dark: #292724;
    --appointments-muted: #8f8982;
    --appointments-line: rgba(46, 42, 38, 0.14);

    width: 100%;
    height: 100svh;

    margin: 0;

    overflow: hidden;

    background: var(--appointments-bg);

    font-family: 'Montserrat', sans-serif;
}


/* =========================================================
   APP
========================================================= */

.client-appointments-page #app {
    display: flex;

    width: 100%;
    height: 100svh;

    flex-direction: column;

    overflow: hidden;

    background: var(--appointments-bg);
}


/* =========================================================
   NAVBAR
========================================================= */

.client-appointments-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background: var(--appointments-bg) !important;

    border: 0 !important;

    box-shadow: none !important;
}


.client-appointments-page .navbar .container,
.client-appointments-page .navbar .container-fluid {
    min-height: 66px;
}


.client-appointments-page .navbar-brand {
    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.client-appointments-page .navbar .nav-link {
    color: rgba(48,45,42,0.67) !important;

    font-size: 0.82rem;
    font-weight: 300;

    transition: color 0.25s ease;
}


.client-appointments-page .navbar .nav-link:hover,
.client-appointments-page .navbar .nav-link.active {
    color: var(--appointments-dark) !important;
}


/* =========================================================
   MAIN
========================================================= */

.client-appointments-page main {
    flex: 1;

    min-height: 0;

    margin: 0 !important;
    padding: 0 !important;

    overflow: hidden;

    background: var(--appointments-bg);
}


/* =========================================================
   PAGE
========================================================= */

.appointments-space {
    position: relative;

    width: 100%;
    height: 100%;

    box-sizing: border-box;

    padding:
        20px
        0
        24px;

    overflow: hidden;

    background: var(--appointments-bg);

    color: var(--appointments-dark);
}


/* subtle light */

.appointments-space::before {
    content: "";

    position: absolute;

    top: -150px;
    left: -180px;

    width: 700px;
    height: 700px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(255,255,255,0.44),
            transparent 68%
        );

    pointer-events: none;
}


/* =========================================================
   SHELL
========================================================= */

.appointments-shell {
    position: relative;

    z-index: 2;

    display: flex;

    width:
        min(1380px, calc(100% - 80px));

    height: 100%;

    min-height: 0;

    margin: 0 auto;

    flex-direction: column;
}


/* =========================================================
   HEADER
========================================================= */

.appointments-header {
    flex: 0 0 auto;

    display: flex;

    align-items: flex-end;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 20px;

    padding:
        8px
        0
        19px;

    border-bottom:
        1px solid var(--appointments-line);
}


.appointments-header h1 {
    margin: 0;

    color: var(--appointments-dark);

    font-size:
        clamp(2.2rem, 2.8vw, 2.9rem);

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.055em;
}


/* =========================================================
   BOOK BUTTON
========================================================= */

.appointments-book-button {
    display: inline-flex;

    width: 210px;
    height: 44px;

    align-items: center;
    justify-content: space-between;

    box-sizing: border-box;

    padding:
        0
        15px;

    border:
        1px solid #302d2a;

    background: #302d2a;

    color: #fff;

    text-decoration: none;

    font-size: 0.52rem;
    font-weight: 400;

    letter-spacing: 0.22em;

    transition:
        background 0.3s ease,
        color 0.3s ease,
        transform 0.3s ease;
}


.appointments-book-button:hover {
    background: transparent;

    color: #302d2a;

    transform: translateY(-1px);
}


.appointments-book-button span:last-child {
    font-size: 0.78rem;

    letter-spacing: 0;

    transition:
        transform 0.3s ease;
}


.appointments-book-button:hover span:last-child {
    transform: translateX(4px);
}


/* =========================================================
   ALERTS
========================================================= */

.appointments-alert {
    flex: 0 0 auto;

    margin-bottom: 12px;

    padding:
        11px
        14px;

    font-size: 0.66rem;
    font-weight: 300;

    line-height: 1.45;
}


.appointments-alert-success {
    color: #4c604a;

    background:
        rgba(99,126,94,0.08);

    border-left:
        2px solid rgba(88,113,84,0.65);
}


.appointments-alert-error {
    color: #80514b;

    background:
        rgba(155,75,75,0.07);

    border-left:
        2px solid rgba(155,75,75,0.60);
}


/* =========================================================
   LIST
========================================================= */

.appointments-list {
    flex: 1;

    min-height: 0;

    overflow-y: auto;
    overflow-x: hidden;

    padding-right: 5px;

    scrollbar-width: thin;

    scrollbar-color:
        rgba(46,42,38,0.20)
        transparent;
}


.appointments-list::-webkit-scrollbar {
    width: 4px;
}


.appointments-list::-webkit-scrollbar-track {
    background: transparent;
}


.appointments-list::-webkit-scrollbar-thumb {
    background:
        rgba(46,42,38,0.20);
}


/* =========================================================
   APPOINTMENT ROW
========================================================= */

.appointment-row {
    position: relative;

    display: grid;

    grid-template-columns:
        125px
        minmax(190px, 1.15fr)
        minmax(310px, 1.6fr)
        minmax(125px, 0.65fr)
        80px;

    align-items: center;

    min-height: 137px;

    margin-bottom: 10px;

    background:
        rgba(255,255,255,0.17);

    border:
        1px solid rgba(46,42,38,0.11);

    transition:
        background 0.3s ease,
        border-color 0.3s ease,
        transform 0.3s ease;
}


.appointment-row:hover {
    background:
        rgba(255,255,255,0.32);

    border-color:
        rgba(46,42,38,0.21);

    transform: translateY(-1px);
}


/* top accent */

.appointment-row::before {
    content: "";

    position: absolute;

    top: -1px;
    left: 24px;

    width: 37px;
    height: 1px;

    background:
        rgba(46,42,38,0.47);
}


/* =========================================================
   DATE
========================================================= */

.appointment-date {
    display: flex;

    height: 100%;

    align-items: center;

    gap: 11px;

    box-sizing: border-box;

    padding:
        20px
        22px;

    border-right:
        1px solid var(--appointments-line);
}


.appointment-day {
    color: #302d2a;

    font-size: 2.2rem;
    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.055em;
}


.appointment-date-copy {
    display: flex;

    flex-direction: column;

    gap: 1px;
}


.appointment-date-copy strong {
    color: #4b4743;

    font-size: 0.58rem;
    font-weight: 500;

    letter-spacing: 0.15em;
}


.appointment-date-copy small {
    color: #99928b;

    font-size: 0.57rem;
    font-weight: 300;
}


/* =========================================================
   COMMON LABEL
========================================================= */

.appointment-overline {
    display: block;

    margin-bottom: 5px;

    color: #99928b;

    font-size: 0.46rem;
    font-weight: 500;

    letter-spacing: 0.23em;
}


/* =========================================================
   SERVICE
========================================================= */

.appointment-service {
    min-width: 0;

    padding:
        18px
        24px;
}


.appointment-service h2 {
    margin:
        0
        0
        11px;

    overflow: hidden;

    color: #302d2a;

    font-size:
        clamp(1.15rem, 1.55vw, 1.45rem);

    font-weight: 300;

    line-height: 1.05;

    letter-spacing: -0.035em;

    white-space: nowrap;

    text-overflow: ellipsis;
}


/* =========================================================
   STATUSES
========================================================= */

.appointment-statuses {
    display: flex;

    flex-wrap: wrap;

    gap: 6px;
}


.appointment-status,
.payment-status {
    display: inline-flex;

    height: 22px;

    align-items: center;

    padding:
        0
        7px;

    box-sizing: border-box;

    border:
        1px solid rgba(46,42,38,0.12);

    background: transparent;

    font-size: 0.42rem;
    font-weight: 500;

    letter-spacing: 0.14em;
}


/* reservation */

.appointment-status-confirmed {
    color: #536652;

    border-color:
        rgba(83,102,82,0.24);

    background:
        rgba(83,102,82,0.06);
}


.appointment-status-completed {
    color: #fff;

    border-color: #302d2a;

    background: #302d2a;
}


.appointment-status-cancelled {
    color: #8a5148;

    border-color:
        rgba(138,81,72,0.24);

    background:
        rgba(138,81,72,0.06);
}


.appointment-status-pending {
    color: #76653f;

    border-color:
        rgba(118,101,63,0.24);

    background:
        rgba(118,101,63,0.06);
}


/* payment */

.payment-status-paid {
    color: #536652;

    border-color:
        rgba(83,102,82,0.24);
}


.payment-status-failed {
    color: #8a5148;

    border-color:
        rgba(138,81,72,0.24);
}


.payment-status-refunded {
    color: #6d6762;

    border-color:
        rgba(109,103,98,0.22);
}


.payment-status-pending {
    color: #76653f;

    border-color:
        rgba(118,101,63,0.24);
}


/* =========================================================
   DETAILS
========================================================= */

.appointment-details {
    display: grid;

    height: 100%;

    grid-template-columns:
        1.25fr
        1fr
        1fr;

    align-items: center;

    border-left:
        1px solid var(--appointments-line);

    border-right:
        1px solid var(--appointments-line);
}


.appointment-details > div {
    min-width: 0;

    padding:
        0
        18px;

    border-right:
        1px solid var(--appointments-line);
}


.appointment-details > div:last-child {
    border-right: 0;
}


.appointment-details span {
    display: block;

    margin-bottom: 6px;

    color: #99928b;

    font-size: 0.45rem;
    font-weight: 500;

    letter-spacing: 0.20em;
}


.appointment-details strong {
    color: #403c38;

    font-size: 0.70rem;
    font-weight: 500;

    white-space: nowrap;
}


/* =========================================================
   PAYMENT
========================================================= */

.appointment-payment {
    padding:
        17px
        18px;
}


.appointment-payment > strong {
    display: block;

    margin-bottom: 12px;

    color: #383531;

    font-size: 0.78rem;
    font-weight: 500;

    white-space: nowrap;
}


/* =========================================================
   PAY BUTTON
========================================================= */

.appointment-pay-button {
    display: inline-flex;

    width: 105px;
    height: 33px;

    align-items: center;
    justify-content: space-between;

    box-sizing: border-box;

    padding:
        0
        10px;

    border:
        1px solid #302d2a;

    background: #302d2a;

    color: #fff;

    text-decoration: none;

    font-size: 0.44rem;
    font-weight: 400;

    letter-spacing: 0.17em;

    transition:
        background 0.3s ease,
        color 0.3s ease;
}


.appointment-pay-button:hover {
    background: transparent;

    color: #302d2a;
}


.appointment-pay-button span:last-child {
    font-size: 0.7rem;

    letter-spacing: 0;
}


/* =========================================================
   ACTIONS
========================================================= */

.appointment-actions {
    display: flex;

    height: 100%;

    align-items: center;
    justify-content: center;

    border-left:
        1px solid var(--appointments-line);
}


.appointment-cancel-button {
    padding: 0;

    border: 0;

    border-bottom:
        1px solid rgba(139,72,64,0.65);

    background: transparent;

    color: #8b4840;

    font-family: inherit;

    font-size: 0.44rem;
    font-weight: 500;

    letter-spacing: 0.15em;

    cursor: pointer;

    transition:
        color 0.25s ease,
        border-color 0.25s ease;
}


.appointment-cancel-button:hover {
    color: #602f2a;

    border-color: #602f2a;
}


.appointment-actions-empty {
    color: #bbb4ad;

    font-size: 0.7rem;
}


/* =========================================================
   EMPTY
========================================================= */

.appointments-empty {
    flex: 1;

    display: flex;

    min-height: 0;

    align-items: center;
    justify-content: center;

    flex-direction: column;

    text-align: center;

    border-top:
        1px solid var(--appointments-line);

    border-bottom:
        1px solid var(--appointments-line);
}


.appointments-empty-label {
    display: block;

    margin-bottom: 12px;

    color: #918b84;

    font-size: 0.50rem;
    font-weight: 500;

    letter-spacing: 0.30em;
}


.appointments-empty h2 {
    margin:
        0
        0
        10px;

    color: #302d2a;

    font-size:
        clamp(1.9rem, 2.8vw, 2.6rem);

    font-weight: 300;

    letter-spacing: -0.05em;
}


.appointments-empty p {
    margin:
        0
        0
        23px;

    color: #918b84;

    font-size: 0.67rem;
    font-weight: 300;
}


.appointments-empty-button {
    display: inline-flex;

    width: 190px;
    height: 43px;

    align-items: center;
    justify-content: space-between;

    padding:
        0
        15px;

    box-sizing: border-box;

    background: #302d2a;

    border:
        1px solid #302d2a;

    color: #fff;

    text-decoration: none;

    font-size: 0.50rem;
    font-weight: 400;

    letter-spacing: 0.20em;

    transition:
        background 0.3s ease,
        color 0.3s ease;
}


.appointments-empty-button:hover {
    background: transparent;

    color: #302d2a;
}


/* =========================================================
   ANIMATION
========================================================= */

.appointments-header {
    animation:
        appointmentsEnter
        0.65s
        cubic-bezier(.2,.8,.2,1)
        both;
}


.appointment-row {
    animation:
        appointmentsEnter
        0.55s
        cubic-bezier(.2,.8,.2,1)
        both;
}


.appointment-row:nth-child(2) {
    animation-delay: 0.04s;
}


.appointment-row:nth-child(3) {
    animation-delay: 0.08s;
}


.appointment-row:nth-child(4) {
    animation-delay: 0.12s;
}


@keyframes appointmentsEnter {

    from {
        opacity: 0;

        transform:
            translateY(8px);
    }

    to {
        opacity: 1;

        transform:
            translateY(0);
    }

}


/* =========================================================
   LARGE DESKTOP
========================================================= */

@media (min-width: 1500px) {

    .appointments-shell {
        width:
            min(1450px, calc(100% - 120px));
    }


    .appointment-row {
        grid-template-columns:
            130px
            minmax(210px, 1.2fr)
            minmax(350px, 1.7fr)
            minmax(135px, 0.7fr)
            85px;
    }

}


/* =========================================================
   SHORT DESKTOP
========================================================= */

@media (min-width: 951px) and (max-height: 800px) {

    .client-appointments-page .navbar {
        flex-basis: 58px;

        min-height: 58px;
    }


    .client-appointments-page .navbar .container,
    .client-appointments-page .navbar .container-fluid {
        min-height: 58px;
    }


    .appointments-space {
        padding:
            10px
            0
            13px;
    }


    .appointments-header {
        margin-bottom: 12px;

        padding:
            5px
            0
            12px;
    }


    .appointments-header h1 {
        font-size: 2rem;
    }


    .appointment-row {
        min-height: 118px;

        margin-bottom: 8px;
    }


    .appointment-date,
    .appointment-service {
        padding:
            14px
            18px;
    }


    .appointment-day {
        font-size: 1.9rem;
    }


    .appointment-service h2 {
        margin-bottom: 8px;

        font-size: 1.12rem;
    }


    .appointment-payment {
        padding:
            13px
            15px;
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 950px) {

    .client-appointments-page,
    .client-appointments-page #app {
        height: auto;

        min-height: 100svh;

        overflow: visible;
    }


    .client-appointments-page main {
        overflow: visible;
    }


    .appointments-space {
        height: auto;

        min-height:
            calc(100svh - 66px);

        overflow: visible;

        padding:
            25px
            0
            35px;
    }


    .appointments-shell {
        width:
            calc(100% - 46px);

        height: auto;
    }


    .appointments-list {
        overflow: visible;

        padding-right: 0;
    }


    .appointment-row {
        grid-template-columns:
            110px
            minmax(0, 1fr)
            115px;

        min-height: auto;
    }


    .appointment-date {
        grid-row:
            1 / 3;
    }


    .appointment-service {
        border-bottom:
            1px solid var(--appointments-line);
    }


    .appointment-details {
        grid-column:
            2 / 4;

        grid-row: 2;

        min-height: 75px;

        border-right: 0;
    }


    .appointment-payment {
        grid-column: 3;

        grid-row: 1;
    }


    .appointment-actions {
        grid-column:
            1 / -1;

        min-height: 38px;

        border-top:
            1px solid var(--appointments-line);

        border-left: 0;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .appointments-shell {
        width:
            calc(100% - 28px);
    }


    .appointments-header {
        align-items: flex-start;

        flex-direction: column;

        gap: 17px;
    }


    .appointments-header h1 {
        font-size: 2rem;
    }


    .appointments-book-button {
        width: 100%;
    }


    .appointment-row {
        display: block;

        min-height: 0;
    }


    .appointment-date {
        height: auto;

        border-right: 0;

        border-bottom:
            1px solid var(--appointments-line);
    }


    .appointment-service {
        padding:
            18px
            20px;
    }


    .appointment-details {
        display: grid;

        min-height: 0;

        grid-template-columns: 1fr;

        border-left: 0;

        border-right: 0;
    }


    .appointment-details > div {
        padding:
            12px
            20px;

        border-right: 0;

        border-bottom:
            1px solid var(--appointments-line);
    }


    .appointment-payment {
        padding:
            16px
            20px;
    }


    .appointment-actions {
        min-height: 45px;

        border-left: 0;

        border-top:
            1px solid var(--appointments-line);
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .appointments-header,
    .appointment-row {
        animation: none !important;
    }

}

</style>

@endpush