<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Eliminar las claves foráneas actuales
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['traveler_id']);

            // Modificar las columnas para referenciar a las nuevas tablas
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('traveler_id')->references('id')->on('travelers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Revertir las claves foráneas a la tabla 'users'
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['traveler_id']);

            // Restaurar las claves foráneas originales
            $table->foreign('hotel_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('traveler_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};