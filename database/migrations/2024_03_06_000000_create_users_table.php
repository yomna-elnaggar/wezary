<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('join_date')->nullable();
            $table->string('phone_number')->unique();
            $table->string('country_code')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('pCountry_code')->nullable();
            $table->string('special_code')->nullable(); 
            $table->string('pic_identityF')->nullable();
            $table->string('pic_identityB')->nullable();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('image')->default('upload/User/User.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('verification_code')->nullable(); 
            $table->integer('is_verified')->unsigned()->nullable();
            $table->foreignId('academic_level_id')->nullable()->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreignId('stage_level_id')->nullable()->references('id')->on('stage_levels')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
