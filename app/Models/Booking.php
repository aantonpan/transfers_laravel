<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'traveler_id',
        'booking_date',
    ];

    // Relación con el hotel (Usuario con rol "hotel")
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hotel_id');
    }

    // Relación con el viajero (Usuario con rol "traveler")
    public function traveler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'traveler_id');
    }
}
