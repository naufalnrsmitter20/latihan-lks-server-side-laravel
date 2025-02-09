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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kota_id")->nullable()->constrained()->on("kotas")->onDelete("cascade");
            $table->foreignId("provinsi_id")->nullable()->constrained()->on("provinsis")->onDelete("cascade");
            $table->foreignId("votetype_id")->constrained()->on("votetypes")->onDelete("cascade");
            $table->string("tipe_pemilihan");
            $table->enum("status", ["ACTIVE" => "ACTIVE", "NOTACTIVE" => "NOTACTIVE"])->default("NOTACTIVE");
            $table->dateTime("start_date")->default(now());
            $table->dateTime("end_date")->default(now());
            $table->integer("min_age");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
