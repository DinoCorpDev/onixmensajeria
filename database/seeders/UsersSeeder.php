<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([            
            'email' => 'brayantriana22@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'Brayan',
            'last_name' => 'Triana',
            'artistic_name' => 'Brayan',
            'date_birthday' => '1999-11-11',
            'gender' => 'Masculino',
            'height' => '70 Kg',
            'shirt_size' => 'L',
            'pant_size' => 'M',
            'shoes_size' => '41',
            'hair_color' => 'Negro',
            'eyes_color' => 'Cafe',
            'weight' => '51',
            'attitudes' => 'Cantante',
            'technical_professional' => 'Cantante',
            'events_participed' => 'La voz kids',
            'description_professional_short' => 'La voz kids',
            'description_professional_long' => 'La voz kids',
            'phone' => 3007819686,
            'id_number' => 1026307251,
            'address' => 'Carrera 93 B # 128 b 23',
            'city' => 'Bogotá',
            'instagram' => '@brayan_triana',
            'facebook' => 'Brayan Triana',
            'twitter' => 'No tengo',
            'snapchat' => 'No tengo',
            'youtube_url' => 'No_tengo',
            'spotify' => 'no_tengo',
            'deezer' => 'no_tengo',
            'autorization' => true,
            'photographic_register' => 'si',
            'pictures' => 'no',
            'video' => 'videos',
            'state' => 1,
            'terms_conditions' => true,
            'email_verified_at' => '2022-03-08',
        ]);
    }
}
