@extends('layouts.app')

@section('body-class', 'client-booking-page')

@section('main-class', '')

@section('content')

<section class="booking-space">

    <div class="booking-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="booking-top">

            <h1>
                Plan your next visit.
            </h1>

            <a
                href="{{ route('client.services.index') }}"
                class="booking-back"
            >
                <span>←</span>
                <span>BACK TO SERVICES</span>
            </a>

        </header>


        {{-- =====================================================
             MAIN LAYOUT
        ====================================================== --}}
        <div class="booking-layout">


            {{-- =================================================
                 LEFT — SELECTED SERVICE
            ================================================== --}}
            <aside class="booking-summary">

                <div>

                    <span class="booking-summary-eyebrow">
                        SELECTED SERVICE
                    </span>

                    <h2>
                        {{ $service->name }}
                    </h2>


                    @if ($service->description)

                        <p class="booking-summary-description">
                            {{ $service->description }}
                        </p>

                    @else

                        <p class="booking-summary-description">
                            Your selected BeautyBook treatment.
                        </p>

                    @endif


                    <div class="booking-summary-details">

                        <div>
                            <span>DURATION</span>

                            <strong>
                                {{ $service->duration_minutes }} min
                            </strong>
                        </div>


                        <div>
                            <span>PRICE</span>

                            <strong>
                                {{ number_format(
                                    (float) $service->price,
                                    2
                                ) }} KM
                            </strong>
                        </div>


                        <div>
                            <span>ADVANCE</span>

                            <strong>
                                {{ number_format(
                                    (float) $service->price * 0.30,
                                    2
                                ) }} KM
                            </strong>
                        </div>

                    </div>

                </div>


                <div class="booking-summary-note">

                    <span>
                        GOOD TO KNOW
                    </span>

                    <p>
                        Select a date and BeautyBook will show
                        only genuinely available appointment times.
                    </p>

                </div>

            </aside>


            {{-- =================================================
                 RIGHT — FORM
            ================================================== --}}
            <div class="booking-form-panel">


                @if ($errors->any())

                    <div class="booking-error-box">

                        <strong>
                            Please check your booking details.
                        </strong>

                        <p>
                            Some information needs your attention
                            before the appointment can be created.
                        </p>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route(
                        'client.reservations.store',
                        $service
                    ) }}"
                    novalidate
                >

                    @csrf


                    {{-- =========================================
                         01 — DATE
                    ========================================== --}}
                    <div class="booking-section booking-section-date">

                        <div class="booking-section-number">
                            01
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">

                                <span>WHEN</span>

                                <h2>
                                    Choose your date
                                </h2>

                            </div>


                            <div class="booking-field">

                                <label for="appointment_date">
                                    APPOINTMENT DATE
                                </label>

                                <input
                                    type="date"
                                    id="appointment_date"
                                    name="appointment_date"
                                    min="{{ now()->toDateString() }}"
                                    value="{{ old('appointment_date') }}"
                                    class="@error('appointment_date') is-invalid @enderror"
                                >


                                @error('appointment_date')

                                    <div class="booking-field-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                         02 — SPECIALIST
                    ========================================== --}}
                    <div class="booking-section booking-section-specialist">

                        <div class="booking-section-number">
                            02
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">

                                <span>WHO</span>

                                <h2>
                                    Choose your specialist
                                </h2>

                            </div>


                            <div class="booking-field">

                                <label for="employee_id">
                                    SPECIALIST
                                </label>


                                <select
                                    id="employee_id"
                                    name="employee_id"
                                    class="@error('employee_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        Any available employee
                                    </option>


                                    @foreach ($employees as $employee)

                                        <option
                                            value="{{ $employee->id }}"
                                            @selected(
                                                old('employee_id')
                                                == $employee->id
                                            )
                                        >
                                            {{ $employee->name }}
                                            {{ $employee->surname }}
                                        </option>

                                    @endforeach

                                </select>


                                @if ($employees->isEmpty())

                                    <div class="booking-help booking-help-error">
                                        There are currently no active
                                        employees available for this service.
                                    </div>

                                @else

                                    <div class="booking-help">
                                        No preference? Leave
                                        “Any available employee” selected
                                        and we will find someone free.
                                    </div>

                                @endif


                                @error('employee_id')

                                    <div class="booking-field-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                         03 — TIME
                    ========================================== --}}
                    <div class="booking-section booking-section-time">

                        <div class="booking-section-number">
                            03
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">

                                <span>TIME</span>

                                <h2>
                                    Pick an available time
                                </h2>

                            </div>


                            <div class="booking-slots">

                                <div
                                    id="slots-loading"
                                    class="booking-slots-message d-none"
                                >
                                    Loading available times...
                                </div>


                                <div
                                    id="slots-message"
                                    class="booking-slots-message"
                                >
                                    Select a date to see available times.
                                </div>


                                <div
                                    id="slots-container"
                                    class="booking-slots-grid"
                                ></div>


                                <input
                                    type="hidden"
                                    id="start_time"
                                    name="start_time"
                                    value="{{ old('start_time') }}"
                                >


                                @error('start_time')

                                    <div class="booking-field-error mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div
                                id="selected-employee"
                                class="booking-selected-employee d-none"
                            >

                                <span>
                                    YOUR SPECIALIST
                                </span>

                                <strong
                                    id="selected-employee-name"
                                ></strong>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                         04 — NOTES
                    ========================================== --}}
                    <div class="booking-section booking-section-notes">

                        <div class="booking-section-number">
                            04
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">

                                <span>OPTIONAL</span>

                                <h2>
                                    Anything we should know?
                                </h2>

                            </div>


                            <div class="booking-field">

                                <label for="notes">
                                    NOTES
                                </label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="3"
                                    class="@error('notes') is-invalid @enderror"
                                    placeholder="Add a note for your appointment..."
                                >{{ old('notes') }}</textarea>


                                @error('notes')

                                    <div class="booking-field-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                         SUBMIT
                    ========================================== --}}
                    <div class="booking-submit-area">

                        <div class="booking-submit-copy">

                            <span>
                                NEXT STEP
                            </span>

                            <p>
                                Review your choices and continue
                                with your appointment.
                            </p>

                        </div>


                        <button
                            type="submit"
                            id="booking-button"
                            class="booking-submit"
                        >
                            <span>
                                CONTINUE WITH BOOKING
                            </span>

                            <span>
                                →
                            </span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — CLIENT BOOKING
