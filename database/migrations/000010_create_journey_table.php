<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('journeys')) {
            Schema::create('journeys', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // Relación con reservas
                $table->string('type'); // 'ida' o 'vuelta'
                $table->date('date'); // Fecha del trayecto
                $table->time('time'); // Hora del trayecto
                $table->string('origin'); // 'hotel' o 'aeropuerto'
                $table->string('destination'); // 'hotel' o 'aeropuerto'
                $table->integer('travelers_count'); // Número de viajeros
                $table->string('traveler_mail');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};