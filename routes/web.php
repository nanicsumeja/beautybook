<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Client\ServiceCatalogController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Owner\ReservationController as OwnerReservationController;
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');
});

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard');

        Route::resource('services', ServiceController::class)
            ->except('show');
            Route::get(
    '/reservations',
    [OwnerReservationController::class, 'index']
)->name('reservations.index');

Route::patch(
    '/reservations/{reservation}/confirm',
    [OwnerReservationController::class, 'confirm']
)->name('reservations.confirm');
    });