========================================================= */

.client-booking-page {
    --booking-bg: #efebe6;
    --booking-dark: #292724;
    --booking-muted: #89837d;
    --booking-line: rgba(46, 42, 38, 0.15);

    width: 100%;
    height: 100svh;

    margin: 0;

    overflow: hidden;

    background: var(--booking-bg);

    font-family: 'Montserrat', sans-serif;
}


/* =========================================================
   APP
========================================================= */

.client-booking-page #app {
    display: flex;

    width: 100%;
    height: 100svh;

    flex-direction: column;

    overflow: hidden;

    background: var(--booking-bg);
}


/* =========================================================
   NAVBAR
========================================================= */

.client-booking-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background: var(--booking-bg) !important;

    border: 0 !important;

    box-shadow: none !important;
}


.client-booking-page .navbar .container,
.client-booking-page .navbar .container-fluid {
    min-height: 66px;
}


.client-booking-page .navbar-brand {
    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.client-booking-page .navbar .nav-link {
    color: rgba(48,45,42,0.67) !important;

    font-size: 0.82rem;
    font-weight: 300;

    transition: color 0.25s ease;
}


.client-booking-page .navbar .nav-link:hover,
.client-booking-page .navbar .nav-link.active {
    color: var(--booking-dark) !important;
}


/* =========================================================
   MAIN
========================================================= */

.client-booking-page main {
    flex: 1;

    min-height: 0;

    width: 100%;

    margin: 0 !important;
    padding: 0 !important;

    overflow: hidden;

    background: var(--booking-bg);
}


/* =========================================================
   PAGE
========================================================= */

.booking-space {
    position: relative;

    width: 100%;
    height: 100%;

    box-sizing: border-box;

    padding:
        15px
        0
        18px;

    overflow: hidden;

    background: var(--booking-bg);

    color: var(--booking-dark);
}


.booking-space::before {
    content: "";

    position: absolute;

    top: -100px;
    left: -190px;

    width: 690px;
    height: 690px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(255,255,255,0.44),
            transparent 68%
        );

    pointer-events: none;
}


