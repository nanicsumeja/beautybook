@extends('layouts.app')

@section(
    'body-class',
    'salon-admin-page salon-service-form-page'
)

@section('main-class', 'salon-service-form-main')

@section('content')
<div class="service-form-shell">

    <section class="service-form-panel">

        <header class="service-form-header">

            <div>
                <p>OWNER WORKSPACE</p>

                <h1>Edit service</h1>

                <span>
                    Update treatment details and availability.
                </span>
            </div>

            <a
                href="{{ route('owner.services.index') }}"
                class="service-form-back"
            >
                ← Services
            </a>

        </header>

        <div class="service-edit-context">
            <span>
                Editing
            </span>

            <strong>
                {{ $service->name }}
            </strong>

            <em class="{{
                $service->is_active
                    ? 'is-active'
                    : 'is-inactive'
            }}">
                {{ $service->is_active
                    ? 'Active'
                    : 'Inactive' }}
            </em>
        </div>

        <form
            method="POST"
            action="{{ route(
                'owner.services.update',
                $service
            ) }}"
            class="service-form"
            novalidate
        >
            @csrf
            @method('PUT')

            <div class="service-form-content">
                @include('owner.services._form')
            </div>

            <footer class="service-form-actions">

                <a
                    href="{{ route('owner.services.index') }}"
                    class="service-secondary-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="service-primary-button"
                >
                    Save changes
                </button>

            </footer>

        </form>

    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const description =
        document.getElementById('description');

    const counter =
        document.getElementById('descriptionCounter');

    if (!description || !counter) {
        return;
    }

    const updateCounter = () => {
        counter.textContent =
            `${description.value.length} / 1000`;
    };

    description.addEventListener(
        'input',
        updateCounter
    );

    updateCounter();
});
</script>
@endsection