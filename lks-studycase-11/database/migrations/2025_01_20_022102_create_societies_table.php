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
            $table->string("id_card_number")->unique()->default(uuid_create());
            $table->string("password");
            $table->string("name");
            $table->date("born_date");
            $table->enum("gender", ["male" => "male", "female" => "female"]);
            $table->text("address");
            $table->text("login_tokens")->nullable();
            $table->foreignId("regional_id")->nullable()->constrained()->on("regionals")->onDelete("set null");
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