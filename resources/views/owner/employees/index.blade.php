@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div
        class="d-flex justify-content-between
               align-items-start mb-5"
    >
        <div>
            <p class="text-muted text-uppercase small mb-2">
                Owner panel
            </p>

            <h1 class="display-6 fw-light mb-2">
                Employees
            </h1>

            <p class="text-muted mb-0">
                Manage employee accounts and assigned services.
            </p>
        </div>

        <a
            href="{{ route('owner.employees.create') }}"
            class="btn btn-dark"
        >
            Add employee
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            @if ($employees->isEmpty())

                <div class="p-5 text-center">
                    <h2 class="h5 fw-normal mb-2">
                        No employees yet
                    </h2>

                    <p class="text-muted mb-4">
                        Add the first salon employee.
                    </p>

                    <a
                        href="{{ route(
                            'owner.employees.create'
                        ) }}"
                        class="btn btn-dark"
                    >
                        Add first employee
                    </a>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">
                                    Employee
                                </th>

                                <th class="py-3">
                                    Contact
                                </th>

                                <th class="py-3">
                                    Services
                                </th>

                                <th class="py-3">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-end">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="px-4 py-3">
                                        <strong>
                                            {{ $employee->name }}
                                            {{ $employee->surname }}
                                        </strong>

                                        <div class="small text-muted">
                                            {{ '@' . $employee->username }}
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        {{ $employee->email }}

                                        @if ($employee->phone)
                                            <div class="small text-muted">
                                                {{ $employee->phone }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        @forelse (
                                            $employee->services
                                            as $service
                                        )
                                            <span
                                                class="badge
                                                       text-bg-light
                                                       border
                                                       text-dark
                                                       me-1
                                                       mb-1"
                                            >
                                                {{ $service->name }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">
                                                No services assigned
                                            </span>
                                        @endforelse
                                    </td>

                                    <td class="py-3">
                                        @if ($employee->is_active)
                                            <span
                                                class="badge
                                                       text-bg-success"
                                            >
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="badge
                                                       text-bg-secondary"
                                            >
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-end">
                                        <a
                                            href="{{ route(
                                                'owner.employees.edit',
                                                $employee
                                            ) }}"
                                            class="btn btn-sm
                                                   btn-outline-dark"
                                        >
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>
    </div>

    <div class="mt-4">
        <a
            href="{{ route('owner.dashboard') }}"
            class="text-dark"
        >
            ← Back to dashboard
        </a>
    </div>

</div>
@endsection