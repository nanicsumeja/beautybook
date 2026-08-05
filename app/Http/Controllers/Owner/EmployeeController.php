<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = User::query()
            ->where('role', 'employee')
            ->with('services')
            ->orderBy('name')
            ->orderBy('surname')
            ->get();

        return view(
            'owner.employees.index',
            compact('employees')
        );
    }

    public function create(): View
    {
        $services = Service::query()
            ->orderBy('name')
            ->get();

        return view(
            'owner.employees.create',
            compact('services')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'surname' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'service_ids' => [
                'nullable',
                'array',
            ],

            'service_ids.*' => [
                'integer',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $employee = User::create([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => $validated['password'],
                'role' => 'employee',
                'is_active' => $request->boolean('is_active'),
            ]);

            $employee->services()->sync(
                $validated['service_ids'] ?? []
            );
        });

        return redirect()
            ->route('owner.employees.index')
            ->with(
                'success',
                'Employee created successfully.'
            );
    }

    public function edit(User $employee): View
    {
        $this->ensureEmployee($employee);

        $employee->load('services');

        $services = Service::query()
            ->orderBy('name')
            ->get();

        return view(
            'owner.employees.edit',
            compact('employee', 'services')
        );
    }

    public function update(
        Request $request,
        User $employee
    ): RedirectResponse {
        $this->ensureEmployee($employee);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'surname' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                    ->ignore($employee->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($employee->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'service_ids' => [
                'nullable',
                'array',
            ],

            'service_ids.*' => [
                'integer',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $request,
            $employee
        ) {
            $employeeData = [
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ];

            if (! empty($validated['password'])) {
                $employeeData['password'] =
                    $validated['password'];
            }

            $employee->update($employeeData);

            $employee->services()->sync(
                $validated['service_ids'] ?? []
            );
        });

        return redirect()
            ->route('owner.employees.index')
            ->with(
                'success',
                'Employee updated successfully.'
            );
    }

    private function ensureEmployee(User $employee): void
    {
        abort_unless(
            $employee->role === 'employee',
            404
        );
    }
}