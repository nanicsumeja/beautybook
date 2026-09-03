@extends('layouts.app')

@section('body-class', 'owner-service-form-page')
@section('main-class', 'owner-service-form-main')

@section('content')

<section class="owner-service-form-space">

    <div class="owner-service-form-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="owner-service-form-header">

            <div>

                <span class="owner-service-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Edit service
                </h1>

                <p>
                    Update treatment details and availability.
                </p>

            </div>


            <a
                href="{{ route('owner.services.index') }}"
                class="owner-service-form-back"
            >
                ← SERVICES
            </a>

        </header>



        <div class="owner-service-form-grid">


            {{-- =================================================
                 FORM
            ================================================== --}}
            <section class="owner-service-form-card">

                <div class="owner-service-form-card-heading">

                    <div>

                        <span>
                            EDIT TREATMENT
                        </span>

                        <h2>
                            Service details
                        </h2>

                    </div>


                    <div
                        class="
                            owner-service-status-badge
                            {{
                                $service->is_active
                                    ? 'is-active'
                                    : 'is-inactive'
                            }}
                        "
                    >
                        {{
                            $service->is_active
                                ? 'ACTIVE'
                                : 'INACTIVE'
                        }}
                    </div>

                </div>



                {{-- CURRENT SERVICE --}}
                <div class="owner-service-edit-context">

                    <span>
                        CURRENT SERVICE
                    </span>

                    <strong>
                        {{ $service->name }}
                    </strong>

                </div>



                <form
                    method="POST"
                    action="{{ route(
                        'owner.services.update',
                        $service
                    ) }}"
                    class="owner-service-form"
                    novalidate
                >

                    @csrf
                    @method('PUT')


                    <div class="owner-service-form-content">

                        @include('owner.services._form')

                    </div>



                    <footer class="owner-service-form-actions">

                        <a
                            href="{{ route('owner.services.index') }}"
                            class="owner-service-secondary"
                        >
                            CANCEL
                        </a>


                        <button
                            type="submit"
                            class="owner-service-primary"
                        >

                            <span>
                                SAVE CHANGES
                            </span>

                            <span>
                                →
                            </span>

                        </button>

                    </footer>

                </form>

            </section>



            {{-- =================================================
                 SIDE PANEL
            ================================================== --}}
            <aside class="owner-service-form-side">

                <span class="owner-service-form-side-eyebrow">
                    SERVICE SETTINGS
                </span>


                <h2>
                    Keep your treatment information up to date.
                </h2>


                <p>
                    Changes to service details, pricing and
                    availability will apply to future bookings.
                </p>



                <div class="owner-service-form-steps">

                    <article>

                        <span>
                            01
                        </span>

                        <div>

                            <strong>
                                Service information
                            </strong>

                            <p>
                                Update the treatment name or
                                description shown to clients.
                            </p>

                        </div>

                    </article>



                    <article>

                        <span>
                            02
                        </span>

                        <div>

                            <strong>
                                Price & duration
                            </strong>

                            <p>
                                Keep treatment pricing and
                                appointment length accurate.
                            </p>

                        </div>

                    </article>



                    <article>

                        <span>
                            03
                        </span>

                        <div>

                            <strong>
                                Availability
                            </strong>

                            <p>
                                Choose whether clients can
                                currently book this service.
                            </p>

                        </div>

                    </article>

                </div>



                {{-- CURRENT STATUS --}}
                <div class="owner-service-current">

                    <span>
                        CURRENT STATUS
                    </span>


                    <div class="owner-service-current-status">

                        <i
                            class="{{
                                $service->is_active
                                    ? 'is-active'
                                    : 'is-inactive'
                            }}"
                        ></i>

                        <strong>
                            {{
                                $service->is_active
                                    ? 'Active service'
                                    : 'Inactive service'
                            }}
                        </strong>

                    </div>


                    <p>
                        {{ $service->name }}
                    </p>

                </div>

            </aside>

        </div>

    </div>

</section>



<script>
document.addEventListener('DOMContentLoaded', () => {

    const description =
        document.getElementById('description');

    const counter =
        document.getElementById('descriptionCounter');


    if (!description || !counter) {
        return;
    }


    const updateCounter = () => {

        counter.textContent =
            `${description.value.length} / 1000`;

    };


    description.addEventListener(
        'input',
        updateCounter
    );


    updateCounter();

});
</script>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER EDIT SERVICE
========================================================= */

