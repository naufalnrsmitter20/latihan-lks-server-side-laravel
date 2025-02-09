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
        Schema::create('log_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("bahan_id")->constrained()->on("bahans")->onDelete("cascade");
            $table->integer("qty");
            $table->dateTime("usage_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_usages');
    }
};
