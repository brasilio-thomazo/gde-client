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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('identity');
            $table->foreignId('department_id')->constrained();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->bigInteger('email_verified_at')->nullable();
            $table->rememberToken();
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->bigInteger('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