.owner-service-form-page {
    min-height:
        100svh;

    background:
        #f3efea;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-service-form-page #app {
    display:
        flex;

    width:
        100%;

    min-height:
        100svh;

    flex-direction:
        column;

    background:
        #f3efea;
}


.owner-service-form-main {
    background:
        #f3efea;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-service-form-page .navbar {
    position:
        relative;

    z-index:
        50;

    flex:
        0 0 66px;

    min-height:
        66px;

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
}


.owner-service-form-page .navbar .container,
.owner-service-form-page .navbar .container-fluid {
    min-height:
        66px;
}


.owner-service-form-page .navbar-brand {
    color:
        #272522 !important;

    font-weight:
        400;

    letter-spacing:
        -0.035em;
}


.owner-service-form-page .navbar .nav-link,
.owner-service-form-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-size:
        0.82rem;

    font-weight:
        300;
}


.owner-service-form-page .navbar .nav-link:hover,
.owner-service-form-page .navbar .nav-link.active,
.owner-service-form-page .navbar .dropdown-toggle:hover,
.owner-service-form-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}



/* =========================================================
   PAGE
========================================================= */

.owner-service-form-space {
    min-height:
        calc(100vh - 66px);

    padding:
        27px
        0
        40px;

    background:
        radial-gradient(
            circle at 92% 5%,
            rgba(190,151,140,0.13),
            transparent 23%
        ),
        #f3efea;

    color:
        #292724;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-service-form-shell {
    width:
        min(
            1050px,
            calc(100% - 48px)
        );

    margin:
        0 auto;
}



/* =========================================================
   HEADER
========================================================= */

.owner-service-form-header {
    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        24px;

    margin-bottom:
        17px;

    padding-bottom:
        17px;

    border-bottom:
        1px solid rgba(46,42,38,0.12);
}


.owner-service-form-eyebrow {
    display:
        block;

    margin-bottom:
        5px;

    color:
        #a0796d;

    font-size:
        0.61rem;

    font-weight:
        500;

    letter-spacing:
        0.19em;
}


.owner-service-form-header h1 {
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


.owner-service-form-header p {
    margin:
        0;

    color:
        #81766f;

    font-size:
        0.74rem;

    font-weight:
        300;
}


.owner-service-form-back {
    color:
        #6d635d;

    text-decoration:
        none;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.11em;

    transition:
        color 0.2s ease;
}


.owner-service-form-back:hover {
    color:
        #a87f73;
}



/* =========================================================
   MAIN GRID
========================================================= */

.owner-service-form-grid {
    display:
        grid;

    grid-template-columns:
        minmax(0,1.25fr)
        minmax(285px,0.75fr);

    align-items:
        stretch;

    border:
        1px solid rgba(46,42,38,0.08);

    background:
        #faf7f3;
}



/* =========================================================
   FORM CARD
========================================================= */

.owner-service-form-card {
    min-width:
        0;

    background:
        #faf7f3;
}


.owner-service-form-card-heading {
    min-height:
        80px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    padding:
        17px
        22px;

    border-bottom:
        1px solid rgba(46,42,38,0.09);
}


.owner-service-form-card-heading
> div:first-child
> span {
    display:
        block;

    margin-bottom:
        4px;

    color:
        #9f776b;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.13em;
}


.owner-service-form-card-heading h2 {
    margin:
        0;

    color:
        #332d2a;

    font-size:
        1.14rem;

    font-weight:
        300;
}



/* =========================================================
   STATUS BADGE
========================================================= */

.owner-service-status-badge {
    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    flex-shrink:
        0;

    min-height:
        26px;

    padding:
        0
        9px;

    font-size:
        0.50rem;

    font-weight:
        500;

    letter-spacing:
        0.09em;
}


.owner-service-status-badge.is-active {
    background:
        #dce5d8;

    color:
        #586b55;
}


.owner-service-status-badge.is-inactive {
    background:
        #ead5d1;

    color:
        #87564e;
}



/* =========================================================
   CURRENT SERVICE STRIP
========================================================= */

.owner-service-edit-context {
    display:
        flex;

    align-items:
        center;

    gap:
        10px;

    min-height:
        46px;

    padding:
        0
        22px;

    background:
        #eee4de;

    border-bottom:
        1px solid rgba(46,42,38,0.08);
}


.owner-service-edit-context span {
    color:
        #9d7e74;

    font-size:
        0.52rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;
}


.owner-service-edit-context strong {
    min-width:
        0;

    overflow:
        hidden;

    color:
        #4a423e;

    font-size:
        0.67rem;

    font-weight:
        500;

    text-overflow:
        ellipsis;

    white-space:
        nowrap;
}


.owner-service-form {
    margin:
        0;
}


.owner-service-form-content {
    padding:
        23px
        22px
        25px;
}



/* =========================================================
   VALIDATION
========================================================= */

.owner-service-form-content
.service-form-errors {
    margin-bottom:
        19px;

    padding:
        13px
        15px;

    background:
        #ead8d4;

    border-left:
        3px solid #a7675b;
}


.owner-service-form-content
.service-form-errors strong {
    display:
        block;

    margin-bottom:
        4px;

    color:
        #754c45;

    font-size:
        0.67rem;

    font-weight:
        500;
}


.owner-service-form-content
.service-form-errors > span {
    display:
        block;

    color:
        #94675e;

    font-size:
        0.60rem;

    line-height:
        1.5;
}



/* =========================================================
   FORM GRID FROM _form.blade.php
========================================================= */

.owner-service-form-content
.service-form-grid {
    display:
        grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0,1fr)
        );

    gap:
        18px
        15px;

    border:
        0;
}


