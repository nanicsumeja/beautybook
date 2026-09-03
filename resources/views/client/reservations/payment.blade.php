@extends('layouts.app')

@section('body-class', 'client-payment-page')

@section('main-class', '')

@section('content')

<section class="payment-space">

    <div class="payment-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="payment-top">

            <h1>
                Pay advance
            </h1>

            <a
                href="{{ route('client.reservations.index') }}"
                class="payment-back"
            >
                <span>←</span>
                <span>BACK TO APPOINTMENTS</span>
            </a>

        </header>


        {{-- =====================================================
             PAYMENT PANEL
        ====================================================== --}}
        <div class="payment-panel">

            {{-- APPOINTMENT --}}
            <div class="payment-appointment">

                <span class="payment-label">
                    YOUR APPOINTMENT
                </span>

                <h2>
                    {{ $reservation->service_name }}
                </h2>


                <div class="payment-appointment-meta">

                    <div>

                        <span>
                            DATE
                        </span>

                        <strong>
                            {{ $reservation->appointment_date->format('d.m.Y') }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            TIME
                        </span>

                        <strong>
                            {{ substr($reservation->start_time, 0, 5) }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 PAYMENT SUMMARY
            ================================================== --}}
            <div class="payment-summary">

                <div class="payment-summary-item">

                    <span>
                        TOTAL PRICE
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $reservation->total_price,
                            2
                        ) }}
                        KM
                    </strong>

                </div>


                <div class="payment-summary-item payment-summary-main">

                    <span>
                        ADVANCE TO PAY
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $reservation->advance_amount,
                            2
                        ) }}
                        KM
                    </strong>

                </div>

            </div>


            {{-- =================================================
                 ERROR
            ================================================== --}}
            @if ($errors->any())

                <div class="payment-error">
                    {{ $errors->first() }}
                </div>

            @endif


            {{-- =================================================
                 BOTTOM
            ================================================== --}}
            <div class="payment-bottom">

                <div class="payment-info">

                    <span>
                        SECURE PAYMENT
                    </span>

                    <p>
                        You will continue to Stripe to securely
                        complete your advance payment.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route(
                        'client.reservations.payment.process',
                        $reservation
                    ) }}"
                >

                    @csrf


                    <button
                        type="submit"
                        class="payment-button"
                    >

                        <span>
                            PAY
                            {{ number_format(
                                (float) $reservation->advance_amount,
                                2
                            ) }}
                            KM
                        </span>

                        <span>
                            →
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — CLIENT PAYMENT
========================================================= */

.client-payment-page {

    --payment-bg: #efebe6;

    --payment-dark: #292724;

    --payment-muted: #8f8982;

    --payment-line:
        rgba(46, 42, 38, 0.14);


    /* warm accent */

    --payment-accent: #a87f73;

    --payment-accent-dark: #77564d;

    --payment-accent-soft: #e2d1ca;

    --payment-accent-light:
        rgba(200, 165, 153, 0.16);


    width: 100%;

    height: 100svh;

    margin: 0;

    overflow: hidden;

    background:
        var(--payment-bg);

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   APP
========================================================= */

.client-payment-page #app {

    display: flex;

    width: 100%;

    height: 100svh;

    flex-direction: column;

    overflow: hidden;

    background:
        var(--payment-bg);
}


/* =========================================================
   NAVBAR
========================================================= */

.client-payment-page .navbar {

    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;

    padding-bottom: 0 !important;

    background:
        var(--payment-bg) !important;

    border: 0 !important;

    box-shadow: none !important;
}


.client-payment-page .navbar .container,
.client-payment-page .navbar .container-fluid {

    min-height: 66px;
}


