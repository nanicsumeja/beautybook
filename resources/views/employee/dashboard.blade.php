@extends('layouts.app')

@section(
    'body-class',
    'employee-lux-page'
)

@section(
    'main-class',
    ''
)

@section('content')

@php
    $inactiveServicesCount =
        $servicesCount - $activeServicesCount;

    $employeeFullName = trim(
        $employee->name . ' ' . $employee->surname
    );
@endphp


<section class="employee-space">

    <div class="employee-shell">

        {{-- HEADER --}}
        <div class="employee-header">

            <div>
                <span class="employee-eyebrow">
                    EMPLOYEE WORKSPACE
                </span>

                <h1>
                    Welcome back,
                    {{ $employee->name }}.
                </h1>

                <p>
                    Your BeautyBook workspace for services,
                    account details and daily salon activity.
                </p>
            </div>


            <div class="employee-header-meta">

                <span>
                    TODAY
                </span>

                <strong>
                    {{ now()->format('d.m.Y') }}
                </strong>

            </div>

        </div>


        <div class="employee-grid">

            {{-- LEFT --}}
            <section class="employee-profile-card">

                <div class="employee-profile-top">

                    <div>

                        <span class="employee-card-label">
                            YOUR PROFILE
                        </span>

                        <h2>
                            {{ $employeeFullName }}
                        </h2>

                        <p>
                            {{ '@' . $employee->username }}
                        </p>

                    </div>


                    <span class="employee-account-status {{
                        $employee->is_active
                            ? 'active'
                            : 'inactive'
                    }}">
                        <i></i>

                        {{ $employee->is_active
                            ? 'ACTIVE'
                            : 'INACTIVE' }}
                    </span>

                </div>


                <div class="employee-avatar-row">

                    <div class="employee-avatar">
                        {{ mb_strtoupper(
                            mb_substr($employee->name, 0, 1)
                        ) }}
                    </div>

                    <div class="employee-profile-message">

                        <span>
                            BEAUTYBOOK TEAM
                        </span>

                        <p>
                            Your account contains the services
                            assigned to you by the salon owner.
                        </p>

                    </div>

                </div>


                <div class="employee-info-grid">

                    <div>
                        <span>EMAIL</span>

                        <strong>
                            {{ $employee->email }}
                        </strong>
                    </div>

                    <div>
                        <span>PHONE</span>

                        <strong>
                            {{ $employee->phone
                                ?: 'Not provided' }}
                        </strong>
                    </div>

                    <div>
                        <span>ROLE</span>

                        <strong>
                            Employee
                        </strong>
                    </div>

                </div>


                <div class="employee-stats">
                    <article>
                        <span>
                            TODAY
                        </span>

                        <strong>
                            {{ $todayAppointmentsCount }}
                        </strong>

                        <small>
                            appointments
                        </small>
                    </article>

                    <article>
                        <span>
                            ASSIGNED
                        </span>

                        <strong>
                            {{ $servicesCount }}
                        </strong>

                        <small>
                            services
                        </small>
                    </article>

                    <article>
                        <span>
                            ACTIVE
                        </span>

                        <strong>
                            {{ $activeServicesCount }}
                        </strong>

                        <small>
                            available
                        </small>
                    </article>

                    <article>
                        <span>
                            INACTIVE
                        </span>

                        <strong>
                            {{ $inactiveServicesCount }}
                        </strong>

                        <small>
                            unavailable
                        </small>
                    </article>

                </div>


                <div class="employee-note">

                    <span>
                        WORKSPACE
                    </span>

                    <p>
                        Your appointments and client activity
                        are available through the employee navigation.
                    </p>

                </div>

            </section>


            {{-- RIGHT --}}
            <section class="employee-services-card">

                <div class="employee-services-header">

                    <div>
                        <span class="employee-card-label">
                            YOUR SERVICES
                        </span>

                        <h2>
                            Assigned services
                        </h2>

                        <p>
                            Services currently linked to your account.
                        </p>
                    </div>


                    <div class="employee-services-count">

                        <strong>
                            {{ $servicesCount }}
                        </strong>

                        <span>
                            {{ $servicesCount === 1
                                ? 'SERVICE'
                                : 'SERVICES' }}
                        </span>

                    </div>

                </div>


                @if ($assignedServices->isNotEmpty())

                    <div class="employee-services-list">

                        @foreach ($assignedServices as $service)

                            <article class="employee-service-row">

                                <div class="employee-service-number">
                                    {{ str_pad(
                                        $loop->iteration,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </div>


                                <div class="employee-service-main">

                                    <span class="employee-service-name">
                                        {{ $service->name }}
                                    </span>

                                    <p>
                                        {{ $service->description
                                            ?: 'No description provided.' }}
                                    </p>

                                </div>


                                <div class="employee-service-details">

                                    <div>
                                        <span>DURATION</span>

                                        <strong>
                                            {{ $service->duration_minutes }}
                                            min
                                        </strong>
                                    </div>

                                    <div>
                                        <span>PRICE</span>

                                        <strong>
                                            {{ number_format(
                                                (float) $service->price,
                                                2
                                            ) }}
                                            KM
                                        </strong>
                                    </div>

                                </div>


                                <span class="employee-service-status {{
                                    $service->is_active
                                        ? 'active'
                                        : 'inactive'
                                }}">
                                    <i></i>

                                    {{ $service->is_active
                                        ? 'ACTIVE'
                                        : 'INACTIVE' }}
                                </span>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="employee-services-empty">

                        <span>
                            NO SERVICES
                        </span>

                        <h3>
                            Nothing assigned yet.
                        </h3>

                        <p>
                            The salon owner has not assigned
                            any services to this account.
                        </p>

                    </div>

                @endif

            </section>

        </div>

    </div>

</section>

@endsection


@push('styles')
<style>

    .employee-lux-page {
        height: 100vh;
        overflow: hidden;
        background: #f3efea;
    }

    .employee-lux-page #app {
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .employee-lux-page main {
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    .employee-space {
        height: 100%;
        min-height: 0;
        overflow: hidden;
        padding: 20px 0;
        box-sizing: border-box;
        background:
            radial-gradient(
                circle at 90% 8%,
                rgba(192, 153, 142, 0.13),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }


    .employee-shell {
        width: min(1180px, calc(100% - 48px));
        height: 100%;
        min-height: 0;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }


    /* HEADER */

    .employee-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }


    .employee-eyebrow {
        display: block;
        margin-bottom: 6px;
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.21em;
        color: #a27a6d;
    }


    .employee-header h1 {
        margin: 0 0 6px;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }


    .employee-header p {
        margin: 0;
        max-width: 600px;
        font-size: 0.76rem;
        line-height: 1.55;
        color: #7c736d;
    }


    .employee-header-meta {
        text-align: right;
    }


    .employee-header-meta span {
        display: block;
        margin-bottom: 4px;
        font-size: 0.52rem;
        letter-spacing: 0.16em;
        color: #a28e85;
    }


    .employee-header-meta strong {
        font-size: 0.76rem;
        font-weight: 500;
    }


    /* GRID */

    .employee-grid {
        display: grid;
        grid-template-columns: 0.78fr 1.22fr;
        gap: 16px;
        flex: 1;
        min-height: 0;
        align-items: stretch;
    }


    /* PROFILE CARD */

    .employee-profile-card {
        background: #211d1a;
        color: #fff;
        padding: 30px;
        min-height: 0;
        max-height: 100%;
        overflow-y: auto;
    }


    .employee-profile-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 26px;
    }


    .employee-card-label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.52rem;
        letter-spacing: 0.17em;
        color: #c8a69b;
    }


    .employee-profile-top h2 {
        margin: 0 0 4px;
        font-size: 1.6rem;
        font-weight: 300;
    }


    .employee-profile-top p {
        margin: 0;
        font-size: 0.68rem;
        color: #aaa19b;
    }


    .employee-account-status,
    .employee-service-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.48rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }


    .employee-account-status i,
    .employee-service-status i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }


    .employee-account-status.active {
        color: #a9c7a5;
    }


    .employee-account-status.active i {
        background: #8eb48a;
    }


    .employee-account-status.inactive {
        color: #d49a91;
    }


    .employee-account-status.inactive i {
        background: #c27268;
    }


    /* AVATAR */

    .employee-avatar-row {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 26px;
    }


    .employee-avatar {
        flex-shrink: 0;
        width: 62px;
        height: 62px;
        display: grid;
        place-items: center;
        background: #d8b8ad;
        color: #211d1a;
        font-size: 1.4rem;
        font-weight: 400;
    }


    .employee-profile-message span {
        display: block;
        margin-bottom: 4px;
        font-size: 0.49rem;
        letter-spacing: 0.15em;
        color: #bca59d;
    }


    .employee-profile-message p {
        margin: 0;
        max-width: 280px;
        font-size: 0.67rem;
        line-height: 1.5;
        color: #bdb4ae;
    }


    /* INFO */

    .employee-info-grid {
        display: grid;
        grid-template-columns: 1fr;
        border-top: 1px solid rgba(255,255,255,0.12);
    }


    .employee-info-grid > div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 13px 0;
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }


    .employee-info-grid span {
        font-size: 0.49rem;
        letter-spacing: 0.14em;
        color: #9f9791;
    }


    .employee-info-grid strong {
        text-align: right;
        font-size: 0.67rem;
        font-weight: 500;
    }


    /* STATS */

    .employee-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        margin-top: 16px;
    }


    .employee-stats article {
        padding: 11px 8px;
        background: rgba(255,255,255,0.055);
    }


    .employee-stats span {
        display: block;
        margin-bottom: 8px;
        font-size: 0.45rem;
        letter-spacing: 0.12em;
        color: #a59c96;
    }


    .employee-stats strong {
        display: block;
        margin-bottom: 1px;
        font-size: 1.3rem;
        font-weight: 300;
    }


    .employee-stats small {
        font-size: 0.47rem;
        color: #9f9690;
    }


    /* NOTE */

    .employee-note {
        margin-top: 18px;
        padding: 16px;
        background: #d8b8ad;
        color: #211d1a;
    }


    .employee-note span {
        display: block;
        margin-bottom: 5px;
        font-size: 0.48rem;
        letter-spacing: 0.16em;
    }


    .employee-note p {
        margin: 0;
        font-size: 0.65rem;
        line-height: 1.5;
    }


    /* SERVICES CARD */

    .employee-services-card {
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);

        min-height: 0;
        max-height: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }


    .employee-services-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 25px;
        padding: 27px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.1);
    }


    .employee-services-header h2 {
        margin: 0 0 5px;
        font-size: 1.5rem;
        font-weight: 300;
    }


    .employee-services-header p {
        margin: 0;
        font-size: 0.67rem;
        color: #80766f;
    }


    .employee-services-count {
        text-align: right;
    }


    .employee-services-count strong {
        display: block;
        font-size: 1.55rem;
        font-weight: 300;
    }


    .employee-services-count span {
        font-size: 0.47rem;
        letter-spacing: 0.14em;
        color: #9c8177;
    }


    /* SERVICE ROW */

    .employee-services-list {
        display: flex;
        flex-direction: column;

        min-height: 0;
        overflow-y: auto;
    }


    .employee-service-row {
        display: grid;
        grid-template-columns:
            38px
            minmax(0, 1fr)
            auto
            auto;
        gap: 20px;
        align-items: center;
        padding: 20px 26px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.09);
    }


    .employee-service-row:last-child {
        border-bottom: 0;
    }


    .employee-service-number {
        font-size: 0.52rem;
        letter-spacing: 0.12em;
        color: #b08b7f;
    }


    .employee-service-main {
        min-width: 0;
    }


    .employee-service-name {
        display: block;
        margin-bottom: 4px;
        font-size: 0.86rem;
        font-weight: 500;
    }


    .employee-service-main p {
        margin: 0;
        max-width: 380px;
        font-size: 0.62rem;
        line-height: 1.45;
        color: #80766f;
    }


    .employee-service-details {
        display: flex;
        gap: 20px;
    }


    .employee-service-details > div {
        min-width: 70px;
    }


    .employee-service-details span {
        display: block;
        margin-bottom: 3px;
        font-size: 0.44rem;
        letter-spacing: 0.12em;
        color: #9d857c;
    }


    .employee-service-details strong {
        font-size: 0.64rem;
        font-weight: 500;
    }


    .employee-service-status.active {
        color: #667c63;
    }


    .employee-service-status.active i {
        background: #779172;
    }


    .employee-service-status.inactive {
        color: #9c5e53;
    }


    .employee-service-status.inactive i {
        background: #ad6b60;
    }


    /* EMPTY */

    .employee-services-empty {
        padding: 60px 30px;
        text-align: center;
    }


    .employee-services-empty > span {
        display: block;
        margin-bottom: 7px;
        font-size: 0.52rem;
        letter-spacing: 0.16em;
        color: #a47f73;
    }


    .employee-services-empty h3 {
        margin: 0 0 7px;
        font-size: 1.35rem;
        font-weight: 300;
    }


    .employee-services-empty p {
        max-width: 340px;
        margin: 0 auto;
        font-size: 0.67rem;
        line-height: 1.5;
        color: #81766f;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .employee-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 700px) {

        .employee-service-row {
            grid-template-columns: 30px 1fr;
        }

        .employee-service-details,
        .employee-service-status {
            grid-column: 2;
        }

    }


    @media (max-width: 575px) {

        .employee-space {
            padding: 22px 0 32px;
        }

        .employee-shell {
            width: calc(100% - 24px);
        }

        .employee-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .employee-header-meta {
            text-align: left;
        }

        .employee-profile-card {
            padding: 24px;
        }

        .employee-profile-top {
            flex-direction: column;
        }

        .employee-stats {
            grid-template-columns: 1fr;
        }

        .employee-services-header {
            padding: 22px;
        }

        .employee-service-row {
            padding: 18px 20px;
        }

    }

</style>
@endpush