<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            'owner' => redirect()->route('owner.dashboard'),

            'employee' => redirect()->route(
                'employee.dashboard'
            ),

            'client' => redirect()->route(
                'client.dashboard'
            ),

            default => redirect()->route('welcome'),
        };
    }
}