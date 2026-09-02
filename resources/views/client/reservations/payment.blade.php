@extends('layouts.app')

@section('body-class', 'client-payment-page')

@section('content')

<section class="payment-space">

    <div class="payment-shell">

        <div class="payment-top">

            <div>
                <span class="payment-eyebrow">
                    YOUR PAYMENT
                </span>

                <h1>
                    Pay advance
                </h1>

                <p>
                    {{ $reservation->service_name }}
                    ·
                    {{ $reservation->appointment_date->format('d.m.Y') }}
                    ·
                    {{ substr($reservation->start_time, 0, 5) }}
                </p>
            </div>

            <a
                href="{{ route('client.reservations.index') }}"
                class="payment-back"
            >
                ← BACK TO APPOINTMENTS
            </a>

        </div>


        <div class="payment-card">

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


                <div class="payment-summary-divider"></div>


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


            @if ($errors->any())

                <div class="payment-error">
                    {{ $errors->first() }}
                </div>

            @endif


            <div class="payment-info">

                <span class="payment-info-label">
                    SECURE PAYMENT
                </span>

                <p>
                    You will be redirected to Stripe to securely
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
                    PAY
                    {{ number_format(
                        (float) $reservation->advance_amount,
                        2
                    ) }}
                    KM

                    <span>→</span>
                </button>

            </form>

        </div>

    </div>

</section>

@endsection


@push('styles')
<style>

    .client-payment-page {
        background: #f3efea;
    }

    .payment-space {
        min-height: calc(100vh - 62px);
        padding: 36px 0 50px;
        background:
            radial-gradient(
                circle at 88% 8%,
                rgba(194, 155, 144, 0.14),
                transparent 22%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .payment-shell {
        width: min(900px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* TOP */

    .payment-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .payment-eyebrow {
        display: block;
        margin-bottom: 6px;
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.21em;
        color: #a27a6d;
    }

    .payment-top h1 {
        margin: 0 0 6px;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 300;
        letter-spacing: -0.04em;
    }

    .payment-top p {
        margin: 0;
        font-size: 0.77rem;
        color: #7d746e;
    }

    .payment-back {
        padding-bottom: 4px;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.57rem;
        font-weight: 500;
        letter-spacing: 0.14em;
    }

    .payment-back:hover {
        color: #9f7468;
    }


    /* CARD */

    .payment-card {
        padding: 34px;
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }


    /* SUMMARY */

    .payment-summary {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: stretch;
        gap: 28px;
        margin-bottom: 28px;
    }

    .payment-summary-item {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 120px;
    }

    .payment-summary-item span {
        display: block;
        margin-bottom: 8px;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.17em;
        color: #9c7d72;
    }

    .payment-summary-item strong {
        font-size: 1.65rem;
        font-weight: 300;
        letter-spacing: -0.03em;
    }

    .payment-summary-main {
        padding: 24px;
        background: #dfc7bd;
    }

    .payment-summary-main strong {
        font-size: 2.3rem;
    }

    .payment-summary-divider {
        width: 1px;
        background: rgba(33, 29, 26, 0.12);
    }


    /* INFO */

    .payment-info {
        margin-bottom: 24px;
        padding-top: 22px;
        border-top: 1px solid rgba(33, 29, 26, 0.1);
    }

    .payment-info-label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.16em;
        color: #a27a6d;
    }

    .payment-info p {
        max-width: 560px;
        margin: 0;
        font-size: 0.72rem;
        line-height: 1.6;
        color: #766d67;
    }


    /* ERROR */

    .payment-error {
        margin-bottom: 20px;
        padding: 13px 15px;
        background: #efdcd6;
        border-left: 3px solid #a65d50;
        color: #754c45;
        font-size: 0.7rem;
    }


    /* BUTTON */

    .payment-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 15px 18px;
        border: 0;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .payment-button:hover {
        background: #9d7063;
    }


    /* RESPONSIVE */

    @media (max-width: 650px) {

        .payment-space {
            padding: 24px 0 35px;
        }

        .payment-shell {
            width: calc(100% - 24px);
        }

        .payment-top {
            align-items: flex-start;
            flex-direction: column;
            gap: 16px;
        }

        .payment-card {
            padding: 24px;
        }

        .payment-summary {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .payment-summary-divider {
            display: none;
        }

        .payment-summary-item {
            min-height: auto;
        }

        .payment-summary-main {
            padding: 20px;
        }

    }

</style>
@endpush