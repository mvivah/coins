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
            RolesTableSeeder::class,
            TitlesTableSeeder::class,
            TeamsTableSeeder::class,
            UsersTableSeeder::class,
            HolidaysTableSeeder::class,
            ServicelinesTableSeeder::class,
            LeavesettingsTableSeeder::class,
            ExpertisesTableSeeder::class,
            DeliverablesTableSeeder::class,
        ]);
    }
}
