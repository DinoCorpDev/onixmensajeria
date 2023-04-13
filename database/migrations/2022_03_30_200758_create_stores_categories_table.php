<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stores_id');
            $table->unsignedBigInteger('categories_id');

            $table->foreign('stores_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->foreign('categories_id')->references('id')->on('categories')->cascadeOnDelete();

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
        Schema::dropIfExists('categories_stores');
    }
}
