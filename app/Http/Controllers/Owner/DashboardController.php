<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('owner.dashboard', [
            'servicesCount' => Service::count(),

            'activeServicesCount' => Service::where(
                'is_active',
                true
            )->count(),

            'inactiveServicesCount' => Service::where(
                'is_active',
                false
            )->count(),
        ]);
    }
}