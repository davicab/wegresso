<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('curso_id')->nullable();
            $table->string('password')->nullable();
            $table->integer('type')->nullable();
            $table->integer('permite_dados')->nullable();
            $table->integer('is_employed')->nullable();
            $table->integer('ano_ingresso')->nullable();
            $table->integer('ano_egresso')->nullable();
            $table->string('atual_emprego')->nullable();
            $table->string('experiencias')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('reset_password_token_expires_at')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
