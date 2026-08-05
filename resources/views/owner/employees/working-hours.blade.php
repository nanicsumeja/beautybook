@extends('layouts.app')
@section(
    'body-class',
    'salon-admin-page salon-working-hours-page'
)

@section(
    'main-class',
    'salon-working-hours-main'
)
@section('content')
<div class="container py-4 working-hours-page">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <p class="text-uppercase small mb-1">
                Employee schedule
            </p>

            <h1 class="mb-1">
                Working hours
            </h1>

            <p class="text-muted mb-0">
                {{ $employee->name }} {{ $employee->surname }}
            </p>
        </div>

        <a
            href="{{ route('owner.employees.index') }}"
            class="btn btn-outline-dark"
        >
            Back to employees
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            Please check the entered working hours.
        </div>
    @endif

    <form
        method="POST"
        action="{{ route(
            'owner.employees.working-hours.update',
            $employee
        ) }}"
    >
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <div class="working-hours-list">

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

                        <div
                            class="working-hours-row border-bottom py-3"
                            data-working-day
                        >
                            <input
                                type="hidden"
                                name="days[{{ $index }}][day_of_week]"
                                value="{{ $dayNumber }}"
                            >

                            <div class="row align-items-center g-3">

                                <div class="col-md-3">
                                    <strong>
                                        {{ $dayName }}
                                    </strong>
                                </div>

                                <div class="col-md-3">
                                    <label
                                        class="form-label small"
                                        for="start_time_{{ $dayNumber }}"
                                    >
                                        Start time
                                    </label>

                                    <input
                                        type="time"
                                        id="start_time_{{ $dayNumber }}"
                                        name="days[{{ $index }}][start_time]"
                                        value="{{ $startTime }}"
                                        class="form-control
                                            @error(
                                                "days.$index.start_time"
                                            )
                                                is-invalid
                                            @enderror"
                                        data-start-time
                                        @disabled($isDayOff)
                                    >

                                    @error("days.$index.start_time")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label
                                        class="form-label small"
                                        for="end_time_{{ $dayNumber }}"
                                    >
                                        End time
                                    </label>

                                    <input
                                        type="time"
                                        id="end_time_{{ $dayNumber }}"
                                        name="days[{{ $index }}][end_time]"
                                        value="{{ $endTime }}"
                                        class="form-control
                                            @error(
                                                "days.$index.end_time"
                                            )
                                                is-invalid
                                            @enderror"
                                        data-end-time
                                        @disabled($isDayOff)
                                    >

                                    @error("days.$index.end_time")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <input
                                        type="hidden"
                                        name="days[{{ $index }}][is_day_off]"
                                        value="0"
                                    >

                                    <div class="form-check mt-md-4">
                                        <input
                                            type="checkbox"
                                            id="day_off_{{ $dayNumber }}"
                                            name="days[{{ $index }}][is_day_off]"
                                            value="1"
                                            class="form-check-input"
                                            data-day-off
                                            @checked($isDayOff)
                                        >

                                        <label
                                            class="form-check-label"
                                            for="day_off_{{ $dayNumber }}"
                                        >
                                            Day off
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a
                        href="{{ route('owner.employees.index') }}"
                        class="btn btn-light"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-dark px-4"
                    >
                        Save working hours
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

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