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
        Schema::table('status', function (Blueprint $table) {
            //
        });
        DB::table("status")->insert([
                "nombre" => "Activo1",
            ]);
        DB::table("status")->insert([
            "nombre" => "Pendiente1",
        ]);
        DB::table("status")->insert([
            "nombre" => "Inactivo1",
        ]);
        DB::table("status")->insert([
            "nombre" => "Cancelado1",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status', function (Blueprint $table) {
            //
        });
    }
};
