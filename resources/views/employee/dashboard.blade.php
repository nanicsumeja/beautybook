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


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}
        <header class="employee-page-header">

            <div>

                <span class="employee-eyebrow">
                    EMPLOYEE WORKSPACE
                </span>

                <h1>
                    Welcome back, {{ $employee->name }}.
                </h1>

            </div>


            <div class="employee-date">

                <span>
                    TODAY
                </span>

                <strong>
                    {{ now()->format('d.m.Y') }}
                </strong>

            </div>

        </header>



        {{-- =====================================================
             CONTENT
        ====================================================== --}}
        <div class="employee-content">


            {{-- =================================================
                 LEFT
            ================================================== --}}
            <section class="employee-left">


                {{-- EMPLOYEE HEADER --}}
                <div class="employee-left-head">

                    <span class="employee-label">
                        EMPLOYEE
                    </span>


                    <div class="employee-name-row">

                        <div>

                            <h2>
                                {{ $employeeFullName }}
                            </h2>

                            <p>
                                {{ '@' . $employee->username }}
                            </p>

                        </div>


                        <span class="employee-status {{
                            $employee->is_active
                                ? 'active'
                                : 'inactive'
                        }}">

                            <i></i>

                            {{
                                $employee->is_active
                                    ? 'ACTIVE'
                                    : 'INACTIVE'
                            }}

                        </span>

                    </div>

                </div>



                {{-- STATS --}}
                <div class="employee-stats">


                    <div class="employee-stat today">

                        <span>
                            TODAY
                        </span>

                        <strong>
                            {{ $todayAppointmentsCount }}
                        </strong>

                    </div>


                    <div class="employee-stat services">

                        <span>
                            SERVICES
                        </span>

                        <strong>
                            {{ $servicesCount }}
                        </strong>

                    </div>


                    <div class="employee-stat active">

                        <span>
                            ACTIVE
                        </span>

                        <strong>
                            {{ $activeServicesCount }}
                        </strong>

                    </div>


                    <div class="employee-stat inactive">

                        <span>
                            INACTIVE
                        </span>

                        <strong>
                            {{ $inactiveServicesCount }}
                        </strong>

                    </div>

                </div>



                {{-- CONTACT --}}
                <div class="employee-contact">

                    <div>

                        <span>
                            EMAIL
                        </span>

                        <strong>
                            {{ $employee->email }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            PHONE
                        </span>

                        <strong>
                            {{
                                $employee->phone
                                    ?: 'Not provided'
                            }}
                        </strong>

                    </div>

                </div>

            </section>



            {{-- =================================================
                 RIGHT
            ================================================== --}}
            <section class="employee-right">


                {{-- SERVICES HEADER --}}
                <div class="employee-right-head">

                    <div>

                        <span class="employee-label">
                            YOUR SERVICES
                        </span>

                        <h2>
                            Assigned services
                        </h2>

                    </div>


                    <div class="employee-service-count">

                        <strong>
                            {{ $servicesCount }}
                        </strong>

                        <span>
                            {{
                                $servicesCount === 1
                                    ? 'SERVICE'
                                    : 'SERVICES'
                            }}
                        </span>

                    </div>

                </div>



                {{-- SERVICES --}}
                @if ($assignedServices->isNotEmpty())

                    <div class="employee-service-list">

                        @foreach ($assignedServices as $service)

                            <article class="employee-service-row">


                                <div class="employee-service-number">

                                    {{
                                        str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        )
                                    }}

                                </div>


                                <div class="employee-service-name">

                                    {{ $service->name }}

                                </div>


                                <div class="employee-service-info">

                                    <span>
                                        DURATION
                                    </span>

                                    <strong>
                                        {{ $service->duration_minutes }}
                                        min
                                    </strong>

                                </div>


                                <div class="employee-service-info">

                                    <span>
                                        PRICE
                                    </span>

                                    <strong>
                                        {{
                                            number_format(
                                                (float) $service->price,
                                                2
                                            )
                                        }}
                                        KM
                                    </strong>

                                </div>


                                <span class="employee-service-status {{
                                    $service->is_active
                                        ? 'active'
                                        : 'inactive'
                                }}">

                                    <i></i>

                                    {{
                                        $service->is_active
                                            ? 'ACTIVE'
                                            : 'INACTIVE'
                                    }}

                                </span>

                            </article>

                        @endforeach

                    </div>


                @else

                    <div class="employee-empty">

                        <span>
                            NO SERVICES
                        </span>

                        <h3>
                            Nothing assigned yet.
                        </h3>

                    </div>

                @endif

            </section>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — EMPLOYEE
========================================================= */

.employee-lux-page {

    --bg: #efebe6;
    --dark: #292724;
    --text: #48423d;
    --muted: #8f8781;

    --line:
        rgba(46, 42, 38, 0.11);

    --rose: #a87f73;
    --rose-dark: #88645a;

    --cream: #f6f0eb;
    --champagne: #eee3ca;
    --sage: #dce5d8;
    --sage-dark: #586d55;
    --soft-red: #ead5d1;
    --red-dark: #8d5951;


    height: 100svh;

    overflow: hidden;

    background: var(--bg);

    font-family:
        'Montserrat',
        sans-serif;
}



/* =========================================================
   APP
========================================================= */

.employee-lux-page #app {

    display: flex;

    width: 100%;
    height: 100svh;

    flex-direction: column;

    overflow: hidden;

    background: var(--bg);
}


.employee-lux-page main {

    flex: 1;

    min-height: 0;

    margin: 0 !important;
    padding: 0 !important;

    overflow: hidden;

    background: var(--bg);
}



/* =========================================================
   NAVBAR
========================================================= */

.employee-lux-page .navbar {

    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

    background:
        #efebe6 !important;

    border: 0 !important;

    box-shadow: none !important;
}


.employee-lux-page .navbar .container,
.employee-lux-page .navbar .container-fluid {

    min-height: 66px;
}


.employee-lux-page .navbar-brand {

    color: #272522 !important;

    font-weight: 400;

    letter-spacing: -0.035em;
}


.employee-lux-page .navbar .nav-link,
.employee-lux-page .navbar .dropdown-toggle {

    color:
        rgba(48,45,42,0.67) !important;

    font-size: 0.82rem;

    font-weight: 300;
}


.employee-lux-page .navbar .nav-link:hover,
.employee-lux-page .navbar .nav-link.active,
.employee-lux-page .navbar .dropdown-toggle:hover,
.employee-lux-page .navbar .dropdown-toggle:focus {

    color:
        #292724 !important;
}



/* =========================================================
   PAGE
========================================================= */

.employee-space {

    width: 100%;
    height: 100%;

    box-sizing: border-box;

    padding:
        8px
        0
        14px;

    overflow: hidden;

    background:

        radial-gradient(
            circle at 91% 3%,
            rgba(168,127,115,0.08),
            transparent 28%
        ),

        #efebe6;

    color: var(--dark);
}



/* =========================================================
   SHELL
========================================================= */

.employee-shell {

    display: flex;

    width:
        min(
            1400px,
            calc(100% - 56px)
        );

    height: 100%;

    min-height: 0;

    margin: 0 auto;

    flex-direction: column;
}



/* =========================================================
   PAGE HEADER
========================================================= */

.employee-page-header {

    flex: 0 0 auto;

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 40px;

    padding:
        4px
        0
        13px;

    border-bottom:
        1px solid var(--line);
}


.employee-eyebrow {

    display: block;

    margin-bottom: 6px;

    color: var(--rose);

    font-size: 0.62rem;

    font-weight: 500;

    letter-spacing: 0.21em;
}


.employee-page-header h1 {

    margin: 0;

    color: var(--dark);

    font-size:
        clamp(
            2.2rem,
            3vw,
            2.9rem
        );

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.05em;
}



/* =========================================================
   DATE
========================================================= */

.employee-date {

    padding-bottom: 2px;

    text-align: right;
}


.employee-date span {

    display: block;

    margin-bottom: 5px;

    color: var(--rose);

    font-size: 0.56rem;

    font-weight: 500;

    letter-spacing: 0.17em;
}


.employee-date strong {

    color: #514b46;

    font-size: 0.84rem;

    font-weight: 500;
}



/* =========================================================
   MAIN CONTENT

   KLJUČ:
   cijeli content je centriran vertikalno.
========================================================= */

.employee-content {

    flex: 1;

    min-height: 0;

    display: grid;

    grid-template-columns:
        minmax(360px, 0.72fr)
        minmax(0, 1.28fr);

    gap: 34px;

    align-items: center;
}



/* =========================================================
   LEFT + RIGHT
   POTPUNO ISTA VISINA
========================================================= */

.employee-left,
.employee-right {

    height:
        min(
            500px,
            calc(100% - 28px)
        );

    min-height: 420px;

    box-sizing: border-box;
}



/* =========================================================
   LEFT
========================================================= */

.employee-left {

    display: grid;

    grid-template-rows:
        92px
        minmax(0, 1fr)
        82px;

    gap: 0;

    overflow: hidden;
}



/* =========================================================
   EMPLOYEE HEADER
========================================================= */

.employee-left-head {

    display: flex;

    justify-content: center;

    flex-direction: column;

    box-sizing: border-box;

    padding:
        10px
        4px
        13px;

    border-bottom:
        1px solid var(--line);
}


.employee-label {

    display: block;

    margin-bottom: 7px;

    color: var(--rose);

    font-size: 0.59rem;

    font-weight: 500;

    letter-spacing: 0.19em;
}


.employee-name-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.employee-name-row h2 {

    margin: 0;

    color: #302d2a;

    font-size:
        clamp(
            1.8rem,
            2vw,
            2.2rem
        );

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.05em;
}


.employee-name-row p {

    margin:
        6px
        0
        0;

    color: var(--muted);

    font-size: 0.7rem;

    font-weight: 300;
}



/* =========================================================
   EMPLOYEE STATUS
========================================================= */

.employee-status {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    white-space: nowrap;

    font-size: 0.51rem;

    font-weight: 500;

    letter-spacing: 0.11em;
}


.employee-status i {

    width: 7px;
    height: 7px;

    display: inline-block;

    border-radius: 50%;
}


.employee-status.active {

    color: var(--sage-dark);
}


.employee-status.active i {

    background: #789073;
}


.employee-status.inactive {

    color: var(--red-dark);
}


.employee-status.inactive i {

    background: #ad6b60;
}



/* =========================================================
   LEFT STATS
========================================================= */

.employee-stats {

    display: grid;

    grid-template-rows:
        repeat(
            4,
            minmax(0, 1fr)
        );

    gap: 5px;

    padding:
        5px
        0;
}


.employee-stat {

    display: flex;

    align-items: center;

    justify-content: space-between;

    min-height: 0;

    box-sizing: border-box;

    padding:
        10px
        16px;
}


.employee-stat.today {

    background:
        rgba(246,240,235,0.76);
}


.employee-stat.services {

    background:
        rgba(238,227,202,0.78);
}


.employee-stat.active {

    background:
        rgba(220,229,216,0.80);
}


.employee-stat.inactive {

    background:
        rgba(234,213,209,0.80);
}


.employee-stat span {

    color: #655d58;

    font-size: 0.58rem;

    font-weight: 500;

    letter-spacing: 0.13em;
}


.employee-stat strong {

    color: #403a36;

    font-size: 1.5rem;

    font-weight: 300;

    line-height: 1;
}


.employee-stat.services strong {

    color: #796640;
}


.employee-stat.active strong {

    color: var(--sage-dark);
}


.employee-stat.inactive strong {

    color: var(--red-dark);
}



/* =========================================================
   CONTACT
========================================================= */

.employee-contact {

    display: grid;

    grid-template-rows:
        repeat(2, 1fr);

    border-top:
        1px solid var(--line);
}


.employee-contact > div {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    border-bottom:
        1px solid var(--line);
}


.employee-contact span {

    color: #978b84;

    font-size: 0.51rem;

    font-weight: 500;

    letter-spacing: 0.14em;
}


.employee-contact strong {

    max-width: 260px;

    overflow: hidden;

    color: #514b46;

    text-align: right;

    font-size: 0.68rem;

    font-weight: 400;

    white-space: nowrap;

    text-overflow: ellipsis;
}



/* =========================================================
   RIGHT
========================================================= */

.employee-right {

    display: grid;

    grid-template-rows:
        92px
        minmax(0, 1fr);

    overflow: hidden;
}



/* =========================================================
   SERVICES HEADER
   ISTA VISINA KAO EMPLOYEE HEADER
========================================================= */

.employee-right-head {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

    box-sizing: border-box;

    padding:
        12px
        16px;

    background:

        linear-gradient(
            90deg,
            rgba(168,127,115,0.09),
            rgba(168,127,115,0.025) 60%,
            transparent
        );

    border-bottom:
        1px solid var(--line);
}


.employee-right-head h2 {

    margin: 0;

    color: #302d2a;

    font-size: 1.55rem;

    font-weight: 300;

    line-height: 1;

    letter-spacing: -0.035em;
}



/* =========================================================
   SERVICE COUNT
========================================================= */

.employee-service-count {

    text-align: right;
}


.employee-service-count strong {

    display: block;

    color: #765b53;

    font-size: 1.6rem;

    font-weight: 300;

    line-height: 1;
}


.employee-service-count span {

    display: block;

    margin-top: 5px;

    color: var(--rose-dark);

    font-size: 0.47rem;

    font-weight: 500;

    letter-spacing: 0.14em;
}



/* =========================================================
   SERVICES LIST

   3 SERVICEA = ravnomjerno ispune ostatak.
========================================================= */

.employee-service-list {

    display: flex;

    min-height: 0;

    flex-direction: column;

    justify-content: center;
}



/* =========================================================
   SERVICE ROW
========================================================= */

.employee-service-row {

    flex: 1;

    min-height: 0;

    display: grid;

    grid-template-columns:
        42px
        minmax(0,1fr)
        120px
        130px
        90px;

    align-items: center;

    gap: 18px;

    box-sizing: border-box;

    padding:
        12px
        16px;

    border-bottom:
        1px solid var(--line);

    transition:
        background 0.2s ease;
}


.employee-service-row:first-child {

    border-top:
        1px solid var(--line);
}


.employee-service-row:hover {

    background:
        rgba(168,127,115,0.06);
}



/* =========================================================
   SERVICE NUMBER
========================================================= */

.employee-service-number {

    color: var(--rose);

    font-size: 0.57rem;

    font-weight: 500;

    letter-spacing: 0.12em;
}



/* =========================================================
   SERVICE NAME
========================================================= */

.employee-service-name {

    min-width: 0;

    overflow: hidden;

    color: #34302d;

    font-size: 0.96rem;

    font-weight: 500;

    white-space: nowrap;

    text-overflow: ellipsis;
}



/* =========================================================
   SERVICE INFO
========================================================= */

.employee-service-info span {

    display: block;

    margin-bottom: 5px;

    color: #94857e;

    font-size: 0.49rem;

    font-weight: 500;

    letter-spacing: 0.12em;
}


.employee-service-info strong {

    color: #403a36;

    font-size: 0.72rem;

    font-weight: 500;

    white-space: nowrap;
}



/* =========================================================
   SERVICE STATUS
========================================================= */

.employee-service-status {

    display: inline-flex;

    align-items: center;

    justify-self: end;

    gap: 7px;

    white-space: nowrap;

    font-size: 0.5rem;

    font-weight: 500;

    letter-spacing: 0.1em;
}


.employee-service-status i {

    width: 7px;
    height: 7px;

    display: inline-block;

    border-radius: 50%;
}


.employee-service-status.active {

    color: #52694f;
}


.employee-service-status.active i {

    background: #718b6c;
}


.employee-service-status.inactive {

    color: #8d564e;
}


.employee-service-status.inactive i {

    background: #a8665c;
}



/* =========================================================
   EMPTY
========================================================= */

.employee-empty {

    display: flex;

    min-height: 0;

    align-items: center;

    justify-content: center;

    flex-direction: column;

    text-align: center;
}


.employee-empty > span {

    margin-bottom: 8px;

    color: var(--rose);

    font-size: 0.57rem;

    font-weight: 500;

    letter-spacing: 0.17em;
}


.employee-empty h3 {

    margin: 0;

    color: #302d2a;

    font-size: 1.4rem;

    font-weight: 300;
}



/* =========================================================
   SHORTER DESKTOP
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .employee-lux-page .navbar {

        flex-basis: 58px;

        min-height: 58px;
    }


    .employee-lux-page .navbar .container,
    .employee-lux-page .navbar .container-fluid {

        min-height: 58px;
    }


    .employee-space {

        padding:
            4px
            0
            6px;
    }


    .employee-page-header {

        padding-bottom: 7px;
    }


    .employee-eyebrow {

        margin-bottom: 3px;

        font-size: 0.53rem;
    }


    .employee-page-header h1 {

        font-size: 1.95rem;
    }


    .employee-left,
    .employee-right {

        height:
            min(
                410px,
                calc(100% - 12px)
            );

        min-height: 360px;
    }


    .employee-left {

        grid-template-rows:
            72px
            minmax(0,1fr)
            58px;
    }


    .employee-right {

        grid-template-rows:
            72px
            minmax(0,1fr);
    }


    .employee-left-head {

        padding:
            6px
            3px;
    }


    .employee-name-row h2 {

        font-size: 1.5rem;
    }


    .employee-label {

        margin-bottom: 4px;

        font-size: 0.51rem;
    }


    .employee-stat {

        padding:
            6px
            12px;
    }


    .employee-stat strong {

        font-size: 1.15rem;
    }


    .employee-right-head {

        padding:
            8px
            13px;
    }


    .employee-right-head h2 {

        font-size: 1.2rem;
    }


    .employee-service-row {

        padding:
            8px
            13px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .employee-lux-page {

        height: auto;

        min-height: 100svh;

        overflow-y: auto;
    }


    .employee-lux-page #app {

        height: auto;

        min-height: 100svh;

        overflow: visible;
    }


    .employee-lux-page main {

        overflow: visible;
    }


    .employee-space {

        height: auto;

        min-height:
            calc(100svh - 66px);

        overflow: visible;

        padding:
            20px
            0
            32px;
    }


    .employee-shell {

        width:
            calc(100% - 34px);

        height: auto;
    }


    .employee-content {

        display: grid;

        grid-template-columns: 1fr;

        gap: 28px;

        padding-top: 25px;
    }


    .employee-left,
    .employee-right {

        width: 100%;

        height: auto;

        min-height: 0;
    }


    .employee-left {

        grid-template-rows:
            auto
            auto
            auto;
    }


    .employee-right {

        grid-template-rows:
            auto
            auto;
    }


    .employee-left-head {

        min-height: 100px;
    }


    .employee-stats {

        grid-template-rows:
            repeat(4, 75px);
    }


    .employee-contact > div {

        min-height: 42px;
    }


    .employee-right-head {

        min-height: 90px;
    }


    .employee-service-list {

        display: block;
    }


    .employee-service-row {

        min-height: 95px;
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .employee-shell {

        width:
            calc(100% - 24px);
    }


    .employee-page-header {

        align-items: flex-start;

        flex-direction: column;

        gap: 12px;
    }


    .employee-page-header h1 {

        font-size: 2rem;
    }


    .employee-date {

        text-align: left;
    }


    .employee-name-row {

        align-items: flex-start;

        flex-direction: column;

        gap: 9px;
    }


    .employee-right-head {

        padding:
            14px
            12px;
    }


    .employee-service-row {

        grid-template-columns:
            30px
            minmax(0,1fr)
            auto;

        grid-template-areas:
            "number name status"
            "number duration price";

        gap:
            10px
            12px;

        min-height: 110px;

        padding:
            14px
            12px;
    }


    .employee-service-number {

        grid-area: number;
    }


    .employee-service-name {

        grid-area: name;
    }


    .employee-service-info:nth-of-type(3) {

        grid-area: duration;
    }


    .employee-service-info:nth-of-type(4) {

        grid-area: price;
    }


    .employee-service-status {

        grid-area: status;

        justify-self: end;
    }


    .employee-contact > div {

        align-items: flex-start;

        justify-content: center;

        flex-direction: column;

        gap: 4px;

        padding:
            7px
            0;
    }


    .employee-contact strong {

        max-width: 100%;

        text-align: left;
    }

}



/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .employee-service-row {

        transition: none;
    }

}

</style>

@endpush