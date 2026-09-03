@extends('layouts.app')

@section('body-class', 'client-services-page')

@section('main-class', '')

@section('content')

<section class="services-space">

    <div class="services-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="services-header">

            <div class="services-heading">

                <span class="services-eyebrow">
                    BEAUTYBOOK SERVICES
                </span>

                <h1>
                    Choose your treatment.
                </h1>

                <p>
                    Find the service that suits you and book your next visit.
                </p>

            </div>


            <a
                href="{{ route('client.dashboard') }}"
                class="services-back"
            >
                <span>←</span>
                BACK TO MY SPACE
            </a>

        </header>


        {{-- =====================================================
             SERVICES
        ====================================================== --}}

        @if ($services->isEmpty())

            <div class="services-empty">

                <span class="services-empty-label">
                    NO SERVICES
                </span>

                <h2>
                    Nothing available right now.
                </h2>

                <p>
                    There are currently no active services.
                </p>

            </div>

        @else

            <div class="services-grid">

                @foreach ($services as $service)

                    <article class="service-card">

                        {{-- TOP --}}
                        <div class="service-card-top">

                            <span class="service-index">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <span class="service-duration">
                                {{ $service->duration_minutes }} MIN
                            </span>

                        </div>


                        {{-- CONTENT --}}
                        <div class="service-card-content">

                            <h2>
                                {{ $service->name }}
                            </h2>

                            @if ($service->description)

                                <p>
                                    {{ $service->description }}
                                </p>

                            @else

                                <p>
                                    BeautyBook treatment for your next salon visit.
                                </p>

                            @endif

                        </div>


                        {{-- BOTTOM --}}
                        <div class="service-card-bottom">

                            <div class="service-price">

                                <span>
                                    PRICE
                                </span>

                                <strong>
                                    {{ number_format(
                                        (float) $service->price,
                                        2
                                    ) }}
                                    KM
                                </strong>

                            </div>


                            <a
                                href="{{ route(
                                    'client.reservations.create',
                                    $service
                                ) }}"
                                class="service-book"
                            >
                                <span>BOOK</span>
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
   BEAUTYBOOK — CLIENT SERVICES
========================================================= */

.client-services-page {
    --services-bg: #efebe6;
    --services-dark: #292724;
    --services-muted: #8f8982;
    --services-line: rgba(46, 42, 38, 0.14);

    margin: 0;

    min-height: 100vh;

    background: var(--services-bg);

    font-family: 'Montserrat', sans-serif;
}


/* =========================================================
   NAVBAR — SAME STYLE AS DASHBOARD
========================================================= */

.client-services-page .navbar {
    background: var(--services-bg) !important;

    border: 0 !important;
    border-bottom: 0 !important;

    box-shadow: none !important;
}


.client-services-page .navbar-brand {
    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.client-services-page .navbar .nav-link {
    color: rgba(48, 45, 42, 0.64) !important;

    font-weight: 300;

    transition: color 0.25s ease;
}


.client-services-page .navbar .nav-link:hover,
.client-services-page .navbar .nav-link.active {
    color: var(--services-dark) !important;
}


/* =========================================================
   MAIN
========================================================= */

.client-services-page main {
    padding: 0 !important;

    background: var(--services-bg);
}


/* =========================================================
   PAGE
========================================================= */

.services-space {
    position: relative;

    min-height: calc(100vh - 70px);

    padding: 34px 0 48px;

    overflow: hidden;

    background: var(--services-bg);

    color: var(--services-dark);
}


/* subtle background light */

.services-space::before {
    content: "";

    position: absolute;

    top: -180px;
    left: -130px;

    width: 600px;
    height: 600px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(255, 255, 255, 0.48),
            transparent 68%
        );

    pointer-events: none;
}


/* =========================================================
   SHELL
========================================================= */

.services-shell {
    position: relative;

    z-index: 2;

    width: min(1320px, calc(100% - 90px));

    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.services-header {
    display: flex;

    align-items: flex-end;
    justify-content: space-between;

    gap: 50px;

    margin-bottom: 30px;

    padding-bottom: 23px;

    border-bottom:
        1px solid var(--services-line);
}


.services-heading {
    max-width: 600px;
}


.services-eyebrow {
    display: block;

    margin-bottom: 9px;

    color: #918b84;

    font-size: 0.43rem;
    font-weight: 500;

    letter-spacing: 0.40em;
}


.services-header h1 {
    margin: 0 0 8px;

    color: var(--services-dark);

    font-size: clamp(1.8rem, 2.7vw, 2.7rem);

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.05em;
}


.services-header p {
    margin: 0;

    color: #918b84;

    font-size: 0.57rem;
    font-weight: 300;

    line-height: 1.7;
}


/* =========================================================
   BACK
========================================================= */

.services-back {
    display: inline-flex;

    align-items: center;

    gap: 10px;

    padding-bottom: 3px;

    color: #716b65;

    font-size: 0.44rem;
    font-weight: 500;

    letter-spacing: 0.28em;

    text-decoration: none;

    white-space: nowrap;

    transition:
        color 0.25s ease,
        transform 0.25s ease;
}


.services-back:hover {
    color: var(--services-dark);

    transform: translateX(-3px);
}


/* =========================================================
   GRID
========================================================= */

.services-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 14px;
}


/* =========================================================
   CARD
========================================================= */

.service-card {
    position: relative;

    min-height: 215px;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    padding: 20px 21px;

    background:
        rgba(255, 255, 255, 0.18);

    border:
        1px solid rgba(46, 42, 38, 0.11);

    transition:
        background 0.3s ease,
        border-color 0.3s ease,
        transform 0.3s ease;
}


