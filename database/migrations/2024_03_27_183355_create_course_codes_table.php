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
        Schema::create('course_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->references('id')->on('courses')->onDelete('cascade');
            $table->string('name');
            $table->integer('availability')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_codes');
    }
};
