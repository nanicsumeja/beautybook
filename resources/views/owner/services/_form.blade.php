@php
    $editing = isset($service);
@endphp

@if ($errors->any())
    <div class="service-form-errors">
        <strong>Please check the entered information.</strong>

        <span>
            {{ $errors->first() }}
        </span>
    </div>
@endif

<div class="service-form-grid">

    <div class="service-form-field service-form-field-wide">
        <label for="name">
            Service name
            <span>Required</span>
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old(
                'name',
                $editing ? $service->name : ''
            ) }}"
            placeholder="Service name"
            class="@error('name') is-invalid @enderror"
        >

        @error('name')
            <small class="service-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="service-form-field">
        <label for="price">
            Price
            <span>KM</span>
        </label>

        <div class="service-input-with-suffix">
            <input
                type="number"
                id="price"
                name="price"
                value="{{ old(
                    'price',
                    $editing ? $service->price : ''
                ) }}"
                min="0"
                step="0.01"
                placeholder="0.00"
                class="@error('price') is-invalid @enderror"
            >

            <span>KM</span>
        </div>

        @error('price')
            <small class="service-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="service-form-field">
        <label for="duration_minutes">
            Duration
            <span>Minutes</span>
        </label>

        <div class="service-input-with-suffix">
            <input
                type="number"
                id="duration_minutes"
                name="duration_minutes"
                value="{{ old(
                    'duration_minutes',
                    $editing
                        ? $service->duration_minutes
                        : ''
                ) }}"
                min="1"
                step="1"
                placeholder="30"
                class="@error('duration_minutes')
                    is-invalid
                @enderror"
            >

            <span>min</span>
        </div>

        @error('duration_minutes')
            <small class="service-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="service-form-field service-form-field-wide">
        <label for="description">
            Description
            <span>Optional</span>
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
            maxlength="1000"
            placeholder="Briefly describe the treatment and its benefits."
            class="@error('description') is-invalid @enderror"
        >{{ old(
            'description',
            $editing ? $service->description : ''
        ) }}</textarea>

        <div class="service-description-footer">
            <small>
                Keep the description clear and concise.
            </small>

            <small id="descriptionCounter">
                0 / 1000
            </small>
        </div>

        @error('description')
            <small class="service-field-error">
                {{ $message }}
            </small>
        @enderror
    </div>

</div>

<div class="service-availability">

    <div>
        <strong>Service availability</strong>

        <span>
            Active services are visible to clients.
        </span>
    </div>

    <label class="service-toggle">
        <input
            type="hidden"
            name="is_active"
            value="0"
        >

        <input
            type="checkbox"
            name="is_active"
            value="1"
            @checked(
                (bool) old(
                    'is_active',
                    $editing ? $service->is_active : true
                )
            )
        >

        <span class="service-toggle-track">
            <i></i>
        </span>

        <em>Active</em>
    </label>

</div>