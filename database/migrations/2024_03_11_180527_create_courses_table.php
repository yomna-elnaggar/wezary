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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'unactive'])->default('unactive');  
            $table->foreignId('academic_level_id')->nullable()->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreignId('stage_level_id')->nullable()->references('id')->on('stage_levels')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->references('id')->on('departments')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->references('id')->on('admins')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
