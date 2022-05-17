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
            $table->string("name",255);
            $table->string("lastname",255);
            $table->string("contact",255);
            $table->string("email",255)->unique();
            $table->string("password",255);     
            $table->string("nickname",255)->nullable();
            $table->date("birthday")->nullable();
            $table->string("gender",255)->nullable();
            $table->string("sectors",255)->nullable();
            $table->string("pyshical",255)->nullable();
            $table->string("competences",255)->nullable();
            $table->string("education",255)->nullable();
            $table->longText("experience")->nullable();
            $table->string("identification",255)->nullable();
            $table->string("address",255)->nullable();
            $table->string("city",255)->nullable();
            $table->string("profile",255)->nullable();
            $table->string("photos",255)->nullable();
            $table->string("video",255)->nullable();
            $table->boolean("autorization");
            $table->boolean("terms_conditions");
            $table->string("roles",255)->nullable();
            $table->boolean('provisionalPassword')->default(false);
            $table->boolean('firstLogin')->default(true);
            $table->boolean('verified')->default(true);
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