.owner-service-form-content
.service-form-field {
    min-width:
        0;
}


.owner-service-form-content
.service-form-field-wide {
    grid-column:
        1 / -1;
}



/* =========================================================
   LABELS
========================================================= */

.owner-service-form-content
.service-form-field > label {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        10px;

    margin-bottom:
        7px;

    color:
        #625954;

    font-size:
        0.56rem;

    font-weight:
        500;

    letter-spacing:
        0.08em;

    text-transform:
        uppercase;
}


.owner-service-form-content
.service-form-field
> label
> span {
    color:
        #a18f86;

    font-size:
        0.50rem;

    font-weight:
        400;

    letter-spacing:
        0.08em;
}



/* =========================================================
   INPUTS
========================================================= */

.owner-service-form-content
.service-form-field input,
.owner-service-form-content
.service-form-field textarea {
    width:
        100%;

    min-height:
        43px;

    padding:
        10px
        12px;

    border:
        1px solid rgba(46,42,38,0.14);

    border-radius:
        0;

    outline:
        0;

    background:
        #f7f2ee;

    box-shadow:
        none;

    color:
        #292724;

    font-family:
        inherit;

    font-size:
        0.68rem;

    transition:
        border-color 0.15s ease,
        box-shadow 0.15s ease,
        background 0.15s ease;
}


.owner-service-form-content
.service-form-field textarea {
    min-height:
        112px;

    resize:
        vertical;

    line-height:
        1.6;
}


.owner-service-form-content
.service-form-field input:focus,
.owner-service-form-content
.service-form-field textarea:focus {
    border-color:
        #aa8074;

    background:
        #fbf8f5;

    box-shadow:
        0 0 0 2px rgba(170,128,116,0.07);
}


.owner-service-form-content
.service-form-field input::placeholder,
.owner-service-form-content
.service-form-field textarea::placeholder {
    color:
        #aaa09a;
}


.owner-service-form-content
.service-form-field .is-invalid {
    border-color:
        #ae6b60;
}



/* =========================================================
   PRICE / DURATION SUFFIX
========================================================= */

.owner-service-form-content
.service-input-with-suffix {
    position:
        relative;
}


.owner-service-form-content
.service-input-with-suffix input {
    padding-right:
        47px;
}


.owner-service-form-content
.service-input-with-suffix > span {
    position:
        absolute;

    top:
        50%;

    right:
        12px;

    transform:
        translateY(-50%);

    color:
        #968981;

    font-size:
        0.58rem;

    pointer-events:
        none;
}



