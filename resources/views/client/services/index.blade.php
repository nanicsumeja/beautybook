@extends('layouts.app')

@section('body-class', 'client-services-page')
@section('main-class', '')

@section('content')

<section class="services-space">

    <div class="services-shell">

        <div class="services-header">

            <div>
                <span class="services-eyebrow">
                    BEAUTYBOOK SERVICES
                </span>

                <h1>
                    Find your next treatment.
                </h1>

                <p>
                    Choose the service that fits your beauty routine.
                </p>
            </div>

            <a
                href="{{ route('client.dashboard') }}"
                class="services-back"
            >
                ← BACK TO MY SPACE
            </a>

        </div>


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

                        <div class="service-card-top">

                            <span class="service-index">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <span class="service-duration">
                                {{ $service->duration_minutes }} MIN
                            </span>

                        </div>


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
                                    A BeautyBook treatment designed
                                    for your next salon visit.
                                </p>

                            @endif

                        </div>


                        <div class="service-card-bottom">

                            <div class="service-price">
                                <span>PRICE</span>

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
                                BOOK
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

    .client-services-page {
        background: #f3efea;
    }

    .services-space {
        min-height: calc(100vh - 62px);
        padding: 34px 0 46px;
        background:
            radial-gradient(
                circle at 90% 5%,
                rgba(196, 159, 148, 0.15),
                transparent 22%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .services-shell {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .services-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 40px;
        margin-bottom: 30px;
        padding-bottom: 22px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .services-eyebrow {
        display: block;
        margin-bottom: 7px;
        font-size: 0.6rem;
        font-weight: 500;
        letter-spacing: 0.22em;
        color: #a37b6e;
    }

    .services-header h1 {
        margin: 0 0 7px;
        font-size: clamp(2rem, 4vw, 3.4rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .services-header p {
        margin: 0;
        font-size: 0.82rem;
        color: #7d756f;
    }

    .services-back {
        padding-bottom: 5px;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.15em;
    }

    .services-back:hover {
        color: #9b6e60;
    }


    /* GRID */

    .services-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }


    /* CARD */

    .service-card {
        min-height: 300px;
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
        transition:
            transform 0.2s ease,
            background 0.2s ease,
            border-color 0.2s ease;
    }

    .service-card:nth-child(4n + 2),
    .service-card:nth-child(4n + 3) {
        background: #e6d8cf;
    }

    .service-card:hover {
        transform: translateY(-3px);
        border-color: rgba(163, 123, 110, 0.28);
    }

    .service-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .service-index,
    .service-duration {
        font-size: 0.58rem;
        letter-spacing: 0.16em;
        color: #9a8e86;
    }

    .service-card-content h2 {
        max-width: 520px;
        margin: 0 0 12px;
        font-size: clamp(1.7rem, 3vw, 2.6rem);
        font-weight: 300;
        line-height: 1.02;
        letter-spacing: -0.035em;
    }

    .service-card-content p {
        max-width: 460px;
        margin: 0;
        font-size: 0.78rem;
        line-height: 1.65;
        color: #746d67;
    }


    /* BOTTOM */

    .service-card-bottom {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-top: 30px;
        padding-top: 18px;
        border-top: 1px solid rgba(33, 29, 26, 0.12);
    }

    .service-price span {
        display: block;
        margin-bottom: 4px;
        font-size: 0.52rem;
        letter-spacing: 0.16em;
        color: #9a8e86;
    }

    .service-price strong {
        font-size: 1rem;
        font-weight: 500;
    }

    .service-book {
        display: inline-flex;
        align-items: center;
        gap: 18px;
        padding: 11px 15px;
        background: #211d1a;
        color: #fff;
        text-decoration: none;
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.15em;
        transition: background 0.2s ease;
    }

    .service-book:hover {
        background: #a9796b;
        color: #fff;
    }


    /* EMPTY */

    .services-empty {
        padding: 60px 40px;
        text-align: center;
        background: #faf7f3;
    }

    .services-empty-label {
        display: block;
        margin-bottom: 12px;
        font-size: 0.6rem;
        letter-spacing: 0.2em;
        color: #a37b6e;
    }

    .services-empty h2 {
        margin-bottom: 10px;
        font-size: 2rem;
        font-weight: 300;
    }

    .services-empty p {
        margin: 0;
        font-size: 0.8rem;
        color: #817871;
    }


    /* RESPONSIVE */

    @media (max-width: 800px) {

        .services-grid {
            grid-template-columns: 1fr;
        }

        .services-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 18px;
        }

    }

    @media (max-width: 575px) {

        .services-space {
            padding: 24px 0 34px;
        }

        .services-shell {
            width: calc(100% - 24px);
        }

        .service-card {
            min-height: 270px;
            padding: 24px;
        }

        .service-card-bottom {
            align-items: center;
        }

    }

</style>
@endpush