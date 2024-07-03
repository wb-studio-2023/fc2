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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('platform_id')->nullable();
            $table->string('site_id')->nullable();
            $table->integer('movie_id')->nullable();
            $table->string('actress_id')->nullable();
            $table->integer('category')->nullable();
            $table->string('tag')->nullable();
            $table->string('title')->nullable();
            $table->string('headline')->nullable();
            $table->text('main')->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->nullable();
            $table->integer('like')->nullable();
            $table->integer('watch')->nullable();
            $table->timestamp('release_at')->nullable();
            $table->integer('delete_flg')->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
