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
        Schema::create('job_apply_positions', function (Blueprint $table) {
            $table->id();
            $table->date("date")->default(now());
            $table->foreignId("society_id")->constrained()->on("societies")->onDelete("cascade");
            $table->foreignId("job_vacancy_id")->constrained()->on("job_vacancies")->onDelete("cascade");
            $table->foreignId("available_position_id")->constrained()->on("available_positions")->onDelete("cascade");
            $table->foreignId("job_apply_society_id")->constrained()->on("job_apply_societies")->onDelete("cascade");
            $table->enum("status", ["accepted" => "accepted", "declined" => "declined", "pending" => "pending"])->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_apply_positions');
    }
};
