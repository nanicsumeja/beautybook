@extends('layouts.app')

@section('body-class', 'owner-appointment-form-page')
@section('main-class', 'owner-appointment-form-main')

@section('content')

<section class="owner-appointment-form-space">

    <div class="owner-appointment-form-shell">

        {{-- BACK --}}
        <div class="owner-form-back-row">

            <a
                href="{{ route('owner.reservations.index') }}"
                class="owner-form-back"
            >
                ← BACK TO APPOINTMENTS
            </a>

        </div>


        {{-- HEADER --}}
        <header class="owner-form-header">

            <div>

                <span class="owner-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Edit appointment
                </h1>

                <p>
                    Change the appointment details or assigned employee.
                </p>

            </div>


            <div class="owner-form-step">

                <span>
                    EDIT
                </span>

                <strong>
                    APPOINTMENT
                </strong>

            </div>

        </header>



        {{-- ERRORS --}}
        @if ($errors->any())

            <div class="owner-form-message error">

                <div class="owner-form-message-icon">
                    !
                </div>

                <div>

                    <strong>
                        The appointment could not be updated.
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif



        <form
            method="POST"
            action="{{ route(
                'owner.reservations.update',
                $reservation
            ) }}"
        >

            @csrf
            @method('PUT')


            <div class="owner-form-grid">


                {{-- =================================================
                     MAIN FORM
                ================================================== --}}
                <section class="owner-form-card">

                    <div class="owner-form-card-heading">

                        <span>
                            APPOINTMENT DETAILS
                        </span>

                        <h2>
                            Update booking information
                        </h2>

                    </div>



                    <div class="owner-form-fields">


                        {{-- CLIENT --}}
                        <div class="owner-form-group full">

                            <label for="client_id">
                                CLIENT
                            </label>

                            <select
                                id="client_id"
                                name="client_id"
                                class="@error('client_id') is-invalid @enderror"
                                required
                            >

                                @foreach ($clients as $client)

                                    <option
                                        value="{{ $client->id }}"
                                        @selected(
                                            old(
                                                'client_id',
                                                $reservation->client_id
                                            )
                                            == $client->id
                                        )
                                    >
                                        {{ $client->name }}
                                        {{ $client->surname }}
                                        — {{ $client->email }}
                                    </option>

                                @endforeach

                            </select>


                            @error('client_id')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- SERVICE --}}
                        <div class="owner-form-group full">

                            <label for="service_id">
                                SERVICE
                            </label>

                            <select
                                id="service_id"
                                name="service_id"
                                class="@error('service_id') is-invalid @enderror"
                                required
                            >

                                @foreach ($services as $service)

                                    <option
                                        value="{{ $service->id }}"
                                        @selected(
                                            old(
                                                'service_id',
                                                $reservation->service_id
                                            )
                                            == $service->id
                                        )
                                    >
                                        {{ $service->name }}
                                        —
                                        {{ $service->duration_minutes }}
                                        min —
                                        {{
                                            number_format(
                                                (float) $service->price,
                                                2
                                            )
                                        }}
                                        KM
                                    </option>

                                @endforeach

                            </select>


                            @error('service_id')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- EMPLOYEE --}}
                        <div class="owner-form-group full">

                            <label for="employee_id">
                                EMPLOYEE
                            </label>

                            <select
                                id="employee_id"
                                name="employee_id"
                                class="@error('employee_id') is-invalid @enderror"
                                required
                            >

                                @foreach ($employees as $employee)

                                    <option
                                        value="{{ $employee->id }}"
                                        data-services="{{
                                            $employee
                                                ->services
                                                ->pluck('id')
                                                ->implode(',')
                                        }}"
                                        @selected(
                                            old(
                                                'employee_id',
                                                $reservation->employee_id
                                            )
                                            == $employee->id
                                        )
                                    >
                                        {{ $employee->name }}
                                        {{ $employee->surname }}
                                    </option>

                                @endforeach

                            </select>


                            <small class="owner-form-help">
                                Employee must perform the selected service.
                            </small>


                            @error('employee_id')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- DATE --}}
                        <div class="owner-form-group">

                            <label for="appointment_date">
                                DATE
                            </label>

                            <input
                                type="date"
                                id="appointment_date"
                                name="appointment_date"
                                value="{{ old(
                                    'appointment_date',
                                    $reservation
                                        ->appointment_date
                                        ->format('Y-m-d')
                                ) }}"
                                min="{{ now()->toDateString() }}"
                                class="@error('appointment_date') is-invalid @enderror"
                                required
                            >


                            @error('appointment_date')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- TIME --}}
                        <div class="owner-form-group">

                            <label for="start_time">
                                START TIME
                            </label>

                            <input
                                type="time"
                                id="start_time"
                                name="start_time"
                                value="{{ old(
                                    'start_time',
                                    substr(
                                        $reservation->start_time,
                                        0,
                                        5
                                    )
                                ) }}"
                                step="900"
                                class="@error('start_time') is-invalid @enderror"
                                required
                            >


                            @error('start_time')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- NOTES --}}
                        <div class="owner-form-group full">

                            <label for="notes">
                                NOTES
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="4"
                                class="@error('notes') is-invalid @enderror"
                                placeholder="Optional appointment note"
                            >{{ old(
                                'notes',
                                $reservation->notes
                            ) }}</textarea>


                            @error('notes')

                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </section>



                {{-- =================================================
                     SIDE PANEL
                ================================================== --}}
                <aside class="owner-form-side">

                    <span class="owner-form-side-eyebrow">
                        EDIT BOOKING
                    </span>

                    <h2>
                        Update this appointment.
                    </h2>

                    <p>
                        Review the booking information before saving
                        any changes.
                    </p>



                    <div class="owner-form-side-info">

                        <div>

                            <span>
                                01
                            </span>

                            <p>
                                Review the selected client and service.
                            </p>

                        </div>


                        <div>

                            <span>
                                02
                            </span>

                            <p>
                                Change the employee if needed.
                            </p>

                        </div>


                        <div>

                            <span>
                                03
                            </span>

                            <p>
                                Adjust the date, time or notes.
                            </p>

                        </div>

                    </div>



                    {{-- CURRENT STATUS --}}
                    <div class="owner-form-side-note">

                        <span>
                            CURRENT STATUS
                        </span>


                        <div class="owner-form-current-status">

                            <strong
                                class="status-{{ $reservation->status }}"
                            >
                                {{ strtoupper($reservation->status) }}
                            </strong>

                            <small>
                                {{
                                    $reservation
                                        ->appointment_date
                                        ->format('d.m.Y')
                                }}
                                ·
                                {{
                                    substr(
                                        $reservation->start_time,
                                        0,
                                        5
                                    )
                                }}
                            </small>

                        </div>

                    </div>



                    <button
                        type="submit"
                        class="owner-form-submit"
                    >

                        <span>
                            SAVE CHANGES
                        </span>

                        <span>
                            →
                        </span>

                    </button>



                    <a
                        href="{{ route('owner.reservations.index') }}"
                        class="owner-form-cancel"
                    >
                        CANCEL
                    </a>

                </aside>

            </div>

        </form>

    </div>

