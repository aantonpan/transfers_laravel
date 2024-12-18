<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'type',
        'date',
        'time',
        'origin',
        'destination',
        'travelers_count',
    ];

    // Relación con el hotel (Usuario con rol "hotel")
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

}
