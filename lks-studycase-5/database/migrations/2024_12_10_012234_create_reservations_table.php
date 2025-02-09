<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->dateTime("checkIn_at");
            $table->dateTime("checkOut_at");
            $table->enum("status", ["PENDING" => "PENDING", "REJECTED" => "REJECTED", "VERIFIED" => "VERIFIED"]);
            $table->foreignId("user_id")->constrained()->on("users")->onDelete("cascade");
            $table->foreignId("admin_id")->nullable()->constrained()->on("users")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
