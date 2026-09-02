@extends('layouts.app')

@section('body-class', 'owner-appointment-form-page')
@section('main-class', 'owner-appointment-form-main')

@section('content')

<section class="owner-appointment-form-space">

    <div class="owner-appointment-form-shell">

        <div class="owner-form-back-row">
            <a
                href="{{ route('owner.reservations.index') }}"
                class="owner-form-back"
            >
                ← BACK TO APPOINTMENTS
            </a>
        </div>


        <header class="owner-form-header">

            <div>
                <span class="owner-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Create appointment
                </h1>

                <p>
                    Create a new appointment and assign an employee.
                </p>
            </div>

            <div class="owner-form-step">
                <span>NEW</span>
                <strong>APPOINTMENT</strong>
            </div>

        </header>


        @if ($errors->any())

            <div class="owner-form-message error">

                <div class="owner-form-message-icon">
                    !
                </div>

                <div>
                    <strong>
                        The appointment could not be created.
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('owner.reservations.store') }}"
        >
            @csrf

            <div class="owner-form-grid">


                {{-- MAIN FORM --}}
                <section class="owner-form-card">

                    <div class="owner-form-card-heading">
                        <span>
                            APPOINTMENT DETAILS
                        </span>

                        <h2>
                            Booking information
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
                                <option value="">
                                    Select client
                                </option>

                                @foreach ($clients as $client)

                                    <option
                                        value="{{ $client->id }}"
                                        @selected(
                                            old('client_id')
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
                                <option value="">
                                    Select service
                                </option>

                                @foreach ($services as $service)

                                    <option
                                        value="{{ $service->id }}"
                                        @selected(
                                            old('service_id')
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
                                <option value="">
                                    Select employee
                                </option>

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
                                            old('employee_id')
                                            == $employee->id
                                        )
                                    >
                                        {{ $employee->name }}
                                        {{ $employee->surname }}
                                    </option>

                                @endforeach
                            </select>

                            <small class="owner-form-help">
                                Only employees who perform the selected
                                service can be assigned.
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
                                value="{{ old('appointment_date') }}"
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
                                value="{{ old('start_time') }}"
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
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="owner-field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </section>


                {{-- SIDE PANEL --}}
                <aside class="owner-form-side">

                    <span class="owner-form-side-eyebrow">
                        NEW BOOKING
                    </span>

                    <h2>
                        Create an appointment.
                    </h2>

                    <p>
                        Choose the client, service, assigned employee,
                        date and start time.
                    </p>


                    <div class="owner-form-side-info">

                        <div>
                            <span>01</span>

                            <p>
                                Select the client and service.
                            </p>
                        </div>

                        <div>
                            <span>02</span>

                            <p>
                                Assign an eligible employee.
                            </p>
                        </div>

                        <div>
                            <span>03</span>

                            <p>
                                Choose the appointment date and time.
                            </p>
                        </div>

                    </div>


                    <div class="owner-form-side-note">

                        <span>
                            EMPLOYEE AVAILABILITY
                        </span>

                        <p>
                            Employee assignment is validated before the
                            appointment is created.
                        </p>

                    </div>


                    <button
                        type="submit"
                        class="owner-form-submit"
                    >
                        CREATE APPOINTMENT
                        <span>→</span>
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
        const serviceId = serviceSelect.value;

        Array.from(employeeSelect.options).forEach(
            (option) => {
                if (!option.value) {
                    return;
                }

                const services = (
                    option.dataset.services || ''
                )
                    .split(',')
                    .filter(Boolean);

                const allowed =
                    !serviceId
                    || services.includes(serviceId);

                option.hidden = !allowed;
                option.disabled = !allowed;

                if (
                    !allowed
                    && option.selected
                ) {
                    employeeSelect.value = '';
                }
            }
        );
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

    .owner-appointment-form-page {
        background: #f3efea;
    }

    .owner-appointment-form-main {
        background: #f3efea;
    }

    .owner-appointment-form-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 40px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190, 151, 140, 0.12),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-appointment-form-shell {
        width: min(1050px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* BACK */

    .owner-form-back-row {
        margin-bottom: 17px;
    }

    .owner-form-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.47rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .owner-form-back:hover {
        color: #9d7063;
    }


    /* HEADER */

    .owner-form-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 18px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-form-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-form-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-form-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.69rem;
    }

    .owner-form-step {
        text-align: right;
    }

    .owner-form-step span {
        display: block;
        margin-bottom: 3px;
        color: #9d8177;
        font-size: 0.4rem;
        letter-spacing: 0.13em;
    }

    .owner-form-step strong {
        font-size: 0.6rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }


    /* ERROR */

    .owner-form-message {
        display: flex;
        gap: 13px;
        margin-bottom: 16px;
        padding: 14px 16px;
        border-left: 3px solid;
    }

    .owner-form-message.error {
        background: #ead8d4;
        border-color: #a7655a;
        color: #754940;
    }

    .owner-form-message-icon {
        width: 25px;
        height: 25px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        background: #9c6156;
        color: #fff;
        font-size: 0.65rem;
    }

    .owner-form-message strong {
        display: block;
        font-size: 0.63rem;
        font-weight: 500;
    }

    .owner-form-message ul {
        margin: 7px 0 0;
        padding-left: 17px;
        font-size: 0.57rem;
        line-height: 1.6;
    }


    /* GRID */

    .owner-form-grid {
        display: grid;
        grid-template-columns: 1.35fr 0.65fr;
        gap: 15px;
        align-items: start;
    }


    /* FORM CARD */

    .owner-form-card {
        background: #faf7f3;
        border: 1px solid rgba(33,29,26,0.08);
    }

    .owner-form-card-heading {
        padding: 20px 23px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-form-card-heading span {
        display: block;
        margin-bottom: 4px;
        color: #a17c70;
        font-size: 0.44rem;
        letter-spacing: 0.14em;
    }

    .owner-form-card-heading h2 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 300;
    }


    /* FIELDS */

    .owner-form-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        padding: 23px;
    }

    .owner-form-group.full {
        grid-column: 1 / -1;
    }

    .owner-form-group label {
        display: block;
        margin-bottom: 6px;
        color: #8f766d;
        font-size: 0.44rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .owner-form-group input,
    .owner-form-group select,
    .owner-form-group textarea {
        width: 100%;
        border: 1px solid rgba(33,29,26,0.15);
        border-radius: 0;
        background: #f7f2ed;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.64rem;
        outline: none;
    }

    .owner-form-group input,
    .owner-form-group select {
        height: 42px;
        padding: 0 12px;
    }

    .owner-form-group textarea {
        resize: vertical;
        padding: 12px;
        line-height: 1.5;
    }

    .owner-form-group input:focus,
    .owner-form-group select:focus,
    .owner-form-group textarea:focus {
        border-color: #a77c70;
        background: #fff;
    }

    .owner-form-group .is-invalid {
        border-color: #aa655a;
    }

    .owner-field-error {
        margin-top: 5px;
        color: #9b5c52;
        font-size: 0.53rem;
    }

    .owner-form-help {
        display: block;
        margin-top: 6px;
        color: #90857e;
        font-size: 0.5rem;
        line-height: 1.45;
    }


    /* SIDE */

    .owner-form-side {
        padding: 27px;
        background: #211d1a;
        color: #fff;
    }

    .owner-form-side-eyebrow {
        display: block;
        margin-bottom: 7px;
        color: #c5a69c;
        font-size: 0.46rem;
        letter-spacing: 0.15em;
    }

    .owner-form-side h2 {
        margin: 0 0 8px;
        font-size: 1.45rem;
        font-weight: 300;
        line-height: 1.15;
    }

    .owner-form-side > p {
        margin: 0;
        color: #bbb1ab;
        font-size: 0.62rem;
        line-height: 1.55;
    }


    /* STEPS */

    .owner-form-side-info {
        margin: 24px 0;
    }

    .owner-form-side-info > div {
        display: grid;
        grid-template-columns: 27px 1fr;
        gap: 10px;
        align-items: start;
        padding: 11px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .owner-form-side-info > div:last-child {
        border-bottom: 0;
    }

    .owner-form-side-info span {
        color: #c69e92;
        font-size: 0.43rem;
        letter-spacing: 0.1em;
    }

    .owner-form-side-info p {
        margin: 0;
        color: #d4ccc7;
        font-size: 0.58rem;
        line-height: 1.45;
    }


    /* NOTE */

    .owner-form-side-note {
        margin-bottom: 18px;
        padding: 14px;
        background: rgba(215,183,172,0.12);
        border: 1px solid rgba(215,183,172,0.2);
    }

    .owner-form-side-note span {
        display: block;
        margin-bottom: 5px;
        color: #c8a99f;
        font-size: 0.4rem;
        letter-spacing: 0.13em;
    }

    .owner-form-side-note p {
        margin: 0;
        color: #bdb4ae;
        font-size: 0.54rem;
        line-height: 1.5;
    }


    /* ACTIONS */

    .owner-form-submit {
        width: 100%;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        border: 0;
        background: #d8b8ad;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.46rem;
        font-weight: 500;
        letter-spacing: 0.11em;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .owner-form-submit:hover {
        background: #ead7d0;
    }

    .owner-form-cancel {
        min-height: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 7px;
        border: 1px solid rgba(255,255,255,0.15);
        color: #c7bdb7;
        text-decoration: none;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-form-cancel:hover {
        color: #fff;
        border-color: rgba(255,255,255,0.35);
    }


    /* RESPONSIVE */

    @media (max-width: 800px) {

        .owner-form-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 575px) {

        .owner-appointment-form-space {
            padding: 21px 0 32px;
        }

        .owner-appointment-form-shell {
            width: calc(100% - 24px);
        }

        .owner-form-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-form-step {
            text-align: left;
        }

        .owner-form-fields {
            grid-template-columns: 1fr;
            padding: 20px;
        }

        .owner-form-group.full {
            grid-column: auto;
        }

        .owner-form-side {
            padding: 23px;
        }

    }

</style>
@endpush