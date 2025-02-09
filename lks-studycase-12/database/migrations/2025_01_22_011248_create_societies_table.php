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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("regional_id")->constrained()->on("regionals")->onDelete("no action");
            $table->char("id_card_number");
            $table->string("password");
            $table->string("name");
            $table->date("born_date")->default(now());
            $table->enum("gender", ["male" => "male", "female" => "female"]);
            $table->text("address");
            $table->text("login_tokens")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
};
