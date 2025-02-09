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
        Schema::create('prakerins', function (Blueprint $table) {
            $table->id();
            $table->enum("status", ["DITERIMA" => "DITERIMA", "MENUNGGU" => "MENUNGGU", "DITOLAK" => "DITOLAK"]);
            $table->foreignId("prakerin_period_id")->constrained()->references("id")->on("prakerin_periods")->onDelete("no action");
            $table->foreignId("user_id")->constrained()->on("users")->onDelete("no action");
            $table->foreignId("industry_id")->constrained()->on("industries")->onDelete("no action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakerins');
    }
};