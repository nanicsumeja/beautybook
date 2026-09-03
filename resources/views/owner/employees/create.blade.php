@extends('layouts.app')

@section('body-class', 'owner-employee-form-page')

@section('main-class', 'owner-employee-form-main')

@section('content')

<section class="owner-employee-form-space">

    <div class="owner-employee-form-shell">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header class="owner-employee-form-header">

            <div>

                <span class="owner-employee-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Add employee
                </h1>

                <p>
                    Create an employee account and assign salon services.
                </p>

            </div>


            <a
                href="{{ route('owner.employees.index') }}"
                class="owner-employee-form-back"
            >
                ← EMPLOYEES
            </a>

        </header>



        {{-- =====================================================
             ERROR SUMMARY
        ====================================================== --}}
        @if ($errors->any())

            <div class="owner-employee-form-message error">

                <span>!</span>

                <p>
                    Please review the highlighted fields.
                </p>

            </div>

        @endif



        <div class="owner-employee-form-layout">


            {{-- =================================================
                 FORM
            ================================================== --}}
            <section class="owner-employee-form-card">

                <header class="owner-employee-form-card-header">

                    <div>

                        <span>
                            NEW TEAM MEMBER
                        </span>

                        <h2>
                            Employee details
                        </h2>

                    </div>


                    <p>
                        Account, contact information and services.
                    </p>

                </header>



                <form
                    method="POST"
                    action="{{ route('owner.employees.store') }}"
                    class="owner-employee-form"
                    novalidate
                >
                    @csrf


                    <div class="owner-employee-form-content">

                        @include('owner.employees._form')

                    </div>



                    <footer class="owner-employee-form-actions">

                        <a
                            href="{{ route('owner.employees.index') }}"
                            class="owner-employee-secondary"
                        >
                            CANCEL
                        </a>


                        <button
                            type="submit"
                            class="owner-employee-primary"
                        >
                            <span>
                                SAVE EMPLOYEE
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
            <aside class="owner-employee-form-side">

                <span class="owner-employee-form-side-eyebrow">
                    EMPLOYEE SETUP
                </span>


                <h2>
                    Build a complete salon team profile.
                </h2>


                <p>
                    Add account details, assign treatments and decide
                    whether this employee can access the system.
                </p>



                <div class="owner-employee-form-steps">

                    <article>

                        <span>
                            01
                        </span>

                        <div>

                            <strong>
                                Account information
                            </strong>

                            <p>
                                Add the employee's personal,
                                contact and login details.
                            </p>

                        </div>

                    </article>



                    <article>

                        <span>
                            02
                        </span>

                        <div>

                            <strong>
                                Assigned services
                            </strong>

                            <p>
                                Select which salon treatments
                                this employee can provide.
                            </p>

                        </div>

                    </article>



                    <article>

                        <span>
                            03
                        </span>

                        <div>

                            <strong>
                                Account access
                            </strong>

                            <p>
                                Active employees can sign in
                                and appear in booking availability.
                            </p>

                        </div>

                    </article>

                </div>



                <div class="owner-employee-form-side-note">

                    <span>
                        NEXT STEP
                    </span>

                    <p>
                        After creating the employee, you can define
                        their weekly working hours from the team directory.
                    </p>

                </div>

            </aside>

        </div>

    </div>

</section>

@endsection



@push('styles')

<style>

/* =========================================================
   BEAUTYBOOK — OWNER ADD EMPLOYEE
========================================================= */

.owner-employee-form-page {
    min-height: 100svh;

    background:
        #f3efea;

    font-family:
        'Montserrat',
        sans-serif;
}


.owner-employee-form-page #app {
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


.owner-employee-form-main {
    background:
        #f3efea;
}



/* =========================================================
   NAVBAR — SAME AS EMPLOYEE DASHBOARD
========================================================= */

