<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $employee = $request->user()->load([
            'services' => function ($query) {
                $query->orderBy('name');
            },
        ]);

        $assignedServices = $employee->services;
        $todayAppointmentsCount = Reservation::query()
            ->where('employee_id', $employee->id)
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return view('employee.dashboard', [
            'employee' => $employee,
            'assignedServices' => $assignedServices,
            'servicesCount' => $assignedServices->count(),
            'activeServicesCount' => $assignedServices
                ->where('is_active', true)
                ->count(),
            'todayAppointmentsCount' => $todayAppointmentsCount,
        ]);
    }
}