/* =========================================================
   DESCRIPTION
========================================================= */

.owner-service-form-content
.service-description-footer {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        15px;

    margin-top:
        6px;
}


.owner-service-form-content
.service-description-footer small {
    color:
        #978b84;

    font-size:
        0.56rem;
}


.owner-service-form-content
.service-field-error {
    display:
        block;

    margin-top:
        5px;

    color:
        #a45f55;

    font-size:
        0.56rem;

    line-height:
        1.45;
}



/* =========================================================
   AVAILABILITY
========================================================= */

.owner-service-form-content
.service-availability {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    margin-top:
        22px;

    padding:
        16px
        17px;

    background:
        #eee4de;

    border:
        1px solid rgba(46,42,38,0.08);
}


.owner-service-form-content
.service-availability
> div
> strong {
    display:
        block;

    margin-bottom:
        3px;

    color:
        #4f4742;

    font-size:
        0.68rem;

    font-weight:
        500;
}


.owner-service-form-content
.service-availability
> div
> span {
    display:
        block;

    color:
        #8e817a;

    font-size:
        0.58rem;
}



/* =========================================================
   ACTIVE TOGGLE
========================================================= */

.owner-service-form-content
.service-toggle {
    display:
        flex;

    align-items:
        center;

    gap:
        8px;

    margin:
        0;

    cursor:
        pointer;
}


.owner-service-form-content
.service-toggle
input[type="hidden"] {
    display:
        none;
}


.owner-service-form-content
.service-toggle
input[type="checkbox"] {
    position:
        absolute;

    width:
        1px;

    height:
        1px;

    opacity:
        0;

    pointer-events:
        none;
}


.owner-service-form-content
.service-toggle-track {
    position:
        relative;

    width:
        34px;

    height:
        18px;

    flex-shrink:
        0;

    background:
        #c9bbb4;

    transition:
        background 0.18s ease;
}


.owner-service-form-content
.service-toggle-track i {
    position:
        absolute;

    top:
        3px;

    left:
        3px;

    width:
        12px;

    height:
        12px;

    background:
        #fff;

    transition:
        transform 0.18s ease;
}


.owner-service-form-content
.service-toggle
input[type="checkbox"]:checked
+ .service-toggle-track {
    background:
        #71836d;
}


.owner-service-form-content
.service-toggle
input[type="checkbox"]:checked
+ .service-toggle-track i {
    transform:
        translateX(16px);
}


.owner-service-form-content
.service-toggle em {
    color:
        #5f5651;

    font-size:
        0.58rem;

    font-style:
        normal;

    font-weight:
        500;

    letter-spacing:
        0.06em;

    text-transform:
        uppercase;
}



/* =========================================================
   FORM ACTIONS
========================================================= */

.owner-service-form-actions {
    min-height:
        70px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        15px;

    padding:
        13px
        22px;

    border-top:
        1px solid rgba(46,42,38,0.09);

    background:
        #f7f2ee;
}


.owner-service-secondary {
    color:
        #786d67;

    text-decoration:
        none;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;
}


.owner-service-secondary:hover {
    color:
        #a87f73;
}


.owner-service-primary {
    min-width:
        175px;

    min-height:
        42px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        18px;

    padding:
        0
        15px;

    border:
        1px solid #a67f73;

    background:
        #a67f73;

    color:
        #fff;

    font-family:
        inherit;

    font-size:
        0.55rem;

    font-weight:
        500;

    letter-spacing:
        0.10em;

    cursor:
        pointer;

    transition:
        background 0.18s ease,
        border-color 0.18s ease;
}


.owner-service-primary:hover {
    background:
        #8f695f;

    border-color:
        #8f695f;
}


.owner-service-primary span:last-child {
    font-size:
        0.75rem;

    font-weight:
        300;
}



/* =========================================================
   SIDE PANEL
========================================================= */

.owner-service-form-side {
    display:
        flex;

    flex-direction:
        column;

    min-width:
        0;

    padding:
        29px
        27px;

    background:
        #e5d4cd;

    border-left:
        1px solid rgba(46,42,38,0.07);

    color:
        #3d3531;
}


.owner-service-form-side-eyebrow {
    display:
        block;

    margin-bottom:
        10px;

    color:
        #956e63;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.15em;
}


