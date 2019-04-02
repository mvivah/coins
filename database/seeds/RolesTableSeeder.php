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
            ['id' => 1, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Managing Director', 'role_description' => 'Reporting to the Board of Directors'],
            ['id' => 3, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Group Chief Executive Officer', 'role_description' => 'Reporting to the Managing Director'],
            ['id' => 4, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Executive Consultant', 'role_description' => 'Reporting to the Group Chief Executive Officer'],
            ['id' => 5, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Director', 'role_description' => 'Reporting to the Group Chief Executive Officer'],
            ['id' => 6, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'General Operations Manager', 'role_description' => 'Reporting to the Groupe Chief Executive Officer'],
            ['id' => 7, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Director of Operations', 'role_description' => 'Reporting to Groupe Chief Executive Officer'],
            ['id' => 8, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Divisional Director', 'role_description' => 'Reporting to Director of Operations'],
            ['id' => 9, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Assistant Director', 'role_description' => 'Reporting to Director'],
            ['id' => 10, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Manager', 'role_description' => 'Reporting to Assistant Director'],
            ['id' => 11, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Assistant Manager', 'role_description' => 'Reporting to Manager'],
            ['id' => 12, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Consultant I', 'role_description' => 'Reporting to Assistant Manager'],
            ['id' => 13, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Consultant II', 'role_description' => 'Reporting to Consultant I'],
            ['id' => 14, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Consultant III', 'role_description' => 'Reporting toConsultant II'],
            ['id' => 15, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'role_name' => 'Intern', 'role_description' => 'Reporting to Consultant III'],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