</section>



<script>
document.addEventListener('DOMContentLoaded', () => {

    const serviceSelect =
        document.getElementById('service_id');

    const employeeSelect =
        document.getElementById('employee_id');


    if (!serviceSelect || !employeeSelect) {
        return;
    }


    const updateEmployees = () => {

        const serviceId =
            serviceSelect.value;


        Array.from(
            employeeSelect.options
        ).forEach((option) => {

            if (!option.value) {
                return;
            }


            const services = (
                option.dataset.services || ''
            )
                .split(',')
                .filter(Boolean);


            const allowed =
                services.includes(serviceId);


            option.hidden =
                !allowed;

            option.disabled =
                !allowed;


            if (
                !allowed
                && option.selected
            ) {
                employeeSelect.value = '';
            }

        });

    };


    serviceSelect.addEventListener(
        'change',
        updateEmployees
    );


    updateEmployees();

});
</script>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER EDIT APPOINTMENT
========================================================= */

.owner-appointment-form-page {
    min-height: 100svh;

    background: #f3efea;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-appointment-form-page #app {
    display: flex;

    width: 100%;

    min-height: 100svh;

    flex-direction: column;

    background: #f3efea;
}


.owner-appointment-form-main {
    background: #f3efea;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-appointment-form-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background:
        #efebe6 !important;

    border: 0 !important;

    box-shadow:
        none !important;
}


