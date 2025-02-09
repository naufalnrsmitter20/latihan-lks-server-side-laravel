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
        Schema::create('votetypes', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ["PILPRES" => "PILPRES", "PILWANTAI" => "PILWANTAI", "PILKADA" => "PILKADA"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votetypes');
    }
};
