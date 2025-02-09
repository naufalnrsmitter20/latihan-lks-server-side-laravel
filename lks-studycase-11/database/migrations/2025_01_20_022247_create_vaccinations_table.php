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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("dose")->nullable();
            $table->date("date");
            $table->foreignId("society_id")->constrained()->on("societies")->onDelete("no action");
            $table->foreignId("spot_id")->constrained()->on("spots")->onDelete("no action");
            $table->foreignId("vaccine_id")->nullable()->constrained()->on("vaccines")->onDelete("no action");
            $table->foreignId("doctor_id")->nullable()->constrained()->on("users")->onDelete("set null");
            $table->foreignId("officer_id")->nullable()->constrained()->on("users")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};