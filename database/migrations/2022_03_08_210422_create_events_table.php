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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('idItalentt');
            $table->string('name');
            $table->string('banner');
            $table->string('typePersonal');
            $table->date('initialDate');
            $table->date('endDate');
            $table->json('hourly');
            $table->string('city');
            $table->json('location');
            $table->string('address');
            $table->bigInteger('totalBudget');
            $table->bigInteger('dailyBudget');
            $table->string('status')->default('open');
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
        Schema::dropIfExists('events');
    }
};
