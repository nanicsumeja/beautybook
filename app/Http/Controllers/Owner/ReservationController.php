<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ActivityLog;

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


    /*
    |--------------------------------------------------------------------------
    | Create appointment
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $clients = User::query()
            ->where('role', 'client')
            ->where('is_active', true)
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $employees = User::query()
            ->where('role', 'employee')
            ->where('is_active', true)
            ->with('services')
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        return view(
            'owner.reservations.create',
            compact(
                'clients',
                'services',
                'employees'
            )
        );
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'employee_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
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

        $client = User::findOrFail(
            $validated['client_id']
        );

        if (
            $client->role !== 'client'
            || !$client->is_active
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' =>
                        'The selected client is not available.',
                ]);
        }

        $service = Service::findOrFail(
            $validated['service_id']
        );

        if (!$service->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' =>
                        'The selected service is inactive.',
                ]);
        }

        $employee = User::query()
            ->with(['services', 'workingHours'])
            ->findOrFail(
                $validated['employee_id']
            );

        $start = Carbon::parse(
            $validated['appointment_date']
            . ' '
            . $validated['start_time']
        );

        $end = $start->copy()->addMinutes(
            $service->duration_minutes
        );

        if ($start->isPast()) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'The appointment must be in the future.',
                ]);
        }

        $availabilityError =
            $this->validateEmployeeAvailability(
                $employee,
                $service,
                $start,
                $end
            );

        if ($availabilityError) {
            return back()
                ->withInput()
                ->withErrors([
                    'employee_id' => $availabilityError,
                ]);
        }

        $clientOverlap = Reservation::query()
            ->where('client_id', $client->id)
            ->whereDate(
                'appointment_date',
                $start->toDateString()
            )
            ->whereIn(
                'status',
                ['pending', 'confirmed']
            )
            ->where(
                'start_time',
                '<',
                $end->format('H:i:s')
            )
            ->where(
                'end_time',
                '>',
                $start->format('H:i:s')
            )
            ->exists();

        if ($clientOverlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'The client already has another appointment at this time.',
                ]);
        }

        Reservation::create([
            'client_id' => $client->id,
            'service_id' => $service->id,
            'employee_id' => $employee->id,

            'service_name' => $service->name,
            'duration_minutes' =>
                $service->duration_minutes,
            'total_price' => $service->price,

            'appointment_date' =>
                $start->toDateString(),
            'start_time' =>
                $start->format('H:i:s'),
            'end_time' =>
                $end->format('H:i:s'),

            'status' => 'pending',

            'advance_amount' =>
                round(
                    ((float) $service->price) * 0.30,
                    2
                ),

            'payment_status' => 'unpaid',

            'notes' =>
                $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('owner.reservations.index')
            ->with(
                'success',
                'Appointment created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit appointment
    |--------------------------------------------------------------------------
    */

    public function edit(
        Reservation $reservation
    ): View {
        if (
            in_array(
                $reservation->status,
                ['completed', 'cancelled'],
                true
            )
        ) {
            abort(403);
        }

        $clients = User::query()
            ->where('role', 'client')
            ->where('is_active', true)
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $employees = User::query()
            ->where('role', 'employee')
            ->where('is_active', true)
            ->with('services')
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        return view(
            'owner.reservations.edit',
            compact(
                'reservation',
                'clients',
                'services',
                'employees'
            )
        );
    }


    public function update(
        Request $request,
        Reservation $reservation
    ): RedirectResponse {

        if (
            in_array(
                $reservation->status,
                ['completed', 'cancelled'],
                true
            )
        ) {
            return back()->withErrors([
                'reservation' =>
                    'Completed or cancelled appointments cannot be edited.',
            ]);
        }

        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'employee_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
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

        $client = User::findOrFail(
            $validated['client_id']
        );

        if (
            $client->role !== 'client'
            || !$client->is_active
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' =>
                        'The selected client is not available.',
                ]);
        }

        $service = Service::findOrFail(
            $validated['service_id']
        );

        if (!$service->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'service_id' =>
                        'The selected service is inactive.',
                ]);
        }

        $employee = User::query()
            ->with(['services', 'workingHours'])
            ->findOrFail(
                $validated['employee_id']
            );

        $start = Carbon::parse(
            $validated['appointment_date']
            . ' '
            . $validated['start_time']
        );

        $end = $start->copy()->addMinutes(
            $service->duration_minutes
        );

        if ($start->isPast()) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'The appointment must be in the future.',
                ]);
        }

        $availabilityError =
            $this->validateEmployeeAvailability(
                $employee,
                $service,
                $start,
                $end,
                $reservation->id
            );

        if ($availabilityError) {
            return back()
                ->withInput()
                ->withErrors([
                    'employee_id' => $availabilityError,
                ]);
        }

        $clientOverlap = Reservation::query()
            ->where('client_id', $client->id)
            ->where('id', '!=', $reservation->id)
            ->whereDate(
                'appointment_date',
                $start->toDateString()
            )
            ->whereIn(
                'status',
                ['pending', 'confirmed']
            )
            ->where(
                'start_time',
                '<',
                $end->format('H:i:s')
            )
            ->where(
                'end_time',
                '>',
                $start->format('H:i:s')
            )
            ->exists();

        if ($clientOverlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'The client already has another appointment at this time.',
                ]);
        }

        $reservation->update([
            'client_id' => $client->id,
            'service_id' => $service->id,
            'employee_id' => $employee->id,

            'service_name' => $service->name,
            'duration_minutes' =>
                $service->duration_minutes,
            'total_price' => $service->price,

            'appointment_date' =>
                $start->toDateString(),
            'start_time' =>
                $start->format('H:i:s'),
            'end_time' =>
                $end->format('H:i:s'),

            'advance_amount' =>
                round(
                    ((float) $service->price) * 0.30,
                    2
                ),

            'notes' =>
                $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('owner.reservations.index')
            ->with(
                'success',
                'Appointment updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Confirm appointment
    |--------------------------------------------------------------------------
    */

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
            $reservation
                ->appointment_date
                ->format('Y-m-d')
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'reservation_id' => $reservation->id,
            'action' => 'appointment_confirmed',
            'description' => 'Owner confirmed appointment',
        ]);

        return redirect()
            ->route('owner.reservations.index')
            ->with(
                'success',
                'Appointment confirmed successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel appointment
    |--------------------------------------------------------------------------
    */

    public function cancel(
        Reservation $reservation
    ): RedirectResponse {

        if (
            !in_array(
                $reservation->status,
                ['pending', 'confirmed'],
                true
            )
        ) {
            return back()->withErrors([
                'reservation' =>
                    'Only pending or confirmed appointments can be cancelled.',
            ]);
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()
            ->route('owner.reservations.index')
            ->with(
                'success',
                'Appointment cancelled successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Employee availability validation
    |--------------------------------------------------------------------------
    */

    private function validateEmployeeAvailability(
        User $employee,
        Service $service,
        Carbon $start,
        Carbon $end,
        ?int $ignoreReservationId = null
    ): ?string {

        /*
         * Employee must be active.
         */
        if (
            $employee->role !== 'employee'
            || !$employee->is_active
        ) {
            return 'The selected employee is inactive or invalid.';
        }


        /*
         * Employee must perform selected service.
         */
        $performsService = $employee
            ->services
            ->contains('id', $service->id);

        if (!$performsService) {
            return 'The selected employee does not perform this service.';
        }


        /*
         * Check working hours.
         */
        $dayOfWeek = $start->dayOfWeekIso;

        $workingHour = $employee
            ->workingHours
            ->firstWhere(
                'day_of_week',
                $dayOfWeek
            );

        if (
            !$workingHour
            || $workingHour->is_day_off
        ) {
            return 'The selected employee does not work on this day.';
        }

        $workStart = Carbon::parse(
            $start->toDateString()
            . ' '
            . $workingHour->start_time
        );

        $workEnd = Carbon::parse(
            $start->toDateString()
            . ' '
            . $workingHour->end_time
        );

        if (
            $start->lt($workStart)
            || $end->gt($workEnd)
        ) {
            return 'The selected time is outside the employee working hours.';
        }


        /*
         * Check overlapping appointments.
         */
        $overlapQuery = Reservation::query()
            ->where(
                'employee_id',
                $employee->id
            )
            ->whereDate(
                'appointment_date',
                $start->toDateString()
            )
            ->whereIn(
                'status',
                ['pending', 'confirmed']
            )
            ->where(
                'start_time',
                '<',
                $end->format('H:i:s')
            )
            ->where(
                'end_time',
                '>',
                $start->format('H:i:s')
            );

        if ($ignoreReservationId !== null) {
            $overlapQuery->where(
                'id',
                '!=',
                $ignoreReservationId
            );
        }

        if ($overlapQuery->exists()) {
            return 'The selected employee already has an appointment at this time.';
        }

        return null;
    }
}