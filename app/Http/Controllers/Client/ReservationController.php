<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use App\Notifications\AppointmentConfirmedNotification;
use App\Models\ActivityLog;

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

        $employees = $service->employees()
            ->where('role', 'employee')
            ->where('is_active', true)
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        return view(
            'client.reservations.create',
            compact('service', 'employees')
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

            'employee_id' => [
                'nullable',
                'integer',
                'exists:users,id',
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
        $dayOfWeek = $start->dayOfWeekIso;
        $employee = null;

        if (! empty($validated['employee_id'])) {
            $employee = User::query()
                ->where('id', $validated['employee_id'])
                ->where('role', 'employee')
                ->where('is_active', true)
                ->whereHas('services', function ($query) use ($service) {
                    $query->where('services.id', $service->id);
                })
                ->first();

            if (! $employee) {
                return back()
                    ->withErrors([
                        'employee_id' =>
                            'The selected employee is not available for this service.',
                    ])
                    ->withInput();
            }

            $workingHour = $employee->workingHours()
                ->where('day_of_week', $dayOfWeek)
                ->first();

            if (
                ! $workingHour
                || $workingHour->is_day_off
                || ! $workingHour->start_time
                || ! $workingHour->end_time
                || $start->format('H:i:s') < $workingHour->start_time
                || $end->format('H:i:s') > $workingHour->end_time
            ) {
                return back()
                    ->withErrors([
                        'employee_id' =>
                            'The selected employee is not working during this time.',
                    ])
                    ->withInput();
            }

            $employeeHasOverlap = Reservation::query()
                ->where('employee_id', $employee->id)
                ->where('appointment_date', $start->toDateString())
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('start_time', '<', $end->format('H:i:s'))
                ->where('end_time', '>', $start->format('H:i:s'))
                ->exists();

            if ($employeeHasOverlap) {
                return back()
                    ->withErrors([
                        'employee_id' =>
                            'The selected employee already has an appointment during this time.',
                    ])
                    ->withInput();
            }
        }

        if (! $employee) {
            $employees = $service->employees()
                ->where('role', 'employee')
                ->where('is_active', true)
                ->get();

            foreach ($employees as $availableEmployee) {
                $workingHour = $availableEmployee->workingHours()
                    ->where('day_of_week', $dayOfWeek)
                    ->first();

                if (
                    ! $workingHour
                    || $workingHour->is_day_off
                    || ! $workingHour->start_time
                    || ! $workingHour->end_time
                    || $start->format('H:i:s') < $workingHour->start_time
                    || $end->format('H:i:s') > $workingHour->end_time
                ) {
                    continue;
                }

                $hasOverlap = Reservation::query()
                    ->where('employee_id', $availableEmployee->id)
                    ->where('appointment_date', $start->toDateString())
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where('start_time', '<', $end->format('H:i:s'))
                    ->where('end_time', '>', $start->format('H:i:s'))
                    ->exists();

                if (! $hasOverlap) {
                    $employee = $availableEmployee;
                    break;
                }
            }

            if (! $employee) {
                return back()
                    ->withErrors([
                        'employee_id' =>
                            'There are no available employees for this time.',
                    ])
                    ->withInput();
            }
        }

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

        $advanceAmount = round(
            (float) $service->price * 0.30,
            2
        );

        $reservation = Reservation::create([
            'client_id' => auth()->id(),
            'service_id' => $service->id,
            'employee_id' => $employee->id,

            'service_name' => $service->name,
            'duration_minutes' => $service->duration_minutes,
            'total_price' => $service->price,
            'advance_amount' => $advanceAmount,

            'appointment_date' => $start->toDateString(),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),

            'status' => 'pending',
            'payment_status' => 'unpaid',

            'notes' => $validated['notes'] ?? null,
        ]);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'reservation_id' => $reservation->id,
            'action' => 'appointment_created',
            'description' => 'Client created appointment',
        ]);

        return redirect()
            ->route('client.reservations.index')
            ->with(
                'success',
                'Your appointment request has been created.'
            );
    }

    public function availableSlots(
        Request $request,
        Service $service
    ): \Illuminate\Http\JsonResponse {
        abort_unless($service->is_active, 404);

        $validated = $request->validate([
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'employee_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
        ]);

        $date = Carbon::parse(
            $validated['appointment_date']
        );

        $employees = $service->employees()
            ->where('role', 'employee')
            ->where('is_active', true)
            ->when(
                ! empty($validated['employee_id']),
                function ($query) use ($validated) {
                    $query->where(
                        'users.id',
                        $validated['employee_id']
                    );
                }
            )
            ->with('workingHours')
            ->get();

        $slots = [];

        foreach ($employees as $employee) {
            $dayOfWeek = $date->dayOfWeekIso;

            $workingHour = $employee->workingHours
                ->firstWhere('day_of_week', $dayOfWeek);

            if (
                ! $workingHour
                || $workingHour->is_day_off
                || ! $workingHour->start_time
                || ! $workingHour->end_time
            ) {
                continue;
            }

            $workStart = Carbon::parse(
                $date->toDateString()
                    . ' '
                    . $workingHour->start_time
            );

            $workEnd = Carbon::parse(
                $date->toDateString()
                    . ' '
                    . $workingHour->end_time
            );

            $reservations = Reservation::query()
                ->where('employee_id', $employee->id)
                ->where(
                    'appointment_date',
                    $date->toDateString()
                )
                ->whereIn(
                    'status',
                    ['pending', 'confirmed']
                )
                ->orderBy('start_time')
                ->get();

            $current = $workStart->copy();

            while (
                $current
                    ->copy()
                    ->addMinutes(
                        $service->duration_minutes
                    )
                    ->lessThanOrEqualTo($workEnd)
            ) {
                $slotStart = $current->copy();

                $slotEnd = $slotStart
                    ->copy()
                    ->addMinutes(
                        $service->duration_minutes
                    );

                $hasOverlap = $reservations->contains(
                    function ($reservation) use (
                        $slotStart,
                        $slotEnd                   
                    ) {
                        $reservationStart = Carbon::parse(
                            $slotStart->toDateString()
                                . ' '
                                . $reservation->start_time
                        );

                        $reservationEnd = Carbon::parse(
                            $slotStart->toDateString()
                                . ' '
                                . $reservation->end_time
                        );

                        return $reservationStart
                                ->lessThan($slotEnd)
                            && $reservationEnd
                                ->greaterThan($slotStart);
                    }
                );

                if (! $hasOverlap && $slotStart->isFuture()) {
                    $slots[] = [
                        'employee_id' => $employee->id,
                        'employee_name' =>
                            $employee->name
                            . ' '
                            . $employee->surname,
                        'start_time' =>
                            $slotStart->format('H:i'),
                        'end_time' =>
                            $slotEnd->format('H:i'),
                    ];
                }

                $current->addMinutes(15);
            }
        }

        return response()->json([
            'slots' => $slots,
        ]);
    }

    public function payment(
        Reservation $reservation
    ): View {
        abort_unless(
            $reservation->client_id === auth()->id(),
            403
        );

        if ($reservation->status === 'cancelled') {
            return redirect()
                ->route('client.reservations.index')
                ->withErrors([
                    'reservation' =>
                        'Cancelled appointments cannot be paid.',
                ]);
        }

        return view(
            'client.reservations.payment',
            compact('reservation')
        );
    }

    public function processPayment(
        Request $request,
        Reservation $reservation
    ): RedirectResponse {
        abort_unless(
            $reservation->client_id === auth()->id(),
            403
        );

        if ($reservation->status === 'cancelled') {
            return redirect()
                ->route('client.reservations.index')
                ->withErrors([
                    'reservation' =>
                        'Cancelled appointments cannot be paid.',
                ]);
        }

        if ($reservation->payment_status === 'paid') {
            return redirect()
                ->route('client.reservations.index')
                ->with(
                    'success',
                    'This appointment has already been paid.'
                );
        }

        $checkout = \Laravel\Cashier\Checkout::create(
            $request->user(),
            [
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'reservation_id' => (string) $reservation->id,
                ],

                'payment_intent_data' => [
                    'metadata' => [
                        'reservation_id' => (string) $reservation->id,
                    ],
                ],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'bam',
                        'product_data' => [
                            'name' =>
                                'Advance payment - '
                                . $reservation->service_name,
                        ],
                        'unit_amount' =>
                            (int) round(
                                (float) $reservation->advance_amount * 100
                            ),
                    ],
                    'quantity' => 1,
                ]],

                'success_url' => route(
                    'client.reservations.payment.success',
                    $reservation
                ) . '?session_id={CHECKOUT_SESSION_ID}',

                'cancel_url' => route(
                    'client.reservations.payment.cancel',
                    $reservation
                ),
            ]
        );

        return $checkout->redirect();
    }

    public function paymentSuccess(
        Request $request,
        Reservation $reservation
    ): RedirectResponse {
        abort_unless(
            $reservation->client_id === auth()->id(),
            403
        );

        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()
                ->route('client.reservations.index')
                ->withErrors([
                    'payment' =>
                        'Payment session could not be verified.',
                ]);
        }

        try {
            $session = Cashier::stripe()->checkout->sessions->retrieve(
                $sessionId,
                []
            );

            if (
                $session->payment_status !== 'paid'
                || $session->status !== 'complete'
            ) {
                return redirect()
                    ->route('client.reservations.index')
                    ->withErrors([
                        'payment' =>
                            'Payment was not completed.',
                    ]);
            }

            $reservation->update([
                'payment_status' => 'paid',
                'payment_method' => 'card',
                'payment_reference' => $session->id,
                'status' => 'confirmed',
                'paid_at' => now(),
            ]);

            $reservation->client->notify(
                new AppointmentConfirmedNotification($reservation)
            );

            return redirect()
                ->route('client.reservations.index')
                ->with(
                    'success',
                    'Payment successful. Your appointment has been confirmed.'
                );

        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('client.reservations.index')
                ->withErrors([
                    'payment' =>
                        'Payment could not be verified. Please try again.',
                ]);
        }
    }

    public function paymentCancel(
        Reservation $reservation
    ): RedirectResponse {
        abort_unless(
            $reservation->client_id === auth()->id(),
            403
        );

        return redirect()
            ->route('client.reservations.index')
            ->withErrors([
                'payment' =>
                    'Payment was cancelled. Your appointment has not been confirmed.',
            ]);
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

        $cancellationDeadline = $appointmentStart
            ->copy()
            ->subHours(24);

        if (now()->greaterThanOrEqualTo($cancellationDeadline)) {
            return back()->withErrors([
                'reservation' =>
                    'This appointment can no longer be cancelled because it is less than 24 hours away.',
            ]);
        }

        if ($reservation->payment_status === 'paid') {
            if (! $reservation->payment_reference) {
                return back()->withErrors([
                    'reservation' =>
                        'The payment reference is missing, so the refund could not be processed.',
                ]);
            }

            try {
                $stripe = Cashier::stripe();
                $session = $stripe
                    ->checkout
                    ->sessions
                    ->retrieve(
                        $reservation->payment_reference,
                        [
                            'expand' => [
                                'payment_intent',
                            ],
                        ]
                    );

                $paymentIntent = $session->payment_intent;

                $paymentIntentId = is_string($paymentIntent)
                    ? $paymentIntent
                    : $paymentIntent?->id;

                if (! $paymentIntentId) {
                    return back()->withErrors([
                        'reservation' =>
                            'The Stripe payment could not be found, so the refund was not processed.',
                    ]);
                }

                $refund = $stripe->refunds->create([
                    'payment_intent' => $paymentIntentId,
                ]);

                if ($refund->status !== 'succeeded') {
                    return back()->withErrors([
                        'reservation' =>
                            'The refund could not be completed. The appointment was not cancelled.',
                    ]);
                }

            } catch (\Throwable $e) {
                report($e);

                return back()->withErrors([
                    'reservation' =>
                        'The refund could not be processed. The appointment was not cancelled.',
                ]);
            }

            $reservation->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded',
                'cancelled_at' => now(),
            ]);

            return redirect()
                ->route('client.reservations.index')
                ->with(
                    'success',
                    'Your appointment has been cancelled and the advance payment has been refunded.'
                );
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'reservation_id' => $reservation->id,
            'action' => 'appointment_cancelled',
            'description' => 'Client cancelled appointment',
        ]);

        return redirect()
            ->route('client.reservations.index')
            ->with(
                'success',
                'Your appointment has been cancelled.'
            );
    }
}