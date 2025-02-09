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
        Schema::create('schedule_route', function (Blueprint $table) {
            $table->id();
            $table->foreignId("schedule_id")->constrained(
                table: "schedules"
            )->onDelete("cascade");
            $table->foreignId("route_id")->constrained(
                table: "routes"
            )->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_route');
    }
};
