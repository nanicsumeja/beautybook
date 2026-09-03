@extends('layouts.app')

@section('body-class', 'owner-services-page')
@section('main-class', 'owner-services-main')

@section('content')

@php
    $totalCount = $services->count();
    $activeCount = $services->where('is_active', true)->count();
    $inactiveCount = $totalCount - $activeCount;
@endphp


<section class="owner-services-space">

    <div class="owner-services-shell">

        {{-- HEADER --}}
        <header class="owner-services-header">

            <div>
                <span class="owner-services-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Services
                </h1>

                <p>
                    Manage treatments, pricing and availability.
                </p>
            </div>

            <div class="owner-services-header-actions">

                <a
                    href="{{ route('owner.services.create') }}"
                    class="owner-services-primary"
                >
                    <span>+</span>
                    ADD SERVICE
                </a>

                <a
                    href="{{ route('owner.dashboard') }}"
                    class="owner-services-dashboard-link"
                >
                    DASHBOARD
                </a>

            </div>

        </header>


        {{-- SUCCESS --}}
        @if (session('success'))

            <div class="owner-services-success">

                <span>✓</span>

                <p>
                    {{ session('success') }}
                </p>

            </div>

        @endif


        {{-- SUMMARY --}}
        <div class="owner-services-summary">

            <article>
                <span>TOTAL SERVICES</span>
                <strong>{{ $totalCount }}</strong>
                <small>catalogue</small>
            </article>

            <article>
                <span>ACTIVE</span>
                <strong>{{ $activeCount }}</strong>
                <small>available</small>
            </article>

            <article>
                <span>INACTIVE</span>
                <strong>{{ $inactiveCount }}</strong>
                <small>unavailable</small>
            </article>

        </div>


        {{-- TOOLBAR --}}
        <div class="owner-services-toolbar">

            <label
                class="owner-services-search"
                for="serviceSearch"
            >

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>

                <input
                    type="search"
                    id="serviceSearch"
                    placeholder="Search services"
                    autocomplete="off"
                >

            </label>


            <div class="owner-services-filters">

                <button
                    type="button"
                    class="active"
                    data-service-filter="all"
                >
                    ALL
                </button>

                <button
                    type="button"
                    data-service-filter="active"
                >
                    ACTIVE
                </button>

                <button
                    type="button"
                    data-service-filter="inactive"
                >
                    INACTIVE
                </button>

            </div>

        </div>


        {{-- EMPTY --}}
        @if ($services->isEmpty())

            <section class="owner-services-empty">

                <span class="owner-services-empty-icon">
                    +
                </span>

                <h2>
                    No services yet
                </h2>

                <p>
                    Add the first treatment to your salon catalogue.
                </p>

                <a
                    href="{{ route('owner.services.create') }}"
                    class="owner-services-primary"
                >
                    ADD FIRST SERVICE
                </a>

            </section>

        @else

            {{-- SERVICES --}}
            <section class="owner-services-card">

                <div class="owner-services-card-heading">

                    <div>
                        <span>
                            SERVICE CATALOGUE
                        </span>

                        <h2>
                            Treatment overview
                        </h2>
                    </div>

                    <strong>
                        {{ $totalCount }}
                        {{ $totalCount === 1 ? 'SERVICE' : 'SERVICES' }}
                    </strong>

                </div>


                <div class="owner-services-list-head">
                    <span>SERVICE</span>
                    <span>PRICE</span>
                    <span>DURATION</span>
                    <span>STATUS</span>
                    <span>ACTIONS</span>
                </div>


                <div
                    class="owner-services-list"
                    id="servicesTableBody"
                >

                    @foreach ($services as $service)

                        <article
                            class="owner-service-row"
                            data-service-row
                            data-status="{{
                                $service->is_active
                                    ? 'active'
                                    : 'inactive'
                            }}"
                            data-search="{{
                                mb_strtolower(
                                    $service->name . ' ' .
                                    ($service->description ?? '')
                                )
                            }}"
                        >

                            {{-- SERVICE --}}
                            <div class="owner-service-info">

                                <div class="owner-service-initial">
                                    {{
                                        mb_strtoupper(
                                            mb_substr(
                                                $service->name,
                                                0,
                                                1
                                            )
                                        )
                                    }}
                                </div>

                                <div>

                                    <span class="owner-service-mobile-label">
                                        SERVICE
                                    </span>

                                    <strong>
                                        {{ $service->name }}
                                    </strong>

                                    @if ($service->description)

                                        <p title="{{ $service->description }}">
                                            {{ $service->description }}
                                        </p>

                                    @else

                                        <p class="is-empty">
                                            No description
                                        </p>

                                    @endif

                                </div>

                            </div>


                            {{-- PRICE --}}
                            <div class="owner-service-value">

                                <span class="owner-service-mobile-label">
                                    PRICE
                                </span>

                                <strong>
                                    {{
                                        number_format(
                                            (float) $service->price,
                                            2
                                        )
                                    }}
                                </strong>

                                <small>KM</small>

                            </div>


                            {{-- DURATION --}}
                            <div class="owner-service-value">

                                <span class="owner-service-mobile-label">
                                    DURATION
                                </span>

                                <strong>
                                    {{ $service->duration_minutes }}
                                </strong>

                                <small>min</small>

                            </div>


                            {{-- STATUS --}}
                            <div class="owner-service-status-cell">

                                <span class="owner-service-mobile-label">
                                    STATUS
                                </span>

                                @if ($service->is_active)

                                    <span class="owner-service-status active">
                                        <i></i>
                                        ACTIVE
                                    </span>

                                @else

                                    <span class="owner-service-status inactive">
                                        <i></i>
                                        INACTIVE
                                    </span>

                                @endif

                            </div>


                            {{-- ACTIONS --}}
                            <div class="owner-service-actions">

                                <a
                                    href="{{ route(
                                        'owner.services.edit',
                                        $service
                                    ) }}"
                                    class="owner-service-edit"
                                >
                                    EDIT
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
                                        class="owner-service-delete"
                                    >
                                        DELETE
                                    </button>

                                </form>

                            </div>

                        </article>

                    @endforeach


                    <div
                        class="owner-services-no-results"
                        id="servicesNoResults"
                        hidden
                    >
                        No services match your search.
                    </div>

                </div>


                <footer class="owner-services-footer">

                    <span id="serviceResultCount">
                        Showing {{ $totalCount }}
                        {{
                            $totalCount === 1
                                ? 'service'
                                : 'services'
                        }}
                    </span>

                    <a href="{{ route('owner.dashboard') }}">
                        BACK TO DASHBOARD
                    </a>

                </footer>

            </section>

        @endif

    </div>