.owner-appointment-form-page .navbar .container,
.owner-appointment-form-page .navbar .container-fluid {
    min-height: 66px;
}


.owner-appointment-form-page .navbar-brand {
    color:
        #272522 !important;

    font-weight: 400;

    letter-spacing:
        -0.035em;
}


.owner-appointment-form-page .navbar .nav-link,
.owner-appointment-form-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-size:
        0.82rem;

    font-weight:
        300;
}


.owner-appointment-form-page .navbar .nav-link:hover,
.owner-appointment-form-page .navbar .nav-link.active,
.owner-appointment-form-page .navbar .dropdown-toggle:hover,
.owner-appointment-form-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}



/* =========================================================
   PAGE
========================================================= */

.owner-appointment-form-space {
    min-height:
        calc(100vh - 66px);

    padding:
        25px
        0
        40px;

    background:
        radial-gradient(
            circle at 92% 5%,
            rgba(190,151,140,0.12),
            transparent 24%
        ),
        #f3efea;

    color:
        #292724;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-appointment-form-shell {
    width:
        min(
            1050px,
            calc(100% - 48px)
        );

    margin:
        0 auto;
}



/* =========================================================
   BACK
========================================================= */

.owner-form-back-row {
    margin-bottom:
        14px;
}


.owner-form-back {
    color:
        #6d635d;

    text-decoration:
        none;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;

    transition:
        color 0.2s ease;
}


.owner-form-back:hover {
    color:
        #a87f73;
}



/* =========================================================
   HEADER
========================================================= */

.owner-form-header {
    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        25px;

    margin-bottom:
        17px;

    padding-bottom:
        17px;

    border-bottom:
        1px solid rgba(46,42,38,0.12);
}


.owner-form-eyebrow {
    display:
        block;

    margin-bottom:
        5px;

    color:
        #a0796d;

    font-size:
        0.61rem;

    font-weight:
        500;

    letter-spacing:
        0.19em;
}


.owner-form-header h1 {
    margin:
        0
        0
        5px;

    font-size:
        clamp(
            2rem,
            4vw,
            3rem
        );

    font-weight:
        300;

    letter-spacing:
        -0.045em;
}


.owner-form-header p {
    margin:
        0;

    color:
        #81766f;

    font-size:
        0.74rem;

    font-weight:
        300;
}


.owner-form-step {
    text-align:
        right;
}


.owner-form-step span {
    display:
        block;

    margin-bottom:
        3px;

    color:
        #a17e72;

    font-size:
        0.52rem;

    font-weight:
        500;

    letter-spacing:
        0.13em;
}


.owner-form-step strong {
    color:
        #534945;

    font-size:
        0.66rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;
}



/* =========================================================
   ERROR
========================================================= */

.owner-form-message {
    display:
        flex;

    gap:
        13px;

    margin-bottom:
        16px;

    padding:
        13px
        15px;

    border-left:
        3px solid;
}


.owner-form-message.error {
    background:
        #ead8d4;

    border-color:
        #a7655a;

    color:
        #754940;
}


.owner-form-message-icon {
    width:
        24px;

    height:
        24px;

    flex-shrink:
        0;

    display:
        grid;

    place-items:
        center;

    background:
        #a7655a;

    color:
        #fff;

    font-size:
        0.63rem;
}


.owner-form-message strong {
    display:
        block;

    font-size:
        0.68rem;

    font-weight:
        500;
}


.owner-form-message ul {
    margin:
        7px
        0
        0;

    padding-left:
        17px;

    font-size:
        0.61rem;

    line-height:
        1.6;
}



/* =========================================================
   GRID
========================================================= */

