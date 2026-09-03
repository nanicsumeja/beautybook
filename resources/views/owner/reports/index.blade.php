@extends('layouts.app')

@section('body-class', 'owner-reports-page')
@section('main-class', 'owner-reports-main')

@section('content')

<section class="owner-reports-space">

    <div class="owner-reports-shell">

        {{-- HEADER --}}
        <header class="owner-reports-header">

            <div>
                <span class="owner-reports-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>Reports</h1>

                <p>
                    Business performance, financial overview and appointment activity.
                </p>
            </div>

            <div class="owner-reports-header-actions">

                <a
                    href="{{
                        route(
                            'owner.reports.pdf',
                            array_filter([
                                'period' => $period,
                                'start_date' => request('start_date'),
                                'end_date' => request('end_date'),
                            ])
                        )
                    }}"
                    class="owner-reports-download"
                >
                    <span>DOWNLOAD PDF</span>
                    <span>↓</span>
                </a>

                <a
                    href="{{ route('owner.dashboard') }}"
                    class="owner-reports-dashboard"
                >
                    ← DASHBOARD
                </a>

            </div>

        </header>


        {{-- PERIOD CONTROL --}}
        <section class="owner-reports-filter-panel">

            <div class="owner-reports-filter-heading">

                <div>
                    <span>REPORTING PERIOD</span>

                    <h2>
                        Select a date range
                    </h2>
                </div>

                <p>
                    Statistics below update according to the selected period.
                </p>

            </div>


            <form
                method="GET"
                action="{{ route('owner.reports.index') }}"
                class="owner-reports-filter-form"
            >

                <div class="owner-reports-field">

                    <label for="period">
                        Period
                    </label>

                    <select
                        name="period"
                        id="period"
                    >
                        <option
                            value="today"
                            {{ $period === 'today' ? 'selected' : '' }}
                        >
                            Today
                        </option>

                        <option
                            value="week"
                            {{ $period === 'week' ? 'selected' : '' }}
                        >
                            This week
                        </option>

                        <option
                            value="month"
                            {{ $period === 'month' ? 'selected' : '' }}
                        >
                            This month
                        </option>

                        <option
                            value="custom"
                            {{ $period === 'custom' ? 'selected' : '' }}
                        >
                            Custom range
                        </option>
                    </select>

                </div>


                <div
                    class="owner-reports-field custom-date-field"
                    style="{{ $period === 'custom' ? '' : 'display:none;' }}"
                >

                    <label for="start_date">
                        Start date
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ request('start_date') }}"
                    >

                </div>


                <div
                    class="owner-reports-field custom-date-field"
                    style="{{ $period === 'custom' ? '' : 'display:none;' }}"
                >

                    <label for="end_date">
                        End date
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ request('end_date') }}"
                    >

                </div>


                <button
                    type="submit"
                    class="owner-reports-apply"
                >
                    <span>APPLY FILTER</span>
                    <span>→</span>
                </button>

            </form>


            @error('start_date')
                <div class="owner-reports-validation">
                    {{ $message }}
                </div>
            @enderror

            @error('end_date')
                <div class="owner-reports-validation">
                    {{ $message }}
                </div>
            @enderror

        </section>


        {{-- CURRENT PERIOD --}}
        <div class="owner-reports-period">

            <div>
                <span>ACTIVE REPORT</span>

                <p>
                    Showing results from
                    <strong>{{ $startDate->format('d.m.Y') }}</strong>
                    to
                    <strong>{{ $endDate->format('d.m.Y') }}</strong>
                </p>
            </div>

            <span class="owner-reports-period-tag">
                {{
                    match($period) {
                        'today' => 'TODAY',
                        'week' => 'THIS WEEK',
                        'custom' => 'CUSTOM RANGE',
                        default => 'THIS MONTH',
                    }
                }}
            </span>

        </div>


        {{-- MAIN STATS --}}
        <section class="owner-reports-section">

            <header class="owner-reports-section-header">

                <div>
                    <span>APPOINTMENTS</span>

                    <h2>
                        Appointment overview
                    </h2>
                </div>

            </header>


            <div class="owner-reports-stat-grid">

                <article class="owner-reports-stat">

                    <div class="owner-reports-stat-top">
                        <span>01</span>
                        <span>TOTAL</span>
                    </div>

                    <strong>
                        {{ $totalReservations }}
                    </strong>

                    <p>
                        All appointments during the selected period.
                    </p>

                </article>


                <article class="owner-reports-stat">

                    <div class="owner-reports-stat-top">
                        <span>02</span>
                        <span>CONFIRMED</span>
                    </div>

                    <strong>
                        {{ $confirmedReservations }}
                    </strong>

                    <p>
                        Appointments currently confirmed.
                    </p>

                </article>


                <article class="owner-reports-stat">

                    <div class="owner-reports-stat-top">
                        <span>03</span>
                        <span>COMPLETED</span>
                    </div>

                    <strong>
                        {{ $completedReservations }}
                    </strong>

                    <p>
                        Successfully completed appointments.
                    </p>

                </article>


                <article class="owner-reports-stat">

                    <div class="owner-reports-stat-top">
                        <span>04</span>
                        <span>CANCELLED</span>
                    </div>

                    <strong>
                        {{ $cancelledReservations }}
                    </strong>

                    <p>
                        Appointments cancelled during this period.
                    </p>

                </article>

            </div>

        </section>


        {{-- FINANCIALS --}}
        <section class="owner-reports-section">

            <header class="owner-reports-section-header">

                <div>
                    <span>FINANCIALS</span>

                    <h2>
                        Financial performance
                    </h2>
                </div>

            </header>


            <div class="owner-reports-finance-grid">

                <article class="owner-reports-finance-card">

                    <div>
                        <span>REVENUE</span>

                        <p>
                            Paid completed services
                        </p>
                    </div>

                    <strong>
                        {{ number_format((float) $revenue, 2) }}
                        <small>KM</small>
                    </strong>

                </article>


                <article class="owner-reports-finance-card">

                    <div>
                        <span>ADVANCES</span>

                        <p>
                            Total paid advances
                        </p>
                    </div>

                    <strong>
                        {{ number_format((float) $totalAdvances, 2) }}
                        <small>KM</small>
                    </strong>

                </article>

            </div>

        </section>


        {{-- TABLES --}}
        <div class="owner-reports-table-grid">

            {{-- SERVICES --}}
            <section class="owner-reports-table-card">

                <header>

                    <div>
                        <span>SERVICES</span>

                        <h2>
                            Most popular services
                        </h2>
                    </div>

                    <small>
                        {{ $popularServices->count() }} RESULTS
                    </small>

                </header>


                @if($popularServices->isEmpty())

                    <div class="owner-reports-empty">

                        <span>—</span>

                        <p>
                            No appointments in this period.
                        </p>

                    </div>

                @else

                    <div class="owner-reports-table-wrap">

                        <table>

                            <thead>
                                <tr>
                                    <th>
                                        Service
                                    </th>

                                    <th>
                                        Appointments
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($popularServices as $service)

                                    <tr>
                                        <td>
                                            {{ $service->service_name }}
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $service->total }}
                                            </strong>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </section>


            {{-- EMPLOYEES --}}
            <section class="owner-reports-table-card dark">

                <header>

                    <div>
                        <span>TEAM</span>

                        <h2>
                            Appointments by employee
                        </h2>
                    </div>

                    <small>
                        {{ $appointmentsByEmployee->count() }} RESULTS
                    </small>

                </header>


                @if($appointmentsByEmployee->isEmpty())

                    <div class="owner-reports-empty">

                        <span>—</span>

                        <p>
                            No employee appointments in this period.
                        </p>

                    </div>

                @else

                    <div class="owner-reports-table-wrap">

                        <table>

                            <thead>
                                <tr>
                                    <th>
                                        Employee
                                    </th>

                                    <th>
                                        Appointments
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($appointmentsByEmployee as $item)

                                    <tr>
                                        <td>
                                            @if($item->employee)

                                                {{ $item->employee->name }}
                                                {{ $item->employee->surname }}

                                            @else

                                                Unknown employee

                                            @endif
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $item->total }}
                                            </strong>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </section>

        </div>


        {{-- PDF CTA --}}
        <section class="owner-reports-export">

            <div>

                <span>REPORT EXPORT</span>

                <h2>
                    Need a printable copy?
                </h2>

                <p>
                    Download the current report as a PDF with the same
                    selected period, statistics and business overview.
                </p>

            </div>

            <a
                href="{{
                    route(
                        'owner.reports.pdf',
                        array_filter([
                            'period' => $period,
                            'start_date' => request('start_date'),
                            'end_date' => request('end_date'),
                        ])
                    )
                }}"
            >
                <span>DOWNLOAD REPORT</span>
                <span>↓</span>
            </a>

        </section>

    </div>

