@extends('layouts.app')

@section(
    'body-class',
    'salon-employee-dashboard-page'
)

@section(
    'main-class',
    'salon-employee-dashboard-main'
)

@section('content')
@php
    $inactiveServicesCount =
        $servicesCount - $activeServicesCount;

    $employeeFullName = trim(
        $employee->name . ' ' . $employee->surname
    );
@endphp

<div class="employee-dashboard-shell">

    <section class="employee-dashboard-panel">

        <header class="employee-dashboard-header">

            <div>
                <p>EMPLOYEE WORKSPACE</p>

                <h1>
                    Welcome back,
                    {{ $employee->name }}
                </h1>

                <span>
                    View your account and assigned salon services.
                </span>
            </div>

            <div class="employee-dashboard-date">
                <span>Today</span>

                <strong>
                    {{ now()->format('d.m.Y') }}
                </strong>
            </div>

        </header>

        <div class="employee-dashboard-grid">

            <section class="employee-overview-card">

                <div class="employee-card-heading">
                    <div>
                        <p>OVERVIEW</p>
                        <h2>Your workspace</h2>
                    </div>

                    <span class="employee-account-status {{
                        $employee->is_active
                            ? 'active'
                            : 'inactive'
                    }}">
                        <i></i>

                        {{ $employee->is_active
                            ? 'Active account'
                            : 'Inactive account' }}
                    </span>
                </div>

                <div class="employee-profile">

                    <div class="employee-profile-avatar">
                        {{ mb_strtoupper(
                            mb_substr($employee->name, 0, 1)
                        ) }}
                    </div>

                    <div>
                        <strong>
                            {{ $employeeFullName }}
                        </strong>

                        <span>
                            {{ '@' . $employee->username }}
                        </span>
                    </div>

                </div>

                <div class="employee-profile-details">

                    <div>
                        <span>Email</span>

                        <strong>
                            {{ $employee->email }}
                        </strong>
                    </div>

                    <div>
                        <span>Phone</span>

                        <strong>
                            {{ $employee->phone
                                ?: 'Not provided' }}
                        </strong>
                    </div>

                    <div>
                        <span>Role</span>

                        <strong>
                            Employee
                        </strong>
                    </div>

                </div>

                <div class="employee-dashboard-stats">

                    <article>
                        <span>Assigned services</span>
                        <strong>{{ $servicesCount }}</strong>
                    </article>

                    <article>
                        <span>Active services</span>
                        <strong>{{ $activeServicesCount }}</strong>
                    </article>

                    <article>
                        <span>Inactive services</span>
                        <strong>{{ $inactiveServicesCount }}</strong>
                    </article>

                </div>

                <div class="employee-dashboard-note">

                    <span>i</span>

                    <p>
                        Your schedule will appear here after
                        appointments are assigned to employees.
                    </p>

                </div>

            </section>

            <section class="employee-assigned-card">

                <div class="employee-card-heading">

                    <div>
                        <p>SERVICES</p>
                        <h2>Assigned services</h2>
                    </div>

                    <span class="employee-service-count">
                        {{ $servicesCount }}
                        {{ $servicesCount === 1
                            ? 'service'
                            : 'services' }}
                    </span>

                </div>

                @if ($assignedServices->isNotEmpty())

    <div class="employee-assigned-list">

        @foreach ($assignedServices as $service)

                            <article class="employee-assigned-service">

                                <div class="employee-service-icon">
                                    {{ mb_strtoupper(
                                        mb_substr(
                                            $service->name,
                                            0,
                                            1
                                        )
                                    ) }}
                                </div>

                                <div class="employee-service-copy">

                                    <strong>
                                        {{ $service->name }}
                                    </strong>

                                    <span>
                                        {{ $service->description
                                            ?: 'No description provided.' }}
                                    </span>

                                </div>

                                <div class="employee-service-meta">

                                    <span>
                                        {{ $service->duration_minutes }}
                                        min
                                    </span>

                                    <strong>
                                        {{ number_format(
                                            (float) $service->price,
                                            2
                                        ) }}
                                        KM
                                    </strong>

                                </div>

                                <span class="employee-service-status {{
                                    $service->is_active
                                        ? 'active'
                                        : 'inactive'
                                }}">
                                    <i></i>

                                    {{ $service->is_active
                                        ? 'Active'
                                        : 'Inactive' }}
                                </span>

                            </article>
        @endforeach

    </div>

@else
                    <div class="employee-assigned-empty">

                        <span>+</span>

                        <h3>No assigned services</h3>

                        <p>
                            The salon owner has not assigned
                            any services to this account yet.
                        </p>

                    </div>

                @endforelse

            </section>

        </div>

    </section>

</div>
@endsection