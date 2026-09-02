<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Reservation $reservation
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $this->reservation->loadMissing('employee');

        return [
            'reservation_id' => $this->reservation->id,
            'title' => 'Appointment confirmed',
            'message' => 'Your appointment has been confirmed.',

            'service' => $this->reservation->service_name,

            'date' => $this->reservation
                ->appointment_date
                ->format('d.m.Y'),

            'time' => substr(
                $this->reservation->start_time,
                0,
                5
            ),

            'employee' => $this->reservation->employee
                ? $this->reservation->employee->name
                    . ' '
                    . $this->reservation->employee->surname
                : 'Any available employee',
        ];
    }
}