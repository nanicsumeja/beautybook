@php
    $editing = isset($service);
@endphp

<div class="mb-3">
    <label for="name" class="form-label">Service name</label>

    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name', $editing ? $service->name : '') }}"
        class="form-control @error('name') is-invalid @enderror"
    >

    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>

    <textarea
        id="description"
        name="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
    >{{ old('description', $editing ? $service->description : '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price (KM)</label>

        <input
            type="number"
            id="price"
            name="price"
            step="0.01"
            min="0"
            value="{{ old('price', $editing ? $service->price : '') }}"
            class="form-control @error('price') is-invalid @enderror"
        >

        @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="duration_minutes" class="form-label">
            Duration in minutes
        </label>

        <input
            type="number"
            id="duration_minutes"
            name="duration_minutes"
            min="5"
            step="5"
            value="{{ old(
                'duration_minutes',
                $editing ? $service->duration_minutes : ''
            ) }}"
            class="form-control @error('duration_minutes') is-invalid @enderror"
        >

        @error('duration_minutes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
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
                $editing ? $service->is_active : true
            )
        )
    >

    <label for="is_active" class="form-check-label">
        Service is active and visible to clients
    </label>
</div>