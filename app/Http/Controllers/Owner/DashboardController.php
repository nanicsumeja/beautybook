<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
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
        ]);
    }
}