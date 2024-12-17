<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Traveler extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Referencia al usuario (traveler)
        'passport_number',
    ];

    // Relación con el usuario (traveler)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con las reservas
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'traveler_id');
    }
}
