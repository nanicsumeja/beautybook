<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
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

        return view('employee.dashboard', [
            'employee' => $employee,
            'assignedServices' => $assignedServices,
            'servicesCount' => $assignedServices->count(),
            'activeServicesCount' => $assignedServices
                ->where('is_active', true)
                ->count(),
        ]);
    }
}