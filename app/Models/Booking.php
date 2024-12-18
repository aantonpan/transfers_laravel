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
        'arrival_date',
        'arrival_time',
        'flight_number',
        'origin_airport',
        'flight_day',
        'flight_time',
        'pickup_time',
        'flight_number_return',
        'hotel_id',
        'traveler_id',
    ];

    // Relación con el hotel (Usuario con rol "hotel")
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    // Relación con el viajero (Usuario con rol "traveler")
    public function traveler(): BelongsTo
    {
        return $this->belongsTo(Traveler::class, 'traveler_id');
    }
}
