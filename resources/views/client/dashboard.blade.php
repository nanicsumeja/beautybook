@extends('layouts.app')

@section('body-class', 'client-film-page')

@section('main-class', '')

@section('content')

<section class="client-film">

    {{-- =====================================================
         VIDEO
    ====================================================== --}}
    <div class="client-film-media">

        <video
            autoplay
            muted
            loop
            playsinline
            preload="auto"
        >
            <source
                src="{{ asset('videos/beauty-loop.mp4') }}"
                type="video/mp4"
            >
        </video>

    </div>


    {{-- =====================================================
         PAGE CONTENT
    ====================================================== --}}
    <div class="client-film-shell">

        <div class="client-film-content">

            {{-- TOP --}}
            <div class="client-film-intro">

                <span class="client-film-eyebrow">
                    YOUR BEAUTYBOOK
                </span>

                <h1>
                    Welcome, {{ Auth::user()->name }}.
                </h1>

                <p>
                    Your personal space for appointments,
                    treatments and beauty care.
                </p>

            </div>


            {{-- CENTER --}}
            <div class="client-film-focus">

                <span class="client-film-focus-label">
                    YOUR NEXT VISIT
                </span>

                <h2>
                    Your next visit starts here.
                </h2>

                <p>
                    Choose a treatment, specialist and a time
                    that works for you.
                </p>

                <a
                    href="{{ route('client.services.index') }}"
                    class="client-film-book"
                >
                    <span>BOOK APPOINTMENT</span>

                    <span class="client-film-arrow">
                        →
                    </span>
                </a>

            </div>


            {{-- BOTTOM --}}
            <div class="client-film-links">

                <a href="{{ route('client.reservations.index') }}">

                    <div>
                        <span>
                            MY APPOINTMENTS
                        </span>

                        <small>
                            Upcoming visits, payments and history
                        </small>
                    </div>

                    <strong>
                        →
                    </strong>

                </a>


                <a href="{{ route('client.services.index') }}">

                    <div>
                        <span>
                            SERVICES
                        </span>

                        <small>
                            Discover treatments and prices
                        </small>
                    </div>

                    <strong>
                        →
                    </strong>

                </a>

            </div>

        </div>


        {{-- SMALL DETAIL --}}
        <div class="client-film-caption">

            <span>
                BEAUTYBOOK
            </span>

            <i></i>

            <span>
                YOUR BEAUTY · YOUR TIME
            </span>

        </div>

    </div>

</section>

@endsection


@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — CLIENT FILM DASHBOARD
========================================================= */

.client-film-page {
    --film-bg: #efebe6;
    --film-dark: #292724;
    --film-muted: #8f8982;

    margin: 0;

    width: 100%;
    height: 100svh;

    overflow: hidden;

    background: var(--film-bg);

    font-family: 'Montserrat', sans-serif;
}


/* =========================================================
   APP
========================================================= */

.client-film-page #app {
    position: relative;

    width: 100%;
    height: 100svh;

    overflow: hidden;

    background: var(--film-bg);

    border: 0 !important;
}


/* =========================================================
   NAVBAR
========================================================= */

.client-film-page .navbar {
    position: absolute !important;

    top: 0;
    left: 0;
    right: 0;

    z-index: 100;

    min-height: 78px;

    padding: 0 !important;

    background: transparent !important;

    border: 0 !important;
    border-top: 0 !important;
    border-bottom: 0 !important;

    box-shadow: none !important;

    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}


/* navbar container */

.client-film-page .navbar .container,
.client-film-page .navbar .container-fluid {
    width: min(1650px, calc(100% - 110px));

    max-width: none;

    min-height: 78px;

    margin: 0 auto;

    padding: 0 !important;

    display: flex;

    align-items: center;
}


/* logo */

.client-film-page .navbar-brand {
    margin-right: 40px;

    color: #272522 !important;

    font-size: 1.06rem;
    font-weight: 400;

    letter-spacing: -0.035em;
}


/* links */

