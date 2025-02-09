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
        Schema::create('qty_kemasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kemasan_id")->constrained()->on("kemasans")->onDelete("cascade");
            $table->float("total_price");
            $table->integer("qty");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qty_kemasans');
    }
};
