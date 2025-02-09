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
        Schema::create('validators', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->on("users")->onDelete("cascade");
            $table->enum("role", ["officer" => "officer", "validator" => "validator"]);
            $table->string("name");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validators');
    }
};
