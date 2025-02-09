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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("slug")->unique();
            $table->string("title");
            $table->string("body");
            $table->timestamps();
            $table->foreignId("author_id")->constrained(
                table: "users", indexName: "post_author_id",
            )->onDelete("set null");
            $table->foreignId("category_id")->constrained(
                table: "posts", indexName: "post_category_id"
            )->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};