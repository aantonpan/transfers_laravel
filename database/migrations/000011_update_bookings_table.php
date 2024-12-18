<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Agregar 'pickup_airport' si no existe
            if (!Schema::hasColumn('bookings', 'pickup_airport')) {
                $table->string('pickup_airport')->nullable()->after('flight_number_return'); // Campo después de 'traveler_id'
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Eliminar 'pickup_airport' si se revierte la migración
            if (Schema::hasColumn('bookings', 'pickup_airport')) {
                $table->dropColumn('pickup_airport');
            }
        });
    }
};