.client-film-page .navbar .nav-link {
    position: relative;

    padding:
        12px
        14px !important;

    color: rgba(48, 45, 42, 0.64) !important;

    font-size: 0.74rem;
    font-weight: 300;

    transition:
        color 0.25s ease,
        opacity 0.25s ease;
}


.client-film-page .navbar .nav-link:hover,
.client-film-page .navbar .nav-link.active {
    color: #292724 !important;
}


/* remove active underline */

.client-film-page .navbar .nav-link::after,
.client-film-page .navbar .nav-link.active::after {
    display: none !important;

    content: none !important;
}


/* =========================================================
   MAIN
========================================================= */

.client-film-page main {
    position: relative;

    width: 100%;
    height: 100svh;

    min-height: 0;

    margin: 0 !important;
    padding: 0 !important;

    overflow: hidden;

    background: var(--film-bg);
}


/* =========================================================
   PAGE
========================================================= */

.client-film {
    position: relative;

    width: 100%;
    height: 100svh;

    overflow: hidden;

    background: var(--film-bg);

    color: var(--film-dark);
}


/* =========================================================
   VERY SUBTLE LEFT LIGHT
========================================================= */

.client-film::before {
    content: "";

    position: absolute;

    left: -130px;
    top: 22%;

    z-index: 0;

    width: 720px;
    height: 720px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(255,255,255,0.40),
            transparent 67%
        );

    pointer-events: none;
}


/* =========================================================
   VIDEO
========================================================= */

.client-film-media {
    position: absolute;

    /*
        Namjerno ide izvan ekrana.
        Zato se fizički rub videa ne vidi.
    */

    top: -13vh;
    right: -8vw;
    bottom: -13vh;

    z-index: 1;

    width: 70vw;

    overflow: hidden;

    pointer-events: none;


    /*
        Video postaje postepeno proziran
        prema lijevoj strani.
    */

    -webkit-mask-image:
        linear-gradient(
            90deg,

            transparent 0%,

            rgba(0,0,0,0.05) 7%,

            rgba(0,0,0,0.18) 13%,

            rgba(0,0,0,0.42) 21%,

            rgba(0,0,0,0.72) 30%,

            rgba(0,0,0,0.92) 39%,

            #000 49%,

            #000 100%
        );

    mask-image:
        linear-gradient(
            90deg,

            transparent 0%,

            rgba(0,0,0,0.05) 7%,

            rgba(0,0,0,0.18) 13%,

            rgba(0,0,0,0.42) 21%,

            rgba(0,0,0,0.72) 30%,

            rgba(0,0,0,0.92) 39%,

            #000 49%,

            #000 100%
        );
}


/* =========================================================
   VIDEO ITSELF
========================================================= */

.client-film-media video {
    position: absolute;

    inset: 0;

    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;

    object-position: 53% 46%;

    filter:
        grayscale(100%)
        contrast(0.90)
        brightness(1.05);

    opacity: 0.94;

    transform: scale(1.025);

    animation:
        filmVideoEnter
        1.6s
        cubic-bezier(.2,.8,.2,1)
        both;
}


/* =========================================================
   EXTRA SOFT BLEND
========================================================= */

.client-film-media::after {
    content: "";

    position: absolute;

    inset: 0;

    z-index: 3;

    background:
        linear-gradient(
            90deg,

            var(--film-bg) 0%,

            rgba(239,235,230,0.93) 9%,

            rgba(239,235,230,0.68) 19%,

            rgba(239,235,230,0.36) 29%,

            rgba(239,235,230,0.10) 40%,

            transparent 52%
        );

    pointer-events: none;
}


/* =========================================================
   SHELL
========================================================= */

.client-film-shell {
    position: relative;

    z-index: 10;

    width: min(1650px, calc(100% - 110px));
    height: 100%;

    margin: 0 auto;

    box-sizing: border-box;
}


/* =========================================================
   LEFT CONTENT
========================================================= */

.client-film-content {
    position: absolute;

    top: 0;
    left: 0;

    width: 455px;
    height: 100%;

    display: grid;

    grid-template-rows:
        auto
        1fr
        auto;

    padding:
        128px
        0
        48px;

    box-sizing: border-box;

    animation:
        filmContentEnter
        0.95s
        cubic-bezier(.2,.8,.2,1)
        0.1s
        both;
}