/* =========================================================
   SHELL
========================================================= */

.booking-shell {
    position: relative;

    z-index: 2;

    display: flex;

    width:
        min(1380px, calc(100% - 80px));

    height: 100%;

    min-height: 0;

    margin: 0 auto;

    flex-direction: column;
}


/* =========================================================
   HEADER — CLEAN VERSION
========================================================= */

.booking-top {
    flex: 0 0 auto;

    display: flex;

    align-items: flex-end;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 18px;

    padding:
        7px
        0
        18px;

    border-bottom:
        1px solid var(--booking-line);
}


/* TITLE */

.booking-top h1 {
    margin: 0;

    color: var(--booking-dark);

    font-size:
        clamp(2.2rem, 2.8vw, 2.9rem);

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.055em;
}


/* BACK */

.booking-back {
    display: inline-flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 4px;

    color: #716b65;

    text-decoration: none;

    font-size: 0.56rem;
    font-weight: 500;

    letter-spacing: 0.22em;

    white-space: nowrap;

    transition:
        color 0.25s ease,
        transform 0.25s ease;
}


.booking-back:hover {
    color: var(--booking-dark);

    transform: translateX(-3px);
}


/* =========================================================
   MAIN LAYOUT
========================================================= */

.booking-layout {
    flex: 1;

    min-height: 0;

    display: grid;

    grid-template-columns:
        minmax(285px, 0.68fr)
        minmax(0, 1.65fr);

    gap: 15px;

    align-items: stretch;
}


/* =========================================================
   LEFT SUMMARY
========================================================= */

.booking-summary {
    display: flex;

    height: 100%;

    min-height: 0;

    box-sizing: border-box;

    flex-direction: column;
    justify-content: space-between;

    padding:
        27px
        27px;

    overflow: hidden;

    background:
        rgba(255,255,255,0.20);

    border:
        1px solid rgba(46,42,38,0.12);
}


.booking-summary-eyebrow {
    display: block;

    margin-bottom: 16px;

    color: #8f8982;

    font-size: 0.54rem;
    font-weight: 500;

    letter-spacing: 0.29em;
}


.booking-summary h2 {
    margin:
        0
        0
        13px;

    color: #302d2a;

    font-size:
        clamp(1.7rem, 2vw, 2.15rem);

    font-weight: 300;

    line-height: 1.03;

    letter-spacing: -0.045em;
}


.booking-summary-description {
    max-width: 350px;

    margin:
        0
        0
        23px;

    color: #88827c;

    font-size: 0.70rem;
    font-weight: 300;

    line-height: 1.6;
}


/* =========================================================
   SUMMARY DETAILS
========================================================= */

.booking-summary-details {
    border-top:
        1px solid var(--booking-line);
}


.booking-summary-details > div {
    display: flex;

    min-height: 49px;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    border-bottom:
        1px solid var(--booking-line);
}


.booking-summary-details span {
    color: #918b84;

    font-size: 0.52rem;
    font-weight: 500;

    letter-spacing: 0.22em;
}


.booking-summary-details strong {
    color: #37332f;

    font-size: 0.85rem;
    font-weight: 500;
}


/* =========================================================
   SUMMARY NOTE
========================================================= */

.booking-summary-note {
    margin-top: 18px;

    padding:
        16px
        17px;

    background:
        rgba(255,255,255,0.32);

    border-left:
        1px solid rgba(46,42,38,0.30);
}


.booking-summary-note span {
    display: block;

    margin-bottom: 6px;

    color: #716b65;

    font-size: 0.50rem;
    font-weight: 500;

    letter-spacing: 0.23em;
}


