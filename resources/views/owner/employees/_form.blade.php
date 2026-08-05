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
        is_array($selectedServices)
            ? $selectedServices
            : []
    );
@endphp

<div class="employee-form-grid">

    <div class="employee-form-field">
        <label for="name">
            <span>First name</span>
            <small>Required</small>
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old(
                'name',
                $editing ? $employee->name : ''
            ) }}"
            autocomplete="given-name"
            class="@error('name') is-invalid @enderror"
        >

        @error('name')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field">
        <label for="surname">
            <span>Last name</span>
            <small>Required</small>
        </label>

        <input
            type="text"
            id="surname"
            name="surname"
            value="{{ old(
                'surname',
                $editing ? $employee->surname : ''
            ) }}"
            autocomplete="family-name"
            class="@error('surname') is-invalid @enderror"
        >

        @error('surname')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field">
        <label for="username">
            <span>Username</span>
            <small>Required</small>
        </label>

        <input
            type="text"
            id="username"
            name="username"
            value="{{ old(
                'username',
                $editing ? $employee->username : ''
            ) }}"
            autocomplete="username"
            class="@error('username') is-invalid @enderror"
        >

        @error('username')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field">
        <label for="email">
            <span>Email</span>
            <small>Required</small>
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old(
                'email',
                $editing ? $employee->email : ''
            ) }}"
            autocomplete="email"
            class="@error('email') is-invalid @enderror"
        >

        @error('email')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field employee-phone-field">
        <label for="phone">
            <span>Phone</span>
            <small>Optional</small>
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            value="{{ old(
                'phone',
                $editing ? $employee->phone : ''
            ) }}"
            autocomplete="tel"
            class="@error('phone') is-invalid @enderror"
        >

        @error('phone')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field">
        <label for="password">
            <span>
                {{ $editing ? 'New password' : 'Password' }}
            </span>

            <small>
                {{ $editing ? 'Optional' : 'Required' }}
            </small>
        </label>

        <input
            type="password"
            id="password"
            name="password"
            autocomplete="new-password"
            class="@error('password') is-invalid @enderror"
        >

        @error('password')
            <small class="employee-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="employee-form-field">
        <label for="password_confirmation">
            <span>Confirm password</span>
            <small>
                {{ $editing ? 'If changed' : 'Required' }}
            </small>
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            autocomplete="new-password"
        >
    </div>

</div>

<section class="employee-services-section">

    <div class="employee-section-heading">
        <div>
            <strong>Assigned services</strong>

            <span>
                Choose the treatments this employee provides.
            </span>
        </div>

        <small>
            {{ count($selectedServices) }} selected
        </small>
    </div>

    @if ($services->isEmpty())

        <div class="employee-services-empty">
            No services have been created yet.
        </div>

    @else

        <div class="employee-services-grid">

            @foreach ($services as $service)

                <label
                    for="service_{{ $service->id }}"
                    class="employee-service-option"
                >
                    <input
                        type="checkbox"
                        id="service_{{ $service->id }}"
                        name="service_ids[]"
                        value="{{ $service->id }}"
                        @checked(
                            in_array(
                                $service->id,
                                $selectedServices,
                                true
                            )
                        )
                    >

                    <span class="employee-service-check">
                        ✓
                    </span>

                    <span class="employee-service-name">
                        {{ $service->name }}

                        @unless ($service->is_active)
                            <small>Inactive</small>
                        @endunless
                    </span>
                </label>

            @endforeach

        </div>

    @endif

    @error('service_ids')
        <small class="employee-field-error">
            {{ $message }}
        </small>
    @enderror

    @error('service_ids.*')
        <small class="employee-field-error">
            {{ $message }}
        </small>
    @enderror

</section>

<div class="employee-access-row">

    <div>
        <strong>Account access</strong>

        <span>
            Active employees can sign in to their account.
        </span>
    </div>

    <label class="employee-access-toggle">

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
            @checked(
                (bool) old(
                    'is_active',
                    $editing ? $employee->is_active : true
                )
            )
        >

        <span class="employee-toggle-track">
            <i></i>
        </span>

        <em>Active</em>

    </label>

</div>