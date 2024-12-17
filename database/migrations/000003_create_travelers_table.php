<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('travelers')) {
            Schema::create('travelers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('passport_number');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('travelers');
    }
};