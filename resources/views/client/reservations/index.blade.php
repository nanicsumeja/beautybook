@extends('layouts.app')

@section('body-class', 'client-appointments-page')
@section('main-class', '')

@section('content')

<section class="appointments-space">

    <div class="appointments-shell">

        {{-- HEADER --}}
        <div class="appointments-header">

            <div>
                <span class="appointments-eyebrow">
                    YOUR BEAUTYBOOK
                </span>

                <h1>
                    My appointments
                </h1>

                <p>
                    Keep track of your upcoming visits, payments and history.
                </p>
            </div>

            <a
                href="{{ route('client.services.index') }}"
                class="appointments-book-button"
            >
                BOOK APPOINTMENT
                <span>→</span>
            </a>

        </div>


        {{-- MESSAGES --}}
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


        {{-- EMPTY --}}
        @if ($reservations->isEmpty())

            <div class="appointments-empty">

                <span>
                    NO APPOINTMENTS
                </span>

                <h2>
                    Your BeautyBook journey starts here.
                </h2>

                <p>
                    Choose a service and book your first appointment.
                </p>

                <a
                    href="{{ route('client.services.index') }}"
                    class="appointments-empty-button"
                >
                    EXPLORE SERVICES
                    <span>→</span>
                </a>

            </div>

        @else

            <div class="appointments-grid">

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


                    <article class="appointment-card">

                        {{-- TOP --}}
                        <div class="appointment-card-top">

                            <div class="appointment-date">

                                <span>
                                    {{ $reservation
                                        ->appointment_date
                                        ->format('d') }}
                                </span>

                                <div>
                                    <strong>
                                        {{ strtoupper(
                                            $reservation
                                                ->appointment_date
                                                ->format('M')
                                        ) }}
                                    </strong>

                                    <small>
                                        {{ $reservation
                                            ->appointment_date
                                            ->format('Y') }}
                                    </small>
                                </div>

                            </div>


                            <span class="appointment-status {{ $statusClass }}">
                                {{ strtoupper($reservation->status) }}
                            </span>

                        </div>


                        {{-- SERVICE --}}
                        <div class="appointment-main">

                            <span class="appointment-label">
                                SERVICE
                            </span>

                            <h2>
                                {{ $reservation->service_name }}
                            </h2>

                        </div>


                        {{-- DETAILS --}}
                        <div class="appointment-details">

                            <div>
                                <span>TIME</span>

                                <strong>
                                    {{ substr(
                                        $reservation->start_time,
                                        0,
                                        5
                                    ) }}
                                    –
                                    {{ substr(
                                        $reservation->end_time,
                                        0,
                                        5
                                    ) }}
                                </strong>
                            </div>

                            <div>
                                <span>DURATION</span>

                                <strong>
                                    {{ $reservation->duration_minutes }}
                                    min
                                </strong>
                            </div>

                            <div>
                                <span>PRICE</span>

                                <strong>
                                    {{ number_format(
                                        (float) $reservation->total_price,
                                        2
                                    ) }}
                                    KM
                                </strong>
                            </div>

                        </div>


                        {{-- PAYMENT --}}
                        <div class="appointment-payment">

                            <div>
                                <span class="appointment-label">
                                    ADVANCE PAYMENT
                                </span>

                                <strong>
                                    {{ number_format(
                                        (float) $reservation->advance_amount,
                                        2
                                    ) }}
                                    KM
                                </strong>
                            </div>

                            <span class="payment-status {{ $paymentClass }}">
                                {{ strtoupper(
                                    $reservation->payment_status
                                ) }}
                            </span>

                        </div>


                        {{-- ACTIONS --}}
                        @if (
                            $reservation->status === 'pending'
                            && in_array(
                                $reservation->payment_status,
                                ['unpaid', 'failed'],
                                true
                            )
                        )

                            <div class="appointment-payment-action">

                                <div>
                                    <span>
                                        PAYMENT REQUIRED
                                    </span>

                                    <p>
                                        Pay your advance to continue
                                        with the appointment.
                                    </p>
                                </div>

                                <a
                                    href="{{ route(
                                        'client.reservations.payment',
                                        $reservation
                                    ) }}"
                                    class="appointment-pay-button"
                                >
                                    PAY
                                    {{ number_format(
                                        (float) $reservation->advance_amount,
                                        2
                                    ) }}
                                    KM
                                    <span>→</span>
                                </a>

                            </div>

                        @endif


                        @if ($canCancel)

                            <div class="appointment-cancel-area">

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
                                        CANCEL APPOINTMENT
                                    </button>

                                </form>

                            </div>

                        @endif

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection


