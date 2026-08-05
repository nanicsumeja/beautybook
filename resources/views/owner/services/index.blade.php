@extends('layouts.app')

@section('body-class', 'salon-admin-page salon-services-page')
@section('main-class', 'salon-services-main')

@section('content')
@php
    $totalCount = $services->count();
    $activeCount = $services->where('is_active', true)->count();
    $inactiveCount = $totalCount - $activeCount;
@endphp

<div class="salon-services-shell">

    <section class="salon-services-panel">

        <header class="salon-services-header">
            <div>
                <p class="salon-services-eyebrow">
                    OWNER WORKSPACE
                </p>

                <h1>Services</h1>

                <p class="salon-services-description">
                    Manage treatments, pricing and availability.
                </p>
            </div>

            <a
                href="{{ route('owner.services.create') }}"
                class="salon-primary-action"
            >
                <span>+</span>
                Add service
            </a>
        </header>

        @if (session('success'))
            <div class="salon-success-message">
                <span>✓</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="salon-services-summary">
            <div>
                <span>Total services</span>
                <strong>{{ $totalCount }}</strong>
            </div>

            <div>
                <span>Active</span>
                <strong>{{ $activeCount }}</strong>
            </div>

            <div>
                <span>Inactive</span>
                <strong>{{ $inactiveCount }}</strong>
            </div>
        </div>

        <div class="salon-services-toolbar">

            <label
                class="salon-services-search"
                for="serviceSearch"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>

                <input
                    type="search"
                    id="serviceSearch"
                    placeholder="Search services"
                    autocomplete="off"
                >
            </label>

            <div class="salon-services-filters">
                <button
                    type="button"
                    class="active"
                    data-service-filter="all"
                >
                    All
                </button>

                <button
                    type="button"
                    data-service-filter="active"
                >
                    Active
                </button>

                <button
                    type="button"
                    data-service-filter="inactive"
                >
                    Inactive
                </button>
            </div>

        </div>

        @if ($services->isEmpty())

            <div class="salon-services-empty">
                <span class="salon-services-empty-icon">
                    +
                </span>

                <h2>No services yet</h2>

                <p>
                    Add the first treatment to your salon catalogue.
                </p>

                <a
                    href="{{ route('owner.services.create') }}"
                    class="salon-primary-action"
                >
                    Add first service
                </a>
            </div>

        @else

            <div class="salon-services-table">

                <div class="salon-services-table-head">
                    <span>Service</span>
                    <span>Price</span>
                    <span>Duration</span>
                    <span>Status</span>
                    <span>Actions</span>
                </div>

                <div
                    class="salon-services-table-body"
                    id="servicesTableBody"
                >
                    @foreach ($services as $service)

                        <article
                            class="salon-service-row"
                            data-service-row
                            data-status="{{ $service->is_active
                                ? 'active'
                                : 'inactive' }}"
                            data-search="{{ mb_strtolower(
                                $service->name . ' ' .
                                ($service->description ?? '')
                            ) }}"
                        >

                            <div class="salon-service-info">

                                <div class="salon-service-initial">
                                    {{ mb_strtoupper(
                                        mb_substr($service->name, 0, 1)
                                    ) }}
                                </div>

                                <div>
                                    <strong>
                                        {{ $service->name }}
                                    </strong>

                                    @if ($service->description)
                                        <p title="{{ $service->description }}">
                                            {{ $service->description }}
                                        </p>
                                    @else
                                        <p class="is-empty">
                                            No description
                                        </p>
                                    @endif
                                </div>

                            </div>

                            <div
                                class="salon-service-value"
                                data-label="Price"
                            >
                                <strong>
                                    {{ number_format(
                                        (float) $service->price,
                                        2
                                    ) }}
                                </strong>

                                <span>KM</span>
                            </div>

                            <div
                                class="salon-service-value"
                                data-label="Duration"
                            >
                                <strong>
                                    {{ $service->duration_minutes }}
                                </strong>

                                <span>min</span>
                            </div>

                            <div
                                class="salon-service-status-cell"
                                data-label="Status"
                            >
                                @if ($service->is_active)
                                    <span class="salon-service-status active">
                                        <i></i>
                                        Active
                                    </span>
                                @else
                                    <span class="salon-service-status inactive">
                                        <i></i>
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="salon-service-actions">

                                <a
                                    href="{{ route(
                                        'owner.services.edit',
                                        $service
                                    ) }}"
                                    class="salon-edit-action"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'owner.services.destroy',
                                        $service
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Are you sure you want to delete this service?'
                                    )"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="salon-delete-action"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </article>

                    @endforeach

                    <div
                        class="salon-services-no-results"
                        id="servicesNoResults"
                        hidden
                    >
                        No services match your search.
                    </div>

                </div>

                <footer class="salon-services-table-footer">
                    <span id="serviceResultCount">
                        Showing {{ $totalCount }}
                        {{ $totalCount === 1
                            ? 'service'
                            : 'services' }}
                    </span>

                    <a href="{{ route('owner.dashboard') }}">
                        Back to dashboard
                    </a>
                </footer>

            </div>

        @endif

    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.getElementById('serviceSearch');

    const rows = Array.from(
        document.querySelectorAll('[data-service-row]')
    );

    const filterButtons = Array.from(
        document.querySelectorAll('[data-service-filter]')
    );

    const resultCount =
        document.getElementById('serviceResultCount');

    const noResults =
        document.getElementById('servicesNoResults');

    if (!searchInput || rows.length === 0) {
        return;
    }

    let activeFilter = 'all';

    const updateServices = () => {
        const query = searchInput.value
            .trim()
            .toLowerCase();

        let visibleCount = 0;

        rows.forEach((row) => {
            const matchesSearch =
                row.dataset.search.includes(query);

            const matchesStatus =
                activeFilter === 'all'
                || row.dataset.status === activeFilter;

            const visible =
                matchesSearch && matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        if (resultCount) {
            resultCount.textContent =
                `Showing ${visibleCount} `
                + (visibleCount === 1
                    ? 'service'
                    : 'services');
        }

        if (noResults) {
            noResults.hidden = visibleCount !== 0;
        }
    };

    searchInput.addEventListener(
        'input',
        updateServices
    );

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter =
                button.dataset.serviceFilter;

            filterButtons.forEach((item) => {
                item.classList.toggle(
                    'active',
                    item === button
                );
            });

            updateServices();
        });
    });
});
</script>
@endsection