<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=[
            ['id'=>1,'staffId'=>'AHC/000/01','name'=>'Administrator','gender'=>'male','email'=>'vmugisha@ahcul.com','password' => bcrypt('m!p@ssW0rd'),'mobilePhone'=>'+256414751506','alternativePhone'=>'+256414751506','team_id'=>1,'role_id'=>3,'reportsTo'=>'Edgart Katarahweire','userStatus'=>'Active','level_id'=>'4','created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10'],
            ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
