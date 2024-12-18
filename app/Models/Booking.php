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
        'pickup_airport',
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
    public function journeys()
{
    return $this->hasMany(Journey::class , 'booking_id');
}

public function calculatePrices(): array
{
    // Definir los precios según el tipo de usuario y reserva
    $prices = [
        'traveler' => [
            'one_way' => ['total' => 25, 'hotel' => 18],
            'round_trip' => ['total' => 40, 'hotel' => 16],
        ],
        'hotel' => [
            'one_way' => ['total' => 25, 'hotel' => 21],
            'round_trip' => ['total' => 40, 'hotel' => 17],
        ],
        'admin' => [
            'one_way' => ['total' => 25, 'hotel' => 18],
            'round_trip' => ['total' => 40, 'hotel' => 16],
        ],
    ];

    // Determinar el tipo de reserva (ida, vuelta, ida y vuelta)
    $type = $this->reservation_type === 'ida_vuelta' ? 'round_trip' : 'one_way';

    // Usar el tipo de usuario para calcular precios
    $userType = $this->user_type;

    return $prices[$userType][$type];
}
}