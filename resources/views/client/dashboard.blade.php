@extends('layouts.app')

@section('body-class', 'client-lux-page')
@section('main-class', '')

@section('content')

<section class="client-space">

    <div class="client-space-shell">

        <div class="client-space-header">

            <div>
                <span class="client-space-eyebrow">
                    YOUR BEAUTYBOOK
                </span>

                <h1>
                    Hi, {{ Auth::user()->name }}.
                </h1>

                <p>
                    Your personal space for beauty appointments.
                </p>
            </div>

            <span class="client-space-status">
                CLIENT ACCOUNT
            </span>

        </div>


        <div class="client-space-grid">

            <div class="client-space-book">

                <span class="client-space-label">
                    YOUR NEXT VISIT
                </span>

                <h2>
                    Ready for your
                    next appointment?
                </h2>

                <p>
                    Choose a service, specialist and available time
                    in just a few steps.
                </p>

                <a
                    href="{{ route('client.services.index') }}"
                    class="client-space-main-button"
                >
                    BOOK APPOINTMENT
                    <span>→</span>
                </a>

                <div class="client-space-decoration">
                    BEAUTYBOOK
                </div>

            </div>


            <div class="client-space-side">

                <a
                    href="{{ route('client.reservations.index') }}"
                    class="client-space-card client-space-card-pink"
                >
                    <div class="client-space-card-label">
                        MY SPACE
                    </div>

                    <div>
                        <h3>My appointments</h3>

                        <p>
                            Upcoming visits, payments and history.
                        </p>
                    </div>

                    <span class="client-space-arrow">→</span>
                </a>


                <a
                    href="{{ route('client.services.index') }}"
                    class="client-space-card client-space-card-light"
                >
                    <div class="client-space-card-label">
                        DISCOVER
                    </div>

                    <div>
                        <h3>Services</h3>

                        <p>
                            Explore treatments, duration and prices.
                        </p>
                    </div>

                    <span class="client-space-arrow">→</span>
                </a>

            </div>

        </div>

    </div>

</section>

@endsection


@push('styles')
<style>

    .client-lux-page {
        height: 100vh;
        overflow: hidden;
        background: #f3efea;
    }

    .client-lux-page #app {
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .client-lux-page main {
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    .client-lux-page {
        background: #f2ece6;
    }

    .client-space {
        height: 100%;
        min-height: 0;
        overflow: hidden;
        padding: 22px 0;
        box-sizing: border-box;
        background:
            radial-gradient(
                circle at 92% 10%,
                rgba(201, 163, 151, 0.18),
                transparent 24%
            ),
            #f2ece6;
        font-family: 'Montserrat', sans-serif;
        color: #211d1a;
        box-sizing: border-box;
    }


    /* HEADER */

    .client-space-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 40px;
        margin-bottom: 16px;
    }

    .client-space-eyebrow {
        display: block;
        margin-bottom: 5px;
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.22em;
        color: #a77b6d;
    }

    .client-space-header h1 {
        margin: 0 0 3px;
        font-size: clamp(1.8rem, 3vw, 2.7rem);
        font-weight: 300;
        letter-spacing: -0.04em;
    }

    .client-space-header p {
        margin: 0;
        font-size: 0.76rem;
        color: #7d756f;
    }

    .client-space-status {
        padding-bottom: 4px;
        font-size: 0.57rem;
        letter-spacing: 0.18em;
        color: #9b9088;
    }


    /* GRID */

    .client-space-shell {
        width: min(1180px, calc(100% - 48px));
        height: 100%;
        margin: 0 auto;

        display: flex;
        flex-direction: column;
    }

    .client-space-grid {
        display: grid;
        grid-template-columns: 1.35fr 0.65fr;
        gap: 16px;

        flex: 1;
        min-height: 0;
    }

    /* MAIN CARD */

    .client-space-book {
        position: relative;
        min-height: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
        padding: 44px;
        background: #211d1a;
        color: #fff;
    }

    .client-space-label {
        margin-bottom: 20px;
        font-size: 0.6rem;
        letter-spacing: 0.22em;
        color: #cba99d;
    }

    .client-space-book h2 {
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 0 16px;
        font-size: clamp(2.2rem, 4.1vw, 4rem);
        font-weight: 300;
        line-height: 0.96;
        letter-spacing: -0.045em;
        text-transform: uppercase;
    }

    .client-space-book p {
        position: relative;
        z-index: 2;
        max-width: 410px;
        margin: 0 0 24px;
        font-size: 0.8rem;
        line-height: 1.65;
        color: #c9c0ba;
    }

    .client-space-main-button {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        width: fit-content;
        min-width: 210px;
        padding: 13px 16px;
        background: #f3ebe5;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.14em;
    }

    .client-space-main-button:hover {
        background: #d6b4a7;
        color: #211d1a;
    }

    .client-space-decoration {
        position: absolute;
        right: -18px;
        bottom: -5px;
        font-size: clamp(4rem, 8vw, 7.5rem);
        font-weight: 300;
        letter-spacing: -0.06em;
        color: rgba(255,255,255,0.035);
        pointer-events: none;
    }


    /* RIGHT SIDE */

    .client-space-side {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 14px;
    }

    .client-space-card {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 26px;
        color: #211d1a;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .client-space-card:hover {
        transform: translateY(-2px);
        color: #211d1a;
    }

    .client-space-card-pink {
        background: #d8b9ae;
    }

    .client-space-card-light {
        background: #e8ddd4;
    }

    .client-space-card-label {
        font-size: 0.56rem;
        letter-spacing: 0.18em;
        opacity: 0.6;
    }

    .client-space-card h3 {
        margin: 0 0 6px;
        font-size: 1.25rem;
        font-weight: 400;
    }

    .client-space-card p {
        max-width: 230px;
        margin: 0;
        font-size: 0.72rem;
        line-height: 1.5;
        opacity: 0.72;
    }

    .client-space-arrow {
        position: absolute;
        right: 24px;
        bottom: 20px;
        font-size: 1rem;
    }


    @media (max-width: 900px) {

        .client-space-grid {
            height: auto;
            max-height: none;
            grid-template-columns: 1fr;
        }

        .client-space-book {
            min-height: 380px;
        }

        .client-space-side {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto;
        }

        .client-space-card {
            min-height: 180px;
        }

        .client-lux-page,
        .client-lux-page #app {
            height: auto;
            min-height: 100vh;
            overflow: auto;
        }

        .client-lux-page main,
        .client-space {
            height: auto;
            overflow: visible;
        }

        .client-space-shell {
            height: auto;
        }

        .client-space-grid {
            flex: none;
        }

    }

    @media (max-width: 575px) {

        .client-space {
            padding: 18px 0;
        }

        .client-space-shell {
            width: calc(100% - 24px);
        }

        .client-space-status {
            display: none;
        }

        .client-space-grid {
            display: block;
        }

        .client-space-book {
            min-height: 360px;
            padding: 30px 24px;
            margin-bottom: 12px;
        }

        .client-space-book h2 {
            font-size: 2.35rem;
        }

        .client-space-side {
            display: grid;
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush