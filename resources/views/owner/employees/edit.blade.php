@extends('layouts.app')

@section(
    'body-class',
    'salon-admin-page salon-employee-form-page'
)

@section('main-class', 'salon-employee-form-main')

@section('content')
<div class="employee-form-shell">

    <section class="employee-form-panel">

        <header class="employee-form-header">

            <div>
                <p>OWNER WORKSPACE</p>

                <h1>Edit employee</h1>

                <span>
                    Update account details and assigned services.
                </span>
            </div>

            <a
                href="{{ route('owner.employees.index') }}"
                class="employee-form-back"
            >
                ← Employees
            </a>

        </header>

        <div class="employee-edit-context">

            <div class="employee-edit-avatar">
                {{ mb_strtoupper(
                    mb_substr($employee->name, 0, 1)
                ) }}
            </div>

            <div>
                <strong>
                    {{ $employee->name }}
                    {{ $employee->surname }}
                </strong>

                <span>
                    {{ '@' . $employee->username }}
                </span>
            </div>

            <em class="{{
                $employee->is_active
                    ? 'is-active'
                    : 'is-inactive'
            }}">
                {{ $employee->is_active
                    ? 'Active'
                    : 'Inactive' }}
            </em>

        </div>

        @if ($errors->any())
            <div class="employee-form-error-summary">
                <span>!</span>

                Please review the highlighted fields.
            </div>
        @endif

        <form
            method="POST"
            action="{{ route(
                'owner.employees.update',
                $employee
            ) }}"
            class="employee-form-card"
            novalidate
        >
            @csrf
            @method('PUT')

            <div class="employee-form-content">
                @include('owner.employees._form')
            </div>

            <footer class="employee-form-actions">

                <a
                    href="{{ route('owner.employees.index') }}"
                    class="employee-secondary-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="employee-primary-button"
                >
                    Save changes
                </button>

            </footer>

        </form>

    </section>

</div>
@endsection