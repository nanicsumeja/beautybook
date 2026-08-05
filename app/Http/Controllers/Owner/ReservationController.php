<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::query()
            ->with(['client', 'service', 'employee'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        return view(
            'owner.reservations.index',
            compact('reservations')
        );
    }

    public function confirm(
        Reservation $reservation
    ): RedirectResponse {
        if ($reservation->status !== 'pending') {
            return back()->withErrors([
                'reservation' =>
                    'Only pending appointments can be confirmed.',
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
                    'A past appointment cannot be confirmed.',
            ]);
        }

        $reservation->update([
            'status' => 'confirmed',
        ]);

        return redirect()
            ->route('owner.reservations.index')
            ->with(
                'success',
                'Appointment confirmed successfully.'
            );
    }
}