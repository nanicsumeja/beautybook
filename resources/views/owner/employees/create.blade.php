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

                <h1>Add employee</h1>

                <span>
                    Create an account and assign salon services.
                </span>
            </div>

            <a
                href="{{ route('owner.employees.index') }}"
                class="employee-form-back"
            >
                ← Employees
            </a>

        </header>

        @if ($errors->any())
            <div class="employee-form-error-summary">
                <span>!</span>

                Please review the highlighted fields.
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('owner.employees.store') }}"
            class="employee-form-card"
            novalidate
        >
            @csrf

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
                    Save employee
                </button>

            </footer>

        </form>

    </section>

</div>
@endsection