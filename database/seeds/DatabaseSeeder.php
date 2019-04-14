<?php

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
        $this->call([
            LevelsTableSeeder::class,
            TeamsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            HolidaysTableSeeder::class,
            ServicelinesTableSeeder::class,
            LeavesettingsTableSeeder::class,
            ExpertisesTableSeeder::class,
            DeliverablesTableSeeder::class,
        ]);
    }
}
