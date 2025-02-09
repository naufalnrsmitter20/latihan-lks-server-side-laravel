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
        Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->enum("role", ["officer" => "officer", "doctor" => "doctor"]);
            $table->string("name");
            $table->foreignId("user_id")->constrained()->on("users")->onDelete("no action");
            $table->foreignId("spot_id")->nullable()->constrained()->on("spots")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};