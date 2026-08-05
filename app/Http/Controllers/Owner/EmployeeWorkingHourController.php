<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\EmployeeWorkingHour;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmployeeWorkingHourController extends Controller
{
    public function edit(User $employee): View
    {
        abort_unless(
            $employee->role === 'employee',
            404
        );

        $employee->load('workingHours');

        $workingHours = $employee
            ->workingHours
            ->keyBy('day_of_week');

        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        return view(
            'owner.employees.working-hours',
            compact(
                'employee',
                'workingHours',
                'days'
            )
        );
    }

    public function update(
        Request $request,
        User $employee
    ): RedirectResponse {
        abort_unless(
            $employee->role === 'employee',
            404
        );

        $validated = $request->validate([
            'days' => [
                'required',
                'array',
                'size:7',
            ],

            'days.*.day_of_week' => [
                'required',
                'integer',
                'between:1,7',
                'distinct',
            ],

            'days.*.start_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'days.*.end_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'days.*.is_day_off' => [
                'nullable',
                'boolean',
            ],
        ]);

        foreach ($validated['days'] as $index => $day) {
            $isDayOff = (bool) (
                $day['is_day_off'] ?? false
            );

            if ($isDayOff) {
                continue;
            }

            if (
                empty($day['start_time'])
                || empty($day['end_time'])
            ) {
                throw ValidationException::withMessages([
                    "days.$index.start_time" =>
                        'Start and end time are required.',
                ]);
            }

            if ($day['end_time'] <= $day['start_time']) {
                throw ValidationException::withMessages([
                    "days.$index.end_time" =>
                        'End time must be after start time.',
                ]);
            }
        }

        DB::transaction(function () use (
            $validated,
            $employee
        ): void {
            foreach ($validated['days'] as $day) {
                $isDayOff = (bool) (
                    $day['is_day_off'] ?? false
                );

                EmployeeWorkingHour::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'day_of_week' => $day['day_of_week'],
                    ],
                    [
                        'start_time' => $isDayOff
                            ? null
                            : $day['start_time'],

                        'end_time' => $isDayOff
                            ? null
                            : $day['end_time'],

                        'is_day_off' => $isDayOff,
                    ]
                );
            }
        });

        return redirect()
            ->route(
                'owner.employees.working-hours.edit',
                $employee
            )
            ->with(
                'success',
                'Working hours updated successfully.'
            );
    }
}