</section>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.getElementById('serviceSearch');

    const rows = Array.from(
        document.querySelectorAll('[data-service-row]')
    );

    const filterButtons = Array.from(
        document.querySelectorAll('[data-service-filter]')
    );

    const resultCount =
        document.getElementById('serviceResultCount');

    const noResults =
        document.getElementById('servicesNoResults');

    if (!searchInput || rows.length === 0) {
        return;
    }

    let activeFilter = 'all';

    const updateServices = () => {
        const query = searchInput.value
            .trim()
            .toLowerCase();

        let visibleCount = 0;

        rows.forEach((row) => {
            const matchesSearch =
                row.dataset.search.includes(query);

            const matchesStatus =
                activeFilter === 'all'
                || row.dataset.status === activeFilter;

            const visible =
                matchesSearch && matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        if (resultCount) {
            resultCount.textContent =
                `Showing ${visibleCount} `
                + (
                    visibleCount === 1
                        ? 'service'
                        : 'services'
                );
        }

        if (noResults) {
            noResults.hidden = visibleCount !== 0;
        }
    };

    searchInput.addEventListener(
        'input',
        updateServices
    );

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter =
                button.dataset.serviceFilter;

            filterButtons.forEach((item) => {
                item.classList.toggle(
                    'active',
                    item === button
                );
            });

            updateServices();
        });
    });
});
</script>

@endsection


@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER SERVICES
========================================================= */

.owner-services-page {
    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


/* =========================================================
   APP
========================================================= */

.owner-services-page #app {
    display: flex;

    width: 100%;

    min-height: 100svh;

    flex-direction: column;

    background: #efebe6;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-services-main {
    background: #f3efea;
}


