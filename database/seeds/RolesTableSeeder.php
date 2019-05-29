<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1,'name' =>'Admin', 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10',],
            ['id' => 2,'name' =>'Director', 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10'],
            ['id' => 3,'name' =>'Consultant', 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10'],
            ['id' => 4,'name' =>'Project Manager', 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10',],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
