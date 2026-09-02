@extends('layouts.app')

@section('body-class', 'employee-appointment-page')

@section('content')

<section class="employee-appointment-space">

    <div class="employee-appointment-shell">

        <div class="appointment-back-row">
            <a
                href="{{ route('employee.schedule.index') }}"
                class="appointment-back"
            >
                ← BACK TO SCHEDULE
            </a>
        </div>


        <div class="appointment-header">

            <div>
                <span class="appointment-eyebrow">
                    EMPLOYEE WORKSPACE
                </span>

                <h1>
                    Appointment details
                </h1>

                <p>
                    View appointment information and current status.
                </p>
            </div>

            @php
                $statusClass = match ($reservation->status) {
                    'confirmed' => 'confirmed',
                    'completed' => 'completed',
                    'cancelled' => 'cancelled',
                    'pending' => 'pending',
                    default => 'default',
                };
            @endphp

            <span class="appointment-status {{ $statusClass }}">
                {{ strtoupper($reservation->status) }}
            </span>

        </div>


        @if (session('success'))

            <div class="appointment-message success">
                {{ session('success') }}
            </div>

        @endif


        @if ($errors->has('reservation'))

            <div class="appointment-message error">
                {{ $errors->first('reservation') }}
            </div>

        @endif


        <div class="appointment-grid">

            <section class="appointment-main-card">

                <div class="appointment-card-heading">

                    <div>
                        <span>
                            APPOINTMENT
                        </span>

                        <h2>
                            {{ $reservation->service_name }}
                        </h2>
                    </div>

                    <div class="appointment-date-box">

                        <strong>
                            {{ $reservation->appointment_date->format('d') }}
                        </strong>

                        <span>
                            {{ strtoupper(
                                $reservation->appointment_date->format('M')
                            ) }}
                        </span>

                    </div>

                </div>


                <div class="appointment-details-grid">

                    <div class="appointment-detail">
                        <span>DATE</span>

                        <strong>
                            {{ $reservation->appointment_date->format('d.m.Y') }}
                        </strong>
                    </div>

                    <div class="appointment-detail">
                        <span>TIME</span>

                        <strong>
                            {{ substr($reservation->start_time, 0, 5) }}
                            –
                            {{ substr($reservation->end_time, 0, 5) }}
                        </strong>
                    </div>

                    <div class="appointment-detail">
                        <span>CLIENT</span>

                        <strong>
                            @if ($reservation->client)
                                {{ $reservation->client->name }}
                                {{ $reservation->client->surname }}
                            @else
                                -
                            @endif
                        </strong>
                    </div>

                    <div class="appointment-detail">
                        <span>SERVICE</span>

                        <strong>
                            {{ $reservation->service_name }}
                        </strong>
                    </div>

                    <div class="appointment-detail">
                        <span>DURATION</span>

                        <strong>
                            {{ $reservation->duration_minutes }}
                            minutes
                        </strong>
                    </div>

                    <div class="appointment-detail">
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


                <div class="appointment-payment-row">

                    <div>
                        <span>
                            PAYMENT STATUS
                        </span>

                        <strong>
                            {{ ucfirst($reservation->payment_status) }}
                        </strong>
                    </div>

                    <div>
                        <span>
                            APPOINTMENT STATUS
                        </span>

                        <strong>
                            {{ ucfirst($reservation->status) }}
                        </strong>
                    </div>

                </div>


                @if ($reservation->notes)

                    <div class="appointment-note">

                        <span>
                            CLIENT NOTE
                        </span>

                        <p>
                            {{ $reservation->notes }}
                        </p>

                    </div>

                @endif


                @if ($reservation->completed_at)

                    <div class="appointment-completed-info">

                        <span>
                            COMPLETED AT
                        </span>

                        <strong>
                            {{ $reservation->completed_at->format('d.m.Y H:i') }}
                        </strong>

                    </div>

                @endif


                @if ($reservation->employee_note)

                    <div class="appointment-note employee">

                        <span>
                            EMPLOYEE NOTE
                        </span>

                        <p>
                            {{ $reservation->employee_note }}
                        </p>

                    </div>

                @endif

            </section>


            <aside class="appointment-action-card">

                @if ($reservation->status === 'confirmed')

                    <span class="action-eyebrow">
                        COMPLETE SERVICE
                    </span>

                    <h2>
                        Finish this appointment.
                    </h2>

                    <p>
                        Mark the service as completed and optionally
                        leave a short internal note.
                    </p>


                    <form
                        method="POST"
                        action="{{ route(
                            'employee.schedule.complete',
                            $reservation
                        ) }}"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="appointment-form-group">

                            <label for="employee_note">
                                EMPLOYEE NOTE
                            </label>

                            <textarea
                                id="employee_note"
                                name="employee_note"
                                rows="5"
                                class="@error('employee_note') is-invalid @enderror"
                                placeholder="Optional note about the completed service"
                            >{{ old('employee_note') }}</textarea>

                            @error('employee_note')
                                <div class="appointment-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="appointment-complete-button"
                        >
                            MARK AS COMPLETED
                            <span>→</span>
                        </button>

                    </form>


                @elseif ($reservation->status === 'completed')

                    <div class="appointment-state completed">

                        <span>
                            COMPLETED
                        </span>

                        <h2>
                            Service completed.
                        </h2>

                        <p>
                            This appointment has already been
                            marked as completed.
                        </p>

                    </div>


                @elseif ($reservation->status === 'cancelled')

                    <div class="appointment-state cancelled">

                        <span>
                            CANCELLED
                        </span>

                        <h2>
                            Appointment cancelled.
                        </h2>

                        <p>
                            This appointment cannot be completed.
                        </p>

                    </div>


                @elseif ($reservation->status === 'pending')

                    <div class="appointment-state pending">

                        <span>
                            PENDING
                        </span>

                        <h2>
                            Waiting for confirmation.
                        </h2>

                        <p>
                            This appointment must be confirmed
                            before it can be completed.
                        </p>

                    </div>

                @endif

            </aside>

        </div>

    </div>

