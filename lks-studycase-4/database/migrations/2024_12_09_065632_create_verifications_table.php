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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->enum("status", ["DISETUJUI" => "DISETUJUI", "MENUNGGU" => "MENUNGGU", "DITOLAK" => "DITOLAK"]);
            $table->string('nama_kegiatan');
            $table->dateTime("start_at");
            $table->dateTime("end_at");
            $table->foreignId("ruang_id")->constrained()->on("ruangs")->onDelete("no action");
            $table->foreignId("siswa_id")->constrained()->on("users")->onDelete("no action");
            $table->foreignId("admin_id")->nullable()->constrained()->on("users")->onDelete("no action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};