<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $statusCounts = Reservation::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $upcomingReservations = Reservation::query()
            ->with('client')
            ->whereDate('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->limit(4)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SYSTEM MONITORING
        |--------------------------------------------------------------------------
        */

        $pendingAppointments = Reservation::query()
            ->where('status', 'pending')
            ->count();

        $employeesWithoutWorkingHours = User::query()
            ->where('role', 'employee')
            ->whereDoesntHave('workingHours')
            ->count();

        $servicesWithoutEmployees = Service::query()
            ->whereDoesntHave('employees')
            ->count();

        $failedPayments = Reservation::query()
            ->where('payment_status', 'failed')
            ->count();

        $appointmentsWithoutEmployees = Reservation::query()
            ->whereNull('employee_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $warningCount =
            $pendingAppointments +
            $employeesWithoutWorkingHours +
            $servicesWithoutEmployees +
            $failedPayments +
            $appointmentsWithoutEmployees;

        $systemStatus = $warningCount === 0
            ? 'Operational'
            : 'Attention required';

        $recentActivities = ActivityLog::query()
            ->with(['user', 'reservation'])
            ->latest()
            ->limit(8)
            ->get();

        return view('owner.dashboard', [
            'servicesCount' => Service::count(),

            'activeServicesCount' => Service::query()
                ->where('is_active', true)
                ->count(),

            'employeesCount' => User::query()
                ->where('role', 'employee')
                ->count(),

            'pendingCount' => (int) (
                $statusCounts['pending'] ?? 0
            ),

            'confirmedCount' => (int) (
                $statusCounts['confirmed'] ?? 0
            ),

            'completedCount' => (int) (
                $statusCounts['completed'] ?? 0
            ),

            'cancelledCount' => (int) (
                $statusCounts['cancelled'] ?? 0
            ),

            'totalReservations' => (int) $statusCounts->sum(),

            'upcomingReservations' => $upcomingReservations,

            /*
            |--------------------------------------------------------------------------
            | Monitoring data
            |--------------------------------------------------------------------------
            */

            'pendingAppointments' => $pendingAppointments,

            'employeesWithoutWorkingHours' =>
                $employeesWithoutWorkingHours,

            'servicesWithoutEmployees' =>
                $servicesWithoutEmployees,

            'failedPayments' => $failedPayments,

            'appointmentsWithoutEmployees' =>
                $appointmentsWithoutEmployees,

            'warningCount' => $warningCount,

            'systemStatus' => $systemStatus,

            'recentActivities' => $recentActivities,
        ]);
    }
}