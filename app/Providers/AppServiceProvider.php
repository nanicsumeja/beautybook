<?php

namespace App\Providers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(WebhookReceived::class, function (WebhookReceived $event) {

            if ($event->payload['type'] !== 'payment_intent.payment_failed') {
                return;
            }

            $paymentIntent = $event->payload['data']['object'];

            $reservationId = $paymentIntent['metadata']['reservation_id'] ?? null;

            if (! $reservationId) {
                return;
            }

            Reservation::where('id', $reservationId)->update([
                'payment_status' => 'failed',
                'payment_method' => 'card',
                'paid_at' => null,
            ]);
        });
    }
}