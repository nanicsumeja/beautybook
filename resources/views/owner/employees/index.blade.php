@extends('layouts.app')

@section('body-class', 'owner-employees-page')
@section('main-class', 'owner-employees-main')

@section('content')

@php
    $totalCount = $employees->count();

    $activeCount = $employees
        ->where('is_active', true)
        ->count();

    $inactiveCount = $totalCount - $activeCount;
@endphp


<section class="owner-employees-space">

    <div class="owner-employees-shell">

        {{-- HEADER --}}
        <header class="owner-employees-header">

            <div>
                <span class="owner-employees-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>Employees</h1>

                <p>
                    Manage employee accounts, services and availability.
                </p>
            </div>


            <div class="owner-employees-header-actions">

                <a
                    href="{{ route('owner.dashboard') }}"
                    class="owner-employees-dashboard-link"
                >
                    DASHBOARD
                </a>

                <a
                    href="{{ route('owner.employees.create') }}"
                    class="owner-employees-add"
                >
                    <span>ADD EMPLOYEE</span>
                    <span>+</span>
                </a>

            </div>

        </header>


        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="owner-employees-message">
                <span>✓</span>

                <p>
                    {{ session('success') }}
                </p>
            </div>
        @endif


        {{-- SUMMARY --}}
        <div class="owner-employees-summary">

            <article>
                <span>TOTAL EMPLOYEES</span>

                <strong>
                    {{ $totalCount }}
                </strong>

                <p>
                    Registered staff members
                </p>
            </article>

            <article>
                <span>ACTIVE</span>

                <strong>
                    {{ $activeCount }}
                </strong>

                <p>
                    Currently available staff
                </p>
            </article>

            <article>
                <span>INACTIVE</span>

                <strong>
                    {{ $inactiveCount }}
                </strong>

                <p>
                    Not available for bookings
                </p>
            </article>

        </div>


        {{-- TOOLBAR --}}
        <div class="owner-employees-toolbar">

            <label
                for="employeeSearch"
                class="owner-employees-search"
            >

                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <circle
                        cx="11"
                        cy="11"
                        r="6.5"
                    ></circle>

                    <path d="M16 16L21 21"></path>
                </svg>

                <input
                    type="search"
                    id="employeeSearch"
                    placeholder="Search by name, email, phone or service"
                    autocomplete="off"
                >

            </label>


            <div class="owner-employees-filters">

                <button
                    type="button"
                    class="active"
                    data-employee-filter="all"
                    aria-pressed="true"
                >
                    ALL
                </button>

                <button
                    type="button"
                    data-employee-filter="active"
                    aria-pressed="false"
                >
                    ACTIVE
                </button>

                <button
                    type="button"
                    data-employee-filter="inactive"
                    aria-pressed="false"
                >
                    INACTIVE
                </button>

            </div>

        </div>


        @if ($employees->isEmpty())

            {{-- EMPTY STATE --}}
            <section class="owner-employees-empty">

                <span class="owner-employees-empty-icon">
                    +
                </span>

                <span class="owner-employees-empty-eyebrow">
                    TEAM DIRECTORY
                </span>

                <h2>No employees yet</h2>

                <p>
                    Add the first employee to start building
                    your salon team.
                </p>

                <a
                    href="{{ route('owner.employees.create') }}"
                    class="owner-employees-add"
                >
                    <span>ADD EMPLOYEE</span>
                    <span>+</span>
                </a>

            </section>

        @else

            {{-- DIRECTORY --}}
            <section class="owner-employees-directory">

                <header class="owner-employees-directory-header">

                    <div>
                        <span>TEAM DIRECTORY</span>

                        <h2>
                            Staff overview
                        </h2>
                    </div>

                    <p>
                        Employee profiles & assigned services
                    </p>

                </header>


                <div class="owner-employees-list">

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
                            class="owner-employee-card"
                            data-employee-row
                            data-status="{{
                                $employee->is_active
                                    ? 'active'
                                    : 'inactive'
                            }}"
                            data-search="{{ $searchValue }}"
                        >

                            {{-- IDENTITY --}}
                            <div class="owner-employee-identity">

                                <span class="owner-employee-avatar">
                                    {{
                                        mb_strtoupper(
                                            mb_substr(
                                                $employee->name,
                                                0,
                                                1
                                            )
                                        )
                                    }}
                                </span>

                                <div>
                                    <span class="owner-employee-label">
                                        EMPLOYEE
                                    </span>

                                    <h3>
                                        {{ $employeeName }}
                                    </h3>

                                    <p>
                                        {{ '@' . $employee->username }}
                                    </p>
                                </div>

                            </div>


                            {{-- CONTACT --}}
                            <div class="owner-employee-info">

                                <span>
                                    CONTACT
                                </span>

                                <strong>
                                    {{ $employee->email }}
                                </strong>

                                <p>
                                    {{
                                        $employee->phone
                                            ?: 'No phone number'
                                    }}
                                </p>

                            </div>


                            {{-- SERVICES --}}
                            <div class="owner-employee-services">

                                <span class="owner-employee-section-label">
                                    SERVICES
                                </span>

                                <div class="owner-employee-service-tags">

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

                            </div>


                            {{-- STATUS --}}
                            <div class="owner-employee-status-wrap">

                                <span class="owner-employee-section-label">
                                    STATUS
                                </span>

                                @if ($employee->is_active)

                                    <span class="owner-employee-status active">
                                        <i></i>
                                        ACTIVE
                                    </span>

                                @else

                                    <span class="owner-employee-status inactive">
                                        <i></i>
                                        INACTIVE
                                    </span>

                                @endif

                            </div>


                            {{-- ACTIONS --}}
                            <div class="owner-employee-actions">

                                <a
                                    href="{{ route(
                                        'owner.employees.working-hours.edit',
                                        $employee
                                    ) }}"
                                >
                                    <span>WORKING HOURS</span>
                                    <span>→</span>
                                </a>

                                <a
                                    href="{{ route(
                                        'owner.employees.edit',
                                        $employee
                                    ) }}"
                                >
                                    <span>EDIT PROFILE</span>
                                    <span>→</span>
                                </a>

                            </div>

                        </article>

                    @endforeach


                    <div
                        class="owner-employees-no-results"
                        id="employeesNoResults"
                        hidden
                    >

                        <span>NO MATCHES</span>

                        <strong>
                            No employees found
                        </strong>

                        <p>
                            Try another search term or status filter.
                        </p>

                    </div>

                </div>


                <footer class="owner-employees-directory-footer">

                    <span id="employeeResultCount">
                        Showing {{ $totalCount }}
                        {{
                            $totalCount === 1
                                ? 'employee'
                                : 'employees'
                        }}
                    </span>

                    <a href="{{ route('owner.dashboard') }}">
                        BACK TO DASHBOARD
                    </a>

                </footer>

            </section>

        @endif

    </div>

