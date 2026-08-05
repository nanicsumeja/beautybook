<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::query()
            ->where('client_id', auth()->id())
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        return view(
            'client.reservations.index',
            compact('reservations')
        );
    }

    public function create(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view(
            'client.reservations.create',
            compact('service')
        );
    }

    public function store(
        Request $request,
        Service $service
    ): RedirectResponse {
        abort_unless($service->is_active, 404);

        $validated = $request->validate([
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $start = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['appointment_date']
                . ' '
                . $validated['start_time']
        );

        if ($start->lessThanOrEqualTo(now())) {
            return back()
                ->withErrors([
                    'start_time' =>
                        'Please choose a future date and time.',
                ])
                ->withInput();
        }

        $end = $start
            ->copy()
            ->addMinutes($service->duration_minutes);

        /*
         * Klijent ne može imati dvije rezervacije
         * koje se vremenski preklapaju.
         */
        $hasOverlap = Reservation::query()
            ->where('client_id', auth()->id())
            ->where('appointment_date', $start->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '<', $end->format('H:i:s'))
            ->where('end_time', '>', $start->format('H:i:s'))
            ->exists();

        if ($hasOverlap) {
            return back()
                ->withErrors([
                    'start_time' =>
                        'You already have an appointment during this time.',
                ])
                ->withInput();
        }

        Reservation::create([
            'client_id' => auth()->id(),
            'service_id' => $service->id,
            'employee_id' => null,

            'service_name' => $service->name,
            'duration_minutes' => $service->duration_minutes,
            'total_price' => $service->price,

            'appointment_date' => $start->toDateString(),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),

            'status' => 'pending',
            'payment_status' => 'pending',

            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('client.reservations.index')
            ->with(
                'success',
                'Your appointment request has been created.'
            );
    }
    public function cancel(
    Reservation $reservation
): RedirectResponse {
    abort_unless(
        $reservation->client_id === auth()->id(),
        403
    );

    if (! in_array(
        $reservation->status,
        ['pending', 'confirmed'],
        true
    )) {
        return back()->withErrors([
            'reservation' =>
                'This appointment can no longer be cancelled.',
        ]);
    }

    $appointmentStart = Carbon::parse(
        $reservation->appointment_date->format('Y-m-d')
            . ' '
            . $reservation->start_time
    );

    if ($appointmentStart->isPast()) {
        return back()->withErrors([
            'reservation' =>
                'Past appointments cannot be cancelled.',
        ]);
    }

    $reservation->update([
        'status' => 'cancelled',
        'cancelled_at' => now(),
    ]);

    return redirect()
        ->route('client.reservations.index')
        ->with(
            'success',
            'Your appointment has been cancelled.'
        );
}
}