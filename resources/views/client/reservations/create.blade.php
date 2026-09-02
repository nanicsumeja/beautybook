@extends('layouts.app')

@section('body-class', 'client-booking-page')
@section('main-class', '')

@section('content')

<section class="booking-space">

    <div class="booking-shell">

        {{-- TOP --}}
        <div class="booking-top">

            <a
                href="{{ route('client.services.index') }}"
                class="booking-back"
            >
                ← BACK TO SERVICES
            </a>

            <span class="booking-step-label">
                BOOK YOUR APPOINTMENT
            </span>

        </div>


        <div class="booking-layout">

            {{-- LEFT: SERVICE SUMMARY --}}
            <aside class="booking-summary">

                <span class="booking-summary-eyebrow">
                    SELECTED SERVICE
                </span>

                <h1>
                    {{ $service->name }}
                </h1>

                @if ($service->description)
                    <p class="booking-summary-description">
                        {{ $service->description }}
                    </p>
                @else
                    <p class="booking-summary-description">
                        Your selected BeautyBook treatment.
                        Choose your preferred specialist,
                        date and available time.
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


                <div class="booking-summary-note">
                    <span>BEAUTYBOOK</span>

                    <p>
                        Select a date and we will show only
                        genuinely available appointment times.
                    </p>
                </div>

            </aside>


            {{-- RIGHT: FORM --}}
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


                    {{-- STEP 1 --}}
                    <div class="booking-section">

                        <div class="booking-section-number">
                            01
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">
                                <span>WHEN</span>
                                <h2>Choose your date</h2>
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


                    {{-- STEP 2 --}}
                    <div class="booking-section">

                        <div class="booking-section-number">
                            02
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">
                                <span>WHO</span>
                                <h2>Choose your specialist</h2>
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


                    {{-- STEP 3 --}}
                    <div class="booking-section">

                        <div class="booking-section-number">
                            03
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">
                                <span>TIME</span>
                                <h2>Pick an available time</h2>
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
                                <span>YOUR SPECIALIST</span>

                                <strong id="selected-employee-name"></strong>
                            </div>

                        </div>

                    </div>


                    {{-- STEP 4 --}}
                    <div class="booking-section">

                        <div class="booking-section-number">
                            04
                        </div>

                        <div class="booking-section-content">

                            <div class="booking-section-heading">
                                <span>OPTIONAL</span>
                                <h2>Anything we should know?</h2>
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


                    {{-- SUBMIT --}}
                    <div class="booking-submit-area">

                        <div class="booking-submit-copy">
                            <span>NEXT STEP</span>

                            <p>
                                Review your details and continue
                                with your appointment.
                            </p>
                        </div>

                        <button
                            type="submit"
                            id="booking-button"
                            class="booking-submit"
                        >
                            CONTINUE WITH BOOKING
                            <span>→</span>
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

    .client-booking-page {
        background: #f3efea;
    }

    .booking-space {
        min-height: calc(100vh - 62px);
        padding: 30px 0 50px;
        background:
            radial-gradient(
                circle at 5% 10%,
                rgba(197, 158, 146, 0.13),
                transparent 22%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .booking-shell {
        width: min(1180px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* TOP */

    .booking-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .booking-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.59rem;
        font-weight: 500;
        letter-spacing: 0.15em;
    }

    .booking-back:hover {
        color: #9f7468;
    }

    .booking-step-label {
        font-size: 0.57rem;
        letter-spacing: 0.19em;
        color: #998d85;
    }


    /* LAYOUT */

    .booking-layout {
        display: grid;
        grid-template-columns: 0.72fr 1.28fr;
        gap: 16px;
        align-items: start;
    }


    /* SERVICE SUMMARY */

    .booking-summary {
        position: sticky;
        top: 90px;
        padding: 38px;
        background: #211d1a;
        color: #fff;
    }

    .booking-summary-eyebrow {
        display: block;
        margin-bottom: 22px;
        font-size: 0.58rem;
        letter-spacing: 0.2em;
        color: #c9a79b;
    }

    .booking-summary h1 {
        margin: 0 0 18px;
        font-size: clamp(2.2rem, 4vw, 3.6rem);
        font-weight: 300;
        line-height: 0.98;
        letter-spacing: -0.045em;
    }

    .booking-summary-description {
        max-width: 380px;
        margin: 0 0 32px;
        font-size: 0.78rem;
        font-weight: 300;
        line-height: 1.7;
        color: #c9c0ba;
    }

    .booking-summary-details {
        border-top: 1px solid rgba(255,255,255,0.14);
    }

    .booking-summary-details > div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255,255,255,0.14);
    }

    .booking-summary-details span {
        font-size: 0.54rem;
        letter-spacing: 0.16em;
        color: #a99f98;
    }

    .booking-summary-details strong {
        font-size: 0.8rem;
        font-weight: 500;
    }

    .booking-summary-note {
        margin-top: 34px;
        padding: 20px;
        background: #d6b7ac;
        color: #211d1a;
    }

    .booking-summary-note span {
        display: block;
        margin-bottom: 7px;
        font-size: 0.54rem;
        letter-spacing: 0.18em;
    }

    .booking-summary-note p {
        margin: 0;
        font-size: 0.7rem;
        line-height: 1.55;
    }


    /* FORM */

    .booking-form-panel {
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.07);
    }

    .booking-section {
        display: grid;
        grid-template-columns: 56px 1fr;
        padding: 32px 34px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.1);
    }

    .booking-section-number {
        padding-top: 4px;
        font-size: 0.57rem;
        letter-spacing: 0.14em;
        color: #b18b7e;
    }

    .booking-section-content {
        min-width: 0;
    }

    .booking-section-heading {
        margin-bottom: 20px;
    }

    .booking-section-heading span {
        display: block;
        margin-bottom: 4px;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.18em;
        color: #aa8073;
    }

    .booking-section-heading h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 400;
    }


    /* FIELDS */

    .booking-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.15em;
        color: #706861;
    }

    .booking-field input,
    .booking-field select,
    .booking-field textarea {
        width: 100%;
        border: 1px solid rgba(33, 29, 26, 0.18);
        border-radius: 0;
        outline: none;
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.82rem;
        transition:
            border-color 0.2s ease,
            background 0.2s ease;
    }

    .booking-field input,
    .booking-field select {
        min-height: 47px;
        padding: 0 13px;
    }

    .booking-field textarea {
        resize: vertical;
        padding: 13px;
    }

    .booking-field input:focus,
    .booking-field select:focus,
    .booking-field textarea:focus {
        border-color: #a97869;
        background: #fff;
    }

    .booking-field .is-invalid {
        border-color: #b75757;
    }

    .booking-help {
        margin-top: 7px;
        font-size: 0.65rem;
        line-height: 1.5;
        color: #8d847e;
    }

    .booking-help-error,
    .booking-field-error {
        color: #a64e4e;
    }

    .booking-field-error {
        margin-top: 6px;
        font-size: 0.65rem;
    }


    /* SLOTS */

    .booking-slots-message {
        margin-bottom: 12px;
        font-size: 0.69rem;
        color: #81776f;
    }

    .booking-slots-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .booking-slot-button {
        padding: 10px 13px;
        border: 1px solid rgba(33, 29, 26, 0.2);
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.69rem;
        transition: all 0.18s ease;
    }

    .booking-slot-button:hover {
        border-color: #a87869;
        background: #eadbd4;
    }

    .booking-slot-button.active {
        border-color: #211d1a;
        background: #211d1a;
        color: #fff;
    }

    .booking-selected-employee {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 16px;
        padding: 13px 15px;
        background: #eee1d9;
    }

    .booking-selected-employee span {
        font-size: 0.53rem;
        letter-spacing: 0.15em;
        color: #90766d;
    }

    .booking-selected-employee strong {
        font-size: 0.75rem;
        font-weight: 500;
    }


    /* ERROR */

    .booking-error-box {
        margin: 25px 30px 0;
        padding: 17px 19px;
        background: #f3dfda;
        border-left: 3px solid #a95d50;
    }

    .booking-error-box strong {
        font-size: 0.77rem;
        font-weight: 500;
    }

    .booking-error-box p {
        margin: 4px 0 0;
        font-size: 0.67rem;
        color: #78645f;
    }


    /* SUBMIT */

    .booking-submit-area {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 27px 34px;
        background: #e7d8cf;
    }

    .booking-submit-copy span {
        display: block;
        margin-bottom: 3px;
        font-size: 0.52rem;
        letter-spacing: 0.17em;
        color: #9a7468;
    }

    .booking-submit-copy p {
        max-width: 260px;
        margin: 0;
        font-size: 0.67rem;
        line-height: 1.45;
        color: #736a64;
    }

    .booking-submit {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        min-width: 235px;
        padding: 14px 17px;
        border: 0;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.13em;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .booking-submit:hover {
        background: #9f7164;
    }


    /* RESPONSIVE */

    @media (max-width: 850px) {

        .booking-layout {
            grid-template-columns: 1fr;
        }

        .booking-summary {
            position: static;
        }

    }

    @media (max-width: 575px) {

        .booking-space {
            padding: 20px 0 30px;
        }

        .booking-shell {
            width: calc(100% - 24px);
        }

        .booking-step-label {
            display: none;
        }

        .booking-summary {
            padding: 28px 24px;
        }

        .booking-section {
            grid-template-columns: 1fr;
            gap: 8px;
            padding: 27px 22px;
        }

        .booking-submit-area {
            align-items: stretch;
            flex-direction: column;
            padding: 24px 22px;
        }

        .booking-submit {
            width: 100%;
        }

    }

</style>
@endpush


<script>
document.addEventListener('DOMContentLoaded', function () {

    const dateInput = document.getElementById(
        'appointment_date'
    );

    const employeeSelect = document.getElementById(
        'employee_id'
    );

    const startTimeInput = document.getElementById(
        'start_time'
    );

    const slotsContainer = document.getElementById(
        'slots-container'
    );

    const slotsMessage = document.getElementById(
        'slots-message'
    );

    const slotsLoading = document.getElementById(
        'slots-loading'
    );

    const selectedEmployee = document.getElementById(
        'selected-employee'
    );

    const selectedEmployeeName = document.getElementById(
        'selected-employee-name'
    );


    function clearSlots() {

        slotsContainer.innerHTML = '';

        startTimeInput.value = '';

        selectedEmployee.classList.add('d-none');

        selectedEmployeeName.textContent = '';

    }


    async function loadSlots() {

        clearSlots();

        const date = dateInput.value;

        const employeeId = employeeSelect.value;


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


            const response = await fetch(url, {

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }

            });


            if (!response.ok) {

                throw new Error(
                    'Failed to load available slots.'
                );

            }


            const data = await response.json();


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

                button.type = 'button';

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


                        button.classList.add('active');


                        startTimeInput.value =
                            slot.start_time;


                        selectedEmployee.classList.remove(
                            'd-none'
                        );

                        selectedEmployeeName.textContent =
                            slot.employee_name;

                    }
                );


                slotsContainer.appendChild(button);

            });


        } catch (error) {

            console.error(error);

            slotsMessage.textContent =
                'Unable to load available times. Please try again.';

            slotsMessage.classList.remove('d-none');

        } finally {

            slotsLoading.classList.add('d-none');

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