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

                <div class="owner-client-profile-status">
                    <div>
                        <span>ACCOUNT STATUS</span>

                        <strong class="{{ $client->is_active ? 'is-active' : 'is-inactive' }}">
                            {{ $client->is_active ? 'ACTIVE' : 'INACTIVE' }}
                        </strong>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('owner.clients.toggle-active', $client) }}"
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
                            class="{{ $client->is_active ? 'deactivate' : 'activate' }}"
                        >
                            {{ $client->is_active ? 'DEACTIVATE CLIENT' : 'ACTIVATE CLIENT' }}
                        </button>
                    </form>
                </div>

                <div class="owner-client-profile-note">

                    <span>
                        SERVICE HISTORY
                    </span>

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

                        <span>○</span>

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

    .owner-client-profile-page {
        background: #f3efea;
    }

    .owner-client-profile-main {
        background: #f3efea;
    }

    .owner-client-profile-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 40px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190,151,140,0.12),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-client-profile-shell {
        width: min(1120px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* BACK */

    .owner-client-profile-back-row {
        margin-bottom: 17px;
    }

    .owner-client-profile-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .owner-client-profile-back:hover {
        color: #9d7063;
    }


    /* HEADER */

    .owner-client-profile-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 18px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-client-profile-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.64rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-client-profile-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-client-profile-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.76rem;
    }

    .owner-client-profile-avatar {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        background: #dec7bd;
        color: #211d1a;
        font-size: 1.15rem;
        font-weight: 400;
    }


    /* GRID */

    .owner-client-profile-grid {
        display: grid;
        grid-template-columns: 0.72fr 1.28fr;
        gap: 15px;
        align-items: start;
    }


    /* PROFILE CARD */

    .owner-client-profile-card {
        background: #211d1a;
        color: #fff;
    }

    .owner-client-profile-card-top {
        padding: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .owner-client-profile-card-top span {
        display: block;
        margin-bottom: 5px;
        color: #c7a59b;
        font-size: 0.56rem;
        letter-spacing: 0.14em;
    }

    .owner-client-profile-card-top h2 {
        margin: 0;
        font-size: 1.22rem;
        font-weight: 300;
    }


    /* CONTACT */

    .owner-client-profile-contact {
        padding: 6px 24px;
    }

    .owner-client-profile-contact > div {
        padding: 17px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .owner-client-profile-contact > div:last-child {
        border-bottom: 0;
    }

    .owner-client-profile-contact span {
        display: block;
        margin-bottom: 5px;
        color: #b99c92;
        font-size: 0.56rem;
        letter-spacing: 0.12em;
    }

    .owner-client-profile-contact strong {
        display: block;
        overflow-wrap: anywhere;
        color: #f4efeb;
        font-size: 0.69rem;
        font-weight: 400;
    }


    /* HISTORY COUNT */

    .owner-client-profile-note {
        margin: 12px 24px 24px;
        padding: 18px;
        background: rgba(216,184,173,0.11);
        border: 1px solid rgba(216,184,173,0.18);
    }

    .owner-client-profile-note > span {
        display: block;
        margin-bottom: 6px;
        color: #c5a79d;
        font-size: 0.54rem;
        letter-spacing: 0.13em;
    }

    .owner-client-profile-note strong {
        display: block;
        font-size: 2rem;
        font-weight: 300;
        line-height: 1;
    }

    .owner-client-profile-note small {
        display: block;
        margin-top: 5px;
        color: #bbb0aa;
        font-size: 0.6rem;
    }


    /* HISTORY CARD */

    .owner-client-history {
        background: #faf7f3;
        border: 1px solid rgba(33,29,26,0.08);
    }

    .owner-client-history-heading {
        min-height: 74px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 17px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-client-history-heading span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.56rem;
        letter-spacing: 0.14em;
    }

    .owner-client-history-heading h2 {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 300;
    }

    .owner-client-history-heading > strong {
        color: #8d7e76;
        font-size: 0.7rem;
        font-weight: 400;
    }


    /* HISTORY HEADER */

    .owner-client-history-head {
        display: grid;
        grid-template-columns:
            0.75fr
            1.25fr
            1fr
            0.7fr
            0.75fr;
        gap: 15px;
        padding: 11px 20px;
        background: #211d1a;
        color: #cbbdb7;
    }

    .owner-client-history-head span {
        font-size: 0.51rem;
        letter-spacing: 0.11em;
    }


    /* HISTORY ROW */

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
        min-height: 72px;
        padding: 12px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.08);
        transition: background 0.15s ease;
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
        font-size: 0.66rem;
        font-weight: 400;
        line-height: 1.45;
    }

    .owner-client-history-row small {
        display: block;
        margin-top: 4px;
        color: #93877f;
        font-size: 0.58rem;
        line-height: 1.45;
    }


    /* STATUS */

    .owner-history-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 8px;
        background: #d9e2d8;
        color: #596958;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.08em;
    }

    .owner-history-mobile-label {
        display: none;
    }


    /* EMPTY */

    .owner-client-history-empty {
        padding: 70px 25px;
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
        margin: 0 0 5px;
        font-size: 1.12rem;
        font-weight: 300;
    }

    .owner-client-history-empty p {
        margin: 0;
        color: #887d76;
        font-size: 0.68rem;
    }

    .owner-client-profile-status {
        margin: 12px 24px 0;
        padding: 16px 0 4px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .owner-client-profile-status > div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 13px;
    }

    .owner-client-profile-status > div > span {
        color: #b99c92;
        font-size: 0.55rem;
        letter-spacing: 0.12em;
    }

    .owner-client-profile-status > div > strong {
        padding: 5px 8px;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.08em;
    }

    .owner-client-profile-status .is-active {
        background: rgba(166, 197, 165, 0.16);
        color: #b7d2b5;
    }

    .owner-client-profile-status .is-inactive {
        background: rgba(201, 137, 125, 0.16);
        color: #d9aaa0;
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
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .owner-client-profile-status button.deactivate {
        border-color: rgba(215, 157, 145, 0.55);
        color: #d8aaa0;
    }

    .owner-client-profile-status button.deactivate:hover {
        background: #b67668;
        border-color: #b67668;
        color: #fff;
    }

    .owner-client-profile-status button.activate {
        border-color: rgba(172, 201, 169, 0.55);
        color: #b8d1b5;
    }

    .owner-client-profile-status button.activate:hover {
        background: #71866f;
        border-color: #71866f;
        color: #fff;
}


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .owner-client-profile-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 760px) {

        .owner-client-history-head {
            display: none;
        }

        .owner-client-history-row {
            grid-template-columns: 1fr 1fr;
            padding: 17px 20px;
        }

        .owner-history-mobile-label {
            display: block;
            margin-bottom: 4px;
            color: #9f8075;
            font-size: 0.52rem;
            letter-spacing: 0.1em;
        }

    }

    @media (max-width: 575px) {

        .owner-client-profile-space {
            padding: 21px 0 32px;
        }

        .owner-client-profile-shell {
            width: calc(100% - 24px);
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