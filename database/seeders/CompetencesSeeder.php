<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('competences')->insert([
            'label' => 'Protocolo',
            'value' => 'protocol',
        ]);

        DB::table('competences')->insert([
            'label' => 'Pasarela ropa interior',
            'value' => 'underwear_catwalk',
        ]);

        DB::table('competences')->insert([
            'label' => 'Pasarela ropa exterior',
            'value' => 'outerwear_catwalk',
        ]);

        DB::table('competences')->insert([
            'label' => 'Baile',
            'value' => 'dance',
        ]);

        DB::table('competences')->insert([
            'label' => 'Canto',
            'value' => 'song',
        ]);

        DB::table('competences')->insert([
            'label' => 'Actuación protagónica',
            'value' => 'leading_performance',
        ]);

        DB::table('competences')->insert([
            'label' => 'Actuación figurante',
            'value' => 'figurant_performance',
        ]);

        DB::table('competences')->insert([
            'label' => 'Actuación extra',
            'value' => 'extra_performance',
        ]);

        DB::table('competences')->insert([
            'label' => 'Impulsador(a)',
            'value' => 'impeller',
        ]);

        DB::table('competences')->insert([
            'label' => 'Promotor(a)',
            'value' => 'promoter',
        ]);

        DB::table('competences')->insert([
            'label' => 'Modelo body painting',
            'value' => 'painting_body_model',
        ]);

        DB::table('competences')->insert([
            'label' => 'Modelo de fotografía',
            'value' => 'photography_model',
        ]);

        DB::table('competences')->insert([
            'label' => 'Presentación de eventos',
            'value' => 'presentation_of_events',
        ]);

        DB::table('competences')->insert([
            'label' => 'Presentación de TV',
            'value' => 'presentation_of_tv',
        ]);

        DB::table('competences')->insert([
            'label' => 'Musico',
            'value' => 'musician',
        ]);

        DB::table('competences')->insert([
            'label' => 'Cantante',
            'value' => 'singer',
        ]);

        DB::table('competences')->insert([
            'label' => 'Comediante',
            'value' => 'comedian',
        ]);
    }
}
