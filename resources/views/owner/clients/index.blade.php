@extends('layouts.app')

@section('body-class', 'owner-clients-page')
@section('main-class', 'owner-clients-main')

@section('content')

<section class="owner-clients-space">

    <div class="owner-clients-shell">

        <header class="owner-clients-header">

            <div>
                <span class="owner-clients-eyebrow">
                    OWNER WORKSPACE
                </span>

                <h1>
                    Clients
                </h1>

                <p>
                    View clients and their completed service history.
                </p>
            </div>

            <a
                href="{{ route('owner.dashboard') }}"
                class="owner-clients-back"
            >
                ← DASHBOARD
            </a>

        </header>


        {{-- SEARCH --}}
        <section class="owner-clients-toolbar">

            <form
                method="GET"
                action="{{ route('owner.clients.index') }}"
                class="owner-clients-search-form"
            >

                <label
                    for="search"
                    class="owner-clients-search"
                >

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="6.5"></circle>
                        <path d="M16 16L21 21"></path>
                    </svg>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search name, email or phone"
                        autocomplete="off"
                    >

                </label>


                <button
                    type="submit"
                    class="owner-clients-search-button"
                >
                    SEARCH
                </button>


                @if ($search)
                    <a
                        href="{{ route('owner.clients.index') }}"
                        class="owner-clients-clear"
                    >
                        CLEAR
                    </a>
                @endif

            </form>

        </section>


        {{-- CLIENTS --}}
        <section class="owner-clients-card">

            <div class="owner-clients-card-heading">

                <div>
                    <span>
                        CLIENT DIRECTORY
                    </span>

                    <h2>
                        Client overview
                    </h2>
                </div>

                <strong>
                    {{ $clients->total() }}
                    {{ $clients->total() === 1 ? 'CLIENT' : 'CLIENTS' }}
                </strong>

            </div>


            @if ($clients->isEmpty())

                <div class="owner-clients-empty">

                    <span>○</span>

                    <h3>
                        No clients found.
                    </h3>

                    <p>
                        Try searching with another name, email or phone number.
                    </p>

                </div>

            @else

                <div class="owner-clients-list-head">
                    <span>CLIENT</span>
                    <span>EMAIL</span>
                    <span>PHONE</span>
                    <span>PROFILE</span>
                </div>


                <div class="owner-clients-list">

                    @foreach ($clients as $client)

                        <article class="owner-client-row">

                            <div class="owner-client-person">

                                <div class="owner-client-avatar">
                                    {{
                                        mb_strtoupper(
                                            mb_substr(
                                                $client->name,
                                                0,
                                                1
                                            )
                                        )
                                    }}
                                </div>

                                <div>

                                    <span class="owner-client-mobile-label">
                                        CLIENT
                                    </span>

                                    <strong>
                                        {{ $client->name }}
                                        {{ $client->surname }}
                                    </strong>

                                    <small>
                                        Client profile
                                    </small>

                                </div>

                            </div>


                            <div class="owner-client-contact">

                                <span class="owner-client-mobile-label">
                                    EMAIL
                                </span>

                                <strong>
                                    {{ $client->email }}
                                </strong>

                            </div>


                            <div class="owner-client-contact">

                                <span class="owner-client-mobile-label">
                                    PHONE
                                </span>

                                <strong>
                                    {{ $client->phone ?: '—' }}
                                </strong>

                            </div>


                            <div class="owner-client-profile-action">

                                <a
                                    href="{{ route(
                                        'owner.clients.show',
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

            @endif

        </section>


        @if ($clients->hasPages())

            <div class="owner-clients-pagination">
                {{ $clients->links() }}
            </div>

        @endif

    </div>

</section>

@endsection


