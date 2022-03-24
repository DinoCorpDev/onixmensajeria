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
            $table->string("nickname");
            $table->date("birthday");
            $table->string("gender");
            $table->string("aptitud");
            $table->string("sectors");
            $table->string("pyshical");
            $table->string("competences");
            $table->string("education");
            $table->string("experience");
            $table->string("identification");
            $table->string("address");
            $table->string("city");
            $table->string("profile");
            $table->string("photos");
            $table->string("video");
            $table->boolean("autorization");
            $table->boolean("terms_conditions");
            $table->string("rol");
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
