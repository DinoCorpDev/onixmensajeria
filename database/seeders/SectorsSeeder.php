<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sectors')->insert([
            'label' => 'Televisión',
            'value' => 'TV',
        ]);

        DB::table('sectors')->insert([
            'label' => 'Presentación',
            'value' => 'host',
        ]);

        DB::table('sectors')->insert([
            'label' => 'Modelaje',
            'value' => 'model',
        ]);

        DB::table('sectors')->insert([
            'label' => 'Teatro',
            'value' => 'theater',
        ]);

        DB::table('sectors')->insert([
            'label' => 'Cine',
            'value' => 'cinema',
        ]);

        DB::table('sectors')->insert([
            'label' => 'Música',
            'value' => 'music',
        ]);
    }
}
