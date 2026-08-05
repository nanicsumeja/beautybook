<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\ServiceCatalogController;

use App\Http\Controllers\Employee\DashboardController
    as EmployeeDashboardController;

use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Owner\EmployeeWorkingHourController;
use App\Http\Controllers\Owner\ReservationController
    as OwnerReservationController;
use App\Http\Controllers\Owner\ServiceController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Auth::routes();


Route::get(
    '/home',
    [App\Http\Controllers\HomeController::class, 'index']
)->name('home');


/*
|--------------------------------------------------------------------------
| Client routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('dashboard');

        Route::get(
            '/services',
            [ServiceCatalogController::class, 'index']
        )->name('services.index');

        Route::get(
            '/reservations',
            [ReservationController::class, 'index']
        )->name('reservations.index');

        Route::get(
            '/services/{service}/book',
            [ReservationController::class, 'create']
        )->name('reservations.create');

        Route::post(
            '/services/{service}/book',
            [ReservationController::class, 'store']
        )->name('reservations.store');

        Route::patch(
            '/reservations/{reservation}/cancel',
            [ReservationController::class, 'cancel']
        )->name('reservations.cancel');
    });


/*
|--------------------------------------------------------------------------
| Owner routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get(
            '/dashboard',
            DashboardController::class
        )->name('dashboard');

        Route::resource(
            'services',
            ServiceController::class
        )->except('show');

        Route::get(
            '/reservations',
            [OwnerReservationController::class, 'index']
        )->name('reservations.index');

        Route::patch(
            '/reservations/{reservation}/confirm',
            [OwnerReservationController::class, 'confirm']
        )->name('reservations.confirm');

        Route::resource(
            'employees',
            EmployeeController::class
        )->except([
            'show',
            'destroy',
        ]);

        Route::get(
            '/employees/{employee}/working-hours',
            [EmployeeWorkingHourController::class, 'edit']
        )->name('employees.working-hours.edit');

        Route::put(
            '/employees/{employee}/working-hours',
            [EmployeeWorkingHourController::class, 'update']
        )->name('employees.working-hours.update');
    });


/*
|--------------------------------------------------------------------------
| Employee routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:employee'])
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {

        Route::get(
            '/dashboard',
            EmployeeDashboardController::class
        )->name('dashboard');
    });