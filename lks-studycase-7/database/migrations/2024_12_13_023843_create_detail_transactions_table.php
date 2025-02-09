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
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("transaction_id")->constrained()->on("transactions")->onDelete("cascade");
            $table->foreignId("roti_id")->constrained()->on("rotis")->onDelete("cascade");
            $table->string("name");
            $table->integer("qty");
            $table->float("price");
            $table->float("subtotal");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
