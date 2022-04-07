<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string("name");
            $table->string("lastname");
            $table->string("contact");
            $table->string("email")->unique();
            $table->string("password");     
            $table->string("nickname")->nullable();
            $table->date("birthday")->nullable();
            $table->string("gender")->nullable();
            $table->string("sectors")->nullable();
            $table->string("pyshical")->nullable();
            $table->string("competences")->nullable();
            $table->string("education")->nullable();
            $table->longText("experience")->nullable();
            $table->string("identification")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("profile")->nullable();
            $table->string("photos")->nullable();
            $table->string("video")->nullable();
            $table->boolean("autorization");
            $table->boolean("terms_conditions");
            $table->string("roles")->nullable();
            $table->boolean('provisionalPassword')->default(false);
            $table->boolean('status')->default(true);
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
};
