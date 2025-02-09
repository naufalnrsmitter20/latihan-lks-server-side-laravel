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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->on("users")->onDelete("cascade");
            $table->foreignId("kota_id")->nullable()->constrained()->on("kotas")->onDelete("set null");
            $table->foreignId("provinsi_id")->nullable()->constrained()->on("provinsis")->onDelete("set null");
            $table->integer("age");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