/* =========================================================
   TOP INTRO
========================================================= */

.client-film-intro {
    max-width: 390px;
}


.client-film-eyebrow {
    display: block;

    margin-bottom: 12px;

    color: #918b84;

    font-size: 0.42rem;
    font-weight: 500;

    letter-spacing: 0.42em;
}


.client-film-intro h1 {
    margin: 0 0 12px;

    color: #292724;

    font-size: clamp(1.9rem, 2.4vw, 2.65rem);
    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.05em;
}


.client-film-intro p {
    max-width: 315px;

    margin: 0;

    color: #97918a;

    font-size: 0.56rem;
    font-weight: 300;

    line-height: 1.75;
}


/* =========================================================
   CENTER
========================================================= */

.client-film-focus {
    align-self: center;

    max-width: 430px;
    margin-left: 80px;

    padding-bottom: 10px;
}


.client-film-focus-label {
    display: block;

    margin-bottom: 15px;

    color: #918b84;

    font-size: 0.42rem;
    font-weight: 500;

    letter-spacing: 0.38em;
}


.client-film-focus h2 {
    max-width: 420px;

    margin: 0 0 15px;

    color: #292724;

    font-size: clamp(1.8rem, 2.35vw, 2.55rem);
    font-weight: 300;

    line-height: 1.05;

    letter-spacing: -0.045em;

    white-space: nowrap;
}


.client-film-focus > p {
    max-width: 315px;

    margin: 0 0 25px;

    color: #8e8881;

    font-size: 0.57rem;
    font-weight: 300;

    line-height: 1.75;
}


/* =========================================================
   BOOK APPOINTMENT
========================================================= */

.client-film-book {
    display: flex;
    margin: 0 auto;

    width: 255px;
    height: 52px;

    align-items: center;
    justify-content: space-between;

    box-sizing: border-box;

    padding: 0 19px;

    border: 1px solid #2d2a27;

    background: #2d2a27;

    color: #fff;

    text-decoration: none;

    font-size: 0.49rem;
    font-weight: 400;

    letter-spacing: 0.29em;

    transition:
        color 0.35s ease,
        background 0.35s ease,
        transform 0.35s ease;
}


.client-film-book:hover {
    color: #292724;

    background: transparent;

    transform: translateY(-2px);
}


.client-film-arrow {
    margin-left: 20px;

    font-size: 0.82rem;

    letter-spacing: 0;

    transition:
        transform 0.3s ease;
}


.client-film-book:hover
.client-film-arrow {
    transform: translateX(5px);
}


/* =========================================================
   BOTTOM LINKS
========================================================= */

.client-film-links {
    width: 430px;

    margin: 0;
}


.client-film-links a {
    display: flex;

    min-height: 58px;

    align-items: center;
    justify-content: space-between;

    gap: 25px;

    box-sizing: border-box;

    padding: 0 3px;

    border-bottom:
        1px solid rgba(46,42,38,0.16);

    color: #3d3935;

    text-decoration: none;

    transition:
        padding 0.3s ease,
        border-color 0.3s ease,
        background 0.3s ease;
}


.client-film-links a:first-child {
    border-top:
        1px solid rgba(46,42,38,0.16);
}


.client-film-links a:hover {
    padding-left: 8px;

    color: #292724;

    border-color:
        rgba(46,42,38,0.42);

    background:
        rgba(255,255,255,0.10);
}


/* title */

.client-film-links span {
    display: block;

    margin-bottom: 5px;

    color: #504b46;

    font-size: 0.43rem;
    font-weight: 500;

    letter-spacing: 0.29em;
}


/* subtitle */

.client-film-links small {
    display: block;

    color: #9e9891;

    font-size: 0.49rem;
    font-weight: 300;

    letter-spacing: 0;
}


/* arrow */

.client-film-links strong {
    color: #716b65;

    font-size: 0.75rem;
    font-weight: 300;

    transition:
        transform 0.3s ease;
}


.client-film-links a:hover strong {
    transform: translateX(5px);
}


