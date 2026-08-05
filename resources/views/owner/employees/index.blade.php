@extends('layouts.app')

@section(
    'body-class',
    'salon-admin-page salon-employees-page'
)

@section('main-class', 'salon-employees-main')

@section('content')
@php
    $totalCount = $employees->count();

    $activeCount = $employees
        ->where('is_active', true)
        ->count();

    $inactiveCount = $totalCount - $activeCount;
@endphp

<div class="salon-employees-shell">

    <section class="salon-employees-panel">

        <header class="salon-employees-header">

            <div>
                <p class="salon-employees-eyebrow">
                    OWNER WORKSPACE
                </p>

                <h1>Employees</h1>

                <p class="salon-employees-description">
                    Manage employee accounts and assigned services.
                </p>
            </div>

            <a
                href="{{ route('owner.employees.create') }}"
                class="salon-employees-primary-action"
            >
                <span aria-hidden="true">+</span>
                Add employee
            </a>

        </header>

        @if (session('success'))
            <div class="salon-employees-message">
                <span aria-hidden="true">✓</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="salon-employees-summary">

            <div>
                <span>Total employees</span>
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

        <div class="salon-employees-toolbar">

            <label
                for="employeeSearch"
                class="salon-employees-search"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>

                <input
                    type="search"
                    id="employeeSearch"
                    placeholder="Search employees"
                    autocomplete="off"
                >
            </label>

            <div class="salon-employees-filters">

                <button
                    type="button"
                    class="active"
                    data-employee-filter="all"
                    aria-pressed="true"
                >
                    All
                </button>

                <button
                    type="button"
                    data-employee-filter="active"
                    aria-pressed="false"
                >
                    Active
                </button>

                <button
                    type="button"
                    data-employee-filter="inactive"
                    aria-pressed="false"
                >
                    Inactive
                </button>

            </div>

        </div>

        @if ($employees->isEmpty())

            <div class="salon-employees-empty">

                <span>+</span>

                <h2>No employees yet</h2>

                <p>
                    Add the first salon employee.
                </p>

                <a
                    href="{{ route('owner.employees.create') }}"
                    class="salon-employees-primary-action"
                >
                    Add employee
                </a>

            </div>

        @else

            <div class="salon-employees-table">

                <div class="salon-employees-table-head">
                    <span>Employee</span>
                    <span>Contact</span>
                    <span>Services</span>
                    <span>Status</span>
                    <span>Action</span>
                </div>

                <div class="salon-employees-table-body">

                    @foreach ($employees as $employee)
                        @php
                            $employeeName =
                                $employee->name
                                . ' '
                                . $employee->surname;

                            $servicesText =
                                $employee->services
                                    ->pluck('name')
                                    ->implode(' ');

                            $searchValue = mb_strtolower(
                                $employeeName
                                . ' '
                                . $employee->username
                                . ' '
                                . $employee->email
                                . ' '
                                . ($employee->phone ?? '')
                                . ' '
                                . $servicesText
                            );
                        @endphp

                        <article
                            class="salon-employee-row"
                            data-employee-row
                            data-status="{{
                                $employee->is_active
                                    ? 'active'
                                    : 'inactive'
                            }}"
                            data-search="{{ $searchValue }}"
                        >

                            <div class="salon-employee-identity">

                                <span class="salon-employee-avatar">
                                    {{ mb_strtoupper(
                                        mb_substr(
                                            $employee->name,
                                            0,
                                            1
                                        )
                                    ) }}
                                </span>

                                <div>
                                    <strong>
                                        {{ $employeeName }}
                                    </strong>

                                    <small>
                                        {{ '@' . $employee->username }}
                                    </small>
                                </div>

                            </div>

                            <div
                                class="salon-employee-contact"
                                data-label="Contact"
                            >
                                <strong>
                                    {{ $employee->email }}
                                </strong>

                                <small>
                                    {{ $employee->phone
                                        ?: 'No phone number' }}
                                </small>
                            </div>

                            <div
                                class="salon-employee-services"
                                data-label="Services"
                            >
                                @forelse (
                                    $employee->services
                                    as $service
                                )
                                    <span>
                                        {{ $service->name }}
                                    </span>
                                @empty
                                    <small>
                                        No services assigned
                                    </small>
                                @endforelse
                            </div>

                            <div
                                class="salon-employee-status-cell"
                                data-label="Status"
                            >
                                @if ($employee->is_active)
                                    <span class="salon-employee-status active">
                                        <i></i>
                                        Active
                                    </span>
                                @else
                                    <span class="salon-employee-status inactive">
                                        <i></i>
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="salon-employee-action">

                                <a
                                    href="{{ route(
                                        'owner.employees.edit',
                                        $employee
                                    ) }}"
                                >
                                    Edit
                                </a>

                            </div>

                        </article>

                    @endforeach

                    <div
                        class="salon-employees-no-results"
                        id="employeesNoResults"
                        hidden
                    >
                        No employees match your search.
                    </div>

                </div>

                <footer class="salon-employees-table-footer">

                    <span id="employeeResultCount">
                        Showing {{ $totalCount }}
                        {{ $totalCount === 1
                            ? 'employee'
                            : 'employees' }}
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
        document.getElementById('employeeSearch');

    const rows = Array.from(
        document.querySelectorAll('[data-employee-row]')
    );

    const buttons = Array.from(
        document.querySelectorAll(
            '[data-employee-filter]'
        )
    );

    const resultCount =
        document.getElementById('employeeResultCount');

    const noResults =
        document.getElementById('employeesNoResults');

    if (!searchInput || rows.length === 0) {
        return;
    }

    let activeFilter = 'all';

    const updateEmployees = () => {
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
                + (
                    visibleCount === 1
                        ? 'employee'
                        : 'employees'
                );
        }

        if (noResults) {
            noResults.hidden = visibleCount !== 0;
        }
    };

    searchInput.addEventListener(
        'input',
        updateEmployees
    );

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter =
                button.dataset.employeeFilter;

            buttons.forEach((item) => {
                const isActive = item === button;

                item.classList.toggle(
                    'active',
                    isActive
                );

                item.setAttribute(
                    'aria-pressed',
                    String(isActive)
                );
            });

            updateEmployees();
        });
    });
});
</script>
@endsection