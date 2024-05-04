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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('academic_level_id')->nullable()->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreignId('stage_level_id')->nullable()->references('id')->on('stage_levels')->onDelete('cascade');
            // $table->foreignId('admin_id')->nullable()->references('id')->on('admins')->onDelete('cascade');
            $table->string('icon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
