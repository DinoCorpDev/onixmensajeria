<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrador'
        ]);

        DB::table('roles')->insert([
            'name' => 'Cantante'
        ]);

        DB::table('roles')->insert([
            'name' => 'Modelo'
        ]);

        DB::table('roles')->insert([
            'name' => 'Presentador'
        ]);

        DB::table('roles')->insert([
            'name' => 'Actor'
        ]);
    }
}
