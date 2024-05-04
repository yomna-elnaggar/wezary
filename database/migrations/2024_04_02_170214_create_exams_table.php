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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
          	$table->string('name');
          	$table->integer('grade')->nullable();
          	$table->string('image')->nullable();
          	$table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
          	$table->foreignId('admin_id')->nullable()->references('id')->on('admins')->onDelete('cascade');
          	$table->foreignId('course_id')->nullable()->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
