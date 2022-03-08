<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
            'id_rol' => 1,
            'id_user' => 1
        ]);

        DB::table('users_roles')->insert([
            'id_rol' => 2,
            'id_user' => 1
        ]);
    }
}
