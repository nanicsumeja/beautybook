@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 850px;">

    <div
        class="d-flex justify-content-between
               align-items-start mb-5"
    >
        <div>
            <p class="text-muted text-uppercase small mb-2">
                Employees
            </p>

            <h1 class="display-6 fw-light mb-2">
                Add employee
            </h1>

            <p class="text-muted mb-0">
                Create an employee account and assign services.
            </p>
        </div>

        <a
            href="{{ route('owner.employees.index') }}"
            class="btn btn-outline-dark"
        >
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

            <form
                method="POST"
                action="{{ route('owner.employees.store') }}"
                novalidate
            >
                @csrf

                @include('owner.employees._form')

                <button
                    type="submit"
                    class="btn btn-dark px-4 py-3"
                >
                    Save employee
                </button>
            </form>

        </div>
    </div>

</div>
@endsection