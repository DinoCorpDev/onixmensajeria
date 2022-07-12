<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install --force');
        $this->call([
            RolesSeeder::class,
            CompetencesSeeder::class,
            SectorsSeeder::class,
            PersonalTypeSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
