@extends('layouts.app')

@section('body-class', 'owner-working-hours-page')
@section('main-class', 'owner-working-hours-main')

@section('content')

<section class="owner-working-hours-space">

    <div class="owner-working-hours-shell">

        {{-- HEADER --}}
        <header class="owner-working-hours-header">

            <div>
                <span class="owner-working-hours-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>Working hours</h1>

                <p>
                    Manage weekly availability for
                    {{ $employee->name }} {{ $employee->surname }}.
                </p>
            </div>

            <a
                href="{{ route('owner.employees.index') }}"
                class="owner-working-hours-back"
            >
                ← EMPLOYEES
            </a>

        </header>


        {{-- MESSAGES --}}
        @if (session('success'))
            <div class="owner-working-hours-message success">
                <span>✓</span>

                <p>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if ($errors->any())
            <div class="owner-working-hours-message error">
                <span>!</span>

                <p>
                    Please check the entered working hours.
                </p>
            </div>
        @endif


        <div class="owner-working-hours-grid">

            {{-- SCHEDULE FORM --}}
            <section class="owner-working-hours-card">

                <header class="owner-working-hours-card-header">

                    <div>
                        <span>WEEKLY SCHEDULE</span>

                        <h2>
                            Employee availability
                        </h2>
                    </div>

                    <p>
                        Set working periods or mark a day as off.
                    </p>

                </header>


                <form
                    method="POST"
                    action="{{ route(
                        'owner.employees.working-hours.update',
                        $employee
                    ) }}"
                >
                    @csrf
                    @method('PUT')


                    <div class="owner-working-hours-list">

                        @foreach ($days as $dayNumber => $dayName)

                            @php
                                $index = $loop->index;

                                $savedDay = $workingHours->get(
                                    $dayNumber
                                );

                                $isDayOff = old(
                                    "days.$index.is_day_off",
                                    $savedDay
                                        ? (int) $savedDay->is_day_off
                                        : 1
                                );

                                $startTime = old(
                                    "days.$index.start_time",
                                    $savedDay?->start_time
                                        ? substr(
                                            $savedDay->start_time,
                                            0,
                                            5
                                        )
                                        : '09:00'
                                );

                                $endTime = old(
                                    "days.$index.end_time",
                                    $savedDay?->end_time
                                        ? substr(
                                            $savedDay->end_time,
                                            0,
                                            5
                                        )
                                        : '17:00'
                                );
                            @endphp


                            <article
                                class="owner-working-day {{
                                    $isDayOff
                                        ? 'is-off'
                                        : ''
                                }}"
                                data-working-day
                            >

                                <input
                                    type="hidden"
                                    name="days[{{ $index }}][day_of_week]"
                                    value="{{ $dayNumber }}"
                                >


                                {{-- DAY --}}
                                <div class="owner-working-day-name">

                                    <span>
                                        DAY {{ str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                    </span>

                                    <strong>
                                        {{ $dayName }}
                                    </strong>

                                </div>


                                {{-- START --}}
                                <div class="owner-working-time">

                                    <label
                                        for="start_time_{{ $dayNumber }}"
                                    >
                                        START TIME
                                    </label>

                                    <input
                                        type="time"
                                        id="start_time_{{ $dayNumber }}"
                                        name="days[{{ $index }}][start_time]"
                                        value="{{ $startTime }}"
                                        class="@error(
                                            "days.$index.start_time"
                                        ) is-invalid @enderror"
                                        data-start-time
                                        @disabled($isDayOff)
                                    >

                                    @error("days.$index.start_time")
                                        <small class="owner-working-error">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>


                                {{-- END --}}
                                <div class="owner-working-time">

                                    <label
                                        for="end_time_{{ $dayNumber }}"
                                    >
                                        END TIME
                                    </label>

                                    <input
                                        type="time"
                                        id="end_time_{{ $dayNumber }}"
                                        name="days[{{ $index }}][end_time]"
                                        value="{{ $endTime }}"
                                        class="@error(
                                            "days.$index.end_time"
                                        ) is-invalid @enderror"
                                        data-end-time
                                        @disabled($isDayOff)
                                    >

                                    @error("days.$index.end_time")
                                        <small class="owner-working-error">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>


                                {{-- DAY OFF --}}
                                <div class="owner-working-day-off">

                                    <input
                                        type="hidden"
                                        name="days[{{ $index }}][is_day_off]"
                                        value="0"
                                    >

                                    <label class="owner-working-toggle">

                                        <input
                                            type="checkbox"
                                            id="day_off_{{ $dayNumber }}"
                                            name="days[{{ $index }}][is_day_off]"
                                            value="1"
                                            data-day-off
                                            @checked($isDayOff)
                                        >

                                        <span class="owner-working-toggle-track">
                                            <i></i>
                                        </span>

                                        <span class="owner-working-toggle-text">
                                            DAY OFF
                                        </span>

                                    </label>

                                </div>

                            </article>

                        @endforeach

                    </div>


                    <footer class="owner-working-hours-actions">

                        <a
                            href="{{ route('owner.employees.index') }}"
                            class="owner-working-hours-secondary"
                        >
                            CANCEL
                        </a>

                        <button
                            type="submit"
                            class="owner-working-hours-primary"
                        >
                            <span>SAVE WORKING HOURS</span>
                            <span>→</span>
                        </button>

                    </footer>

                </form>

            </section>


            {{-- EMPLOYEE PANEL --}}
            <aside class="owner-working-hours-side">

                <span class="owner-working-hours-side-eyebrow">
                    EMPLOYEE SCHEDULE
                </span>

                <div class="owner-working-hours-avatar">
                    {{
                        mb_strtoupper(
                            mb_substr(
                                $employee->name,
                                0,
                                1
                            )
                        )
                    }}
                </div>

                <h2>
                    {{ $employee->name }}
                    {{ $employee->surname }}
                </h2>

                <p>
                    Define when this employee can receive
                    salon appointments throughout the week.
                </p>


                <div class="owner-working-hours-notes">

                    <article>
                        <span>01</span>

                        <div>
                            <strong>
                                Working period
                            </strong>

                            <p>
                                Start and end times define the
                                employee's available booking window.
                            </p>
                        </div>
                    </article>

                    <article>
                        <span>02</span>

                        <div>
                            <strong>
                                Day off
                            </strong>

                            <p>
                                Enable Day off when the employee
                                is unavailable for the entire day.
                            </p>
                        </div>
                    </article>

                    <article>
                        <span>03</span>

                        <div>
                            <strong>
                                Booking availability
                            </strong>

                            <p>
                                Client time slots are based on
                                these working hours.
                            </p>
                        </div>
                    </article>

                </div>


                <div class="owner-working-hours-side-note">

                    <span>SCHEDULE NOTE</span>

                    <p>
                        Changes affect future availability used
                        when booking appointments.
                    </p>

                </div>

            </aside>

        </div>

    </div>

