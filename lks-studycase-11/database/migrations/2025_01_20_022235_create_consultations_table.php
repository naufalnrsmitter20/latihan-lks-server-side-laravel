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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->enum("status", ["accepted" => "accepted", "declined" => "declined", "pending" => "pending"])->default("pending");
            $table->text("disease_history");
            $table->text("current_symptoms");
            $table->text("doctor_notes")->nullable();
            $table->foreignId("society_id")->nullable()->constrained()->on("societies")->onDelete("set null");
            $table->foreignId("doctor_id")->nullable()->constrained()->on("users")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};