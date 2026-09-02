@extends('layouts.app')

@section('body-class', 'owner-employee-form-page')
@section('main-class', 'owner-employee-form-main')

@section('content')

<section class="owner-employee-form-space">

    <div class="owner-employee-form-shell">

        {{-- HEADER --}}
        <header class="owner-employee-form-header">

            <div>
                <span class="owner-employee-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>Add employee</h1>

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


        {{-- ERROR SUMMARY --}}
        @if ($errors->any())
            <div class="owner-employee-form-message error">

                <span>!</span>

                <p>
                    Please review the highlighted fields.
                </p>

            </div>
        @endif


        <div class="owner-employee-form-layout">

            {{-- FORM --}}
            <section class="owner-employee-form-card">

                <header class="owner-employee-form-card-header">

                    <div>
                        <span>NEW TEAM MEMBER</span>

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
                            <span>SAVE EMPLOYEE</span>
                            <span>→</span>
                        </button>

                    </footer>

                </form>

            </section>


            {{-- SIDE PANEL --}}
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

                        <span>01</span>

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

                        <span>02</span>

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

                        <span>03</span>

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

                    <span>NEXT STEP</span>

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

    /* PAGE */

    .owner-employee-form-page,
    .owner-employee-form-main {
        background: #f3efea;
    }

    .owner-employee-form-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 42px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190,151,140,0.13),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-employee-form-shell {
        width: min(1080px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-employee-form-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        margin-bottom: 17px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-employee-form-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-employee-form-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-employee-form-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.69rem;
    }

    .owner-employee-form-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.43rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-employee-form-back:hover {
        color: #9d7063;
    }


    /* ERROR MESSAGE */

    .owner-employee-form-message {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding: 11px 14px;
    }

    .owner-employee-form-message > span {
        width: 19px;
        height: 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 50%;
        font-size: 0.45rem;
    }

    .owner-employee-form-message p {
        margin: 0;
        font-size: 0.52rem;
    }

    .owner-employee-form-message.error {
        border: 1px solid rgba(164,95,85,0.18);
        background: #ead8d4;
        color: #82564e;
    }

    .owner-employee-form-message.error > span {
        border: 1px solid rgba(164,95,85,0.3);
    }


    /* MAIN LAYOUT */

    .owner-employee-form-layout {
        display: grid;
        grid-template-columns: 1.35fr 0.65fr;
        align-items: stretch;
        border: 1px solid rgba(33,29,26,0.08);
    }


    /* FORM CARD */

    .owner-employee-form-card {
        min-width: 0;
        background: #faf7f3;
    }

    .owner-employee-form-card-header {
        min-height: 79px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 17px 22px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-employee-form-card-header span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .owner-employee-form-card-header h2 {
        margin: 0;
        font-size: 1.16rem;
        font-weight: 300;
    }

    .owner-employee-form-card-header > p {
        max-width: 180px;
        margin: 0;
        color: #988d86;
        font-size: 0.44rem;
        line-height: 1.55;
        text-align: right;
    }

    .owner-employee-form {
        margin: 0;
    }

    .owner-employee-form-content {
        padding: 24px 22px;
    }


    /* FORM GRID FROM _form.blade.php */

    .owner-employee-form-content .employee-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 15px;
    }

    .owner-employee-form-content .employee-form-field {
        min-width: 0;
    }


    /* FIELD LABELS */

    .owner-employee-form-content
    .employee-form-field > label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
    }

    .owner-employee-form-content
    .employee-form-field > label > span {
        color: #625954;
        font-size: 0.45rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .owner-employee-form-content
    .employee-form-field > label > small {
        color: #a18f86;
        font-size: 0.37rem;
        font-weight: 400;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }


    /* INPUTS */

    .owner-employee-form-content
    .employee-form-field > input {
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid rgba(33,29,26,0.15);
        border-radius: 0;
        outline: none;
        background: #f7f2ee;
        box-shadow: none;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.62rem;
        transition:
            border-color 0.15s ease,
            box-shadow 0.15s ease;
    }

    .owner-employee-form-content
    .employee-form-field > input:focus {
        border-color: #aa8074;
        box-shadow:
            0 0 0 2px rgba(170,128,116,0.08);
    }

    .owner-employee-form-content
    .employee-form-field > input.is-invalid {
        border-color: #ae6b60;
    }

    .owner-employee-form-content
    .employee-field-error {
        display: block;
        margin-top: 5px;
        color: #a45f55;
        font-size: 0.43rem;
        line-height: 1.45;
    }


    /* SERVICES SECTION */

    .owner-employee-form-content
    .employee-services-section {
        margin-top: 25px;
        padding-top: 22px;
        border-top: 1px solid rgba(33,29,26,0.09);
    }

    .owner-employee-form-content
    .employee-section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 14px;
    }

    .owner-employee-form-content
    .employee-section-heading strong {
        display: block;
        margin-bottom: 3px;
        color: #4f4742;
        font-size: 0.61rem;
        font-weight: 500;
    }

    .owner-employee-form-content
    .employee-section-heading div > span {
        display: block;
        color: #8f837c;
        font-size: 0.46rem;
    }

    .owner-employee-form-content
    .employee-section-heading > small {
        flex-shrink: 0;
        color: #9f796e;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }


    /* SERVICES GRID */

    .owner-employee-form-content
    .employee-services-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .owner-employee-form-content
    .employee-service-option {
        position: relative;
        min-height: 48px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        padding: 9px 11px;
        border: 1px solid rgba(33,29,26,0.11);
        background: #f7f2ee;
        cursor: pointer;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-employee-form-content
    .employee-service-option:hover {
        border-color: rgba(157,112,99,0.45);
        background: #f3e9e3;
    }

    .owner-employee-form-content
    .employee-service-option > input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .owner-employee-form-content
    .employee-service-check {
        width: 19px;
        height: 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(33,29,26,0.18);
        background: #fff;
        color: transparent;
        font-size: 0.43rem;
        transition:
            background 0.15s ease,
            border-color 0.15s ease,
            color 0.15s ease;
    }

    .owner-employee-form-content
    .employee-service-option
    > input:checked
    + .employee-service-check {
        border-color: #7c6d66;
        background: #7c6d66;
        color: #fff;
    }

    .owner-employee-form-content
    .employee-service-name {
        min-width: 0;
        color: #5d544f;
        font-size: 0.51rem;
        font-weight: 500;
    }

    .owner-employee-form-content
    .employee-service-name small {
        display: inline-block;
        margin-left: 5px;
        padding: 2px 4px;
        background: #ead8d4;
        color: #8c6158;
        font-size: 0.33rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .owner-employee-form-content
    .employee-services-empty {
        padding: 16px;
        border: 1px solid rgba(33,29,26,0.09);
        background: #eee5df;
        color: #8d817a;
        font-size: 0.49rem;
    }


    /* ACCOUNT ACCESS */

    .owner-employee-form-content
    .employee-access-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 23px;
        padding: 17px 18px;
        border: 1px solid rgba(33,29,26,0.08);
        background: #eee4de;
    }

    .owner-employee-form-content
    .employee-access-row > div > strong {
        display: block;
        margin-bottom: 3px;
        color: #4f4742;
        font-size: 0.58rem;
        font-weight: 500;
    }

    .owner-employee-form-content
    .employee-access-row > div > span {
        display: block;
        color: #8e817a;
        font-size: 0.45rem;
    }


    /* ACTIVE TOGGLE */

    .owner-employee-form-content
    .employee-access-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        cursor: pointer;
    }

    .owner-employee-form-content
    .employee-access-toggle
    input[type="hidden"] {
        display: none;
    }

    .owner-employee-form-content
    .employee-access-toggle
    input[type="checkbox"] {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .owner-employee-form-content
    .employee-toggle-track {
        position: relative;
        width: 34px;
        height: 18px;
        flex-shrink: 0;
        background: #c9bbb4;
        transition: background 0.18s ease;
    }

    .owner-employee-form-content
    .employee-toggle-track i {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 12px;
        height: 12px;
        background: #fff;
        transition: transform 0.18s ease;
    }

    .owner-employee-form-content
    .employee-access-toggle
    input[type="checkbox"]:checked
    + .employee-toggle-track {
        background: #6e806b;
    }

    .owner-employee-form-content
    .employee-access-toggle
    input[type="checkbox"]:checked
    + .employee-toggle-track i {
        transform: translateX(16px);
    }

    .owner-employee-form-content
    .employee-access-toggle em {
        color: #5f5651;
        font-size: 0.49rem;
        font-style: normal;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }


    /* ACTIONS */

    .owner-employee-form-actions {
        min-height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 22px;
        border-top: 1px solid rgba(33,29,26,0.09);
    }

    .owner-employee-secondary {
        color: #786d67;
        text-decoration: none;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-employee-secondary:hover {
        color: #211d1a;
    }

    .owner-employee-primary {
        min-width: 185px;
        min-height: 43px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0 15px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-employee-primary:hover {
        background: #9d7063;
        border-color: #9d7063;
    }

    .owner-employee-primary span:last-child {
        font-size: 0.75rem;
        font-weight: 300;
    }


    /* SIDE PANEL */

    .owner-employee-form-side {
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 29px 27px;
        background: #211d1a;
        color: #f7f2ee;
    }

    .owner-employee-form-side-eyebrow {
        display: block;
        margin-bottom: 10px;
        color: #c6a59a;
        font-size: 0.41rem;
        font-weight: 500;
        letter-spacing: 0.15em;
    }

    .owner-employee-form-side > h2 {
        max-width: 300px;
        margin: 0 0 10px;
        font-size: clamp(1.45rem, 2.7vw, 2rem);
        font-weight: 300;
        line-height: 1.08;
        letter-spacing: -0.035em;
    }

    .owner-employee-form-side > p {
        max-width: 305px;
        margin: 0;
        color: #bfb3ad;
        font-size: 0.53rem;
        line-height: 1.7;
    }


    /* SIDE STEPS */

    .owner-employee-form-steps {
        margin-top: 27px;
        border-top: 1px solid rgba(255,255,255,0.11);
    }

    .owner-employee-form-steps article {
        display: grid;
        grid-template-columns: 30px 1fr;
        gap: 10px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255,255,255,0.11);
    }

    .owner-employee-form-steps article > span {
        color: #bc9387;
        font-size: 0.42rem;
    }

    .owner-employee-form-steps strong {
        display: block;
        margin-bottom: 3px;
        color: #f2ebe7;
        font-size: 0.54rem;
        font-weight: 500;
    }

    .owner-employee-form-steps p {
        margin: 0;
        color: #a99d97;
        font-size: 0.45rem;
        line-height: 1.55;
    }


    /* SIDE NOTE */

    .owner-employee-form-side-note {
        margin-top: auto;
        padding: 15px;
        background: rgba(215,180,168,0.1);
        border: 1px solid rgba(215,180,168,0.17);
    }

    .owner-employee-form-side-note span {
        display: block;
        margin-bottom: 6px;
        color: #c6a59a;
        font-size: 0.38rem;
        letter-spacing: 0.12em;
    }

    .owner-employee-form-side-note p {
        margin: 0;
        color: #bdb0aa;
        font-size: 0.46rem;
        line-height: 1.6;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .owner-employee-form-layout {
            grid-template-columns: 1fr;
        }

        .owner-employee-form-side {
            min-height: 410px;
        }

    }

    @media (max-width: 650px) {

        .owner-employee-form-content
        .employee-form-grid {
            grid-template-columns: 1fr;
        }

        .owner-employee-form-content
        .employee-services-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 575px) {

        .owner-employee-form-space {
            padding: 21px 0 32px;
        }

        .owner-employee-form-shell {
            width: calc(100% - 24px);
        }

        .owner-employee-form-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .owner-employee-form-card-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 6px;
        }

        .owner-employee-form-card-header > p {
            max-width: none;
            text-align: left;
        }

        .owner-employee-form-content {
            padding: 20px 18px;
        }

        .owner-employee-form-content
        .employee-section-heading {
            flex-direction: column;
            gap: 7px;
        }

        .owner-employee-form-content
        .employee-access-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-employee-form-actions {
            align-items: stretch;
            flex-direction: column-reverse;
            padding: 16px 18px 19px;
        }

        .owner-employee-primary {
            width: 100%;
        }

        .owner-employee-secondary {
            align-self: center;
        }

        .owner-employee-form-side {
            padding: 25px 21px;
        }

    }

</style>
@endpush