.owner-employee-form-page .navbar {
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


.owner-employee-form-page .navbar .container,
.owner-employee-form-page .navbar .container-fluid {
    min-height:
        66px;
}


.owner-employee-form-page .navbar-brand {
    color:
        #272522 !important;

    font-weight:
        400;

    letter-spacing:
        -0.035em;
}


.owner-employee-form-page .navbar .nav-link,
.owner-employee-form-page .navbar .dropdown-toggle {
    color:
        rgba(48,45,42,0.67) !important;

    font-size:
        0.82rem;

    font-weight:
        300;
}


.owner-employee-form-page .navbar .nav-link:hover,
.owner-employee-form-page .navbar .nav-link.active,
.owner-employee-form-page .navbar .dropdown-toggle:hover,
.owner-employee-form-page .navbar .dropdown-toggle:focus {
    color:
        #292724 !important;
}



/* =========================================================
   PAGE
========================================================= */

.owner-employee-form-space {
    min-height:
        calc(100vh - 66px);

    padding:
        27px
        0
        42px;

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


.owner-employee-form-shell {
    width:
        min(
            1080px,
            calc(100% - 48px)
        );

    margin:
        0 auto;
}



/* =========================================================
   HEADER
========================================================= */

.owner-employee-form-header {
    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        25px;

    margin-bottom:
        17px;

    padding-bottom:
        17px;

    border-bottom:
        1px solid rgba(46,42,38,0.12);
}


.owner-employee-form-eyebrow {
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


.owner-employee-form-header h1 {
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


.owner-employee-form-header p {
    margin:
        0;

    color:
        #81766f;

    font-size:
        0.74rem;

    font-weight:
        300;
}


.owner-employee-form-back {
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


.owner-employee-form-back:hover {
    color:
        #a87f73;
}



/* =========================================================
   ERROR MESSAGE
========================================================= */

.owner-employee-form-message {
    display:
        flex;

    align-items:
        center;

    gap:
        10px;

    margin-bottom:
        16px;

    padding:
        11px
        14px;
}


.owner-employee-form-message > span {
    width:
        19px;

    height:
        19px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    flex-shrink:
        0;

    border-radius:
        50%;

    font-size:
        0.45rem;
}


.owner-employee-form-message p {
    margin:
        0;

    font-size:
        0.66rem;
}


.owner-employee-form-message.error {
    border:
        1px solid rgba(164,95,85,0.18);

    background:
        #ead8d4;

    color:
        #82564e;
}


.owner-employee-form-message.error > span {
    border:
        1px solid rgba(164,95,85,0.3);
}



/* =========================================================
   MAIN LAYOUT
========================================================= */

.owner-employee-form-layout {
    display:
        grid;

    grid-template-columns:
        minmax(0,1.36fr)
        minmax(280px,0.64fr);

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

.owner-employee-form-card {
    min-width:
        0;

    background:
        #faf7f3;
}


.owner-employee-form-card-header {
    min-height:
        78px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        25px;

    padding:
        17px
        22px;

    border-bottom:
        1px solid rgba(46,42,38,0.09);
}


.owner-employee-form-card-header span {
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


.owner-employee-form-card-header h2 {
    margin:
        0;

    font-size:
        1.14rem;

    font-weight:
        300;
}


.owner-employee-form-card-header > p {
    max-width:
        180px;

    margin:
        0;

    color:
        #988d86;

    font-size:
        0.59rem;

    line-height:
        1.55;

    text-align:
        right;
}


.owner-employee-form {
    margin:
        0;
}


.owner-employee-form-content {
    padding:
        23px
        22px
        25px;
}



/* =========================================================
   FORM GRID
========================================================= */

.owner-employee-form-content .employee-form-grid {
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
}


.owner-employee-form-content .employee-form-field {
    min-width:
        0;
}



/* =========================================================
   FIELD LABELS
========================================================= */

.owner-employee-form-content
.employee-form-field > label {
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
}


.owner-employee-form-content
.employee-form-field > label > span {
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


.owner-employee-form-content
.employee-form-field > label > small {
    color:
        #a18f86;

    font-size:
        0.50rem;

    font-weight:
        400;

    letter-spacing:
        0.08em;

    text-transform:
        uppercase;
}



/* =========================================================
   INPUTS
========================================================= */

.owner-employee-form-content
.employee-form-field > input {
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
        none;

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


.owner-employee-form-content
.employee-form-field > input:focus {
    border-color:
        #aa8074;

    background:
        #fbf8f5;

    box-shadow:
        0 0 0 2px rgba(170,128,116,0.07);
}


.owner-employee-form-content
.employee-form-field > input.is-invalid {
    border-color:
        #ae6b60;
}


.owner-employee-form-content
.employee-field-error {
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
   SERVICES SECTION
========================================================= */

.owner-employee-form-content
.employee-services-section {
    margin-top:
        25px;

    padding-top:
        22px;

    border-top:
        1px solid rgba(46,42,38,0.09);
}


.owner-employee-form-content
.employee-section-heading {
    display:
        flex;

    align-items:
        flex-start;

    justify-content:
        space-between;

    gap:
        20px;

    margin-bottom:
        14px;
}


.owner-employee-form-content
.employee-section-heading strong {
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


.owner-employee-form-content
.employee-section-heading div > span {
    display:
        block;

    color:
        #8f837c;

    font-size:
        0.59rem;
}


.owner-employee-form-content
.employee-section-heading > small {
    flex-shrink:
        0;

    color:
        #9f796e;

    font-size:
        0.51rem;

    font-weight:
        500;

    letter-spacing:
        0.08em;

    text-transform:
        uppercase;
}



/* =========================================================
   SERVICES GRID
========================================================= */

.owner-employee-form-content
.employee-services-grid {
    display:
        grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0,1fr)
        );

    gap:
        8px;
}


.owner-employee-form-content
.employee-service-option {
    position:
        relative;

    min-height:
        48px;

    display:
        flex;

    align-items:
        center;

    gap:
        10px;

    margin:
        0;

    padding:
        9px
        11px;

    border:
        1px solid rgba(46,42,38,0.10);

    background:
        #f7f2ee;

    cursor:
        pointer;

    transition:
        background 0.15s ease,
        border-color 0.15s ease;
}


.owner-employee-form-content
.employee-service-option:hover {
    border-color:
        rgba(168,127,115,0.40);

    background:
        #f1e7e1;
}


.owner-employee-form-content
.employee-service-option > input {
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


.owner-employee-form-content
.employee-service-check {
    width:
        19px;

    height:
        19px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    flex-shrink:
        0;

    border:
        1px solid rgba(46,42,38,0.18);

    background:
        #fff;

    color:
        transparent;

    font-size:
        0.43rem;

    transition:
        background 0.15s ease,
        border-color 0.15s ease,
        color 0.15s ease;
}


.owner-employee-form-content
.employee-service-option
> input:checked
+ .employee-service-check {
    border-color:
        #a87f73;

    background:
        #a87f73;

    color:
        #fff;
}


.owner-employee-form-content
.employee-service-name {
    min-width:
        0;

    color:
        #5d544f;

    font-size:
        0.61rem;

    font-weight:
        500;
}


.owner-employee-form-content
.employee-service-name small {
    display:
        inline-block;

    margin-left:
        5px;

    padding:
        2px
        4px;

    background:
        #ead8d4;

    color:
        #8c6158;

    font-size:
        0.47rem;

    font-weight:
        500;

    text-transform:
        uppercase;
}


.owner-employee-form-content
.employee-services-empty {
    padding:
        16px;

    border:
        1px solid rgba(46,42,38,0.09);

    background:
        #eee5df;

    color:
        #8d817a;

    font-size:
        0.60rem;
}



/* =========================================================
   ACCOUNT ACCESS
========================================================= */

.owner-employee-form-content
.employee-access-row {
    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;

    margin-top:
        23px;

    padding:
        16px
        17px;

    border:
        1px solid rgba(46,42,38,0.08);

    background:
        #eee4de;
}


.owner-employee-form-content
.employee-access-row > div > strong {
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


.owner-employee-form-content
.employee-access-row > div > span {
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

.owner-employee-form-content
.employee-access-toggle {
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


.owner-employee-form-content
.employee-access-toggle
input[type="hidden"] {
    display:
        none;
}


.owner-employee-form-content
.employee-access-toggle
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


.owner-employee-form-content
.employee-toggle-track {
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


.owner-employee-form-content
.employee-toggle-track i {
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


.owner-employee-form-content
.employee-access-toggle
input[type="checkbox"]:checked
+ .employee-toggle-track {
    background:
        #71836d;
}


.owner-employee-form-content
.employee-access-toggle
input[type="checkbox"]:checked
+ .employee-toggle-track i {
    transform:
        translateX(16px);
}


.owner-employee-form-content
.employee-access-toggle em {
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
   ACTIONS
========================================================= */

.owner-employee-form-actions {
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


.owner-employee-secondary {
    color:
        #786d67;

    text-decoration:
        none;

    font-size:
        0.54rem;

    font-weight:
        500;

    letter-spacing:
        0.1em;
}


.owner-employee-secondary:hover {
    color:
        #a87f73;
}


.owner-employee-primary {
    min-width:
        185px;

    min-height:
        42px;

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
        0.1em;

    cursor:
        pointer;

    transition:
        background 0.18s ease,
        border-color 0.18s ease;
}


.owner-employee-primary:hover {
    background:
        #8f695f;

    border-color:
        #8f695f;
}


.owner-employee-primary span:last-child {
    font-size:
        0.75rem;

    font-weight:
        300;
}



/* =========================================================
   SIDE PANEL
========================================================= */

.owner-employee-form-side {
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


.owner-employee-form-side-eyebrow {
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


.owner-employee-form-side > h2 {
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
        1.1;

    letter-spacing:
        -0.035em;
}


.owner-employee-form-side > p {
    max-width:
        305px;

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

.owner-employee-form-steps {
    margin-top:
        27px;

    border-top:
        1px solid rgba(78,61,54,0.12);
}


.owner-employee-form-steps article {
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


.owner-employee-form-steps article > span {
    color:
        #9d7063;

    font-size:
        0.53rem;

    font-weight:
        500;
}


.owner-employee-form-steps strong {
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


.owner-employee-form-steps p {
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
   SIDE NOTE
========================================================= */

.owner-employee-form-side-note {
    margin-top:
        auto;

    padding:
        15px;

    background:
        rgba(255,255,255,0.30);

    border:
        1px solid rgba(112,81,72,0.10);
}


.owner-employee-form-side-note span {
    display:
        block;

    margin-bottom:
        6px;

    color:
        #936a5f;

    font-size:
        0.51rem;

    font-weight:
        500;

    letter-spacing:
        0.12em;
}


.owner-employee-form-side-note p {
    margin:
        0;

    color:
        #74665f;

    font-size:
        0.59rem;

    line-height:
        1.6;
}



/* =========================================================
   SHORT DESKTOP — SAME AS EMPLOYEE DASHBOARD
========================================================= */

@media (min-width: 901px) and (max-height: 800px) {

    .owner-employee-form-page .navbar {
        flex-basis:
            58px;

        min-height:
            58px;
    }


    .owner-employee-form-page .navbar .container,
    .owner-employee-form-page .navbar .container-fluid {
        min-height:
            58px;
    }

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .owner-employee-form-layout {
        grid-template-columns:
            1fr;
    }


    .owner-employee-form-side {
        min-height:
            360px;

        border-left:
            0;

        border-top:
            1px solid rgba(46,42,38,0.08);
    }

}



/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 650px) {

    .owner-employee-form-content
    .employee-form-grid {
        grid-template-columns:
            1fr;
    }


    .owner-employee-form-content
    .employee-services-grid {
        grid-template-columns:
            1fr;
    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    .owner-employee-form-space {
        padding:
            21px
            0
            32px;
    }


    .owner-employee-form-shell {
        width:
            calc(100% - 24px);
    }


    .owner-employee-form-header {
        align-items:
            flex-start;

        flex-direction:
            column;

        gap:
            13px;
    }


    .owner-employee-form-card-header {
        align-items:
            flex-start;

        flex-direction:
            column;

        gap:
            6px;
    }


    .owner-employee-form-card-header > p {
        max-width:
            none;

        text-align:
            left;
    }


    .owner-employee-form-content {
        padding:
            20px
            18px;
    }


    .owner-employee-form-content
    .employee-section-heading {
        flex-direction:
            column;

        gap:
            7px;
    }


    .owner-employee-form-content
    .employee-access-row {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .owner-employee-form-actions {
        align-items:
            stretch;

        flex-direction:
            column-reverse;

        padding:
            16px
            18px
            19px;
    }


    .owner-employee-primary {
        width:
            100%;
    }


    .owner-employee-secondary {
        align-self:
            center;
    }


    .owner-employee-form-side {
        min-height:
            auto;

        padding:
            25px
            21px;
    }


    .owner-employee-form-side-note {
        margin-top:
            25px;
    }

}

</style>

@endpush