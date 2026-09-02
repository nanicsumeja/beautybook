<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search'));

        $clientIds = Reservation::query()
            ->where('employee_id', auth()->id())
            ->pluck('client_id')
            ->unique();

        $clients = User::query()
            ->where('role', 'client')
            ->whereIn('id', $clientIds)
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('surname', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                }
            )
            ->orderBy('name')
            ->orderBy('surname')
            ->paginate(10)
            ->withQueryString();

        return view(
            'employee.clients.index',
            compact('clients', 'search')
        );
    }

    public function show(User $client): View
    {
        abort_unless(
            $client->role === 'client',
            404
        );

        $hasAccess = Reservation::query()
            ->where('employee_id', auth()->id())
            ->where('client_id', $client->id)
            ->exists();

        abort_unless($hasAccess, 403);

        $completedReservations = Reservation::query()
            ->with('service')
            ->where('employee_id', auth()->id())
            ->where('client_id', $client->id)
            ->where('status', 'completed')
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->get();

        return view(
            'employee.clients.show',
            compact(
                'client',
                'completedReservations'
            )
        );
    }
}