<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stores_id');
            $table->unsignedBigInteger('services_id');

            $table->foreign('stores_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->foreign('services_id')->references('id')->on('services')->cascadeOnDelete();
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
        Schema::dropIfExists('services_stores');
    }
}
