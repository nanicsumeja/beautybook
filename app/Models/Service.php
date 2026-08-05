<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'name',
    'description',
    'price',
    'duration_minutes',
    'is_active',
])]
class Service extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_minutes' => 'integer',
            'is_active' => 'boolean',
        ];
    }
    public function employees(): BelongsToMany
{
    return $this->belongsToMany(
        User::class,
        'employee_service',
        'service_id',
        'employee_id'
    )->withTimestamps();
}
}