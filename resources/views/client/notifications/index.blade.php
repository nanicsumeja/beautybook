@extends('layouts.app')

@section('body-class', 'client-notifications-page')

@section('content')

<div class="container notifications-page">

    <div class="notifications-header">

        <div>
            <span class="notifications-eyebrow">
                YOUR BEAUTYBOOK
            </span>

            <h1>Notifications</h1>

            <p>
                Your appointment updates and confirmations.
            </p>
        </div>


        @if (auth()->user()->unreadNotifications->isNotEmpty())

            <form
                action="{{ route('client.notifications.read-all') }}"
                method="POST"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="notifications-read-all"
                >
                    MARK ALL AS READ
                </button>

            </form>

        @endif

    </div>


    @if (session('success'))

        <div class="notifications-success">
            {{ session('success') }}
        </div>

    @endif


    @if ($notifications->isEmpty())

        <div class="notifications-empty">

            <span>NOTIFICATIONS</span>

            <h2>No notifications yet</h2>

            <p>
                Your appointment notifications will appear here.
            </p>

        </div>

    @else

        <div class="notifications-list">

            @foreach ($notifications as $notification)

                <article
                    class="notification-card {{
                        is_null($notification->read_at)
                            ? 'notification-unread'
                            : ''
                    }}"
                >

                    <div class="notification-main">

                        <div class="notification-content">

                            <div class="notification-title-row">

                                <h2>
                                    {{
                                        $notification->data['title']
                                            ?? 'Notification'
                                    }}
                                </h2>

                                @if (is_null($notification->read_at))

                                    <span class="notification-new">
                                        NEW
                                    </span>

                                @endif

                            </div>


                            <p class="notification-message">
                                {{
                                    $notification->data['message']
                                        ?? ''
                                }}
                            </p>


                            <div class="notification-details">

                                <div>
                                    <span>SERVICE</span>

                                    <strong>
                                        {{
                                            $notification->data['service']
                                                ?? '-'
                                        }}
                                    </strong>
                                </div>

                                <div>
                                    <span>DATE</span>

                                    <strong>
                                        {{
                                            $notification->data['date']
                                                ?? '-'
                                        }}
                                    </strong>
                                </div>

                                <div>
                                    <span>TIME</span>

                                    <strong>
                                        {{
                                            $notification->data['time']
                                                ?? '-'
                                        }}
                                    </strong>
                                </div>

                                <div>
                                    <span>SPECIALIST</span>

                                    <strong>
                                        {{
                                            $notification->data['employee']
                                                ?? '-'
                                        }}
                                    </strong>
                                </div>

                            </div>

                        </div>


                        @if (is_null($notification->read_at))

                            <form
                                action="{{
                                    route(
                                        'client.notifications.read',
                                        $notification->id
                                    )
                                }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="notification-read-button"
                                >
                                    MARK AS READ
                                </button>

                            </form>

                        @endif

                    </div>


                    <div class="notification-footer">

                        <span>
                            {{
                                $notification->created_at
                                    ->format('d.m.Y')
                            }}
                        </span>

                        <span>
                            {{
                                $notification->created_at
                                    ->format('H:i')
                            }}
                        </span>

                    </div>

                </article>

            @endforeach

        </div>


        <div class="notifications-pagination">
            {{ $notifications->links() }}
        </div>

    @endif

</div>

@endsection


@push('styles')
<style>

    .client-notifications-page {
        background: #f3efea;
    }

    .notifications-page {
        max-width: 1100px;
        padding-top: 34px;
        padding-bottom: 50px;
        font-family: 'Montserrat', sans-serif;
        color: #211d1a;
    }


    /* HEADER */

    .notifications-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 26px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(33, 29, 26, 0.12);
    }

    .notifications-eyebrow {
        display: block;
        margin-bottom: 6px;
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.21em;
        color: #a27a6d;
    }

    .notifications-header h1 {
        margin: 0 0 5px;
        font-size: clamp(2rem, 4vw, 3.1rem);
        font-weight: 300;
        letter-spacing: -0.04em;
    }

    .notifications-header p {
        margin: 0;
        font-size: 0.78rem;
        color: #7d746e;
    }

    .notifications-read-all {
        padding: 11px 14px;
        border: 1px solid #211d1a;
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.57rem;
        font-weight: 500;
        letter-spacing: 0.13em;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .notifications-read-all:hover {
        background: #211d1a;
        color: #fff;
    }


    /* LIST */

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .notification-card {
        overflow: hidden;
        background: #faf7f3;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }

    .notification-card.notification-unread {
        background: #eaded6;
        border-left: 3px solid #a97869;
    }

    .notification-main {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 35px;
        padding: 23px 25px;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }


    /* TITLE */

    .notification-title-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .notification-title-row h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 500;
    }

    .notification-new {
        padding: 4px 7px;
        background: #211d1a;
        color: #fff;
        font-size: 0.46rem;
        font-weight: 500;
        letter-spacing: 0.13em;
    }

    .notification-message {
        margin: 0 0 18px;
        font-size: 0.74rem;
        line-height: 1.55;
        color: #746b65;
    }


    /* DETAILS */

    .notification-details {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .notification-details > div {
        min-width: 0;
    }

    .notification-details span {
        display: block;
        margin-bottom: 3px;
        font-size: 0.48rem;
        letter-spacing: 0.14em;
        color: #a07b70;
    }

    .notification-details strong {
        display: block;
        overflow-wrap: anywhere;
        font-size: 0.68rem;
        font-weight: 500;
    }


    /* READ BUTTON */

    .notification-read-button {
        flex-shrink: 0;
        padding: 9px 11px;
        border: 1px solid rgba(33, 29, 26, 0.55);
        background: transparent;
        color: #211d1a;
        font-family: inherit;
        font-size: 0.51rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .notification-read-button:hover {
        background: #211d1a;
        color: #fff;
    }


    /* FOOTER */

    .notification-footer {
        display: flex;
        gap: 10px;
        padding: 9px 25px;
        border-top: 1px solid rgba(33, 29, 26, 0.08);
        font-size: 0.52rem;
        letter-spacing: 0.08em;
        color: #9a8f87;
    }


    /* SUCCESS */

    .notifications-success {
        margin-bottom: 15px;
        padding: 13px 16px;
        background: #dfe8de;
        border-left: 3px solid #70856b;
        color: #455441;
        font-size: 0.7rem;
    }


    /* EMPTY */

    .notifications-empty {
        padding: 65px 30px;
        background: #faf7f3;
        text-align: center;
        border: 1px solid rgba(33, 29, 26, 0.08);
    }

    .notifications-empty > span {
        display: block;
        margin-bottom: 9px;
        font-size: 0.54rem;
        letter-spacing: 0.18em;
        color: #a27a6d;
    }

    .notifications-empty h2 {
        margin: 0 0 8px;
        font-size: 1.7rem;
        font-weight: 300;
    }

    .notifications-empty p {
        margin: 0;
        font-size: 0.72rem;
        color: #817771;
    }


    /* PAGINATION */

    .notifications-pagination {
        margin-top: 22px;
    }


    /* RESPONSIVE */

    @media (max-width: 768px) {

        .notifications-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 16px;
        }

        .notification-main {
            flex-direction: column;
            gap: 18px;
        }

        .notification-details {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 575px) {

        .notifications-page {
            padding-top: 24px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .notification-main {
            padding: 20px;
        }

        .notification-details {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .notification-footer {
            padding-left: 20px;
            padding-right: 20px;
        }

    }

</style>
@endpush