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
            'name' => 'Administrador',
            'lastname' => '1',
            'email' => 'administrador@gmail.com',
            'password' => Hash::make('Talentos@2020!Bogota'),
            'autorization' => true,
            'terms_conditions' => true,
            'contact' => "{'phone':'3144459146'}"
        ]);
    }
}
