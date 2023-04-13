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
            $table->string('names');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('provisionalPassword')->default(false);
            $table->string('password');

            $table->unsignedBigInteger('id_rol')->nullable()->default(3);
            $table->foreign('id_rol')->references('id')->on('roles');

            $table->string('dni')->nullable();
            $table->string('doc_responsable')->nullable();
            $table->boolean('is_adult')->default(false);
            $table->boolean('policy_privacy')->default(false);
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
