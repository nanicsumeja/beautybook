@php
    $editing = isset($employee);

    $selectedServices = old(
        'service_ids',
        $editing
            ? $employee->services->pluck('id')->toArray()
            : []
    );

    $selectedServices = array_map(
        'intval',
        $selectedServices
    );
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">
            First name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old(
                'name',
                $editing ? $employee->name : ''
            ) }}"
            class="form-control
                @error('name') is-invalid @enderror"
        >

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="surname" class="form-label">
            Last name
        </label>

        <input
            type="text"
            id="surname"
            name="surname"
            value="{{ old(
                'surname',
                $editing ? $employee->surname : ''
            ) }}"
            class="form-control
                @error('surname') is-invalid @enderror"
        >

        @error('surname')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="username" class="form-label">
            Username
        </label>

        <input
            type="text"
            id="username"
            name="username"
            value="{{ old(
                'username',
                $editing ? $employee->username : ''
            ) }}"
            class="form-control
                @error('username') is-invalid @enderror"
        >

        @error('username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old(
                'email',
                $editing ? $employee->email : ''
            ) }}"
            class="form-control
                @error('email') is-invalid @enderror"
        >

        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="phone" class="form-label">
        Phone
    </label>

    <input
        type="text"
        id="phone"
        name="phone"
        value="{{ old(
            'phone',
            $editing ? $employee->phone : ''
        ) }}"
        class="form-control
            @error('phone') is-invalid @enderror"
    >

    @error('phone')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="password" class="form-label">
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            class="form-control
                @error('password') is-invalid @enderror"
        >

        @if ($editing)
            <div class="form-text">
                Leave blank to keep the current password.
            </div>
        @endif

        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label
            for="password_confirmation"
            class="form-label"
        >
            Confirm password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
        >
    </div>
</div>

<div class="mb-4">
    <p class="form-label mb-2">
        Services
    </p>

    @if ($services->isEmpty())
        <p class="text-muted small mb-0">
            No services have been created yet.
        </p>
    @else
        <div class="row g-2">
            @foreach ($services as $service)
                <div class="col-md-6">
                    <div class="form-check border rounded p-3 ps-5">
                        <input
                            type="checkbox"
                            id="service_{{ $service->id }}"
                            name="service_ids[]"
                            value="{{ $service->id }}"
                            class="form-check-input"
                            @checked(
                                in_array(
                                    $service->id,
                                    $selectedServices,
                                    true
                                )
                            )
                        >

                        <label
                            for="service_{{ $service->id }}"
                            class="form-check-label"
                        >
                            {{ $service->name }}

                            @unless ($service->is_active)
                                <span class="text-muted">
                                    (inactive)
                                </span>
                            @endunless
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @error('service_ids')
        <div class="text-danger small mt-2">
            {{ $message }}
        </div>
    @enderror

    @error('service_ids.*')
        <div class="text-danger small mt-2">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-check mb-4">
    <input
        type="hidden"
        name="is_active"
        value="0"
    >

    <input
        type="checkbox"
        id="is_active"
        name="is_active"
        value="1"
        class="form-check-input"
        @checked(
            (bool) old(
                'is_active',
                $editing ? $employee->is_active : true
            )
        )
    >

    <label for="is_active" class="form-check-label">
        Employee is active and can sign in
    </label>
</div>