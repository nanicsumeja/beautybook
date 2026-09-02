<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description =
        'Send in-app reminders for upcoming appointments';

    public function handle(): int
    {
        $now = now();
        $reminderLimit = now()->addHours(24);

        $reservations = Reservation::query()
            ->with(['client', 'employee'])
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->get();

        $sent = 0;

        foreach ($reservations as $reservation) {
            $appointmentStart = Carbon::parse(
                $reservation->appointment_date->format('Y-m-d')
                    . ' '
                    . $reservation->start_time
            );

            if (
                $appointmentStart->lessThanOrEqualTo($now)
                || $appointmentStart->greaterThan($reminderLimit)
            ) {
                continue;
            }

            if (! $reservation->client) {
                continue;
            }

            $reservation->client->notify(
                new AppointmentReminderNotification($reservation)
            );

            $reservation->update([
                'reminder_sent_at' => now(),
            ]);

            $sent++;
        }

        $this->info(
            "Appointment reminders sent: {$sent}"
        );

        return self::SUCCESS;
    }
}