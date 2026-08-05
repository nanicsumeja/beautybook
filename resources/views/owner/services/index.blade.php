@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-1">OWNER PANEL</p>
            <h1 class="h3 mb-0">Services</h1>
        </div>

        <a
            href="{{ route('owner.services.create') }}"
            class="btn btn-dark"
        >
            Add service
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            @if ($services->isEmpty())

                <div class="text-center p-5">
                    <h2 class="h5">No services yet</h2>

                    <p class="text-muted mb-4">
                        Add the first salon service.
                    </p>

                    <a
                        href="{{ route('owner.services.create') }}"
                        class="btn btn-dark"
                    >
                        Add first service
                    </a>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Duration</th>
                                <th class="py-3">Status</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td class="px-4 py-3">
                                        <strong>{{ $service->name }}</strong>

                                        @if ($service->description)
                                            <div class="small text-muted mt-1">
                                                {{ $service->description }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        {{ number_format((float) $service->price, 2) }}
                                        KM
                                    </td>

                                    <td class="py-3">
                                        {{ $service->duration_minutes }} min
                                    </td>

                                    <td class="py-3">
                                        @if ($service->is_active)
                                            <span class="badge text-bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge text-bg-secondary">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="d-flex justify-content-end gap-2">

                                            <a
                                                href="{{ route(
                                                    'owner.services.edit',
                                                    $service
                                                ) }}"
                                                class="btn btn-sm btn-outline-dark"
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
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
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