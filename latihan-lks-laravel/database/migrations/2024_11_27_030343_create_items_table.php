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
        Schema::create('items', function (Blueprint $table) {
            $status_enum = ["verified" => "verified", "not_verified" => "not_verified"];
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->integer("item_number");
            $table->string("desc");
            $table->enum("status", array_keys($status_enum))->default("not_verified");
            $table->timestamps();
            $table->foreignId("author_id")->constrained(
                table: "users", indexName:"item_author_id"
            );
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};