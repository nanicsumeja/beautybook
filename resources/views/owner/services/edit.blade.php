@extends('layouts.app')

@section('body-class', 'owner-service-form-page')
@section('main-class', 'owner-service-form-main')

@section('content')

<section class="owner-service-form-space">

    <div class="owner-service-form-shell">

        {{-- HEADER --}}
        <header class="owner-service-form-header">

            <div>
                <span class="owner-service-form-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>Edit service</h1>

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

            {{-- FORM --}}
            <section class="owner-service-form-card">

                <div class="owner-service-form-card-heading">

                    <div>
                        <span>EDIT TREATMENT</span>
                        <h2>Service details</h2>
                    </div>

                    <div class="owner-service-status-badge {{
                        $service->is_active
                            ? 'is-active'
                            : 'is-inactive'
                    }}">
                        {{
                            $service->is_active
                                ? 'ACTIVE'
                                : 'INACTIVE'
                        }}
                    </div>

                </div>


                <div class="owner-service-edit-context">

                    <span>CURRENT SERVICE</span>

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
                            <span>SAVE CHANGES</span>
                            <span>→</span>
                        </button>

                    </footer>

                </form>

            </section>


            {{-- SIDE PANEL --}}
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
                        <span>01</span>

                        <div>
                            <strong>Service information</strong>

                            <p>
                                Update the treatment name or
                                description shown to clients.
                            </p>
                        </div>
                    </article>

                    <article>
                        <span>02</span>

                        <div>
                            <strong>Price & duration</strong>

                            <p>
                                Keep treatment pricing and
                                appointment length accurate.
                            </p>
                        </div>
                    </article>

                    <article>
                        <span>03</span>

                        <div>
                            <strong>Availability</strong>

                            <p>
                                Choose whether clients can
                                currently book this service.
                            </p>
                        </div>
                    </article>

                </div>


                <div class="owner-service-current">

                    <span>CURRENT STATUS</span>

                    <div class="owner-service-current-status">

                        <i class="{{
                            $service->is_active
                                ? 'is-active'
                                : 'is-inactive'
                        }}"></i>

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

    /* PAGE */

    .owner-service-form-page {
        background: #f3efea;
    }

    .owner-service-form-main {
        background: #f3efea;
    }

    .owner-service-form-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 40px;
        background:
            radial-gradient(
                circle at 92% 5%,
                rgba(190, 151, 140, 0.13),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-service-form-shell {
        width: min(1050px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-service-form-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 17px;
        padding-bottom: 17px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .owner-service-form-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-service-form-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-service-form-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.69rem;
    }

    .owner-service-form-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.43rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-service-form-back:hover {
        color: #9d7063;
    }


    /* MAIN GRID */

    .owner-service-form-grid {
        display: grid;
        grid-template-columns: 1.18fr 0.82fr;
        align-items: stretch;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }


    /* LIGHT FORM SIDE */

    .owner-service-form-card {
        min-width: 0;
        background: #faf7f3;
    }

    .owner-service-form-card-heading {
        min-height: 82px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 24px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.09);
    }

    .owner-service-form-card-heading > div:first-child > span {
        display: block;
        margin-bottom: 4px;
        color: #9f776b;
        font-size: 0.41rem;
        font-weight: 500;
        letter-spacing: 0.14em;
    }

    .owner-service-form-card-heading h2 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 300;
    }


    /* STATUS BADGE */

    .owner-service-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 6px 9px;
        font-size: 0.36rem;
        font-weight: 500;
        letter-spacing: 0.09em;
    }

    .owner-service-status-badge.is-active {
        background: #dce5da;
        color: #5c6b59;
    }

    .owner-service-status-badge.is-inactive {
        background: #ead8d4;
        color: #885f56;
    }


    /* CURRENT SERVICE STRIP */

    .owner-service-edit-context {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 47px;
        padding: 0 24px;
        background: #eee4de;
        border-bottom: 1px solid rgba(33, 29, 26, 0.08);
    }

    .owner-service-edit-context span {
        color: #9d7e74;
        font-size: 0.38rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-service-edit-context strong {
        min-width: 0;
        overflow: hidden;
        color: #4a423e;
        font-size: 0.57rem;
        font-weight: 500;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .owner-service-form {
        margin: 0;
    }

    .owner-service-form-content {
        padding: 24px;
    }


    /* VALIDATION */

    .owner-service-form-content .service-form-errors {
        margin-bottom: 19px;
        padding: 13px 15px;
        background: #ead8d4;
        border-left: 3px solid #a7675b;
    }

    .owner-service-form-content .service-form-errors strong {
        display: block;
        margin-bottom: 4px;
        color: #754c45;
        font-size: 0.57rem;
        font-weight: 500;
    }

    .owner-service-form-content .service-form-errors > span {
        display: block;
        color: #94675e;
        font-size: 0.48rem;
        line-height: 1.5;
    }


    /* FORM GRID FROM _form.blade.php */

    .owner-service-form-content .service-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 15px;
        border: 0;
    }

    .owner-service-form-content .service-form-field {
        min-width: 0;
    }

    .owner-service-form-content .service-form-field-wide {
        grid-column: 1 / -1;
    }


    /* LABELS */

    .owner-service-form-content .service-form-field > label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
        color: #625954;
        font-size: 0.45rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .owner-service-form-content
    .service-form-field > label > span {
        color: #a18f86;
        font-size: 0.37rem;
        font-weight: 400;
        letter-spacing: 0.08em;
    }


    /* INPUTS */

    .owner-service-form-content
    .service-form-field input,
    .owner-service-form-content
    .service-form-field textarea {
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid rgba(33, 29, 26, 0.15);
        border-radius: 0;
        outline: 0;
        background: #f7f2ee;
        box-shadow: none;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.62rem;
        transition:
            border-color 0.15s ease,
            box-shadow 0.15s ease;
    }

    .owner-service-form-content
    .service-form-field textarea {
        min-height: 116px;
        resize: vertical;
        line-height: 1.6;
    }

    .owner-service-form-content
    .service-form-field input:focus,
    .owner-service-form-content
    .service-form-field textarea:focus {
        border-color: #aa8074;
        box-shadow:
            0 0 0 2px rgba(170, 128, 116, 0.08);
    }

    .owner-service-form-content
    .service-form-field input::placeholder,
    .owner-service-form-content
    .service-form-field textarea::placeholder {
        color: #aaa09a;
    }

    .owner-service-form-content
    .service-form-field .is-invalid {
        border-color: #ae6b60;
    }


    /* PRICE / DURATION SUFFIX */

    .owner-service-form-content
    .service-input-with-suffix {
        position: relative;
    }

    .owner-service-form-content
    .service-input-with-suffix input {
        padding-right: 47px;
    }

    .owner-service-form-content
    .service-input-with-suffix > span {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        color: #968981;
        font-size: 0.47rem;
        pointer-events: none;
    }


    /* DESCRIPTION */

    .owner-service-form-content
    .service-description-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 6px;
    }

    .owner-service-form-content
    .service-description-footer small {
        color: #978b84;
        font-size: 0.43rem;
    }

    .owner-service-form-content
    .service-field-error {
        display: block;
        margin-top: 5px;
        color: #a45f55;
        font-size: 0.43rem;
        line-height: 1.45;
    }


    /* AVAILABILITY */

    .owner-service-form-content
    .service-availability {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 22px;
        padding: 17px 18px;
        background: #eee4de;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }

    .owner-service-form-content
    .service-availability > div > strong {
        display: block;
        margin-bottom: 3px;
        color: #4f4742;
        font-size: 0.58rem;
        font-weight: 500;
    }

    .owner-service-form-content
    .service-availability > div > span {
        display: block;
        color: #8e817a;
        font-size: 0.45rem;
    }


    /* ACTIVE TOGGLE */

    .owner-service-form-content .service-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        cursor: pointer;
    }

    .owner-service-form-content
    .service-toggle input[type="hidden"] {
        display: none;
    }

    .owner-service-form-content
    .service-toggle input[type="checkbox"] {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .owner-service-form-content
    .service-toggle-track {
        position: relative;
        width: 34px;
        height: 18px;
        flex-shrink: 0;
        background: #c9bbb4;
        transition: background 0.18s ease;
    }

    .owner-service-form-content
    .service-toggle-track i {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 12px;
        height: 12px;
        background: #fff;
        transition: transform 0.18s ease;
    }

    .owner-service-form-content
    .service-toggle input[type="checkbox"]:checked
    + .service-toggle-track {
        background: #6e806b;
    }

    .owner-service-form-content
    .service-toggle input[type="checkbox"]:checked
    + .service-toggle-track i {
        transform: translateX(16px);
    }

    .owner-service-form-content
    .service-toggle em {
        color: #5f5651;
        font-size: 0.49rem;
        font-style: normal;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }


    /* ACTIONS */

    .owner-service-form-actions {
        min-height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 24px;
        border-top: 1px solid rgba(33, 29, 26, 0.09);
    }

    .owner-service-secondary {
        color: #786d67;
        text-decoration: none;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-service-secondary:hover {
        color: #211d1a;
    }

    .owner-service-primary {
        min-width: 175px;
        min-height: 43px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 0 15px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.11em;
        cursor: pointer;
        transition:
            background 0.15s ease,
            border-color 0.15s ease;
    }

    .owner-service-primary:hover {
        background: #9d7063;
        border-color: #9d7063;
    }

    .owner-service-primary span:last-child {
        font-size: 0.75rem;
        font-weight: 300;
    }


    /* DARK SIDE PANEL */

    .owner-service-form-side {
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 30px 28px;
        background: #211d1a;
        color: #f7f2ee;
    }

    .owner-service-form-side-eyebrow {
        display: block;
        margin-bottom: 9px;
        color: #c6a59a;
        font-size: 0.41rem;
        font-weight: 500;
        letter-spacing: 0.15em;
    }

    .owner-service-form-side > h2 {
        max-width: 300px;
        margin: 0 0 10px;
        font-size: clamp(1.45rem, 2.7vw, 2.05rem);
        font-weight: 300;
        line-height: 1.08;
        letter-spacing: -0.035em;
    }

    .owner-service-form-side > p {
        max-width: 310px;
        margin: 0;
        color: #bfb3ad;
        font-size: 0.57rem;
        line-height: 1.7;
    }


    /* SIDE STEPS */

    .owner-service-form-steps {
        margin-top: 28px;
        border-top: 1px solid rgba(255, 255, 255, 0.11);
    }

    .owner-service-form-steps article {
        display: grid;
        grid-template-columns: 31px 1fr;
        gap: 11px;
        padding: 17px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.11);
    }

    .owner-service-form-steps article > span {
        color: #bc9387;
        font-size: 0.43rem;
        letter-spacing: 0.08em;
    }

    .owner-service-form-steps strong {
        display: block;
        margin-bottom: 3px;
        color: #f2ebe7;
        font-size: 0.57rem;
        font-weight: 500;
    }

    .owner-service-form-steps p {
        margin: 0;
        color: #a99d97;
        font-size: 0.46rem;
        line-height: 1.55;
    }


    /* CURRENT STATUS */

    .owner-service-current {
        margin-top: auto;
        padding: 16px;
        background: rgba(215, 180, 168, 0.1);
        border: 1px solid rgba(215, 180, 168, 0.17);
    }

    .owner-service-current > span {
        display: block;
        margin-bottom: 8px;
        color: #c6a59a;
        font-size: 0.39rem;
        letter-spacing: 0.12em;
    }

    .owner-service-current-status {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .owner-service-current-status i {
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .owner-service-current-status i.is-active {
        background: #89a083;
    }

    .owner-service-current-status i.is-inactive {
        background: #b5786c;
    }

    .owner-service-current-status strong {
        color: #eee7e3;
        font-size: 0.55rem;
        font-weight: 500;
    }

    .owner-service-current > p {
        margin: 5px 0 0 13px;
        color: #aaa09a;
        font-size: 0.46rem;
    }


    /* RESPONSIVE */

    @media (max-width: 830px) {

        .owner-service-form-grid {
            grid-template-columns: 1fr;
        }

        .owner-service-form-side {
            min-height: 410px;
        }

    }

    @media (max-width: 575px) {

        .owner-service-form-space {
            padding: 21px 0 32px;
        }

        .owner-service-form-shell {
            width: calc(100% - 24px);
        }

        .owner-service-form-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .owner-service-form-card-heading {
            align-items: flex-start;
        }

        .owner-service-form-content {
            padding: 20px;
        }

        .owner-service-form-content
        .service-form-grid {
            grid-template-columns: 1fr;
        }

        .owner-service-form-content
        .service-form-field-wide {
            grid-column: auto;
        }

        .owner-service-form-content
        .service-availability {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-service-form-actions {
            align-items: stretch;
            flex-direction: column-reverse;
            padding: 16px 20px 20px;
        }

        .owner-service-primary {
            width: 100%;
        }

        .owner-service-secondary {
            align-self: center;
        }

        .owner-service-form-side {
            padding: 25px 21px;
        }

    }

</style>
@endpush