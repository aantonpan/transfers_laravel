<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'user_id', // Referencia al usuario (hotel)
    ];

    // Relación con el usuario (hotel)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con las reservas
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id');
    }

    public function getBookingsWithRelations()
    {
        return $this->bookings()
                    ->with(['hotel', 'traveler.user']) // Eager loading the related models
                    ->get();
    }
}
