<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'client_id',
    'service_id',
    'employee_id',
    'service_name',
    'duration_minutes',
    'total_price',
    'appointment_date',
    'start_time',
    'end_time',
    'status',
    'payment_status',
    'payment_reference',
    'notes',
    'cancelled_at',
    'advance_amount',
    'payment_method',
    'paid_at',
    'reminder_sent_at',
    'completed_at',
    'employee_note',
])]
class Reservation extends Model
{
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'duration_minutes' => 'integer',
            'total_price' => 'decimal:2',
            'advance_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}