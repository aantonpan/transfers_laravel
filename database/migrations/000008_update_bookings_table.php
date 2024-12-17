<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modificar la tabla 'bookings' para agregar los nuevos campos
        Schema::table('bookings', function (Blueprint $table) {
            // Agregar nuevos campos para la información de la reserva
            $table->enum('reservation_type', ['aeropuerto_hotel', 'hotel_aeropuerto', 'ida_vuelta'])->nullable()->after('booking_date');
            $table->date('arrival_date')->nullable()->after('reservation_type');
            $table->time('arrival_time')->nullable()->after('arrival_date');
            $table->string('flight_number')->nullable()->after('arrival_time');
            $table->string('origin_airport')->nullable()->after('flight_number');
            $table->date('flight_day')->nullable()->after('origin_airport');
            $table->time('flight_time')->nullable()->after('flight_day');
            $table->time('pickup_time')->nullable()->after('flight_time');
            $table->string('flight_number_return')->nullable()->after('pickup_time');
            $table->integer('travelers_count')->default(1)->after('flight_number_return');
        });
    }

    public function down(): void
    {
        // Eliminar los campos agregados si se revierte la migración
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'reservation_type',
                'arrival_date',
                'arrival_time',
                'flight_number',
                'origin_airport',
                'flight_day',
                'flight_time',
                'pickup_time',
                'flight_number_return',
                'travelers_count',
            ]);
        });
    }
};