.owner-form-grid {
    display:
        grid;

    grid-template-columns:
        minmax(0,1.36fr)
        minmax(280px,0.64fr);

    gap: 0;

    align-items: stretch;

    background:
        #faf7f3;

    border:
        1px solid rgba(46,42,38,0.08);
}



/* =========================================================
   MAIN FORM
========================================================= */

.owner-form-card {
    min-width:
        0;

    background:
        #faf7f3;
}


.owner-form-card-heading {
    min-height:
        77px;

    display:
        flex;

    flex-direction:
        column;

    justify-content:
        center;

    padding:
        17px
        22px;

    border-bottom:
        1px solid rgba(46,42,38,0.09);
}


.owner-form-card-heading span {
    display:
        block;

    margin-bottom:
        4px;

    color:
        #9f776b;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.13em;
}


.owner-form-card-heading h2 {
    margin:
        0;

    font-size:
        1.14rem;

    font-weight:
        300;
}



/* =========================================================
   FIELDS
========================================================= */

.owner-form-fields {
    display:
        grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0,1fr)
        );

    gap:
        17px
        15px;

    padding:
        23px
        22px
        25px;
}


.owner-form-group {
    min-width:
        0;
}


.owner-form-group.full {
    grid-column:
        1 / -1;
}


.owner-form-group label {
    display:
        block;

    margin-bottom:
        7px;

    color:
        #625954;

    font-size:
        0.56rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;
}


.owner-form-group input,
.owner-form-group select,
.owner-form-group textarea {
    width:
        100%;

    border:
        1px solid rgba(46,42,38,0.14);

    border-radius:
        0;

    outline:
        none;

    background:
        #f7f2ee;

    color:
        #292724;

    font-family:
        inherit;

    font-size:
        0.68rem;

    box-shadow:
        none;

    transition:
        border-color 0.15s ease,
        background 0.15s ease,
        box-shadow 0.15s ease;
}


.owner-form-group input,
.owner-form-group select {
    height:
        43px;

    padding:
        0
        12px;
}


.owner-form-group textarea {
    min-height:
        94px;

    padding:
        11px
        12px;

    resize:
        vertical;

    line-height:
        1.5;
}


.owner-form-group input:focus,
.owner-form-group select:focus,
.owner-form-group textarea:focus {
    border-color:
        #aa8074;

    background:
        #fbf8f5;

    box-shadow:
        0 0 0 2px rgba(170,128,116,0.07);
}


.owner-form-group .is-invalid {
    border-color:
        #aa655a;
}


.owner-field-error {
    margin-top:
        5px;

    color:
        #9b5c52;

    font-size:
        0.56rem;
}


.owner-form-help {
    display:
        block;

    margin-top:
        6px;

    color:
        #90857e;

    font-size:
        0.58rem;

    line-height:
        1.45;
}



/* =========================================================
   SIDE PANEL
========================================================= */

.owner-form-side {
    display:
        flex;

    min-width:
        0;

    flex-direction:
        column;

    padding:
        28px
        27px;

    background:
        #e5d4cd;

    border-left:
        1px solid rgba(46,42,38,0.07);

    color:
        #3d3531;
}


.owner-form-side-eyebrow {
    display:
        block;

    margin-bottom:
        9px;

    color:
        #956e63;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.15em;
}


.owner-form-side h2 {
    max-width:
        270px;

    margin:
        0
        0
        9px;

    color:
        #3e3531;

    font-size:
        1.45rem;

    font-weight:
        300;

    line-height:
        1.14;

    letter-spacing:
        -0.035em;
}


.owner-form-side > p {
    max-width:
        290px;

    margin:
        0;

    color:
        #776963;

    font-size:
        0.64rem;

    line-height:
        1.65;
}



/* =========================================================
   SIDE STEPS
========================================================= */

.owner-form-side-info {
    margin:
        24px
        0;

    border-top:
        1px solid rgba(78,61,54,0.12);
}


.owner-form-side-info > div {
    display:
        grid;

    grid-template-columns:
        28px
        1fr;

    gap:
        10px;

    align-items:
        start;

    padding:
        14px
        0;

    border-bottom:
        1px solid rgba(78,61,54,0.12);
}


