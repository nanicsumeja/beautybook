@extends('layouts.app')

@section('body-class', 'employee-client-profile-page')

@section('content')

<section class="employee-client-profile-space">

    <div class="employee-client-profile-shell">

        <div class="client-profile-back-row">

            <a
                href="{{ route('employee.clients.index') }}"
                class="client-profile-back"
            >
                ← BACK TO CLIENTS
            </a>

        </div>


        <div class="client-profile-header">

            <div>

                <span class="client-profile-eyebrow">
                    CLIENT PROFILE
                </span>

                <h1>
                    {{ $client->name }}
                    {{ $client->surname }}
                </h1>

                <p>
                    Contact details and completed service history.
                </p>

            </div>

        </div>


        <div class="client-profile-grid">

            <section class="client-profile-card">

                <div class="client-profile-identity">

                    <div class="client-profile-avatar">
                        {{ mb_strtoupper(
                            mb_substr($client->name, 0, 1)
                        ) }}
                    </div>

                    <div>

                        <span>
                            BEAUTYBOOK CLIENT
                        </span>

                        <h2>
                            {{ $client->name }}
                            {{ $client->surname }}
                        </h2>

                    </div>

                </div>


                <div class="client-profile-contact">

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
                            {{ $client->phone ?: '-' }}
                        </strong>

                    </div>

                </div>


                <div class="client-profile-note">

                    <span>
                        CLIENT RECORD
                    </span>

                    <p>
                        This profile includes services completed
                        with you.
                    </p>

                </div>

            </section>


            <section class="client-history-card">

                <div class="client-history-header">

                    <div>

                        <span>
                            SERVICE HISTORY
                        </span>

                        <h2>
                            Completed services
                        </h2>

                        <p>
                            Previous completed appointments with this client.
                        </p>

                    </div>


                    <div class="client-history-count">

                        <strong>
                            {{ $completedReservations->count() }}
                        </strong>

                        <span>
                            COMPLETED
                        </span>

                    </div>

                </div>


                @if ($completedReservations->isEmpty())

                    <div class="client-history-empty">

                        <span>
                            NO HISTORY
                        </span>

                        <h3>
                            No completed services yet.
                        </h3>

                        <p>
                            Completed appointments will appear here.
                        </p>

                    </div>

                @else

                    <div class="client-history-list">

                        <div class="client-history-list-header">
                            <span>DATE & TIME</span>
                            <span>SERVICE</span>
                            <span>PRICE</span>
                            <span>STATUS</span>
                        </div>


                        @foreach (
                            $completedReservations
                            as $reservation
                        )

                            <article class="client-history-row">

                                <div class="client-history-date">

                                    <div class="client-history-date-box">

                                        <strong>
                                            {{
                                                $reservation
                                                    ->appointment_date
                                                    ->format('d')
                                            }}
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

                                        <span>
                                            {{
                                                $reservation
                                                    ->appointment_date
                                                    ->format('d.m.Y')
                                            }}
                                        </span>

                                        <strong>
                                            {{
                                                substr(
                                                    $reservation
                                                        ->start_time,
                                                    0,
                                                    5
                                                )
                                            }}
                                        </strong>

                                    </div>

                                </div>


                                <div class="client-history-service">

                                    <span class="client-history-mobile-label">
                                        SERVICE
                                    </span>

                                    <strong>
                                        {{
                                            $reservation
                                                ->service_name
                                        }}
                                    </strong>

                                </div>


                                <div class="client-history-price">

                                    <span class="client-history-mobile-label">
                                        PRICE
                                    </span>

                                    <strong>
                                        {{
                                            number_format(
                                                (float)
                                                $reservation
                                                    ->total_price,
                                                2
                                            )
                                        }}
                                        KM
                                    </strong>

                                </div>


                                <div>

                                    <span class="client-history-status">
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

    .employee-client-profile-page {
        background: #f3efea;
    }

    .employee-client-profile-space {
        min-height: calc(100vh - 62px);
        padding: 28px 0 40px;
        background:
            radial-gradient(
                circle at 91% 7%,
                rgba(190, 151, 140, 0.12),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .employee-client-profile-shell {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* BACK */

    .client-profile-back-row {
        margin-bottom: 18px;
    }

    .client-profile-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.5rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .client-profile-back:hover {
        color: #9d7063;
    }


    /* HEADER */

    .client-profile-header {
        margin-bottom: 20px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .client-profile-eyebrow {
        display: block;
        margin-bottom: 6px;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        color: #a27a6d;
    }

    .client-profile-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3.1rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .client-profile-header p {
        margin: 0;
        font-size: 0.73rem;
        color: #7c736d;
    }


    /* GRID */

    .client-profile-grid {
        display: grid;
        grid-template-columns: 0.7fr 1.3fr;
        gap: 16px;
        align-items: start;
    }


    /* PROFILE CARD */

    .client-profile-card {
        padding: 28px;
        background: #211d1a;
        color: #fff;
    }

    .client-profile-identity {
        display: flex;
        align-items: center;
        gap: 17px;
        padding-bottom: 23px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    .client-profile-avatar {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        background: #d7b7ac;
        color: #211d1a;
        font-size: 1.35rem;
        font-weight: 400;
    }

    .client-profile-identity span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.47rem;
        letter-spacing: 0.15em;
        color: #c3a79d;
    }

    .client-profile-identity h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 300;
    }


    /* CONTACT */

    .client-profile-contact {
        padding-top: 8px;
    }

    .client-profile-contact > div {
        padding: 14px 0;
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    .client-profile-contact span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.46rem;
        letter-spacing: 0.14em;
        color: #9f9791;
    }

    .client-profile-contact strong {
        font-size: 0.68rem;
        font-weight: 500;
        word-break: break-word;
    }


    /* NOTE */

    .client-profile-note {
        margin-top: 19px;
        padding: 15px;
        background: #d7b7ac;
        color: #211d1a;
    }

    .client-profile-note span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.46rem;
        letter-spacing: 0.14em;
    }

    .client-profile-note p {
        margin: 0;
        font-size: 0.64rem;
        line-height: 1.5;
    }


    /* HISTORY */

    .client-history-card {
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }

    .client-history-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        padding: 25px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.1);
    }

    .client-history-header > div:first-child > span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.48rem;
        letter-spacing: 0.15em;
        color: #a27a6d;
    }

    .client-history-header h2 {
        margin: 0 0 5px;
        font-size: 1.4rem;
        font-weight: 300;
    }

    .client-history-header p {
        margin: 0;
        font-size: 0.65rem;
        color: #81766f;
    }

    .client-history-count {
        text-align: right;
    }

    .client-history-count strong {
        display: block;
        font-size: 1.5rem;
        font-weight: 300;
    }

    .client-history-count span {
        font-size: 0.44rem;
        letter-spacing: 0.13em;
        color: #9c8177;
    }


    /* LIST */

    .client-history-list-header {
        display: grid;
        grid-template-columns: 1.25fr 1.2fr 0.7fr 0.65fr;
        gap: 18px;
        padding: 12px 21px;
        background: #211d1a;
        color: #cbbeb8;
    }

    .client-history-list-header span {
        font-size: 0.44rem;
        letter-spacing: 0.13em;
    }

    .client-history-row {
        display: grid;
        grid-template-columns: 1.25fr 1.2fr 0.7fr 0.65fr;
        gap: 18px;
        align-items: center;
        padding: 15px 21px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.09);
        transition: background 0.15s ease;
    }

    .client-history-row:last-child {
        border-bottom: 0;
    }

    .client-history-row:hover {
        background: #f3ebe6;
    }


    /* DATE */

    .client-history-date {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .client-history-date-box {
        width: 42px;
        height: 50px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #dec7bd;
    }

    .client-history-date-box strong {
        font-size: 1rem;
        font-weight: 400;
        line-height: 1;
    }

    .client-history-date-box span {
        margin-top: 3px;
        font-size: 0.4rem;
        letter-spacing: 0.12em;
    }

    .client-history-date > div:last-child > span {
        display: block;
        margin-bottom: 3px;
        font-size: 0.48rem;
        color: #8d817a;
    }

    .client-history-date > div:last-child > strong {
        font-size: 0.68rem;
        font-weight: 500;
    }


    /* SERVICE / PRICE */

    .client-history-service strong,
    .client-history-price strong {
        font-size: 0.66rem;
        font-weight: 500;
    }

    .client-history-mobile-label {
        display: none;
    }


    /* STATUS */

    .client-history-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 84px;
        padding: 7px 9px;
        background: #211d1a;
        color: #fff;
        font-size: 0.43rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }


    /* EMPTY */

    .client-history-empty {
        padding: 60px 30px;
        text-align: center;
    }

    .client-history-empty > span {
        display: block;
        margin-bottom: 7px;
        font-size: 0.48rem;
        letter-spacing: 0.16em;
        color: #a27a6d;
    }

    .client-history-empty h3 {
        margin: 0 0 7px;
        font-size: 1.35rem;
        font-weight: 300;
    }

    .client-history-empty p {
        margin: 0;
        font-size: 0.64rem;
        color: #7c736d;
    }


    /* RESPONSIVE */

    @media (max-width: 850px) {

        .client-profile-grid {
            grid-template-columns: 1fr;
        }

        .client-history-list-header {
            display: none;
        }

        .client-history-row {
            grid-template-columns: 1fr 1fr;
        }

        .client-history-mobile-label {
            display: block;
            margin-bottom: 4px;
            font-size: 0.42rem;
            letter-spacing: 0.12em;
            color: #9c8177;
        }

    }


    @media (max-width: 575px) {

        .employee-client-profile-space {
            padding: 22px 0 32px;
        }

        .employee-client-profile-shell {
            width: calc(100% - 24px);
        }

        .client-profile-card {
            padding: 23px;
        }

        .client-history-header {
            padding: 22px;
        }

        .client-history-row {
            grid-template-columns: 1fr;
            gap: 13px;
            padding: 18px;
        }

    }

</style>
@endpush