<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Agregar 'user_id' si no existe
            if (!Schema::hasColumn('bookings', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable(false)->after('travelers_count');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Agregar 'traveler_id' si no existe
            if (!Schema::hasColumn('bookings', 'traveler_id')) {
                $table->unsignedBigInteger('traveler_id')->nullable(false)->after('user_id');
                $table->foreign('traveler_id')->references('id')->on('travelers')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Eliminar 'user_id' y 'traveler_id' si se revierte la migración
            $table->dropForeign(['user_id']);
            $table->dropForeign(['traveler_id']);
            $table->dropColumn(['user_id', 'traveler_id']);
        });
    }
};