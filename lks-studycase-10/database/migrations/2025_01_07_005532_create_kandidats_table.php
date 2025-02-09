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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->id();
            $table->string("nama_kandidat");
            $table->integer("no_urut");
            $table->string("image");
            $table->enum("role", ["PRESIDEN" => "PRESIDEN", "WAPRES" => "WAPRES", "DPR" => "DPR", "DPD" => "DPD"]);
            $table->foreignId("partai_id")->nullable()->constrained()->on("partais")->onDelete("set null");
            $table->foreignId("vote_id")->nullable()->constrained()->on("votes")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