@push('styles')
<style>

    .client-appointments-page {
        background: #f3efea;
    }

    .appointments-space {
        min-height: calc(100vh - 62px);
        padding: 34px 0 50px;
        background:
            radial-gradient(
                circle at 90% 8%,
                rgba(194, 155, 144, 0.14),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .appointments-shell {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .appointments-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 28px;
        padding-bottom: 22px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .appointments-eyebrow {
        display: block;
        margin-bottom: 7px;
        font-size: 0.59rem;
        font-weight: 500;
        letter-spacing: 0.21em;
        color: #a27a6d;
    }

    .appointments-header h1 {
        margin: 0 0 7px;
        font-size: clamp(2rem, 4vw, 3.4rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .appointments-header p {
        margin: 0;
        font-size: 0.8rem;
        color: #7d746e;
    }

    .appointments-book-button {
        display: inline-flex;
        align-items: center;
        gap: 24px;
        padding: 13px 16px;
        background: #211d1a;
        color: #fff;
        text-decoration: none;
        font-size: 0.61rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        transition: background 0.2s ease;
    }

    .appointments-book-button:hover {
        background: #9e7164;
        color: #fff;
    }


    /* ALERTS */

    .appointments-alert {
        margin-bottom: 16px;
        padding: 15px 18px;
        font-size: 0.72rem;
        line-height: 1.5;
    }

    .appointments-alert-success {
        background: #dfe8de;
        color: #42523f;
        border-left: 3px solid #6f8569;
    }

    .appointments-alert-error {
        background: #efddd8;
        color: #754d45;
        border-left: 3px solid #a35e51;
    }


    /* GRID */

    .appointments-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }


    /* CARD */

    .appointment-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }

    .appointment-card:nth-child(4n + 2),
    .appointment-card:nth-child(4n + 3) {
        background: #e8ddd5;
    }

    .appointment-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 25px 26px 18px;
    }


    /* DATE */

    .appointment-date {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .appointment-date > span {
        font-size: 2.25rem;
        font-weight: 300;
        line-height: 1;
        letter-spacing: -0.05em;
    }

    .appointment-date div {
        display: flex;
        flex-direction: column;
    }

    .appointment-date strong {
        font-size: 0.61rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .appointment-date small {
        margin-top: 2px;
        font-size: 0.58rem;
        color: #918780;
    }


    /* STATUS */

    .appointment-status,
    .payment-status {
        display: inline-block;
        padding: 6px 8px;
        font-size: 0.49rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .appointment-status-confirmed {
        background: #d7e2d6;
        color: #536652;
    }

    .appointment-status-completed {
        background: #211d1a;
        color: #fff;
    }

    .appointment-status-cancelled {
        background: #ead4cf;
        color: #8a4d43;
    }

    .appointment-status-pending {
        background: #e8dfca;
        color: #7a673d;
    }


    /* MAIN */

    .appointment-main {
        padding: 10px 26px 24px;
    }

    .appointment-label {
        display: block;
        margin-bottom: 5px;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.16em;
        color: #9d7b70;
    }

    .appointment-main h2 {
        margin: 0;
        font-size: clamp(1.6rem, 3vw, 2.35rem);
        font-weight: 300;
        line-height: 1.05;
        letter-spacing: -0.035em;
    }


    /* DETAILS */

    .appointment-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid rgba(33, 29, 26, 0.1);
        border-bottom: 1px solid rgba(33, 29, 26, 0.1);
    }

    .appointment-details > div {
        padding: 16px 18px;
        border-right: 1px solid rgba(33, 29, 26, 0.1);
    }

    .appointment-details > div:last-child {
        border-right: 0;
    }

    .appointment-details span {
        display: block;
        margin-bottom: 4px;
        font-size: 0.49rem;
        letter-spacing: 0.14em;
        color: #988d85;
    }

    .appointment-details strong {
        font-size: 0.7rem;
        font-weight: 500;
    }


    /* PAYMENT */

    .appointment-payment {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 26px;
    }

    .appointment-payment strong {
        font-size: 0.85rem;
        font-weight: 500;
    }

    .payment-status-paid {
        background: #d7e2d6;
        color: #526550;
    }

    .payment-status-failed {
        background: #ead4cf;
        color: #8a4d43;
    }

    .payment-status-refunded {
        background: #ddd8d5;
        color: #69615c;
    }

    .payment-status-pending {
        background: #e8dfca;
        color: #786437;
    }


    /* PAY ACTION */

    .appointment-payment-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin: 0 20px 20px;
        padding: 17px 18px;
        background: #211d1a;
        color: #fff;
    }

    .appointment-payment-action > div > span {
        display: block;
        margin-bottom: 3px;
        font-size: 0.5rem;
        letter-spacing: 0.16em;
        color: #cba99e;
    }

    .appointment-payment-action p {
        margin: 0;
        font-size: 0.64rem;
        line-height: 1.45;
        color: #beb6b0;
    }

    .appointment-pay-button {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 11px 13px;
        background: #f3ebe5;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.57rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .appointment-pay-button:hover {
        background: #d7b6aa;
        color: #211d1a;
    }


    /* CANCEL */

    .appointment-cancel-area {
        margin-top: auto;
        padding: 0 26px 22px;
    }

    .appointment-cancel-button {
        padding: 0;
        border: 0;
        border-bottom: 1px solid #9b5148;
        background: transparent;
        color: #9b5148;
        font-family: inherit;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.13em;
        cursor: pointer;
    }

    .appointment-cancel-button:hover {
        color: #6f382f;
        border-color: #6f382f;
    }


    /* EMPTY */

    .appointments-empty {
        padding: 75px 35px;
        text-align: center;
        background: #211d1a;
        color: #fff;
    }

    .appointments-empty > span {
        display: block;
        margin-bottom: 11px;
        font-size: 0.57rem;
        letter-spacing: 0.2em;
        color: #c8a79b;
    }

    .appointments-empty h2 {
        max-width: 600px;
        margin: 0 auto 12px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.04em;
    }

    .appointments-empty p {
        margin: 0 0 25px;
        font-size: 0.75rem;
        color: #bdb5b0;
    }

    .appointments-empty-button {
        display: inline-flex;
        align-items: center;
        gap: 20px;
        padding: 12px 15px;
        background: #f3ebe5;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.59rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .appointments-empty-button:hover {
        background: #d6b5aa;
        color: #211d1a;
    }


    /* RESPONSIVE */

    @media (max-width: 820px) {

        .appointments-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 575px) {

        .appointments-space {
            padding: 24px 0 35px;
        }

        .appointments-shell {
            width: calc(100% - 24px);
        }

        .appointments-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .appointment-details {
            grid-template-columns: 1fr;
        }

        .appointment-details > div {
            border-right: 0;
            border-bottom:
                1px solid rgba(33, 29, 26, 0.1);
        }

        .appointment-details > div:last-child {
            border-bottom: 0;
        }

        .appointment-payment-action {
            align-items: stretch;
            flex-direction: column;
        }

        .appointment-pay-button {
            justify-content: space-between;
        }

    }

</style>
@endpush