.client-payment-page .navbar-brand {

    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.client-payment-page .navbar .nav-link {

    color:
        rgba(48,45,42,0.67) !important;

    font-size: 0.82rem;

    font-weight: 300;

    transition:
        color 0.25s ease;
}


.client-payment-page .navbar .nav-link:hover,
.client-payment-page .navbar .nav-link.active {

    color:
        var(--payment-dark) !important;
}


/* =========================================================
   MAIN
========================================================= */

.client-payment-page main {

    flex: 1;

    min-height: 0;

    margin: 0 !important;

    padding: 0 !important;

    overflow: hidden;

    background:
        var(--payment-bg);
}


/* =========================================================
   PAGE
========================================================= */

.payment-space {

    position: relative;

    width: 100%;

    height: 100%;

    box-sizing: border-box;

    padding:
        20px
        0
        27px;

    overflow: hidden;

    background:
        var(--payment-bg);

    color:
        var(--payment-dark);
}


/* subtle background atmosphere */

.payment-space::before {

    content: "";

    position: absolute;

    top: -180px;

    left: -180px;

    width: 700px;

    height: 700px;

    border-radius: 50%;

    background:

        radial-gradient(
            circle,
            rgba(255,255,255,0.48),
            transparent 67%
        );

    pointer-events: none;
}


/* warm detail on right */

.payment-space::after {

    content: "";

    position: absolute;

    right: -170px;

    bottom: -230px;

    width: 580px;

    height: 580px;

    border-radius: 50%;

    background:

        radial-gradient(
            circle,
            rgba(200,165,153,0.12),
            transparent 68%
        );

    pointer-events: none;
}


/* =========================================================
   SHELL
========================================================= */

.payment-shell {

    position: relative;

    z-index: 2;

    display: flex;

    width:
        min(980px, calc(100% - 80px));

    height: 100%;

    margin: 0 auto;

    flex-direction: column;
}


/* =========================================================
   HEADER
========================================================= */

.payment-top {

    flex: 0 0 auto;

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 40px;

    padding:
        8px
        0
        18px;

    border-bottom:
        1px solid var(--payment-line);
}


.payment-top h1 {

    margin: 0;

    color:
        var(--payment-dark);

    font-size:
        clamp(2.2rem, 2.8vw, 2.9rem);

    font-weight: 300;

    line-height: 1;

    letter-spacing:
        -0.055em;
}


/* =========================================================
   BACK
========================================================= */

.payment-back {

    display: inline-flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 4px;

    color: #716b65;

    text-decoration: none;

    font-size: 0.55rem;

    font-weight: 500;

    letter-spacing: 0.21em;

    white-space: nowrap;

    transition:
        color 0.25s ease,
        transform 0.25s ease;
}


.payment-back:hover {

    color:
        var(--payment-accent);

    transform:
        translateX(-3px);
}


/* =========================================================
   PANEL
========================================================= */

.payment-panel {

    align-self: center;

    width: 100%;

    margin:
        auto
        0;

    overflow: hidden;

    border:
        1px solid rgba(46,42,38,0.12);

    background:
        rgba(255,255,255,0.18);

    animation:
        paymentEnter
        0.65s
        cubic-bezier(.2,.8,.2,1)
        both;
}


/* little accent line */

.payment-panel::before {

    content: "";

    display: block;

    width: 72px;

    height: 2px;

    margin-left: 30px;

    background:
        var(--payment-accent);
}


/* =========================================================
   APPOINTMENT
========================================================= */

.payment-appointment {

    padding:
        26px
        30px
        25px;

    border-bottom:
        1px solid var(--payment-line);
}


/* label */

.payment-label {

    display: block;

    margin-bottom: 9px;

    color:
        var(--payment-accent);

    font-size: 0.51rem;

    font-weight: 500;

    letter-spacing: 0.28em;
}


/* service */

.payment-appointment h2 {

    margin:
        0
        0
        21px;

    color: #302d2a;

    font-size:
        clamp(1.55rem, 2vw, 2rem);

    font-weight: 300;

    line-height: 1.05;

    letter-spacing:
        -0.04em;
}


/* =========================================================
   DATE + TIME
========================================================= */

.payment-appointment-meta {

    display: flex;

    width: 370px;

    border-top:
        1px solid var(--payment-line);

    border-bottom:
        1px solid var(--payment-line);
}


.payment-appointment-meta > div {

    width: 50%;

    box-sizing: border-box;

    padding:
        12px
        0;
}


.payment-appointment-meta > div + div {

    padding-left: 24px;

    border-left:
        1px solid var(--payment-line);
}


.payment-appointment-meta span {

    display: block;

    margin-bottom: 5px;

    color:
        var(--payment-accent);

    font-size: 0.48rem;

    font-weight: 500;

    letter-spacing: 0.21em;
}


.payment-appointment-meta strong {

    color: #403c38;

    font-size: 0.79rem;

    font-weight: 500;
}


/* =========================================================
   PAYMENT SUMMARY
========================================================= */

.payment-summary {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    border-bottom:
        1px solid var(--payment-line);
}


/* normal price */

.payment-summary-item {

    position: relative;

    display: flex;

    min-height: 116px;

    justify-content: center;

    flex-direction: column;

    box-sizing: border-box;

    padding:
        20px
        30px;

    background:
        rgba(255,255,255,0.10);
}


.payment-summary-item + .payment-summary-item {

    border-left:
        1px solid var(--payment-line);
}


.payment-summary-item span {

    display: block;

    margin-bottom: 8px;

    color: #918b84;

    font-size: 0.50rem;

    font-weight: 500;

    letter-spacing: 0.24em;
}


.payment-summary-item strong {

    color: #3b3733;

    font-size: 1.55rem;

    font-weight: 300;

    letter-spacing:
        -0.035em;
}


/* =========================================================
   ADVANCE — ACCENT
========================================================= */

.payment-summary-main {

    position: relative;

    background:

        linear-gradient(
            135deg,
            rgba(226,209,202,0.78) 0%,
            rgba(239,235,230,0.52) 100%
        );
}


/* top accent */

.payment-summary-main::before {

    content: "";

    position: absolute;

    top: -1px;

    left: 30px;

    width: 46px;

    height: 2px;

    background:
        var(--payment-accent);
}


.payment-summary-main span {

    color:
        var(--payment-accent-dark);
}


.payment-summary-main strong {

    color:
        #6e5047;

    font-size: 2rem;

    font-weight: 300;
}


/* =========================================================
   ERROR
========================================================= */

.payment-error {

    margin:
        18px
        30px
        0;

    padding:
        12px
        14px;

    color: #80514b;

    background:
        rgba(155,75,75,0.07);

    border-left:
        2px solid rgba(155,75,75,0.60);

    font-size: 0.64rem;

    font-weight: 300;
}


/* =========================================================
   BOTTOM
========================================================= */

.payment-bottom {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 40px;

    padding:
        24px
        30px;

    background:
        rgba(255,255,255,0.10);
}


/* =========================================================
   SECURE PAYMENT INFO
========================================================= */

.payment-info {

    max-width: 390px;
}


.payment-info span {

    display: block;

    margin-bottom: 6px;

    color:
        var(--payment-accent);

    font-size: 0.50rem;

    font-weight: 500;

    letter-spacing: 0.25em;
}


.payment-info p {

    margin: 0;

    color: #918b84;

    font-size: 0.65rem;

    font-weight: 300;

    line-height: 1.55;
}


/* =========================================================
   PAY BUTTON
========================================================= */

.payment-button {

    display: inline-flex;

    width: 245px;

    height: 46px;

    align-items: center;

    justify-content: space-between;

    gap: 22px;

    box-sizing: border-box;

    padding:
        0
        16px;

    border:
        1px solid #302d2a;

    background: #302d2a;

    color: #fff;

    font-family: inherit;

    font-size: 0.55rem;

    font-weight: 400;

    letter-spacing: 0.20em;

    cursor: pointer;

    transition:
        background 0.3s ease,
        border-color 0.3s ease,
        color 0.3s ease,
        transform 0.3s ease;
}


.payment-button:hover {

    border-color:
        var(--payment-accent);

    background:
        var(--payment-accent);

    color: #fff;

    transform:
        translateY(-1px);
}


.payment-button span:last-child {

    font-size: 0.82rem;

    letter-spacing: 0;

    transition:
        transform 0.3s ease;
}


.payment-button:hover span:last-child {

    transform:
        translateX(4px);
}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes paymentEnter {

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
   SHORT DESKTOP
========================================================= */

@media (min-width: 701px) and (max-height: 800px) {

    .client-payment-page .navbar {

        flex-basis: 58px;

        min-height: 58px;
    }


    .client-payment-page .navbar .container,
    .client-payment-page .navbar .container-fluid {

        min-height: 58px;
    }


    .payment-space {

        padding:
            10px
            0
            13px;
    }


    .payment-top {

        padding:
            5px
            0
            12px;
    }


    .payment-top h1 {

        font-size: 2rem;
    }


    .payment-panel {

        margin:
            14px
            0
            auto;
    }


    .payment-appointment {

        padding:
            18px
            24px;
    }


    .payment-panel::before {

        margin-left: 24px;
    }


    .payment-appointment h2 {

        margin-bottom: 13px;

        font-size: 1.5rem;
    }


    .payment-appointment-meta > div {

        padding:
            9px
            0;
    }


    .payment-appointment-meta > div + div {

        padding-left: 20px;
    }


    .payment-summary-item {

        min-height: 88px;

        padding:
            14px
            24px;
    }


    .payment-summary-main::before {

        left: 24px;
    }


    .payment-summary-item strong {

        font-size: 1.35rem;
    }


    .payment-summary-main strong {

        font-size: 1.7rem;
    }


    .payment-bottom {

        padding:
            16px
            24px;
    }


    .payment-button {

        height: 41px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .client-payment-page {

        height: auto;

        min-height: 100svh;

        overflow-y: auto;
    }


    .client-payment-page #app {

        height: auto;

        min-height: 100svh;

        overflow: visible;
    }


    .client-payment-page main {

        overflow: visible;
    }


    .payment-space {

        height: auto;

        min-height:
            calc(100svh - 65px);

        overflow: visible;

        padding:
            24px
            0
            35px;
    }


    .payment-shell {

        width:
            calc(100% - 28px);

        height: auto;
    }


    .payment-top {

        align-items: flex-start;

        flex-direction: column;

        gap: 16px;
    }


    .payment-top h1 {

        font-size: 2rem;
    }


    .payment-back {

        margin: 0;
    }


    .payment-panel {

        margin-top: 20px;
    }


    .payment-panel::before {

        margin-left: 20px;
    }


    .payment-appointment {

        padding:
            22px
            20px;
    }


    .payment-appointment-meta {

        width: 100%;
    }


    .payment-summary {

        grid-template-columns: 1fr;
    }


    .payment-summary-item {

        min-height: 95px;

        padding:
            18px
            20px;
    }


    .payment-summary-item + .payment-summary-item {

        border-left: 0;

        border-top:
            1px solid var(--payment-line);
    }


    .payment-summary-main::before {

        left: 20px;
    }


    .payment-bottom {

        align-items: stretch;

        flex-direction: column;

        gap: 20px;

        padding:
            21px
            20px;
    }


    .payment-button {

        width: 100%;
    }


    .payment-error {

        margin:
            18px
            20px
            0;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .payment-panel {

        animation:
            none !important;
    }

}

</style>

@endpush