/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-services-page .navbar {
    position: relative;

    z-index: 50;

    flex: 0 0 66px;

    min-height: 66px;

    padding-top: 0 !important;
    padding-bottom: 0 !important;

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


.owner-services-page .navbar .container,
.owner-services-page .navbar .container-fluid {
    min-height: 66px;
}


/* BEAUTYBOOK */

.owner-services-page .navbar-brand {
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


/* NAV LINKS */

.owner-services-page .navbar .nav-link,
.owner-services-page .navbar .dropdown-toggle {
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

    transition:
        color 0.25s ease;
}


.owner-services-page .navbar .nav-link:hover,
.owner-services-page .navbar .nav-link.active,
.owner-services-page .navbar .dropdown-toggle:hover,
.owner-services-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}


/* DROPDOWN */

.owner-services-page .navbar .dropdown-menu {
    margin-top: 8px;

    padding: 7px 0;

    background: #f4f0ec;

    border:
        1px solid rgba(46,42,38,0.11);

    border-radius: 0;

    box-shadow:
        0 12px 30px rgba(46,42,38,0.07);

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-services-page .navbar .dropdown-item {
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


.owner-services-page .navbar .dropdown-item:hover,
.owner-services-page .navbar .dropdown-item:focus {
    background:
        #e8dfda;

    color:
        #292724;
}


/* =========================================================
   PAGE
========================================================= */

.owner-services-space {
    min-height:
        calc(100vh - 66px);

    padding:
        27px
        0
        40px;

    background:
        radial-gradient(
            circle at 93% 4%,
            rgba(190,151,140,0.12),
            transparent 23%
        ),
        #f3efea;

    color:
        #211d1a;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-services-shell {
    width:
        min(
            1160px,
            calc(100% - 48px)
        );

    margin:
        0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.owner-services-header {
    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 25px;

    padding-bottom: 17px;

    margin-bottom: 15px;

    border-bottom:
        1px solid rgba(33,29,26,0.12);
}


.owner-services-eyebrow {
    display: block;

    margin-bottom: 5px;

    color:
        #a0796d;

    font-size:
        0.64rem;

    font-weight:
        500;

    letter-spacing:
        0.19em;
}


.owner-services-header h1 {
    margin:
        0
        0
        5px;

    font-size:
        clamp(
            2rem,
            4vw,
            3rem
        );

    font-weight:
        300;

    letter-spacing:
        -0.045em;
}


.owner-services-header p {
    margin: 0;

    color:
        #81766f;

    font-size:
        0.76rem;
}


.owner-services-header-actions {
    display: flex;

    align-items: center;

    gap: 13px;
}


.owner-services-primary {
    min-height:
        41px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        9px;

    padding:
        0
        16px;

    border:
        1px solid #211d1a;

    background:
        #211d1a;

    color:
        #fff;

    text-decoration:
        none;

    font-size:
        0.58rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;
}


.owner-services-primary > span {
    font-size:
        0.9rem;

    font-weight:
        300;

    line-height:
        1;
}


.owner-services-primary:hover {
    background:
        #9d7063;

    border-color:
        #9d7063;

    color:
        #fff;
}


.owner-services-dashboard-link {
    color:
        #211d1a;

    text-decoration:
        none;

    font-size:
        0.57rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;
}


.owner-services-dashboard-link:hover {
    color:
        #9d7063;
}


/* =========================================================
   SUCCESS
========================================================= */

.owner-services-success {
    display: flex;

    align-items:
        center;

    gap:
        10px;

    margin-bottom:
        13px;

    padding:
        12px
        15px;

    background:
        #dfe5dd;

    border-left:
        3px solid #72806e;

    color:
        #566251;
}


.owner-services-success > span {
    font-size:
        0.7rem;
}


.owner-services-success p {
    margin:
        0;

    font-size:
        0.68rem;
}


/* =========================================================
   SUMMARY
========================================================= */

.owner-services-summary {
    display:
        grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:
        10px;

    margin-bottom:
        13px;
}


.owner-services-summary article {
    min-height:
        87px;

    padding:
        15px
        17px;

    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);
}


.owner-services-summary span {
    display:
        block;

    margin-bottom:
        7px;

    color:
        #967a71;

    font-size:
        0.56rem;

    letter-spacing:
        0.12em;
}


.owner-services-summary strong {
    display:
        block;

    font-size:
        1.65rem;

    font-weight:
        300;

    line-height:
        1;
}


.owner-services-summary small {
    display:
        block;

    margin-top:
        4px;

    color:
        #9a8f88;

    font-size:
        0.62rem;
}


/* =========================================================
   TOOLBAR
========================================================= */

.owner-services-toolbar {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        15px;

    margin-bottom:
        12px;
}


.owner-services-search {
    width:
        min(
            410px,
            100%
        );

    height:
        40px;

    display:
        flex;

    align-items:
        center;

    gap:
        9px;

    padding:
        0
        13px;

    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.13);
}


.owner-services-search svg {
    width:
        14px;

    height:
        14px;

    flex-shrink:
        0;

    fill:
        none;

    stroke:
        #8c7f78;

    stroke-width:
        1.5;
}


.owner-services-search input {
    width:
        100%;

    border:
        0;

    outline:
        0;

    background:
        transparent;

    color:
        #211d1a;

    font-family:
        inherit;

    font-size:
        0.7rem;
}


.owner-services-filters {
    display:
        inline-flex;

    align-items:
        center;

    gap:
        3px;

    padding:
        3px;

    background:
        #e9e0da;
}


.owner-services-filters button {
    min-height:
        31px;

    padding:
        0
        13px;

    border:
        0;

    background:
        transparent;

    color:
        #84766f;

    font-family:
        inherit;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.1em;

    cursor:
        pointer;
}


.owner-services-filters button.active {
    background:
        #211d1a;

    color:
        #fff;
}


/* =========================================================
   CARD
========================================================= */

.owner-services-card {
    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);
}


.owner-services-card-heading {
    min-height:
        71px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    padding:
        15px
        20px;

    border-bottom:
        1px solid rgba(33,29,26,0.09);
}


.owner-services-card-heading span {
    display:
        block;

    margin-bottom:
        3px;

    color:
        #9f776b;

    font-size:
        0.56rem;

    letter-spacing:
        0.14em;
}


.owner-services-card-heading h2 {
    margin:
        0;

    font-size:
        1.05rem;

    font-weight:
        300;
}


.owner-services-card-heading > strong {
    color:
        #8b7b73;

    font-size:
        0.57rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;
}


/* =========================================================
   LIST HEAD
========================================================= */

.owner-services-list-head {
    display:
        grid;

    grid-template-columns:
        1.55fr
        0.55fr
        0.65fr
        0.7fr
        0.85fr;

    gap:
        18px;

    padding:
        11px
        20px;

    background:
        #e9e0da;

    color:
        #090808;
}


.owner-services-list-head span {
    font-size:
        0.52rem;

    letter-spacing:
        0.12em;
}


/* =========================================================
   ROW
========================================================= */

.owner-service-row {
    display:
        grid;

    grid-template-columns:
        1.55fr
        0.55fr
        0.65fr
        0.7fr
        0.85fr;

    gap:
        18px;

    align-items:
        center;

    min-height:
        75px;

    padding:
        11px
        20px;

    border-bottom:
        1px solid rgba(33,29,26,0.08);

    transition:
        background 0.15s ease;
}


.owner-service-row:last-of-type {
    border-bottom:
        0;
}


.owner-service-row:hover {
    background:
        #f3ebe6;
}


/* =========================================================
   SERVICE INFO
========================================================= */

.owner-service-info {
    display:
        flex;

    align-items:
        center;

    gap:
        11px;

    min-width:
        0;
}


.owner-service-initial {
    width:
        37px;

    height:
        37px;

    flex-shrink:
        0;

    display:
        grid;

    place-items:
        center;

    background:
        #dec7bd;

    font-size:
        0.73rem;
}


.owner-service-info strong {
    display:
        block;

    font-size:
        0.72rem;

    font-weight:
        500;
}


.owner-service-info p {
    max-width:
        280px;

    margin:
        3px
        0
        0;

    overflow:
        hidden;

    color:
        #91857e;

    font-size:
        0.6rem;

    line-height:
        1.4;

    text-overflow:
        ellipsis;

    white-space:
        nowrap;
}


.owner-service-info p.is-empty {
    color:
        #aaa09a;

    font-style:
        italic;
}


/* =========================================================
   VALUES
========================================================= */

.owner-service-value strong {
    font-size:
        0.72rem;

    font-weight:
        400;
}


.owner-service-value small {
    margin-left:
        2px;

    color:
        #948980;

    font-size:
        0.58rem;
}


/* =========================================================
   STATUS
========================================================= */

.owner-service-status {
    display:
        inline-flex;

    align-items:
        center;

    gap:
        6px;

    padding:
        5px
        8px;

    font-size:
        0.52rem;

    font-weight:
        500;

    letter-spacing:
        0.08em;
}


.owner-service-status i {
    width:
        5px;

    height:
        5px;

    border-radius:
        50%;
}


.owner-service-status.active {
    background:
        #dce5da;

    color:
        #5c6b59;
}


.owner-service-status.active i {
    background:
        #6b7c68;
}


.owner-service-status.inactive {
    background:
        #ead8d4;

    color:
        #885f56;
}


.owner-service-status.inactive i {
    background:
        #9d6b61;
}


/* =========================================================
   ACTIONS
========================================================= */

.owner-service-actions {
    display:
        flex;

    align-items:
        center;

    justify-content:
        flex-end;

    gap:
        7px;
}


.owner-service-actions form {
    margin:
        0;
}


.owner-service-edit,
.owner-service-delete {
    min-height:
        29px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        0
        9px;

    font-family:
        inherit;

    font-size:
        0.52rem;

    font-weight:
        500;

    letter-spacing:
        0.09em;
}


.owner-service-edit {
    border:
        1px solid rgba(33,29,26,0.22);

    color:
        #211d1a;

    text-decoration:
        none;
}


.owner-service-edit:hover {
    background:
        #211d1a;

    border-color:
        #211d1a;

    color:
        #fff;
}


.owner-service-delete {
    border:
        1px solid rgba(157,96,85,0.24);

    background:
        transparent;

    color:
        #9d6055;

    cursor:
        pointer;
}


.owner-service-delete:hover {
    background:
        #9d6055;

    border-color:
        #9d6055;

    color:
        #fff;
}


/* =========================================================
   MOBILE LABEL
========================================================= */

.owner-service-mobile-label {
    display:
        none;
}


/* =========================================================
   FOOTER
========================================================= */

.owner-services-footer {
    min-height:
        49px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    padding:
        0
        20px;

    border-top:
        1px solid rgba(33,29,26,0.09);

    color:
        #8c8079;
}


.owner-services-footer span {
    font-size:
        0.58rem;
}


.owner-services-footer a {
    color:
        #211d1a;

    text-decoration:
        none;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.09em;
}


.owner-services-footer a:hover {
    color:
        #9d7063;
}


/* =========================================================
   NO RESULTS
========================================================= */

.owner-services-no-results {
    padding:
        45px
        20px;

    color:
        #8b8079;

    text-align:
        center;

    font-size:
        0.68rem;
}


/* =========================================================
   EMPTY
========================================================= */

.owner-services-empty {
    padding:
        70px
        25px;

    background:
        #faf7f3;

    border:
        1px solid rgba(33,29,26,0.08);

    text-align:
        center;
}


.owner-services-empty-icon {
    display:
        block;

    margin-bottom:
        7px;

    color:
        #b48d82;

    font-size:
        1.6rem;

    font-weight:
        300;
}


.owner-services-empty h2 {
    margin:
        0
        0
        6px;

    font-size:
        1.25rem;

    font-weight:
        300;
}


.owner-services-empty p {
    margin:
        0
        0
        18px;

    color:
        #897d76;

    font-size:
        0.68rem;
}


/* =========================================================
   SHORT DESKTOP — SAME NAVBAR
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-services-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .owner-services-page .navbar .container,
    .owner-services-page .navbar .container-fluid {
        min-height:
            58px;
    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 880px) {

    .owner-services-list-head {
        display:
            none;
    }


    .owner-service-row {
        grid-template-columns:
            1fr
            1fr;

        padding:
            17px
            20px;
    }


    .owner-service-mobile-label {
        display:
            block;

        margin-bottom:
            4px;

        color:
            #9e8076;

        font-size:
            0.52rem;

        letter-spacing:
            0.1em;
    }


    .owner-service-actions {
        justify-content:
            flex-start;
    }

}


@media (max-width: 650px) {

    .owner-services-header {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .owner-services-header-actions {
        width:
            100%;

        justify-content:
            space-between;
    }


    .owner-services-toolbar {
        align-items:
            stretch;

        flex-direction:
            column;
    }


    .owner-services-search {
        width:
            100%;
    }


    .owner-services-filters {
        align-self:
            flex-start;
    }


    .owner-services-summary {
        grid-template-columns:
            1fr;
    }

}


@media (max-width: 575px) {

    .owner-services-space {
        padding:
            21px
            0
            32px;
    }


    .owner-services-shell {
        width:
            calc(100% - 24px);
    }


    .owner-service-row {
        grid-template-columns:
            1fr;

        gap:
            13px;
    }


    .owner-services-card-heading {
        align-items:
            flex-start;

        flex-direction:
            column;

        gap:
            7px;
    }


    .owner-services-footer {
        align-items:
            flex-start;

        flex-direction:
            column;

        padding:
            14px
            20px;
    }

}

</style>

@endpush