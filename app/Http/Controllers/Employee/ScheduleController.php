<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\ActivityLog;

class ScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date'],
            'filter' => [
                'nullable',
                'in:all,today,future,completed,cancelled',
            ],
        ]);

        $filter = $validated['filter'] ?? 'all';

        $reservations = Reservation::query()
            ->with('client')
            ->where('employee_id', auth()->id())

            ->when(
                ! empty($validated['date']),
                function ($query) use ($validated) {
                    $query->where(
                        'appointment_date',
                        $validated['date']
                    );
                }
            )

            ->when(
                $filter === 'today',
                function ($query) {
                    $query->whereDate(
                        'appointment_date',
                        today()
                    );
                }
            )

            ->when(
                $filter === 'future',
                function ($query) {
                    $query->whereDate(
                        'appointment_date',
                        '>',
                        today()
                    );
                }
            )

            ->when(
                $filter === 'completed',
                function ($query) {
                    $query->where(
                        'status',
                        'completed'
                    );
                }
            )

            ->when(
                $filter === 'cancelled',
                function ($query) {
                    $query->where(
                        'status',
                        'cancelled'
                    );
                }
            )

            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        return view(
            'employee.schedule.index',
            compact(
                'reservations',
                'filter'
            )
        );
    }

    public function show(
        Reservation $reservation
    ): View {
        abort_unless(
            $reservation->employee_id === auth()->id(),
            403
        );

        $reservation->load([
            'client',
            'service',
        ]);

        return view(
            'employee.schedule.show',
            compact('reservation')
        );
    }

    public function complete(
        Request $request,
        Reservation $reservation
    ): RedirectResponse {
        abort_unless(
            $reservation->employee_id === auth()->id(),
            403
        );

        if ($reservation->status === 'cancelled') {
            return back()->withErrors([
                'reservation' =>
                    'A cancelled appointment cannot be completed.',
            ]);
        }

        if ($reservation->status === 'completed') {
            return back()->withErrors([
                'reservation' =>
                    'This appointment is already completed.',
            ]);
        }

        if ($reservation->status !== 'confirmed') {
            return back()->withErrors([
                'reservation' =>
                    'Only confirmed appointments can be completed.',
            ]);
        }

        $validated = $request->validate([
            'employee_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $reservation->update([
            'status' => 'completed',
            'completed_at' => now(),
            'employee_note' =>
                $validated['employee_note'] ?? null,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'reservation_id' => $reservation->id,
            'action' => 'service_completed',
            'description' => 'Employee completed service',
        ]);

        return redirect()
            ->route(
                'employee.schedule.show',
                $reservation
            )
            ->with(
                'success',
                'Appointment marked as completed.'
            );
    }
}