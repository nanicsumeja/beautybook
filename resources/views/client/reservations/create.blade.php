@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 760px;">

    <div class="d-flex justify-content-between align-items-start mb-5">
        <div>
            <p class="text-muted text-uppercase small mb-2">
                Book appointment
            </p>

            <h1 class="display-6 fw-light mb-2">
                {{ $service->name }}
            </h1>

            <p class="text-muted mb-0">
                {{ $service->duration_minutes }} minutes
                ·
                {{ number_format((float) $service->price, 2) }} KM
            </p>
        </div>

        <a
            href="{{ route('client.services.index') }}"
            class="btn btn-outline-dark"
        >
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

            <form
                method="POST"
                action="{{ route(
                    'client.reservations.store',
                    $service
                ) }}"
                novalidate
            >
                @csrf

                <div class="mb-4">
                    <label
                        for="appointment_date"
                        class="form-label"
                    >
                        Appointment date
                    </label>

                    <input
                        type="date"
                        id="appointment_date"
                        name="appointment_date"
                        min="{{ now()->toDateString() }}"
                        value="{{ old('appointment_date') }}"
                        class="form-control
                            @error('appointment_date')
                                is-invalid
                            @enderror"
                    >

                    @error('appointment_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="start_time"
                        class="form-label"
                    >
                        Start time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        step="900"
                        value="{{ old('start_time') }}"
                        class="form-control
                            @error('start_time')
                                is-invalid
                            @enderror"
                    >

                    @error('start_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">
                        Notes
                        <span class="text-muted">(optional)</span>
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        class="form-control
                            @error('notes')
                                is-invalid
                            @enderror"
                        placeholder="Add any useful information..."
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn btn-dark px-4 py-3"
                >
                    Continue with booking
                </button>

            </form>

        </div>
    </div>

</div>
@endsection