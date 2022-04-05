<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('personal_types')->insert([
            'label' => 'Hombre',
            'value' => 'man',
        ]);

        DB::table('personal_types')->insert([
            'label' => 'Mujer',
            'value' => 'woman',
        ]);

        DB::table('personal_types')->insert([
            'label' => 'Mixto',
            'value' => 'both',
        ]);
    }
}