.service-card:hover {
    background:
        rgba(255, 255, 255, 0.38);

    border-color:
        rgba(46, 42, 38, 0.23);

    transform: translateY(-3px);
}


/*
    Mala linija na vrhu daje kartici
    malo više strukture bez dodatne boje.
*/

.service-card::before {
    content: "";

    position: absolute;

    top: -1px;
    left: 20px;

    width: 34px;
    height: 1px;

    background:
        rgba(45, 42, 39, 0.48);
}


/* =========================================================
   CARD TOP
========================================================= */

.service-card-top {
    display: flex;

    align-items: center;
    justify-content: space-between;

    margin-bottom: 25px;
}


.service-index {
    color: #aaa39c;

    font-size: 0.40rem;
    font-weight: 500;

    letter-spacing: 0.24em;
}


.service-duration {
    color: #8f8982;

    font-size: 0.41rem;
    font-weight: 500;

    letter-spacing: 0.23em;
}


/* =========================================================
   CARD CONTENT
========================================================= */

.service-card-content {
    flex: 1;

    padding-right: 10px;
}


.service-card-content h2 {
    margin: 0 0 9px;

    color: #302d2a;

    font-size: clamp(1rem, 1.35vw, 1.25rem);

    font-weight: 400;

    line-height: 1.15;

    letter-spacing: -0.03em;
}


.service-card-content p {
    display: -webkit-box;

    max-width: 310px;

    margin: 0;

    overflow: hidden;

    color: #928c85;

    font-size: 0.53rem;
    font-weight: 300;

    line-height: 1.65;

    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}


/* =========================================================
   CARD BOTTOM
========================================================= */

.service-card-bottom {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-top: 22px;

    padding-top: 14px;

    border-top:
        1px solid rgba(46, 42, 38, 0.11);
}


/* =========================================================
   PRICE
========================================================= */

.service-price span {
    display: block;

    margin-bottom: 3px;

    color: #a09a93;

    font-size: 0.38rem;
    font-weight: 500;

    letter-spacing: 0.26em;
}


.service-price strong {
    color: #383531;

    font-size: 0.76rem;
    font-weight: 500;
}


/* =========================================================
   BOOK
========================================================= */

.service-book {
    display: inline-flex;

    min-width: 88px;
    height: 35px;

    align-items: center;
    justify-content: space-between;

    gap: 18px;

    padding: 0 11px;

    box-sizing: border-box;

    border:
        1px solid #302d2a;

    background: #302d2a;

    color: #fff;

    font-size: 0.42rem;
    font-weight: 400;

    letter-spacing: 0.25em;

    text-decoration: none;

    transition:
        color 0.3s ease,
        background 0.3s ease,
        transform 0.3s ease;
}


.service-book:hover {
    color: #302d2a;

    background: transparent;

    transform: translateY(-1px);
}


.service-book span:last-child {
    font-size: 0.7rem;

    letter-spacing: 0;

    transition: transform 0.3s ease;
}


.service-book:hover span:last-child {
    transform: translateX(3px);
}


/* =========================================================
   EMPTY STATE
========================================================= */

.services-empty {
    max-width: 560px;

    margin: 80px auto 0;

    padding:
        42px
        30px;

    text-align: center;

    border-top:
        1px solid var(--services-line);

    border-bottom:
        1px solid var(--services-line);
}


.services-empty-label {
    display: block;

    margin-bottom: 12px;

    color: #918b84;

    font-size: 0.42rem;
    font-weight: 500;

    letter-spacing: 0.36em;
}


.services-empty h2 {
    margin: 0 0 9px;

    color: var(--services-dark);

    font-size: 1.6rem;
    font-weight: 300;

    letter-spacing: -0.04em;
}


.services-empty p {
    margin: 0;

    color: #918b84;

    font-size: 0.56rem;
    font-weight: 300;
}


/* =========================================================
   ENTRANCE
========================================================= */

.services-header {
    animation:
        servicesHeaderEnter
        0.75s
        cubic-bezier(.2,.8,.2,1)
        both;
}


.service-card {
    animation:
        serviceCardEnter
        0.65s
        cubic-bezier(.2,.8,.2,1)
        both;
}


.service-card:nth-child(2) {
    animation-delay: 0.04s;
}


.service-card:nth-child(3) {
    animation-delay: 0.08s;
}


.service-card:nth-child(4) {
    animation-delay: 0.12s;
}


.service-card:nth-child(5) {
    animation-delay: 0.16s;
}


.service-card:nth-child(6) {
    animation-delay: 0.20s;
}


@keyframes servicesHeaderEnter {

    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


@keyframes serviceCardEnter {

    from {
        opacity: 0;

        transform:
            translateY(10px);
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

    .services-shell {
        width: min(
            1420px,
            calc(100% - 120px)
        );
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1000px) {

    .services-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .services-shell {
        width: calc(100% - 50px);
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 750px) {

    .services-header {
        align-items: flex-start;

        flex-direction: column;

        gap: 18px;
    }


    .services-header h1 {
        font-size: 2rem;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .services-space {
        padding:
            25px
            0
            35px;
    }


    .services-shell {
        width:
            calc(100% - 28px);
    }


    .services-grid {
        grid-template-columns: 1fr;

        gap: 10px;
    }


    .services-header {
        margin-bottom: 20px;

        padding-bottom: 18px;
    }


    .services-header h1 {
        font-size: 1.85rem;
    }


    .service-card {
        min-height: 190px;

        padding:
            18px
            18px;
    }


    .service-card-top {
        margin-bottom: 19px;
    }


    .service-card-bottom {
        margin-top: 18px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .services-header,
    .service-card {
        animation: none !important;
    }

}

</style>

@endpush