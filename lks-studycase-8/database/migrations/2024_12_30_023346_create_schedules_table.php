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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum("type", ["BUS" => "BUS", "TRAIN" => "TRAIN"]);
            $table->string("line");
            $table->foreignId("from_place_id")->constrained(
                table: "places"
            )->onDelete("cascade");
            $table->foreignId("to_place_id")->constrained(
                table: "places"
            )->onDelete("cascade");
            $table->integer("travel_time");
            $table->dateTime("departure_time");
            $table->dateTime("arrival_time");
            $table->integer("distance");
            $table->integer("speed");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