.owner-form-side-info span {
    color:
        #9d7063;

    font-size:
        0.53rem;

    font-weight:
        500;

    letter-spacing:
        0.1em;
}


.owner-form-side-info p {
    margin:
        0;

    color:
        #74665f;

    font-size:
        0.60rem;

    line-height:
        1.5;
}



/* =========================================================
   CURRENT STATUS
========================================================= */

.owner-form-side-note {
    margin-bottom:
        18px;

    padding:
        14px;

    background:
        rgba(255,255,255,0.30);

    border:
        1px solid rgba(112,81,72,0.10);
}


.owner-form-side-note > span {
    display:
        block;

    margin-bottom:
        9px;

    color:
        #936a5f;

    font-size:
        0.51rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.owner-form-current-status {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        12px;
}


.owner-form-current-status strong {
    display:
        inline-flex;

    align-items:
        center;

    min-height:
        25px;

    padding:
        0
        8px;

    background:
        #eee3ca;

    color:
        #725f3f;

    font-size:
        0.49rem;

    font-weight:
        500;

    letter-spacing:
        0.08em;
}


.owner-form-current-status strong.status-confirmed {
    background:
        #dce5d8;

    color:
        #586b55;
}


.owner-form-current-status strong.status-completed {
    background:
        #ddd2cc;

    color:
        #5f514b;
}


.owner-form-current-status strong.status-cancelled {
    background:
        #ead5d1;

    color:
        #87564e;
}


.owner-form-current-status small {
    color:
        #796c65;

    font-size:
        0.56rem;

    white-space:
        nowrap;
}



/* =========================================================
   ACTIONS
========================================================= */

.owner-form-submit {
    width:
        100%;

    min-height:
        42px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    margin-top:
        auto;

    padding:
        0
        14px;

    border:
        1px solid #a67f73;

    background:
        #a67f73;

    color:
        #fff;

    font-family:
        inherit;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;

    cursor:
        pointer;

    transition:
        background 0.18s ease,
        border-color 0.18s ease;
}


.owner-form-submit:hover {
    background:
        #8f695f;

    border-color:
        #8f695f;
}


.owner-form-submit span:last-child {
    font-size:
        0.73rem;

    font-weight:
        300;
}


.owner-form-cancel {
    min-height:
        36px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    margin-top:
        7px;

    border:
        1px solid rgba(112,81,72,0.18);

    background:
        rgba(255,255,255,0.15);

    color:
        #695a54;

    text-decoration:
        none;

    font-size:
        0.53rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;

    transition:
        background 0.18s ease,
        border-color 0.18s ease,
        color 0.18s ease;
}


.owner-form-cancel:hover {
    background:
        rgba(255,255,255,0.35);

    border-color:
        rgba(112,81,72,0.25);

    color:
        #493d38;
}



/* =========================================================
   SHORT DESKTOP — SAME NAVBAR AS EMPLOYEE DASHBOARD
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-appointment-form-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .owner-appointment-form-page .navbar .container,
    .owner-appointment-form-page .navbar .container-fluid {
        min-height:
            58px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 800px) {

    .owner-form-grid {
        grid-template-columns:
            1fr;
    }


    .owner-form-side {
        min-height:
            350px;

        border-left:
            0;

        border-top:
            1px solid rgba(46,42,38,0.08);
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .owner-appointment-form-space {
        padding:
            21px
            0
            32px;
    }


    .owner-appointment-form-shell {
        width:
            calc(100% - 24px);
    }


    .owner-form-header {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .owner-form-step {
        text-align:
            left;
    }


    .owner-form-fields {
        grid-template-columns:
            1fr;

        padding:
            20px
            18px;
    }


    .owner-form-group.full {
        grid-column:
            auto;
    }


    .owner-form-side {
        min-height:
            auto;

        padding:
            25px
            21px;
    }


    .owner-form-current-status {
        align-items:
            flex-start;

        flex-direction:
            column;
    }

}

</style>

@endpush