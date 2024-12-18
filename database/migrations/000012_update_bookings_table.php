<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('user_type')->default('traveler')->after('pickup_airport'); // 'traveler', 'admin', 'hotel'
            $table->decimal('price_total', 8, 2)->nullable()->after('user_type');
            $table->decimal('price_hotel', 8, 2)->nullable()->after('price_total');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'price_total', 'price_hotel']);
        });
    }
};