.booking-summary-note p {
    margin: 0;

    color: #89837d;

    font-size: 0.64rem;
    font-weight: 300;

    line-height: 1.5;
}


/* =========================================================
   FORM PANEL
========================================================= */

.booking-form-panel {
    position: relative;

    height: 100%;

    min-height: 0;

    overflow: hidden;

    background:
        rgba(255,255,255,0.14);

    border:
        1px solid rgba(46,42,38,0.12);
}


/* =========================================================
   FORM GRID
========================================================= */

.booking-form-panel form {
    display: grid;

    width: 100%;
    height: 100%;

    min-height: 0;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    grid-template-rows:
        minmax(0, 1fr)
        minmax(0, 1fr)
        auto;
}


/* =========================================================
   FORM SECTION
========================================================= */

.booking-section {
    display: grid;

    min-width: 0;
    min-height: 0;

    box-sizing: border-box;

    grid-template-columns:
        35px
        minmax(0, 1fr);

    padding:
        20px
        21px;

    overflow: hidden;

    border-bottom:
        1px solid var(--booking-line);
}


.booking-section-date,
.booking-section-time {
    border-right:
        1px solid var(--booking-line);
}


.booking-section-number {
    padding-top: 4px;

    color: #9d9690;

    font-size: 0.52rem;
    font-weight: 500;

    letter-spacing: 0.18em;
}


.booking-section-content {
    min-width: 0;
}


/* =========================================================
   SECTION HEADINGS
========================================================= */

.booking-section-heading {
    margin-bottom: 14px;
}


.booking-section-heading span {
    display: block;

    margin-bottom: 4px;

    color: #89837d;

    font-size: 0.50rem;
    font-weight: 500;

    letter-spacing: 0.24em;
}


.booking-section-heading h2 {
    margin: 0;

    color: #302d2a;

    font-size: 1.22rem;
    font-weight: 400;

    line-height: 1.15;

    letter-spacing: -0.025em;
}


/* =========================================================
   FIELDS
========================================================= */

.booking-field {
    width: 100%;
}


.booking-field label {
    display: block;

    margin-bottom: 7px;

    color: #716b65;

    font-size: 0.51rem;
    font-weight: 500;

    letter-spacing: 0.20em;
}


.booking-field input,
.booking-field select,
.booking-field textarea {
    width: 100%;

    box-sizing: border-box;

    border:
        1px solid rgba(46,42,38,0.18);

    border-radius: 0;

    outline: none;

    background:
        rgba(255,255,255,0.17);

    color: #302d2a;

    font-family: inherit;

    font-size: 0.83rem;
    font-weight: 300;

    transition:
        border-color 0.25s ease,
        background 0.25s ease;
}


.booking-field input,
.booking-field select {
    height: 43px;

    padding:
        0
        12px;
}


.booking-field textarea {
    height: 70px;
    min-height: 70px;

    padding:
        10px
        12px;

    resize: none;

    line-height: 1.45;
}


.booking-field input:focus,
.booking-field select:focus,
.booking-field textarea:focus {
    border-color:
        rgba(46,42,38,0.50);

    background:
        rgba(255,255,255,0.44);
}


.booking-field textarea::placeholder {
    color: #a49d96;
}


.booking-field .is-invalid {
    border-color:
        rgba(155,75,75,0.65);
}


/* =========================================================
   HELP
========================================================= */

.booking-help {
    margin-top: 7px;

    color: #918b84;

    font-size: 0.61rem;
    font-weight: 300;

    line-height: 1.4;
}


.booking-help-error,
.booking-field-error {
    color: #965454;
}


.booking-field-error {
    margin-top: 5px;

    font-size: 0.60rem;
}


/* =========================================================
   AVAILABLE TIMES
========================================================= */

.booking-slots-message {
    margin-bottom: 9px;

    color: #89837d;

    font-size: 0.64rem;
    font-weight: 300;
}


.booking-slots-grid {
    display: flex;

    flex-wrap: wrap;

    gap: 6px;

    max-height: 84px;

    overflow: hidden;
}


