<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        BeautyBook Report
    </title>

    <style>
        @page {
            margin: 28px 32px 32px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #2b2521;
            background: #ffffff;
            font-size: 11px;
            line-height: 1.45;
        }

        .report-header {
            padding-bottom: 18px;
            border-bottom: 1px solid #d9d0ca;
        }

        .report-brand {
            font-size: 9px;
            letter-spacing: 2px;
            color: #a0786d;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .report-title {
            margin: 0;
            font-size: 28px;
            font-weight: 400;
            color: #211d1a;
        }

        .report-subtitle {
            margin-top: 6px;
            color: #7e736d;
            font-size: 10px;
        }

        .report-meta {
            margin-top: 14px;
            width: 100%;
            border-collapse: collapse;
        }

        .report-meta td {
            width: 50%;
            vertical-align: top;
        }

        .report-meta-label {
            color: #a0786d;
            font-size: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .report-meta-value {
            font-size: 10px;
            color: #4e4641;
        }

        .section {
            margin-top: 22px;
        }

        .section-heading {
            margin-bottom: 10px;
        }

        .section-eyebrow {
            font-size: 8px;
            letter-spacing: 1.3px;
            color: #a0786d;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .section-title {
            margin: 0;
            font-size: 15px;
            font-weight: 400;
            color: #29231f;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .stats-table td {
            width: 25%;
            padding: 11px 10px;
            border: 1px solid #e2d9d3;
            background: #faf7f4;
            vertical-align: top;
        }

        .stat-label {
            color: #857972;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 19px;
            color: #241f1c;
        }

        .finance-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .finance-table td {
            width: 50%;
            padding: 13px 12px;
            border: 1px solid #e2d9d3;
            background: #f3ebe6;
            vertical-align: top;
        }

        .finance-label {
            color: #7e7069;
            font-size: 8px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .finance-value {
            font-size: 20px;
            color: #2c2521;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 8px 9px;
            text-align: left;
            border-bottom: 1px solid #cfc4bd;
            background: #eee4de;
            color: #6c5f59;
            font-size: 8px;
            font-weight: 400;
            letter-spacing: 0.7px;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 8px 9px;
            border-bottom: 1px solid #e7dfda;
            color: #4f4742;
            font-size: 9px;
        }

        .data-table th:last-child,
        .data-table td:last-child {
            text-align: right;
        }

        .data-table tbody tr:nth-child(even) td {
            background: #fbf8f6;
        }

        .empty-state {
            padding: 14px;
            border: 1px solid #e1d9d4;
            background: #faf7f4;
            color: #8b7f78;
            font-size: 9px;
        }

        .footer {
            margin-top: 28px;
            padding-top: 11px;
            border-top: 1px solid #d9d0ca;
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            width: 50%;
            color: #9a8e87;
            font-size: 8px;
        }

        .footer td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>

    <header class="report-header">

        <div class="report-brand">
            BEAUTYBOOK · BUSINESS REPORT
        </div>

        <h1 class="report-title">
            Performance Report
        </h1>

        <div class="report-subtitle">
            Salon performance, appointment activity and financial overview.
        </div>

        <table class="report-meta">
            <tr>
                <td>
                    <div class="report-meta-label">
                        Reporting period
                    </div>

                    <div class="report-meta-value">
                        {{ $startDate->format('d.m.Y') }}
                        –
                        {{ $endDate->format('d.m.Y') }}
                    </div>
                </td>

                <td>
                    <div class="report-meta-label">
                        Generated
                    </div>

                    <div class="report-meta-value">
                        {{ now()->format('d.m.Y H:i') }}
                    </div>
                </td>
            </tr>
        </table>

    </header>


    <section class="section">

        <div class="section-heading">
            <div class="section-eyebrow">
                APPOINTMENTS
            </div>

            <h2 class="section-title">
                Appointment overview
            </h2>
        </div>

        <table class="stats-table">
            <tr>

                <td>
                    <div class="stat-label">
                        Total
                    </div>

                    <div class="stat-value">
                        {{ $totalReservations }}
                    </div>
                </td>

                <td>
                    <div class="stat-label">
                        Confirmed
                    </div>

                    <div class="stat-value">
                        {{ $confirmedReservations }}
                    </div>
                </td>

                <td>
                    <div class="stat-label">
                        Completed
                    </div>

                    <div class="stat-value">
                        {{ $completedReservations }}
                    </div>
                </td>

                <td>
                    <div class="stat-label">
                        Cancelled
                    </div>

                    <div class="stat-value">
                        {{ $cancelledReservations }}
                    </div>
                </td>

            </tr>
        </table>

    </section>


    <section class="section">

        <div class="section-heading">
            <div class="section-eyebrow">
                FINANCIALS
            </div>

            <h2 class="section-title">
                Financial performance
            </h2>
        </div>

        <table class="finance-table">
            <tr>

                <td>
                    <div class="finance-label">
                        Revenue from paid completed services
                    </div>

                    <div class="finance-value">
                        {{ number_format((float) $revenue, 2) }} KM
                    </div>
                </td>

                <td>
                    <div class="finance-label">
                        Total paid advances
                    </div>

                    <div class="finance-value">
                        {{ number_format((float) $totalAdvances, 2) }} KM
                    </div>
                </td>

            </tr>
        </table>

    </section>


    <section class="section">

        <div class="section-heading">
            <div class="section-eyebrow">
                SERVICES
            </div>

            <h2 class="section-title">
                Most popular services
            </h2>
        </div>

        @if($popularServices->isEmpty())

            <div class="empty-state">
                No appointments were recorded in this period.
            </div>

        @else

            <table class="data-table">

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
                                {{ $service->total }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </section>


    <section class="section">

        <div class="section-heading">
            <div class="section-eyebrow">
                TEAM
            </div>

            <h2 class="section-title">
                Appointments by employee
            </h2>
        </div>

        @if($appointmentsByEmployee->isEmpty())

            <div class="empty-state">
                No employee appointments were recorded in this period.
            </div>

        @else

            <table class="data-table">

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
                                {{ $item->total }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </section>


    <table class="footer">
        <tr>
            <td>
                BeautyBook · Salon Management System
            </td>

            <td>
                {{ $startDate->format('d.m.Y') }}
                –
                {{ $endDate->format('d.m.Y') }}
            </td>
        </tr>
    </table>

</body>
</html>