</section>

@endsection


@push('styles')
<style>

    .employee-appointment-page {
        background: #f3efea;
    }

    .employee-appointment-space {
        min-height: calc(100vh - 62px);
        padding: 28px 0 40px;
        background:
            radial-gradient(
                circle at 92% 8%,
                rgba(190, 151, 140, 0.12),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .employee-appointment-shell {
        width: min(1120px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* BACK */

    .appointment-back-row {
        margin-bottom: 18px;
    }

    .appointment-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.5rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .appointment-back:hover {
        color: #9d7063;
    }


    /* HEADER */

    .appointment-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 20px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .appointment-eyebrow {
        display: block;
        margin-bottom: 6px;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        color: #a27a6d;
    }

    .appointment-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3.1rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .appointment-header p {
        margin: 0;
        font-size: 0.72rem;
        color: #7c736d;
    }


    /* STATUS */

    .appointment-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 92px;
        padding: 8px 11px;
        font-size: 0.46rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .appointment-status.confirmed {
        background: #dfe7dc;
        color: #52684f;
    }

    .appointment-status.completed {
        background: #211d1a;
        color: #fff;
    }

    .appointment-status.cancelled {
        background: #ead8d4;
        color: #8d554b;
    }

    .appointment-status.pending {
        background: #eee2c9;
        color: #876e3f;
    }

    .appointment-status.default {
        background: #e3dfdb;
        color: #6d655f;
    }


    /* MESSAGES */

    .appointment-message {
        margin-bottom: 16px;
        padding: 13px 15px;
        font-size: 0.68rem;
        border-left: 3px solid;
    }

    .appointment-message.success {
        background: #e2e9df;
        border-color: #799273;
        color: #52644e;
    }

    .appointment-message.error {
        background: #ead8d4;
        border-color: #a7665b;
        color: #804f47;
    }


    /* GRID */

    .appointment-grid {
        display: grid;
        grid-template-columns: 1.35fr 0.65fr;
        gap: 16px;
        align-items: start;
    }


    /* MAIN */

    .appointment-main-card {
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
        padding: 28px;
    }

    .appointment-card-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.1);
    }

    .appointment-card-heading > div:first-child > span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.5rem;
        letter-spacing: 0.15em;
        color: #a27a6d;
    }

    .appointment-card-heading h2 {
        margin: 0;
        font-size: 1.45rem;
        font-weight: 300;
    }


    /* DATE BOX */

    .appointment-date-box {
        width: 55px;
        height: 62px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #dec7bd;
    }

    .appointment-date-box strong {
        font-size: 1.35rem;
        font-weight: 400;
        line-height: 1;
    }

    .appointment-date-box span {
        margin-top: 4px;
        font-size: 0.45rem;
        letter-spacing: 0.12em;
    }


    /* DETAILS */

    .appointment-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        margin-top: 4px;
    }

    .appointment-detail {
        padding: 17px 0;
        border-bottom: 1px solid rgba(33, 29, 26, 0.09);
    }

    .appointment-detail:nth-child(odd) {
        padding-right: 24px;
        border-right: 1px solid rgba(33, 29, 26, 0.09);
    }

    .appointment-detail:nth-child(even) {
        padding-left: 24px;
    }

    .appointment-detail span,
    .appointment-payment-row span,
    .appointment-note span,
    .appointment-completed-info span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.47rem;
        letter-spacing: 0.14em;
        color: #9c8177;
    }

    .appointment-detail strong {
        font-size: 0.7rem;
        font-weight: 500;
    }


    /* PAYMENT */

    .appointment-payment-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 20px;
    }

    .appointment-payment-row > div {
        padding: 14px 16px;
        background: #f0e6e0;
    }

    .appointment-payment-row strong {
        font-size: 0.68rem;
        font-weight: 500;
    }


    /* NOTES */

    .appointment-note {
        margin-top: 18px;
        padding: 17px;
        background: #eee4de;
    }

    .appointment-note.employee {
        background: #211d1a;
        color: #fff;
    }

    .appointment-note.employee span {
        color: #c4a59b;
    }

    .appointment-note p {
        margin: 0;
        font-size: 0.68rem;
        line-height: 1.6;
    }

    .appointment-completed-info {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid rgba(33, 29, 26, 0.1);
    }

    .appointment-completed-info strong {
        font-size: 0.68rem;
        font-weight: 500;
    }


    /* ACTION CARD */

    .appointment-action-card {
        padding: 27px;
        background: #211d1a;
        color: #fff;
    }

    .action-eyebrow {
        display: block;
        margin-bottom: 7px;
        font-size: 0.5rem;
        letter-spacing: 0.16em;
        color: #c6a79d;
    }

    .appointment-action-card h2 {
        margin: 0 0 7px;
        font-size: 1.45rem;
        font-weight: 300;
        line-height: 1.15;
    }

    .appointment-action-card > p {
        margin: 0 0 23px;
        font-size: 0.65rem;
        line-height: 1.55;
        color: #bdb4ae;
    }


    /* FORM */

    .appointment-form-group {
        margin-bottom: 16px;
    }

    .appointment-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 0.47rem;
        letter-spacing: 0.14em;
        color: #bca49b;
    }

    .appointment-form-group textarea {
        width: 100%;
        resize: vertical;
        padding: 12px;
        border: 1px solid rgba(255,255,255,0.14);
        background: rgba(255,255,255,0.06);
        color: #fff;
        font-family: inherit;
        font-size: 0.67rem;
        outline: none;
    }

    .appointment-form-group textarea::placeholder {
        color: #918985;
    }

    .appointment-form-group textarea:focus {
        border-color: #c8a69b;
    }

    .appointment-form-group textarea.is-invalid {
        border-color: #c2776b;
    }

    .appointment-field-error {
        margin-top: 6px;
        color: #d8a89f;
        font-size: 0.58rem;
    }


    /* BUTTON */

    .appointment-complete-button {
        width: 100%;
        min-height: 45px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 0 15px;
        border: 0;
        background: #d7b7ac;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.52rem;
        font-weight: 500;
        letter-spacing: 0.13em;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .appointment-complete-button:hover {
        background: #ead7d0;
    }


    /* FINAL STATES */

    .appointment-state > span {
        display: block;
        margin-bottom: 8px;
        font-size: 0.5rem;
        letter-spacing: 0.16em;
        color: #c7a89e;
    }

    .appointment-state h2 {
        margin-bottom: 8px;
    }

    .appointment-state p {
        margin: 0;
        font-size: 0.66rem;
        line-height: 1.55;
        color: #bbb2ac;
    }

    .appointment-state.completed {
        border-top: 3px solid #789073;
        padding-top: 18px;
    }

    .appointment-state.cancelled {
        border-top: 3px solid #aa655a;
        padding-top: 18px;
    }

    .appointment-state.pending {
        border-top: 3px solid #b99a5f;
        padding-top: 18px;
    }


    /* RESPONSIVE */

    @media (max-width: 850px) {

        .appointment-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 575px) {

        .employee-appointment-space {
            padding: 22px 0 32px;
        }

        .employee-appointment-shell {
            width: calc(100% - 24px);
        }

        .appointment-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .appointment-main-card,
        .appointment-action-card {
            padding: 22px;
        }

        .appointment-details-grid {
            grid-template-columns: 1fr;
        }

        .appointment-detail:nth-child(odd),
        .appointment-detail:nth-child(even) {
            padding-left: 0;
            padding-right: 0;
            border-right: 0;
        }

        .appointment-payment-row {
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush