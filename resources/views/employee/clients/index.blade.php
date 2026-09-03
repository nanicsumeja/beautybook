@extends('layouts.app')

@section('body-class', 'employee-clients-page')

@section('content')

<section class="employee-clients-space">

    <div class="employee-clients-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="employee-clients-header">

            <div>

                <span class="clients-eyebrow">
                    EMPLOYEE WORKSPACE
                </span>

                <h1>
                    Clients
                </h1>

                <p>
                    Clients who have appointments with you.
                </p>

            </div>

        </div>


        {{-- =====================================================
             TOOLBAR
        ====================================================== --}}
        <div class="clients-toolbar">

            <form
                method="GET"
                action="{{ route('employee.clients.index') }}"
                class="clients-search-form"
            >

                <div class="clients-search-field">

                    <label for="search">
                        SEARCH CLIENTS
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Name, email or phone"
                    >

                </div>


                <button type="submit">
                    SEARCH
                </button>


                @if ($search !== '')

                    <a
                        href="{{ route('employee.clients.index') }}"
                        class="clients-clear"
                    >
                        CLEAR
                    </a>

                @endif

            </form>

        </div>


        {{-- =====================================================
             EMPTY
        ====================================================== --}}
        @if ($clients->isEmpty())

            <div class="clients-empty">

                <span>
                    NO CLIENTS
                </span>

                <h2>
                    No clients found.
                </h2>

                <p>

                    @if ($search !== '')

                        No clients match your search.

                    @else

                        You currently have no clients.

                    @endif

                </p>

            </div>

        @else


            {{-- =================================================
                 CLIENT LIST
            ================================================== --}}
            <div class="clients-list">

                <div class="clients-list-header">

                    <span>
                        CLIENT
                    </span>

                    <span>
                        EMAIL
                    </span>

                    <span>
                        PHONE
                    </span>

                    <span></span>

                </div>


                @foreach ($clients as $client)

                    <article class="client-row">


                        {{-- =========================================
                             CLIENT
                        ========================================== --}}
                        <div class="client-identity">

                            <div class="client-avatar">

                                {{
                                    mb_strtoupper(
                                        mb_substr($client->name, 0, 1)
                                    )
                                }}

                            </div>


                            <div>

                                <span class="client-mobile-label">
                                    CLIENT
                                </span>

                                <strong>
                                    {{ $client->name }}
                                    {{ $client->surname }}
                                </strong>

                            </div>

                        </div>



                        {{-- =========================================
                             EMAIL
                        ========================================== --}}
                        <div class="client-contact">

                            <span class="client-mobile-label">
                                EMAIL
                            </span>

                            <strong>
                                {{ $client->email }}
                            </strong>

                        </div>



                        {{-- =========================================
                             PHONE
                        ========================================== --}}
                        <div class="client-contact">

                            <span class="client-mobile-label">
                                PHONE
                            </span>

                            <strong>
                                {{ $client->phone ?: '-' }}
                            </strong>

                        </div>



                        {{-- =========================================
                             ACTION
                        ========================================== --}}
                        <div class="client-action">

                            <a
                                href="{{ route(
                                    'employee.clients.show',
                                    $client
                                ) }}"
                            >
                                VIEW
                                <span>→</span>
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}
            <div class="clients-pagination">

                {{ $clients->links() }}

            </div>

        @endif

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — EMPLOYEE CLIENTS
========================================================= */

.employee-clients-page {
    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}



/* =========================================================
   APP
========================================================= */

.employee-clients-page #app {
    display: flex;

    width: 100%;

    min-height: 100svh;

    flex-direction: column;

    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.employee-clients-page .navbar {
    position: relative;

    z-index: 50;

    flex:
        0
        0
        66px;

    min-height: 66px;

    padding-top:
        0 !important;

    padding-bottom:
        0 !important;

    background:
        #efebe6 !important;

    border:
        0 !important;

    box-shadow:
        none !important;

    font-family:
        'Montserrat',
        sans-serif !important;
}


.employee-clients-page .navbar .container,
.employee-clients-page .navbar .container-fluid {
    min-height:
        66px;
}


/* BEAUTYBOOK */

.employee-clients-page .navbar-brand {
    color:
        #272522 !important;

    font-family:
        'Montserrat',
        sans-serif !important;

    font-weight:
        400 !important;

    letter-spacing:
        -0.035em !important;
}


/* DASHBOARD / MY SCHEDULE / CLIENTS */

.employee-clients-page .navbar .nav-link,
.employee-clients-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-family:
        'Montserrat',
        sans-serif !important;

    font-size:
        0.82rem !important;

    font-weight:
        300 !important;

    letter-spacing:
        normal !important;
}


.employee-clients-page .navbar .nav-link:hover,
.employee-clients-page .navbar .nav-link.active,
.employee-clients-page .navbar .dropdown-toggle:hover,
.employee-clients-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}


/* DROPDOWN */

.employee-clients-page .navbar .dropdown-menu {
    margin-top:
        8px;

    padding:
        7px
        0;

    background:
        #f4f0ec;

    border:
        1px solid rgba(46,42,38,0.11);

    border-radius:
        0;

    box-shadow:
        0 12px 30px rgba(46,42,38,0.07);

    font-family:
        'Montserrat',
        sans-serif;
}


.employee-clients-page .navbar .dropdown-item {
    padding:
        8px
        16px;

    color:
        #4b4743;

    font-family:
        'Montserrat',
        sans-serif;

    font-size:
        0.72rem;

    font-weight:
        300;
}


.employee-clients-page .navbar .dropdown-item:hover,
.employee-clients-page .navbar .dropdown-item:focus {
    background:
        #e8dfda;

    color:
        #292724;
}



/* =========================================================
   PAGE
========================================================= */

.employee-clients-space {
    min-height:
        calc(100vh - 66px);

    padding:
        28px
        0
        40px;

    background:

        radial-gradient(
            circle at 92% 6%,
            rgba(190,151,140,0.12),
            transparent 24%
        ),

        #f3efea;

    color:
        #211d1a;

    font-family:
        'Montserrat',
        sans-serif;
}



/* =========================================================
   SHELL
========================================================= */

.employee-clients-shell {
    width:
        min(
            1180px,
            calc(100% - 48px)
        );

    margin:
        0
        auto;
}



/* =========================================================
   HEADER
========================================================= */

.employee-clients-header {
    margin-bottom:
        20px;

    padding-bottom:
        17px;

    border-bottom:
        1px solid rgba(33,29,26,0.12);
}


.clients-eyebrow {
    display:
        block;

    margin-bottom:
        6px;

    font-size:
        0.56rem;

    font-weight:
        500;

    letter-spacing:
        0.2em;

    color:
        #a27a6d;
}


.employee-clients-header h1 {
    margin:
        0
        0
        5px;

    font-size:
        clamp(
            2rem,
            4vw,
            3.1rem
        );

    font-weight:
        300;

    letter-spacing:
        -0.045em;
}


.employee-clients-header p {
    margin:
        0;

    font-size:
        0.74rem;

    color:
        #7c736d;
}



/* =========================================================
   TOOLBAR
========================================================= */

.clients-toolbar {
    margin-bottom:
        18px;
}


.clients-search-form {
    display:
        flex;

    align-items:
        flex-end;

    gap:
        7px;
}


.clients-search-field {
    width:
        min(
            470px,
            100%
        );
}


.clients-search-field label {
    display:
        block;

    margin-bottom:
        5px;

    font-size:
        0.47rem;

    letter-spacing:
        0.14em;

    color:
        #92796f;
}


.clients-search-field input {
    width:
        100%;

    height:
        40px;

    padding:
        0
        13px;

    border:
        1px solid rgba(33,29,26,0.16);

    background:
        #faf7f3;

    color:
        #211d1a;

    font-family:
        inherit;

    font-size:
        0.67rem;

    outline:
        none;
}


.clients-search-field input:focus {
    border-color:
        #a27a6d;
}



/* =========================================================
   SEARCH BUTTON
========================================================= */

.clients-search-form button,
.clients-clear {
    height:
        40px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        0
        15px;

    border:
        1px solid #211d1a;

    background:
        #211d1a;

    color:
        #fff;

    text-decoration:
        none;

    font-family:
        inherit;

    font-size:
        0.48rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.clients-clear {
    background:
        transparent;

    color:
        #211d1a;
}


.clients-search-form button:hover {
    background:
        #9d7063;

    border-color:
        #9d7063;
}



/* =========================================================
   LIST
========================================================= */

.clients-list {
    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);
}


.clients-list-header {
    display:
        grid;

    grid-template-columns:
        1.15fr
        1.25fr
        0.9fr
        0.35fr;

    gap:
        22px;

    padding:
        13px
        22px;

    background:
        #211d1a;

    color:
        #cbbeb8;
}


.clients-list-header span {
    font-size:
        0.46rem;

    letter-spacing:
        0.14em;
}



/* =========================================================
   CLIENT ROW
========================================================= */

.client-row {
    display:
        grid;

    grid-template-columns:
        1.15fr
        1.25fr
        0.9fr
        0.35fr;

    gap:
        22px;

    align-items:
        center;

    padding:
        15px
        22px;

    border-bottom:
        1px solid rgba(33,29,26,0.09);

    transition:
        background 0.15s ease;
}


.client-row:last-child {
    border-bottom:
        0;
}


.client-row:hover {
    background:
        #f3ebe6;
}



/* =========================================================
   CLIENT
========================================================= */

.client-identity {
    display:
        flex;

    align-items:
        center;

    gap:
        13px;

    min-width:
        0;
}


.client-avatar {
    width:
        40px;

    height:
        40px;

    flex-shrink:
        0;

    display:
        grid;

    place-items:
        center;

    background:
        #dec7bd;

    color:
        #211d1a;

    font-size:
        0.9rem;

    font-weight:
        400;
}


.client-identity strong,
.client-contact strong {
    display:
        block;

    font-size:
        0.67rem;

    font-weight:
        500;

    word-break:
        break-word;
}


.client-mobile-label {
    display:
        none;
}



/* =========================================================
   ACTION
========================================================= */

.client-action {
    text-align:
        right;
}


.client-action a {
    display:
        inline-flex;

    align-items:
        center;

    gap:
        8px;

    color:
        #211d1a;

    text-decoration:
        none;

    font-size:
        0.48rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.client-action a:hover {
    color:
        #9d7063;
}



/* =========================================================
   EMPTY
========================================================= */

.clients-empty {
    padding:
        70px
        30px;

    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);

    text-align:
        center;
}


.clients-empty > span {
    display:
        block;

    margin-bottom:
        7px;

    font-size:
        0.5rem;

    letter-spacing:
        0.16em;

    color:
        #a27a6d;
}


.clients-empty h2 {
    margin:
        0
        0
        7px;

    font-size:
        1.45rem;

    font-weight:
        300;
}


.clients-empty p {
    margin:
        0;

    font-size:
        0.67rem;

    color:
        #7c736d;
}



/* =========================================================
   PAGINATION
========================================================= */

.clients-pagination {
    margin-top:
        18px;
}



/* =========================================================
   SHORT DESKTOP
   SAME NAVBAR AS EMPLOYEE DASHBOARD
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .employee-clients-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .employee-clients-page .navbar .container,
    .employee-clients-page .navbar .container-fluid {
        min-height:
            58px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 800px) {

    .clients-list-header {
        display:
            none;
    }


    .client-row {
        grid-template-columns:
            1fr
            1fr;
    }


    .client-mobile-label {
        display:
            block;

        margin-bottom:
            4px;

        font-size:
            0.43rem;

        letter-spacing:
            0.12em;

        color:
            #9c8177;
    }


    .client-action {
        text-align:
            left;
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .employee-clients-space {
        padding:
            22px
            0
            32px;
    }


    .employee-clients-shell {
        width:
            calc(100% - 24px);
    }


    .clients-search-form {
        align-items:
            stretch;

        flex-direction:
            column;
    }


    .clients-search-field {
        width:
            100%;
    }


    .clients-search-form button,
    .clients-clear {
        width:
            100%;
    }


    .client-row {
        grid-template-columns:
            1fr;

        gap:
            13px;

        padding:
            18px;
    }

}

</style>

@endpush