<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\ServiceCatalogController;
use App\Http\Controllers\Client\NotificationController;

use App\Http\Controllers\Employee\DashboardController
    as EmployeeDashboardController;
use App\Http\Controllers\Employee\ScheduleController;
use App\Http\Controllers\Employee\ClientController;

use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Owner\EmployeeWorkingHourController;
use App\Http\Controllers\Owner\ReservationController
    as OwnerReservationController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\Owner\ClientController as OwnerClientController;
use App\Http\Controllers\Owner\ReportController;


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
            '/notifications',
            [NotificationController::class, 'index']
        )->name('notifications.index');

        Route::patch(
            '/notifications/{notification}/read',
            [NotificationController::class, 'markAsRead']
        )->name('notifications.read');

        Route::patch(
            '/notifications/read-all',
            [NotificationController::class, 'markAllAsRead']
        )->name('notifications.read-all');

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

        Route::get(
            '/reservations/{reservation}/payment',
            [ReservationController::class, 'payment']
        )->name('reservations.payment');

        Route::post(
            '/reservations/{reservation}/payment',
            [ReservationController::class, 'processPayment']
        )->name('reservations.payment.process');

        Route::get(
            '/reservations/{reservation}/payment/success',
            [ReservationController::class, 'paymentSuccess']
        )->name('reservations.payment.success');

        Route::get(
            '/reservations/{reservation}/payment/cancel',
            [ReservationController::class, 'paymentCancel']
        )->name('reservations.payment.cancel');

        Route::get(
            '/services/{service}/available-slots',
            [ReservationController::class, 'availableSlots']
        )->name('reservations.available-slots');

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

        Route::get(
            '/reservations/create',
            [OwnerReservationController::class, 'create']
        )->name('reservations.create');

        Route::post(
            '/reservations',
            [OwnerReservationController::class, 'store']
        )->name('reservations.store');

        Route::get(
            '/reservations/{reservation}/edit',
            [OwnerReservationController::class, 'edit']
        )->name('reservations.edit');

        Route::put(
            '/reservations/{reservation}',
            [OwnerReservationController::class, 'update']
        )->name('reservations.update');

        Route::patch(
            '/reservations/{reservation}/confirm',
            [OwnerReservationController::class, 'confirm']
        )->name('reservations.confirm');

        Route::patch(
            '/reservations/{reservation}/cancel',
            [OwnerReservationController::class, 'cancel']
        )->name('reservations.cancel');

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

        Route::get(
            '/clients',
            [OwnerClientController::class, 'index']
        )->name('clients.index');

        Route::get(
            '/clients/{client}',
            [OwnerClientController::class, 'show']
        )->name('clients.show');

        Route::patch(
            '/clients/{client}/toggle-active',
            [OwnerClientController::class, 'toggleActive']
        )->name('clients.toggle-active');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get(
            '/reports/pdf',
            [ReportController::class, 'downloadPdf']
        )->name('reports.pdf');
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

        Route::get(
            '/schedule',
            [ScheduleController::class, 'index']
        )->name('schedule.index');

        Route::get(
            '/schedule/{reservation}',
            [ScheduleController::class, 'show']
        )->name('schedule.show');

        Route::get(
            '/clients',
            [ClientController::class, 'index']
        )->name('clients.index');

        Route::get(
            '/clients/{client}',
            [ClientController::class, 'show']
        )->name('clients.show');

        Route::patch(
            '/schedule/{reservation}/complete',
            [ScheduleController::class, 'complete']
        )->name('schedule.complete');
    });