.booking-slot-button {
    min-width: 84px;
    height: 34px;

    padding:
        0
        10px;

    border:
        1px solid rgba(46,42,38,0.19);

    background: transparent;

    color: #403c38;

    font-family: inherit;

    font-size: 0.65rem;
    font-weight: 400;

    cursor: pointer;

    transition:
        background 0.25s ease,
        color 0.25s ease,
        border-color 0.25s ease,
        transform 0.25s ease;
}


.booking-slot-button:hover {
    border-color:
        rgba(46,42,38,0.45);

    background:
        rgba(255,255,255,0.42);

    transform: translateY(-1px);
}


.booking-slot-button.active {
    border-color: #302d2a;

    background: #302d2a;

    color: #fff;
}


/* =========================================================
   SELECTED EMPLOYEE
========================================================= */

.booking-selected-employee {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-top: 9px;

    padding:
        9px
        11px;

    box-sizing: border-box;

    background:
        rgba(255,255,255,0.30);

    border-left:
        1px solid rgba(46,42,38,0.30);
}


.booking-selected-employee span {
    color: #89837d;

    font-size: 0.49rem;
    font-weight: 500;

    letter-spacing: 0.21em;
}


.booking-selected-employee strong {
    color: #37332f;

    font-size: 0.74rem;
    font-weight: 500;
}


/* =========================================================
   ERROR BOX
========================================================= */

.booking-error-box {
    position: absolute;

    top: 10px;
    right: 10px;

    z-index: 20;

    width: 315px;

    box-sizing: border-box;

    padding:
        12px
        14px;

    background: #eee3df;

    border-left:
        2px solid #965454;

    box-shadow:
        0 5px 20px rgba(46,42,38,0.08);
}


.booking-error-box strong {
    display: block;

    color: #634747;

    font-size: 0.69rem;
    font-weight: 500;
}


.booking-error-box p {
    margin:
        4px
        0
        0;

    color: #876d6d;

    font-size: 0.60rem;
    font-weight: 300;
}


/* =========================================================
   SUBMIT
========================================================= */

.booking-submit-area {
    grid-column:
        1 / -1;

    display: flex;

    min-height: 68px;

    align-items: center;
    justify-content: space-between;

    gap: 30px;

    box-sizing: border-box;

    padding:
        11px
        20px;

    background:
        rgba(255,255,255,0.27);
}


.booking-submit-copy span {
    display: block;

    margin-bottom: 3px;

    color: #89837d;

    font-size: 0.50rem;
    font-weight: 500;

    letter-spacing: 0.23em;
}


.booking-submit-copy p {
    margin: 0;

    color: #918b84;

    font-size: 0.62rem;
    font-weight: 300;

    line-height: 1.4;
}


/* BUTTON */

.booking-submit {
    display: inline-flex;

    width: 250px;
    height: 45px;

    flex: 0 0 auto;

    align-items: center;
    justify-content: space-between;

    gap: 22px;

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
        color 0.3s ease,
        transform 0.3s ease;
}


.booking-submit:hover {
    background: transparent;

    color: #302d2a;

    transform: translateY(-1px);
}


.booking-submit span:last-child {
    font-size: 0.82rem;

    letter-spacing: 0;

    transition:
        transform 0.3s ease;
}


.booking-submit:hover span:last-child {
    transform: translateX(4px);
}


/* =========================================================
   ANIMATION
========================================================= */

.booking-top,
.booking-summary,
.booking-form-panel {
    animation:
        bookingEnter
        0.65s
        cubic-bezier(.2,.8,.2,1)
        both;
}


.booking-summary {
    animation-delay: 0.03s;
}


.booking-form-panel {
    animation-delay: 0.07s;
}


