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
            'label' => 'Cantante',
            'value' => 'singer',
        ]);

        DB::table('roles')->insert([
            'label' => 'Modelo',
            'value' => 'model'
        ]);

        DB::table('roles')->insert([
            'label' => 'Presentador',
            'value' => 'host'
        ]);

        DB::table('roles')->insert([
            'label' => 'Actor',
            'value' => 'actor'
        ]);
    }
}
