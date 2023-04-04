<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

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
            'names' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('vozya2022'),
            'id_rol' => 1,
        ]);
    }
}