.owner-service-form-side > h2 {
    max-width:
        300px;

    margin:
        0
        0
        10px;

    color:
        #3e3531;

    font-size:
        clamp(
            1.4rem,
            2.7vw,
            1.95rem
        );

    font-weight:
        300;

    line-height:
        1.10;

    letter-spacing:
        -0.035em;
}


.owner-service-form-side > p {
    max-width:
        310px;

    margin:
        0;

    color:
        #776963;

    font-size:
        0.64rem;

    line-height:
        1.7;
}



/* =========================================================
   SIDE STEPS
========================================================= */

.owner-service-form-steps {
    margin-top:
        27px;

    border-top:
        1px solid rgba(78,61,54,0.12);
}


.owner-service-form-steps article {
    display:
        grid;

    grid-template-columns:
        30px
        1fr;

    gap:
        10px;

    padding:
        16px
        0;

    border-bottom:
        1px solid rgba(78,61,54,0.12);
}


.owner-service-form-steps article > span {
    color:
        #9d7063;

    font-size:
        0.53rem;

    font-weight:
        500;
}


.owner-service-form-steps strong {
    display:
        block;

    margin-bottom:
        3px;

    color:
        #4a3d38;

    font-size:
        0.67rem;

    font-weight:
        500;
}


.owner-service-form-steps p {
    margin:
        0;

    color:
        #82736c;

    font-size:
        0.59rem;

    line-height:
        1.55;
}



/* =========================================================
   CURRENT STATUS
========================================================= */

.owner-service-current {
    margin-top:
        auto;

    padding:
        15px;

    background:
        rgba(255,255,255,0.30);

    border:
        1px solid rgba(112,81,72,0.10);
}


.owner-service-current > span {
    display:
        block;

    margin-bottom:
        8px;

    color:
        #936a5f;

    font-size:
        0.51rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.owner-service-current-status {
    display:
        flex;

    align-items:
        center;

    gap:
        7px;
}


.owner-service-current-status i {
    width:
        6px;

    height:
        6px;

    flex-shrink:
        0;

    border-radius:
        50%;
}


.owner-service-current-status i.is-active {
    background:
        #71836d;
}


.owner-service-current-status i.is-inactive {
    background:
        #b5786c;
}


.owner-service-current-status strong {
    color:
        #544640;

    font-size:
        0.65rem;

    font-weight:
        500;
}


.owner-service-current > p {
    margin:
        5px
        0
        0
        13px;

    color:
        #81736c;

    font-size:
        0.58rem;
}



/* =========================================================
   SHORT DESKTOP — SAME AS EMPLOYEE DASHBOARD
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-service-form-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .owner-service-form-page .navbar .container,
    .owner-service-form-page .navbar .container-fluid {
        min-height:
            58px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 830px) {

    .owner-service-form-grid {
        grid-template-columns:
            1fr;
    }


    .owner-service-form-side {
        min-height:
            360px;

        border-left:
            0;

        border-top:
            1px solid rgba(46,42,38,0.08);
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .owner-service-form-space {
        padding:
            21px
            0
            32px;
    }


    .owner-service-form-shell {
        width:
            calc(100% - 24px);
    }


    .owner-service-form-header {
        align-items:
            flex-start;

        flex-direction:
            column;

        gap:
            13px;
    }


    .owner-service-form-card-heading {
        align-items:
            flex-start;
    }


    .owner-service-form-content {
        padding:
            20px
            18px;
    }


    .owner-service-form-content
    .service-form-grid {
        grid-template-columns:
            1fr;
    }


    .owner-service-form-content
    .service-form-field-wide {
        grid-column:
            auto;
    }


    .owner-service-form-content
    .service-availability {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .owner-service-form-actions {
        align-items:
            stretch;

        flex-direction:
            column-reverse;

        padding:
            16px
            18px
            19px;
    }


    .owner-service-primary {
        width:
            100%;
    }


    .owner-service-secondary {
        align-self:
            center;
    }


    .owner-service-form-side {
        min-height:
            auto;

        padding:
            25px
            21px;
    }


    .owner-service-current {
        margin-top:
            25px;
    }

}

</style>

@endpush