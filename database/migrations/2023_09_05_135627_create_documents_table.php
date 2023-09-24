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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('document_type_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('code')->unique();
            $table->string('identity');
            $table->string('name');
            $table->text('comment')->nullable();
            $table->string('storage')->nullable();
            $table->string('storage_old')->nullable();
            $table->date('date_document');
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            $table->unsignedBigInteger('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
