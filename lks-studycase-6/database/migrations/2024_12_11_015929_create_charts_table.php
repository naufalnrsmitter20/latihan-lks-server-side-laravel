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
        Schema::create('charts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("qty_telur_id")->constrained()->on("qty_telurs")->onDelete("cascade");
            $table->foreignId("qty_kemasan_id")->constrained()->on("qty_kemasans")->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->on("users")->onDelete("cascade");
            $table->float("total_amount");;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charts');
    }
};
