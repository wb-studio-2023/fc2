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
        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->integer('article_id')->index();
            $table->integer('site_id');
            $table->string('movie_id');
            $table->string('path');
            $table->timestamps();
            $table->unique(['article_id', 'path']);
            $table->unique(['movie_id', 'site_id', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_images');
    }
};
