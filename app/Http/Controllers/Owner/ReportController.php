<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->buildReportData($request);

        return view('owner.reports.index', $data);
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->buildReportData($request);

        $fileName = 'beautybook-report-'
            . $data['startDate']->format('Y-m-d')
            . '-to-'
            . $data['endDate']->format('Y-m-d')
            . '.pdf';

        return Pdf::loadView(
            'owner.reports.pdf',
            $data
        )
            ->setPaper('a4', 'portrait')
            ->download($fileName);
    }

    private function buildReportData(Request $request): array
    {
        $period = $request->get('period', 'month');

        $startDate = null;
        $endDate = null;

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;

            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;

            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case 'custom':
                $request->validate([
                    'start_date' => ['required', 'date'],
                    'end_date' => [
                        'required',
                        'date',
                        'after_or_equal:start_date',
                    ],
                ]);

                $startDate = Carbon::parse(
                    $request->start_date
                );

                $endDate = Carbon::parse(
                    $request->end_date
                );
                break;

            default:
                $period = 'month';

                $startDate = Carbon::now()
                    ->startOfMonth();

                $endDate = Carbon::now()
                    ->endOfMonth();

                break;
        }

        $baseQuery = Reservation::query()
            ->whereBetween(
                'appointment_date',
                [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]
            );

        $totalReservations = (clone $baseQuery)
            ->count();

        $confirmedReservations = (clone $baseQuery)
            ->where('status', 'confirmed')
            ->count();

        $completedReservations = (clone $baseQuery)
            ->where('status', 'completed')
            ->count();

        $cancelledReservations = (clone $baseQuery)
            ->where('status', 'cancelled')
            ->count();

        $revenue = (clone $baseQuery)
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $totalAdvances = (clone $baseQuery)
            ->where('payment_status', 'paid')
            ->sum('advance_amount');

        $popularServices = Reservation::query()
            ->selectRaw(
                'service_name, COUNT(*) as total'
            )
            ->whereBetween(
                'appointment_date',
                [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]
            )
            ->whereNotNull('service_name')
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->get();

        $appointmentsByEmployee = Reservation::query()
            ->with('employee')
            ->selectRaw(
                'employee_id, COUNT(*) as total'
            )
            ->whereBetween(
                'appointment_date',
                [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]
            )
            ->whereNotNull('employee_id')
            ->groupBy('employee_id')
            ->orderByDesc('total')
            ->get();

        return [
            'period' => $period,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalReservations' => $totalReservations,
            'confirmedReservations' => $confirmedReservations,
            'completedReservations' => $completedReservations,
            'cancelledReservations' => $cancelledReservations,
            'revenue' => $revenue,
            'totalAdvances' => $totalAdvances,
            'popularServices' => $popularServices,
            'appointmentsByEmployee' => $appointmentsByEmployee,
        ];
    }
}