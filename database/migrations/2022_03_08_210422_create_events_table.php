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
            $table->string('name');
            $table->bigInteger('number');
            $table->string('required_personal');
            $table->string('personal_type');
            $table->string('personla_quantity');
            $table->date('date_initial');
            $table->date('date_final');
            $table->time('hourly');
            $table->string('place');
            $table->string('total_budget');
            $table->string('daily_budget');
            $table->string('qr_code');
            $table->string('state')->default(1);
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
