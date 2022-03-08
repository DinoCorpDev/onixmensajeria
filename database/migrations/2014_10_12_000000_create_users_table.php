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
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');                        
            $table->string('last_name');
            $table->string('artistic_name');
            $table->date('date_birthday');
            $table->string('gender');
            $table->string('height');
            $table->string('shirt_size');
            $table->string('pant_size');
            $table->string('shoes_size');
            $table->string('hair_color');
            $table->string('eyes_color');
            $table->string('weight');
            $table->string('attitudes');
            $table->string('technical_professional');
            $table->string('events_participed');
            $table->text('description_professional_short');
            $table->longText('description_professional_long');
            $table->bigInteger('phone');
            $table->bigInteger('id_number');
            $table->string('address');
            $table->string('city');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('snapchat');
            $table->string('youtube_url');
            $table->string('spotify');
            $table->string('deezer');
            $table->boolean('autorization')->default(false);
            $table->string('photographic_register');
            $table->string('pictures');
            $table->string('video');
            $table->integer('state')->default(1);
            $table->boolean('terms_conditions')->default(false);
            $table->timestamp('email_verified_at')->nullable();            
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