</section>


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


@push('styles')
<style>

    /* PAGE */

    .owner-employees-page,
    .owner-employees-main {
        background: #f3efea;
    }

    .owner-employees-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 42px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190, 151, 140, 0.13),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-employees-shell {
        width: min(1120px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-employees-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 28px;
        margin-bottom: 19px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-employees-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-employees-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-employees-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.69rem;
    }

    .owner-employees-header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .owner-employees-dashboard-link {
        color: #6f655f;
        text-decoration: none;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-employees-dashboard-link:hover {
        color: #211d1a;
    }

    .owner-employees-add {
        min-width: 155px;
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 14px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        text-decoration: none;
        font-size: 0.41rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-employees-add:hover {
        background: #9d7063;
        border-color: #9d7063;
        color: #fff;
    }

    .owner-employees-add span:last-child {
        font-size: 0.78rem;
        font-weight: 300;
    }


    /* SUCCESS */

    .owner-employees-message {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 17px;
        padding: 11px 14px;
        border: 1px solid rgba(92,107,89,0.18);
        background: #e3e9e0;
        color: #596555;
    }

    .owner-employees-message > span {
        width: 19px;
        height: 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(92,107,89,0.3);
        border-radius: 50%;
        font-size: 0.45rem;
    }

    .owner-employees-message p {
        margin: 0;
        font-size: 0.52rem;
    }


    /* SUMMARY */

    .owner-employees-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin-bottom: 16px;
        border: 1px solid rgba(33,29,26,0.08);
        background: #faf7f3;
    }

    .owner-employees-summary article {
        position: relative;
        min-height: 112px;
        padding: 18px 20px;
        border-right: 1px solid rgba(33,29,26,0.08);
    }

    .owner-employees-summary article:last-child {
        border-right: 0;
    }

    .owner-employees-summary span {
        display: block;
        margin-bottom: 7px;
        color: #9e796d;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .owner-employees-summary strong {
        display: block;
        margin-bottom: 6px;
        font-size: 1.65rem;
        font-weight: 300;
        letter-spacing: -0.04em;
    }

    .owner-employees-summary p {
        margin: 0;
        color: #968a83;
        font-size: 0.46rem;
    }


    /* TOOLBAR */

    .owner-employees-toolbar {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 14px;
        margin-bottom: 16px;
    }

    .owner-employees-search {
        min-height: 44px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 14px;
        border: 1px solid rgba(33,29,26,0.11);
        background: #faf7f3;
    }

    .owner-employees-search svg {
        width: 15px;
        height: 15px;
        fill: none;
        stroke: #8e8179;
        stroke-width: 1.4;
    }

    .owner-employees-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.56rem;
    }

    .owner-employees-search input::placeholder {
        color: #a49993;
    }

    .owner-employees-filters {
        display: flex;
        align-items: stretch;
        border: 1px solid rgba(33,29,26,0.11);
        background: #faf7f3;
    }

    .owner-employees-filters button {
        min-width: 78px;
        padding: 0 13px;
        border: 0;
        border-right: 1px solid rgba(33,29,26,0.09);
        background: transparent;
        color: #8a7e77;
        font-family: inherit;
        font-size: 0.39rem;
        font-weight: 500;
        letter-spacing: 0.09em;
        cursor: pointer;
    }

    .owner-employees-filters button:last-child {
        border-right: 0;
    }

    .owner-employees-filters button.active {
        background: #211d1a;
        color: #fff;
    }


    /* DIRECTORY */

    .owner-employees-directory {
        border: 1px solid rgba(33,29,26,0.08);
        background: #faf7f3;
    }

    .owner-employees-directory-header {
        min-height: 76px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-employees-directory-header span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .owner-employees-directory-header h2 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 300;
    }

    .owner-employees-directory-header > p {
        margin: 0;
        color: #9b8f88;
        font-size: 0.45rem;
    }


    /* EMPLOYEE CARD */

    .owner-employee-card {
        display: grid;
        grid-template-columns:
            1.25fr
            1.2fr
            1.45fr
            0.65fr
            0.9fr;
        gap: 18px;
        align-items: center;
        min-height: 120px;
        padding: 18px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.085);
        transition: background 0.15s ease;
    }

    .owner-employee-card:hover {
        background: #f6f0eb;
    }

    .owner-employee-card[hidden] {
        display: none !important;
    }


    /* IDENTITY */

    .owner-employee-identity {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .owner-employee-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5d8d1;
        color: #795f56;
        font-size: 0.78rem;
        font-weight: 400;
    }

    .owner-employee-label,
    .owner-employee-section-label,
    .owner-employee-info > span {
        display: block;
        margin-bottom: 4px;
        color: #a1877d;
        font-size: 0.36rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-employee-identity h3 {
        overflow: hidden;
        margin: 0 0 3px;
        color: #29231f;
        font-size: 0.66rem;
        font-weight: 500;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .owner-employee-identity p {
        margin: 0;
        color: #978b84;
        font-size: 0.43rem;
    }


    /* CONTACT */

    .owner-employee-info {
        min-width: 0;
    }

    .owner-employee-info strong {
        display: block;
        overflow: hidden;
        margin-bottom: 4px;
        color: #5e5550;
        font-size: 0.5rem;
        font-weight: 500;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .owner-employee-info p {
        margin: 0;
        color: #978b84;
        font-size: 0.43rem;
    }


    /* SERVICES */

    .owner-employee-services {
        min-width: 0;
    }

    .owner-employee-service-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .owner-employee-service-tags > span {
        display: inline-flex;
        align-items: center;
        min-height: 23px;
        padding: 4px 7px;
        background: #eee4de;
        color: #725f57;
        font-size: 0.37rem;
        line-height: 1.25;
    }

    .owner-employee-service-tags small {
        color: #a19690;
        font-size: 0.42rem;
    }


    /* STATUS */

    .owner-employee-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.38rem;
        font-weight: 500;
        letter-spacing: 0.08em;
    }

    .owner-employee-status i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .owner-employee-status.active {
        color: #61705e;
    }

    .owner-employee-status.active i {
        background: #7f947a;
    }

    .owner-employee-status.inactive {
        color: #93685f;
    }

    .owner-employee-status.inactive i {
        background: #b77b70;
    }


    /* ACTIONS */

    .owner-employee-actions {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 6px;
    }

    .owner-employee-actions a {
        min-height: 29px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 0 9px;
        border: 1px solid rgba(33,29,26,0.13);
        color: #5e5550;
        text-decoration: none;
        font-size: 0.34rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        transition:
            background 0.15s ease,
            color 0.15s ease;
    }

    .owner-employee-actions a:hover {
        background: #211d1a;
        color: #fff;
    }

    .owner-employee-actions a span:last-child {
        font-size: 0.55rem;
    }


    /* FOOTER */

    .owner-employees-directory-footer {
        min-height: 51px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 20px;
        background: #eee5df;
    }

    .owner-employees-directory-footer > span {
        color: #847871;
        font-size: 0.43rem;
    }

    .owner-employees-directory-footer a {
        color: #5d544f;
        text-decoration: none;
        font-size: 0.38rem;
        font-weight: 500;
        letter-spacing: 0.09em;
    }


    /* NO RESULTS */

    .owner-employees-no-results {
        padding: 42px 20px;
        text-align: center;
    }

    .owner-employees-no-results > span {
        display: block;
        margin-bottom: 6px;
        color: #a17d71;
        font-size: 0.4rem;
        letter-spacing: 0.12em;
    }

    .owner-employees-no-results strong {
        display: block;
        margin-bottom: 5px;
        font-size: 0.75rem;
        font-weight: 400;
    }

    .owner-employees-no-results p {
        margin: 0;
        color: #958a84;
        font-size: 0.45rem;
    }


    /* EMPTY */

    .owner-employees-empty {
        display: flex;
        min-height: 390px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 35px;
        border: 1px solid rgba(33,29,26,0.08);
        background: #faf7f3;
        text-align: center;
    }

    .owner-employees-empty-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 17px;
        background: #e8ddd7;
        color: #8b6a60;
        font-size: 1.25rem;
        font-weight: 300;
    }

    .owner-employees-empty-eyebrow {
        margin-bottom: 7px;
        color: #a17a6e;
        font-size: 0.4rem;
        letter-spacing: 0.13em;
    }

    .owner-employees-empty h2 {
        margin: 0 0 6px;
        font-size: 1.35rem;
        font-weight: 300;
    }

    .owner-employees-empty p {
        max-width: 300px;
        margin: 0 0 18px;
        color: #8e837d;
        font-size: 0.52rem;
        line-height: 1.6;
    }


    /* RESPONSIVE */

    @media (max-width: 1020px) {

        .owner-employee-card {
            grid-template-columns:
                1.25fr
                1.15fr
                1.35fr
                0.65fr;
        }

        .owner-employee-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: flex-end;
        }

        .owner-employee-actions a {
            min-width: 130px;
        }

    }


    @media (max-width: 790px) {

        .owner-employees-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-employees-header-actions {
            width: 100%;
            justify-content: space-between;
        }

        .owner-employees-summary {
            grid-template-columns: 1fr;
        }

        .owner-employees-summary article {
            min-height: auto;
            border-right: 0;
            border-bottom: 1px solid rgba(33,29,26,0.08);
        }

        .owner-employees-summary article:last-child {
            border-bottom: 0;
        }

        .owner-employees-toolbar {
            grid-template-columns: 1fr;
        }

        .owner-employees-filters {
            min-height: 42px;
        }

        .owner-employees-filters button {
            flex: 1;
        }

        .owner-employees-directory-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 7px;
        }

        .owner-employee-card {
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .owner-employee-services,
        .owner-employee-actions {
            grid-column: 1 / -1;
        }

        .owner-employee-actions {
            justify-content: flex-start;
        }

    }


    @media (max-width: 575px) {

        .owner-employees-space {
            padding: 21px 0 32px;
        }

        .owner-employees-shell {
            width: calc(100% - 24px);
        }

        .owner-employees-header-actions {
            align-items: stretch;
            flex-direction: column-reverse;
        }

        .owner-employees-add {
            width: 100%;
        }

        .owner-employees-dashboard-link {
            align-self: flex-start;
        }

        .owner-employees-filters button {
            min-width: 0;
            padding: 0 8px;
        }

        .owner-employee-card {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 18px;
        }

        .owner-employee-services,
        .owner-employee-actions {
            grid-column: auto;
        }

        .owner-employee-actions {
            flex-direction: column;
        }

        .owner-employee-actions a {
            width: 100%;
        }

        .owner-employees-directory-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 14px 18px;
        }

    }

</style>
@endpush