@keyframes bookingEnter {

    from {
        opacity: 0;
        transform: translateY(8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/* =========================================================
   SHORT DESKTOP
========================================================= */

@media (min-width: 951px) and (max-height: 800px) {

    .client-booking-page .navbar {
        flex-basis: 58px;
        min-height: 58px;
    }


    .client-booking-page .navbar .container,
    .client-booking-page .navbar .container-fluid {
        min-height: 58px;
    }


    .booking-space {
        padding:
            8px
            0
            10px;
    }


    .booking-top {
        margin-bottom: 12px;

        padding:
            5px
            0
            12px;
    }


    .booking-top h1 {
        font-size: 2rem;
    }


    .booking-back {
        margin-bottom: 3px;

        font-size: 0.52rem;
    }


    .booking-summary {
        padding:
            17px
            21px;
    }


    .booking-summary-eyebrow {
        margin-bottom: 9px;
    }


    .booking-summary h2 {
        margin-bottom: 8px;

        font-size: 1.55rem;
    }


    .booking-summary-description {
        margin-bottom: 12px;

        font-size: 0.63rem;
    }


    .booking-summary-details > div {
        min-height: 39px;
    }


    .booking-summary-note {
        margin-top: 10px;

        padding:
            10px
            12px;
    }


    .booking-summary-note p {
        font-size: 0.57rem;
    }


    .booking-section {
        padding:
            12px
            16px;

        grid-template-columns:
            31px
            minmax(0, 1fr);
    }


    .booking-section-heading {
        margin-bottom: 8px;
    }


    .booking-section-heading span {
        margin-bottom: 2px;
    }


    .booking-section-heading h2 {
        font-size: 1.07rem;
    }


    .booking-field label {
        margin-bottom: 5px;
    }


    .booking-field input,
    .booking-field select {
        height: 35px;
    }


    .booking-field textarea {
        height: 50px;
        min-height: 50px;
    }


    .booking-help {
        margin-top: 4px;

        font-size: 0.56rem;

        line-height: 1.3;
    }


    .booking-slots-message {
        margin-bottom: 5px;
    }


    .booking-slots-grid {
        max-height: 60px;

        gap: 5px;
    }


    .booking-slot-button {
        height: 28px;

        font-size: 0.59rem;
    }


    .booking-selected-employee {
        margin-top: 5px;

        padding:
            5px
            9px;
    }


    .booking-submit-area {
        min-height: 54px;

        padding:
            6px
            16px;
    }


    .booking-submit {
        height: 39px;
    }

}


/* =========================================================
   LARGE DESKTOP
========================================================= */

@media (min-width: 1500px) {

    .booking-shell {
        width:
            min(1450px, calc(100% - 120px));
    }


    .booking-layout {
        grid-template-columns:
            minmax(300px, 0.65fr)
            minmax(0, 1.7fr);
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 950px) {

    .client-booking-page {
        height: auto;

        min-height: 100svh;

        overflow-y: auto;
    }


    .client-booking-page #app {
        height: auto;

        min-height: 100svh;

        overflow: visible;
    }


    .client-booking-page main {
        overflow: visible;
    }


    .booking-space {
        height: auto;

        min-height:
            calc(100svh - 65px);

        overflow: visible;

        padding:
            25px
            0
            35px;
    }


    .booking-shell {
        width:
            calc(100% - 46px);

        height: auto;
    }


    .booking-top {
        margin-bottom: 22px;

        padding-bottom: 18px;
    }


    .booking-top h1 {
        font-size: 2.2rem;
    }


    .booking-layout {
        grid-template-columns: 1fr;
    }


    .booking-summary {
        height: auto;
    }


    .booking-form-panel {
        height: auto;

        overflow: visible;
    }


    .booking-form-panel form {
        height: auto;

        grid-template-columns: 1fr;

        grid-template-rows: auto;
    }


    .booking-section {
        min-height: auto;

        padding:
            23px
            24px;
    }


    .booking-section-date,
    .booking-section-time {
        border-right: 0;
    }


    .booking-slots-grid {
        max-height: none;

        overflow: visible;
    }


    .booking-submit-area {
        grid-column: auto;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .booking-shell {
        width:
            calc(100% - 28px);
    }


    .booking-top {
        align-items: flex-start;

        flex-direction: column;

        gap: 16px;
    }


    .booking-top h1 {
        font-size: 1.9rem;
    }


    .booking-back {
        margin: 0;
    }


    .booking-summary {
        padding:
            22px
            20px;
    }


    .booking-section {
        grid-template-columns: 1fr;

        gap: 7px;

        padding:
            21px
            19px;
    }


    .booking-section-number {
        padding-top: 0;
    }


    .booking-section-heading h2 {
        font-size: 1.15rem;
    }


    .booking-field input,
    .booking-field select,
    .booking-field textarea {
        font-size: 0.82rem;
    }


    .booking-submit-area {
        align-items: stretch;

        flex-direction: column;

        gap: 15px;

        padding:
            19px;
    }


    .booking-submit {
        width: 100%;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .booking-top,
    .booking-summary,
    .booking-form-panel {
        animation: none !important;
    }

}

</style>

@endpush



<script>

document.addEventListener('DOMContentLoaded', function () {

    const dateInput =
        document.getElementById('appointment_date');

    const employeeSelect =
        document.getElementById('employee_id');

    const startTimeInput =
        document.getElementById('start_time');

    const slotsContainer =
        document.getElementById('slots-container');

    const slotsMessage =
        document.getElementById('slots-message');

    const slotsLoading =
        document.getElementById('slots-loading');

    const selectedEmployee =
        document.getElementById('selected-employee');

    const selectedEmployeeName =
        document.getElementById('selected-employee-name');


    function clearSlots() {

        slotsContainer.innerHTML = '';

        startTimeInput.value = '';

        selectedEmployee.classList.add('d-none');

        selectedEmployeeName.textContent = '';

    }


    async function loadSlots() {

        clearSlots();


        const date =
            dateInput.value;

        const employeeId =
            employeeSelect.value;


        if (!date) {

            slotsMessage.textContent =
                'Select a date to see available times.';

            slotsMessage.classList.remove('d-none');

            return;

        }


        slotsMessage.classList.add('d-none');

        slotsLoading.classList.remove('d-none');


        try {

            const url =
                "{{ route(
                    'client.reservations.available-slots',
                    $service
                ) }}"
                + '?appointment_date='
                + encodeURIComponent(date)
                + '&employee_id='
                + encodeURIComponent(employeeId);


            const response =
                await fetch(url, {

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                });


            if (!response.ok) {

                throw new Error(
                    'Failed to load available slots.'
                );

            }


            const data =
                await response.json();


            if (
                !data.slots
                || data.slots.length === 0
            ) {

                slotsMessage.textContent =
                    'There are no available times for this date.';

                slotsMessage.classList.remove('d-none');

                return;

            }


            slotsMessage.textContent =
                'Choose an available time:';

            slotsMessage.classList.remove('d-none');


            data.slots.forEach(function (slot) {

                const button =
                    document.createElement('button');


                button.type =
                    'button';


                button.className =
                    'booking-slot-button';


                button.textContent =
                    slot.start_time
                    + ' – '
                    + slot.end_time;


                button.addEventListener(
                    'click',
                    function () {

                        document
                            .querySelectorAll(
                                '#slots-container button'
                            )
                            .forEach(function (btn) {

                                btn.classList.remove(
                                    'active'
                                );

                            });


                        button.classList.add(
                            'active'
                        );


                        startTimeInput.value =
                            slot.start_time;


                        selectedEmployee
                            .classList
                            .remove('d-none');


                        selectedEmployeeName.textContent =
                            slot.employee_name;

                    }
                );


                slotsContainer.appendChild(
                    button
                );

            });


        } catch (error) {

            console.error(error);


            slotsMessage.textContent =
                'Unable to load available times. Please try again.';


            slotsMessage.classList.remove(
                'd-none'
            );


        } finally {

            slotsLoading.classList.add(
                'd-none'
            );

        }

    }


    dateInput.addEventListener(
        'change',
        loadSlots
    );


    employeeSelect.addEventListener(
        'change',
        loadSlots
    );


    if (dateInput.value) {

        loadSlots();

    }

});

</script>