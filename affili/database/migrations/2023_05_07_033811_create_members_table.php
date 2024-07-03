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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('name');
            $table->string('like')->nullable();
            $table->string('watch')->nullable();
            $table->integer('menu_lunch_weekday')->default(0);
            $table->integer('menu_lunch_club')->default(0);
            $table->integer('menu_dinner')->default(0);
            $table->integer('status')->default(0);
            $table->integer('delete_flg')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
