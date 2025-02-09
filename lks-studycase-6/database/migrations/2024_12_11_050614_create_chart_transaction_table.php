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
        Schema::create('chart_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId("transaction_id")->constrained()->on("transactions")->onDelete("cascade");
            $table->foreignId("chart_id")->constrained()->on("charts")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_transaction');
    }
};
