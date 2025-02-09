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
        Schema::create('prakerin_periods', function (Blueprint $table) {
            $table->id();
            $table->enum("period_status", ["ACTIVE" => "ACTIVE", "INACTIVE" => "INACTIVE"]);
            $table->foreignId("year_period_id")->constrained()->references("id")->on("year_periods")->onDelete("no action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakerin_periods');
    }
};