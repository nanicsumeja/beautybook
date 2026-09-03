<?php

namespace App\Http\Controllers\Owner;

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

        $clients = User::query()
            ->where('role', 'client')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->orderBy('surname')
            ->paginate(10)
            ->withQueryString();

        return view('owner.clients.index', compact(
            'clients',
            'search'
        ));
    }

    public function show(User $client): View
    {
        abort_unless($client->role === 'client', 404);

        $completedReservations = Reservation::query()
            ->with([
                'service',
                'employee',
            ])
            ->where('client_id', $client->id)
            ->where('status', 'completed')
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->get();

        return view('owner.clients.show', compact(
            'client',
            'completedReservations'
        ));
    }

    public function toggleActive(User $client)
    {
        abort_unless($client->role === 'client', 404);

        $client->update([
            'is_active' => ! $client->is_active,
        ]);

        return back()->with(
            'success',
            $client->is_active
                ? 'Client has been activated successfully.'
                : 'Client has been deactivated successfully.'
        );
    }
}