</section>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll(
        '[data-working-day]'
    );

    rows.forEach((row) => {
        const checkbox = row.querySelector(
            '[data-day-off]'
        );

        const startTime = row.querySelector(
            '[data-start-time]'
        );

        const endTime = row.querySelector(
            '[data-end-time]'
        );

        const updateInputs = () => {
            const isDayOff = checkbox.checked;

            startTime.disabled = isDayOff;
            endTime.disabled = isDayOff;

            row.classList.toggle(
                'is-off',
                isDayOff
            );
        };

        checkbox.addEventListener(
            'change',
            updateInputs
        );

        updateInputs();
    });
});
</script>

@endsection


@push('styles')
<style>

    /* PAGE */

    .owner-working-hours-page,
    .owner-working-hours-main {
        background: #f3efea;
    }

    .owner-working-hours-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 42px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190,151,140,0.13),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-working-hours-shell {
        width: min(1080px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-working-hours-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 17px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-working-hours-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.64rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-working-hours-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-working-hours-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.76rem;
    }

    .owner-working-hours-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.57rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-working-hours-back:hover {
        color: #9d7063;
    }


    /* MESSAGES */

    .owner-working-hours-message {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding: 11px 14px;
    }

    .owner-working-hours-message span {
        width: 19px;
        height: 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 50%;
        font-size: 0.45rem;
    }

    .owner-working-hours-message p {
        margin: 0;
        font-size: 0.66rem;
    }

    .owner-working-hours-message.success {
        border: 1px solid rgba(92,107,89,0.18);
        background: #e3e9e0;
        color: #596555;
    }

    .owner-working-hours-message.success span {
        border: 1px solid rgba(92,107,89,0.3);
    }

    .owner-working-hours-message.error {
        border: 1px solid rgba(164,95,85,0.18);
        background: #ead8d4;
        color: #82564e;
    }

    .owner-working-hours-message.error span {
        border: 1px solid rgba(164,95,85,0.3);
    }


    /* MAIN GRID */

    .owner-working-hours-grid {
        display: grid;
        grid-template-columns: 1.38fr 0.62fr;
        align-items: stretch;
        border: 1px solid rgba(33,29,26,0.08);
    }


    /* FORM CARD */

    .owner-working-hours-card {
        min-width: 0;
        background: #faf7f3;
    }

    .owner-working-hours-card-header {
        min-height: 79px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 17px 22px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-working-hours-card-header span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .owner-working-hours-card-header h2 {
        margin: 0;
        font-size: 1.16rem;
        font-weight: 300;
    }

    .owner-working-hours-card-header > p {
        max-width: 180px;
        margin: 0;
        color: #988d86;
        font-size: 0.6rem;
        line-height: 1.55;
        text-align: right;
    }


    /* DAYS */

    .owner-working-day {
        display: grid;
        grid-template-columns: 1.05fr 1fr 1fr 0.72fr;
        gap: 15px;
        align-items: center;
        min-height: 91px;
        padding: 14px 22px;
        border-bottom: 1px solid rgba(33,29,26,0.085);
        transition:
            background 0.15s ease,
            opacity 0.15s ease;
    }

    .owner-working-day:last-child {
        border-bottom: 0;
    }

    .owner-working-day:hover {
        background: #f7f1ed;
    }

    .owner-working-day.is-off {
        background: #f0ebe7;
    }


    /* DAY NAME */

    .owner-working-day-name > span {
        display: block;
        margin-bottom: 4px;
        color: #a68c82;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-working-day-name strong {
        color: #39312d;
        font-size: 0.7rem;
        font-weight: 500;
    }


    /* TIME INPUTS */

    .owner-working-time label {
        display: block;
        margin-bottom: 6px;
        color: #8f817a;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.09em;
    }

    .owner-working-time input {
        width: 100%;
        min-height: 39px;
        padding: 7px 9px;
        border: 1px solid rgba(33,29,26,0.14);
        border-radius: 0;
        outline: none;
        background: #f8f4f0;
        color: #332c28;
        font-family: inherit;
        font-size: 0.68rem;
    }

    .owner-working-time input:focus {
        border-color: #aa8074;
        box-shadow:
            0 0 0 2px rgba(170,128,116,0.08);
    }

    .owner-working-time input:disabled {
        background: #e7dfda;
        color: #a99d96;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .owner-working-time input.is-invalid {
        border-color: #aa655b;
    }

    .owner-working-error {
        display: block;
        margin-top: 4px;
        color: #a45f55;
        font-size: 0.56rem;
        line-height: 1.4;
    }


    /* DAY OFF */

    .owner-working-day-off {
        display: flex;
        justify-content: flex-end;
    }

    .owner-working-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        cursor: pointer;
    }

    .owner-working-toggle input[type="checkbox"] {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .owner-working-toggle-track {
        position: relative;
        width: 34px;
        height: 18px;
        flex-shrink: 0;
        background: #c9bbb4;
        transition: background 0.18s ease;
    }

    .owner-working-toggle-track i {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 12px;
        height: 12px;
        background: #fff;
        transition: transform 0.18s ease;
    }

    .owner-working-toggle
    input[type="checkbox"]:checked
    + .owner-working-toggle-track {
        background: #8c7067;
    }

    .owner-working-toggle
    input[type="checkbox"]:checked
    + .owner-working-toggle-track i {
        transform: translateX(16px);
    }

    .owner-working-toggle-text {
        color: #766b65;
        font-size: 0.52rem;
        font-weight: 500;
        letter-spacing: 0.08em;
    }


    /* ACTIONS */

    .owner-working-hours-actions {
        min-height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 22px;
        border-top: 1px solid rgba(33,29,26,0.09);
    }

    .owner-working-hours-secondary {
        color: #786d67;
        text-decoration: none;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-working-hours-secondary:hover {
        color: #211d1a;
    }

    .owner-working-hours-primary {
        min-width: 205px;
        min-height: 43px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 15px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-working-hours-primary:hover {
        background: #9d7063;
        border-color: #9d7063;
    }

    .owner-working-hours-primary span:last-child {
        font-size: 0.75rem;
        font-weight: 300;
    }


    /* SIDE */

    .owner-working-hours-side {
        display: flex;
        flex-direction: column;
        padding: 29px 27px;
        background: #211d1a;
        color: #f7f2ee;
    }

    .owner-working-hours-side-eyebrow {
        display: block;
        margin-bottom: 14px;
        color: #c6a59a;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.15em;
    }

    .owner-working-hours-avatar {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 13px;
        background: #d8c4bc;
        color: #59453e;
        font-size: 0.9rem;
        font-weight: 400;
    }

    .owner-working-hours-side > h2 {
        margin: 0 0 7px;
        color: #f3ebe7;
        font-size: 1.35rem;
        font-weight: 300;
        letter-spacing: -0.03em;
    }

    .owner-working-hours-side > p {
        margin: 0;
        color: #bcb0aa;
        font-size: 0.66rem;
        line-height: 1.7;
    }


    /* SIDE NOTES */

    .owner-working-hours-notes {
        margin-top: 27px;
        border-top: 1px solid rgba(255,255,255,0.11);
    }

    .owner-working-hours-notes article {
        display: grid;
        grid-template-columns: 30px 1fr;
        gap: 10px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255,255,255,0.11);
    }

    .owner-working-hours-notes article > span {
        color: #bc9387;
        font-size: 0.54rem;
    }

    .owner-working-hours-notes strong {
        display: block;
        margin-bottom: 3px;
        color: #f2ebe7;
        font-size: 0.68rem;
        font-weight: 500;
    }

    .owner-working-hours-notes p {
        margin: 0;
        color: #a99d97;
        font-size: 0.6rem;
        line-height: 1.55;
    }

    .owner-working-hours-side-note {
        margin-top: auto;
        padding: 15px;
        background: rgba(215,180,168,0.1);
        border: 1px solid rgba(215,180,168,0.17);
    }

    .owner-working-hours-side-note span {
        display: block;
        margin-bottom: 6px;
        color: #c6a59a;
        font-size: 0.53rem;
        letter-spacing: 0.12em;
    }

    .owner-working-hours-side-note p {
        margin: 0;
        color: #bdb0aa;
        font-size: 0.61rem;
        line-height: 1.6;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .owner-working-hours-grid {
            grid-template-columns: 1fr;
        }

        .owner-working-hours-side {
            min-height: 400px;
        }

    }

    @media (max-width: 720px) {

        .owner-working-day {
            grid-template-columns: 1fr 1fr;
        }

        .owner-working-day-name,
        .owner-working-day-off {
            grid-column: 1 / -1;
        }

        .owner-working-day-off {
            justify-content: flex-start;
        }

    }

    @media (max-width: 575px) {

        .owner-working-hours-space {
            padding: 21px 0 32px;
        }

        .owner-working-hours-shell {
            width: calc(100% - 24px);
        }

        .owner-working-hours-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .owner-working-hours-card-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 6px;
        }

        .owner-working-hours-card-header > p {
            max-width: none;
            text-align: left;
        }

        .owner-working-day {
            grid-template-columns: 1fr;
            gap: 13px;
            padding: 17px 18px;
        }

        .owner-working-day-name,
        .owner-working-day-off {
            grid-column: auto;
        }

        .owner-working-hours-actions {
            align-items: stretch;
            flex-direction: column-reverse;
            padding: 16px 18px 19px;
        }

        .owner-working-hours-primary {
            width: 100%;
        }

        .owner-working-hours-secondary {
            align-self: center;
        }

        .owner-working-hours-side {
            padding: 25px 21px;
        }

    }

</style>
@endpush