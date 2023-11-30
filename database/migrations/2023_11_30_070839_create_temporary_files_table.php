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
        Schema::create('temporary_file', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('folder');
            $table->text('nama_file');
            $table->string('nama_file_unformatted');
            $table->integer('size');
            $table->string('extension');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_file');
    }
};
