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
            $table->integer('curso');
            $table->string('password');
            $table->integer('type');
            $table->integer('is_employed');
            $table->integer('ano_ingresso');
            $table->integer('ano_egresso');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('reset_password_token_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