/* =========================================================
   BOTTOM RIGHT CAPTION
========================================================= */

.client-film-caption {
    position: absolute;

    right: 0;
    bottom: 26px;

    display: flex;

    align-items: center;

    gap: 13px;

    color: rgba(65,60,55,0.40);

    font-size: 0.37rem;
    font-weight: 500;

    letter-spacing: 0.31em;

    pointer-events: none;
}


.client-film-caption i {
    display: block;

    width: 35px;
    height: 1px;

    background:
        rgba(65,60,55,0.23);
}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes filmVideoEnter {

    from {
        opacity: 0;

        transform:
            translateX(25px)
            scale(1.055);
    }

    to {
        opacity: 0.94;

        transform:
            translateX(0)
            scale(1.025);
    }

}


@keyframes filmContentEnter {

    from {
        opacity: 0;

        transform:
            translateY(12px);
    }

    to {
        opacity: 1;

        transform:
            translateY(0);
    }

}


/* =========================================================
   SHORTER DESKTOP SCREENS
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .client-film-page .navbar,
    .client-film-page .navbar .container,
    .client-film-page .navbar .container-fluid {
        min-height: 66px;
    }


    .client-film-content {
        padding:
            93px
            0
            27px;
    }


    .client-film-intro h1 {
        font-size: 1.9rem;
    }


    .client-film-intro p {
        line-height: 1.55;
    }


    .client-film-focus-label {
        margin-bottom: 10px;
    }


    .client-film-focus h2 {
        margin-bottom: 11px;

        font-size: 2.75rem;
    }


    .client-film-focus > p {
        margin-bottom: 18px;

        line-height: 1.55;
    }


    .client-film-book {
        height: 48px;
    }


    .client-film-links a {
        min-height: 49px;
    }


    .client-film-caption {
        bottom: 16px;
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .client-film-page .navbar .container,
    .client-film-page .navbar .container-fluid {
        width: calc(100% - 46px);
    }


    .client-film-shell {
        width: calc(100% - 50px);
    }


    .client-film-media {
        right: -22vw;

        width: 89vw;
    }


    .client-film-content {
        width: 390px;

        padding:
            108px
            0
            38px;
    }


    .client-film-links {
        width: 370px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 600px) {

    .client-film-page,
    .client-film-page #app,
    .client-film-page main,
    .client-film {
        height: 100svh;

        overflow: hidden;
    }


    .client-film-page .navbar {
        min-height: 62px;
    }


    .client-film-page .navbar .container,
    .client-film-page .navbar .container-fluid {
        width: calc(100% - 30px);

        min-height: 62px;
    }


    .client-film-page .navbar-brand {
        margin-right: 0;

        font-size: 0.95rem;
    }


    .client-film-shell {
        width: calc(100% - 30px);
    }


    /* VIDEO */

    .client-film-media {
        top: -16vh;
        right: -57vw;
        bottom: auto;

        width: 145vw;
        height: 78vh;
    }


    .client-film-media video {
        object-position: 53% 35%;

        opacity: 0.64;
    }


    /* CONTENT */

    .client-film-content {
        position: relative;

        top: 0;
        left: 0;

        width: 100%;
        height: 100%;

        padding:
            87px
            0
            18px;

        grid-template-rows:
            auto
            1fr
            auto;
    }


    .client-film-intro {
        max-width: 265px;
    }


    .client-film-intro h1 {
        font-size: 1.8rem;
    }


    .client-film-intro p {
        max-width: 240px;

        font-size: 0.53rem;
    }


    .client-film-focus {
        align-self: end;

        width: 100%;

        margin-bottom: 22px;
    }


    .client-film-focus h2 {
        font-size: 2.55rem;
    }


    .client-film-focus > p {
        max-width: 260px;

        margin-bottom: 18px;
    }


    .client-film-book {
        width: 100%;
    }


    .client-film-links {
        width: 100%;
    }


    .client-film-links a {
        min-height: 47px;
    }


    .client-film-caption {
        display: none;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .client-film-media video,
    .client-film-content {
        animation: none !important;
    }

}

</style>

@endpush