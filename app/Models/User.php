<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Rol del usuario (admin, hotel, traveler)
    ];

    /**
     * Los atributos que deben permanecer ocultos en las respuestas.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser casteados.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutador para hashear la contraseña automáticamente.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => bcrypt($value) // Hashear la contraseña automáticamente
        );
    }

    /**
     * Relación con hoteles.
     */
    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class, 'user_id');
    }

    /**
     * Relación con reservas (Bookings) como hotel.
     */
    public function hotelBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id');
    }

    /**
     * Relación con reservas (Bookings) como viajero.
     */
    public function travelerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}