</section>

@endsection


@push('styles')
<style>

    .owner-reports-page,
    .owner-reports-main {
        background: #f3efea;
    }

    .owner-reports-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 45px;
        background:
            radial-gradient(
                circle at 92% 4%,
                rgba(190,151,140,0.14),
                transparent 24%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-reports-shell {
        width: min(1120px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-reports-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 28px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-reports-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.64rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-reports-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-reports-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.76rem;
    }

    .owner-reports-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .owner-reports-download {
        min-width: 165px;
        min-height: 39px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 0 13px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        text-decoration: none;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-reports-download:hover {
        background: #9d7063;
        border-color: #9d7063;
        color: #fff;
    }

    .owner-reports-download span:last-child {
        font-size: 0.7rem;
        font-weight: 300;
    }

    .owner-reports-dashboard {
        min-height: 39px;
        display: flex;
        align-items: center;
        padding: 0 12px;
        border: 1px solid rgba(33,29,26,0.16);
        color: #514944;
        text-decoration: none;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.09em;
    }

    .owner-reports-dashboard:hover {
        border-color: #9d7063;
        color: #9d7063;
    }


    /* FILTER */

    .owner-reports-filter-panel {
        margin-bottom: 15px;
        padding: 20px 21px;
        border: 1px solid rgba(33,29,26,0.08);
        background: #faf7f3;
    }

    .owner-reports-filter-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 17px;
        padding-bottom: 13px;
        border-bottom: 1px solid rgba(33,29,26,0.08);
    }

    .owner-reports-filter-heading span,
    .owner-reports-section-header span,
    .owner-reports-table-card header span,
    .owner-reports-export > div > span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .owner-reports-filter-heading h2,
    .owner-reports-section-header h2,
    .owner-reports-table-card header h2,
    .owner-reports-export h2 {
        margin: 0;
        font-size: 1.12rem;
        font-weight: 300;
    }

    .owner-reports-filter-heading > p {
        max-width: 280px;
        margin: 0;
        color: #948881;
        font-size: 0.6rem;
        line-height: 1.55;
        text-align: right;
    }

    .owner-reports-filter-form {
        display: grid;
        grid-template-columns:
            minmax(150px, 1fr)
            minmax(145px, 1fr)
            minmax(145px, 1fr)
            165px;
        align-items: end;
        gap: 12px;
    }

    .owner-reports-field label {
        display: block;
        margin-bottom: 6px;
        color: #655c57;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .owner-reports-field select,
    .owner-reports-field input {
        width: 100%;
        min-height: 41px;
        padding: 8px 10px;
        border: 1px solid rgba(33,29,26,0.14);
        border-radius: 0;
        outline: none;
        background: #f7f2ee;
        color: #332d29;
        font-family: inherit;
        font-size: 0.68rem;
    }

    .owner-reports-field select:focus,
    .owner-reports-field input:focus {
        border-color: #a97e72;
        box-shadow: 0 0 0 2px rgba(169,126,114,0.08);
    }

    .owner-reports-apply {
        min-height: 41px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 0 13px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        cursor: pointer;
    }

    .owner-reports-apply:hover {
        background: #9d7063;
        border-color: #9d7063;
    }

    .owner-reports-apply span:last-child {
        font-size: 0.7rem;
    }

    .owner-reports-validation {
        margin-top: 9px;
        color: #a45f55;
        font-size: 0.58rem;
    }


    /* PERIOD */

    .owner-reports-period {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
        padding: 12px 15px;
        background: #eee4de;
        border: 1px solid rgba(33,29,26,0.07);
    }

    .owner-reports-period > div > span {
        display: block;
        margin-bottom: 2px;
        color: #a17b70;
        font-size: 0.52rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-reports-period p {
        margin: 0;
        color: #6f655f;
        font-size: 0.62rem;
    }

    .owner-reports-period p strong {
        color: #3c3531;
        font-weight: 500;
    }

    .owner-reports-period-tag {
        padding: 5px 8px;
        background: rgba(255,255,255,0.55);
        color: #796962;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.09em;
    }


    /* SECTIONS */

    .owner-reports-section {
        margin-bottom: 27px;
    }

    .owner-reports-section-header {
        margin-bottom: 12px;
    }


    /* STATS */

    .owner-reports-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        border-top: 1px solid rgba(33,29,26,0.1);
        border-left: 1px solid rgba(33,29,26,0.1);
    }

    .owner-reports-stat {
        min-height: 158px;
        padding: 16px;
        border-right: 1px solid rgba(33,29,26,0.1);
        border-bottom: 1px solid rgba(33,29,26,0.1);
        background: #faf7f3;
    }

    .owner-reports-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 18px;
    }

    .owner-reports-stat-top span:first-child {
        color: #b19489;
        font-size: 0.51rem;
    }

    .owner-reports-stat-top span:last-child {
        color: #877a73;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-reports-stat > strong {
        display: block;
        margin-bottom: 9px;
        color: #29231f;
        font-size: 2rem;
        font-weight: 300;
        line-height: 1;
    }

    .owner-reports-stat > p {
        max-width: 180px;
        margin: 0;
        color: #988d86;
        font-size: 0.59rem;
        line-height: 1.5;
    }


    /* FINANCE */

    .owner-reports-finance-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .owner-reports-finance-card {
        min-height: 125px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        padding: 20px;
        background: #dfcbc3;
        border: 1px solid rgba(33,29,26,0.07);
    }

    .owner-reports-finance-card:nth-child(2) {
        background: #e9ddd6;
    }

    .owner-reports-finance-card > div > span {
        display: block;
        margin-bottom: 5px;
        color: #83665d;
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.12em;
    }

    .owner-reports-finance-card p {
        margin: 0;
        color: #796c65;
        font-size: 0.6rem;
    }

    .owner-reports-finance-card > strong {
        color: #352d29;
        font-size: clamp(1.35rem, 3vw, 2rem);
        font-weight: 300;
        white-space: nowrap;
    }

    .owner-reports-finance-card > strong small {
        font-size: 0.57rem;
        font-weight: 500;
        letter-spacing: 0.07em;
    }


    /* TABLE GRID */

    .owner-reports-table-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 27px;
    }

    .owner-reports-table-card {
        min-width: 0;
        background: #faf7f3;
        border: 1px solid rgba(33,29,26,0.09);
    }

    .owner-reports-table-card > header {
        min-height: 72px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 14px 16px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-reports-table-card > header small {
        flex-shrink: 0;
        color: #9d8d84;
        font-size: 0.49rem;
        letter-spacing: 0.08em;
    }

    .owner-reports-table-wrap {
        overflow-x: auto;
    }

    .owner-reports-table-card table {
        width: 100%;
        border-collapse: collapse;
    }

    .owner-reports-table-card th {
        padding: 9px 15px;
        border-bottom: 1px solid rgba(33,29,26,0.08);
        color: #9d8f87;
        font-size: 0.5rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-align: left;
        text-transform: uppercase;
    }

    .owner-reports-table-card th:last-child,
    .owner-reports-table-card td:last-child {
        text-align: right;
    }

    .owner-reports-table-card td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(33,29,26,0.07);
        color: #625954;
        font-size: 0.62rem;
    }

    .owner-reports-table-card tbody tr:last-child td {
        border-bottom: none;
    }

    .owner-reports-table-card td strong {
        color: #382f2b;
        font-weight: 500;
    }


    /* DARK TABLE */

    .owner-reports-table-card.dark {
        background: #211d1a;
        border-color: #211d1a;
        color: #fff;
    }

    .owner-reports-table-card.dark > header {
        border-bottom-color: rgba(255,255,255,0.1);
    }

    .owner-reports-table-card.dark header span {
        color: #c29e92;
    }

    .owner-reports-table-card.dark header h2 {
        color: #f5efeb;
    }

    .owner-reports-table-card.dark > header small {
        color: #9d918b;
    }

    .owner-reports-table-card.dark th {
        border-bottom-color: rgba(255,255,255,0.1);
        color: #8f837d;
    }

    .owner-reports-table-card.dark td {
        border-bottom-color: rgba(255,255,255,0.08);
        color: #c8bdb7;
    }

    .owner-reports-table-card.dark td strong {
        color: #f4ece8;
    }


    /* EMPTY */

    .owner-reports-empty {
        min-height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 5px;
        padding: 20px;
        color: #948881;
        text-align: center;
    }

    .owner-reports-empty > span {
        font-size: 1rem;
        font-weight: 300;
    }

    .owner-reports-empty p {
        margin: 0;
        font-size: 0.6rem;
    }

    .owner-reports-table-card.dark .owner-reports-empty {
        color: #998d87;
    }


    /* EXPORT */

    .owner-reports-export {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 35px;
        padding: 23px 25px;
        background: #d9c0b7;
    }

    .owner-reports-export h2 {
        margin-bottom: 5px;
    }

    .owner-reports-export p {
        max-width: 540px;
        margin: 0;
        color: #72635d;
        font-size: 0.61rem;
        line-height: 1.6;
    }

    .owner-reports-export > a {
        min-width: 190px;
        min-height: 43px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 14px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        text-decoration: none;
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-reports-export > a:hover {
        background: #9b6d61;
        border-color: #9b6d61;
    }

    .owner-reports-export > a span:last-child {
        font-size: 0.72rem;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .owner-reports-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .owner-reports-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .owner-reports-table-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 700px) {

        .owner-reports-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-reports-header-actions {
            width: 100%;
            justify-content: space-between;
        }

        .owner-reports-filter-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 7px;
        }

        .owner-reports-filter-heading > p {
            max-width: none;
            text-align: left;
        }

        .owner-reports-finance-grid {
            grid-template-columns: 1fr;
        }

        .owner-reports-export {
            align-items: flex-start;
            flex-direction: column;
        }

    }

    @media (max-width: 575px) {

        .owner-reports-space {
            padding: 21px 0 34px;
        }

        .owner-reports-shell {
            width: calc(100% - 24px);
        }

        .owner-reports-header-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .owner-reports-download,
        .owner-reports-dashboard {
            width: 100%;
        }

        .owner-reports-filter-form {
            grid-template-columns: 1fr;
        }

        .owner-reports-stat-grid {
            grid-template-columns: 1fr;
        }

        .owner-reports-period {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-reports-finance-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-reports-export > a {
            width: 100%;
        }

    }

</style>
@endpush


@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    const period = document.getElementById('period');

    const customFields = document.querySelectorAll(
        '.custom-date-field'
    );

    const startDate = document.getElementById(
        'start_date'
    );

    const endDate = document.getElementById(
        'end_date'
    );

    function toggleCustomDates() {

        const isCustom =
            period.value === 'custom';

        customFields.forEach(function (field) {

            field.style.display =
                isCustom ? '' : 'none';

        });

        startDate.required = isCustom;
        endDate.required = isCustom;

    }

    period.addEventListener(
        'change',
        toggleCustomDates
    );

    toggleCustomDates();

});

</script>
@endpush