@push('styles')
<style>

    .owner-clients-page {
        background: #f3efea;
    }

    .owner-clients-main {
        background: #f3efea;
    }

    .owner-clients-space {
        min-height: calc(100vh - 62px);
        padding: 27px 0 40px;
        background:
            radial-gradient(
                circle at 93% 5%,
                rgba(190,151,140,0.12),
                transparent 23%
            ),
            #f3efea;
        color: #211d1a;
        font-family: 'Montserrat', sans-serif;
    }

    .owner-clients-shell {
        width: min(1120px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* HEADER */

    .owner-clients-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 25px;
        padding-bottom: 17px;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(33,29,26,0.12);
    }

    .owner-clients-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #a0796d;
        font-size: 0.53rem;
        font-weight: 500;
        letter-spacing: 0.19em;
    }

    .owner-clients-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        letter-spacing: -0.045em;
    }

    .owner-clients-header p {
        margin: 0;
        color: #81766f;
        font-size: 0.69rem;
    }

    .owner-clients-back {
        color: #211d1a;
        text-decoration: none;
        font-size: 0.44rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }

    .owner-clients-back:hover {
        color: #9d7063;
    }


    /* TOOLBAR */

    .owner-clients-toolbar {
        margin-bottom: 13px;
    }

    .owner-clients-search-form {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .owner-clients-search {
        width: min(430px, 100%);
        height: 41px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0 13px;
        background: #faf7f3;
        border: 1px solid rgba(33,29,26,0.13);
    }

    .owner-clients-search svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        fill: none;
        stroke: #8c7f78;
        stroke-width: 1.5;
    }

    .owner-clients-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.61rem;
    }

    .owner-clients-search-button {
        height: 41px;
        padding: 0 17px;
        border: 1px solid #211d1a;
        background: #211d1a;
        color: #fff;
        font-family: inherit;
        font-size: 0.41rem;
        font-weight: 500;
        letter-spacing: 0.11em;
        cursor: pointer;
    }

    .owner-clients-search-button:hover {
        background: #9d7063;
        border-color: #9d7063;
    }

    .owner-clients-clear {
        height: 41px;
        display: inline-flex;
        align-items: center;
        padding: 0 11px;
        color: #806f67;
        text-decoration: none;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }


    /* CARD */

    .owner-clients-card {
        background: #faf7f3;
        border: 1px solid rgba(33,29,26,0.08);
    }

    .owner-clients-card-heading {
        min-height: 73px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.09);
    }

    .owner-clients-card-heading span {
        display: block;
        margin-bottom: 3px;
        color: #9e776b;
        font-size: 0.42rem;
        letter-spacing: 0.14em;
    }

    .owner-clients-card-heading h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 300;
    }

    .owner-clients-card-heading > strong {
        color: #8b7b73;
        font-size: 0.42rem;
        font-weight: 500;
        letter-spacing: 0.11em;
    }


    /* LIST HEADER */

    .owner-clients-list-head {
        display: grid;
        grid-template-columns:
            1.25fr
            1.15fr
            0.8fr
            0.45fr;
        gap: 20px;
        padding: 11px 20px;
        background: #e9e0da;
        color: #0a0a0a;
    }

    .owner-clients-list-head span {
        font-size: 0.38rem;
        letter-spacing: 0.12em;
    }


    /* ROW */

    .owner-client-row {
        display: grid;
        grid-template-columns:
            1.25fr
            1.15fr
            0.8fr
            0.45fr;
        gap: 20px;
        align-items: center;
        min-height: 70px;
        padding: 10px 20px;
        border-bottom: 1px solid rgba(33,29,26,0.08);
        transition: background 0.15s ease;
    }

    .owner-client-row:last-child {
        border-bottom: 0;
    }

    .owner-client-row:hover {
        background: #f3ebe6;
    }


    /* PERSON */

    .owner-client-person {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .owner-client-avatar {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        background: #dec7bd;
        font-size: 0.72rem;
        font-weight: 400;
    }

    .owner-client-person strong {
        display: block;
        font-size: 0.61rem;
        font-weight: 500;
    }

    .owner-client-person small {
        display: block;
        margin-top: 3px;
        color: #958982;
        font-size: 0.44rem;
    }

    .owner-client-contact strong {
        display: block;
        overflow-wrap: anywhere;
        font-size: 0.56rem;
        font-weight: 400;
        color: #554e49;
    }

    .owner-client-mobile-label {
        display: none;
    }


    /* PROFILE */

    .owner-client-profile-action {
        display: flex;
        justify-content: flex-end;
    }

    .owner-client-profile-action a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #211d1a;
        text-decoration: none;
        font-size: 0.4rem;
        font-weight: 500;
        letter-spacing: 0.1em;
    }

    .owner-client-profile-action a span {
        font-size: 0.8rem;
        font-weight: 300;
        transition: transform 0.2s ease;
    }

    .owner-client-profile-action a:hover {
        color: #9d7063;
    }

    .owner-client-profile-action a:hover span {
        transform: translateX(3px);
    }


    /* EMPTY */

    .owner-clients-empty {
        padding: 65px 25px;
        text-align: center;
    }

    .owner-clients-empty > span {
        display: block;
        margin-bottom: 7px;
        color: #b48d82;
        font-size: 1.4rem;
        font-weight: 300;
    }

    .owner-clients-empty h3 {
        margin: 0 0 5px;
        font-size: 1.15rem;
        font-weight: 300;
    }

    .owner-clients-empty p {
        margin: 0;
        color: #887d76;
        font-size: 0.58rem;
    }


    /* PAGINATION */

    .owner-clients-pagination {
        margin-top: 17px;
    }


    /* RESPONSIVE */

    @media (max-width: 850px) {

        .owner-clients-list-head {
            display: none;
        }

        .owner-client-row {
            grid-template-columns: 1fr 1fr;
            padding: 17px 20px;
        }

        .owner-client-mobile-label {
            display: block;
            margin-bottom: 4px;
            color: #9d8076;
            font-size: 0.37rem;
            letter-spacing: 0.1em;
        }

        .owner-client-profile-action {
            justify-content: flex-start;
        }

    }


    @media (max-width: 575px) {

        .owner-clients-space {
            padding: 21px 0 32px;
        }

        .owner-clients-shell {
            width: calc(100% - 24px);
        }

        .owner-clients-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .owner-clients-search-form {
            align-items: stretch;
            flex-direction: column;
        }

        .owner-clients-search {
            width: 100%;
        }

        .owner-clients-search-button {
            width: 100%;
        }

        .owner-clients-clear {
            justify-content: center;
        }

        .owner-client-row {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .owner-clients-card-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

    }

</style>
@endpush