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
            ['id'=>1,'staffId'=>'AHC/574/18','name'=>'Vivacious Admin','gender'=>'male','email'=>'vmugisha@ahcul.com','password' => bcrypt('m!p@ssW0rd'),'mobilePhone'=>'+256414751506','alternativePhone'=>'+256414751506','team_id'=>1,'level_id'=>1,'reportsTo'=>'Edgart Katarahweire','userStatus'=>'Active','title_id'=>'3','created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10'],
            ['id'=>2,'staffId'=>'AHC/574/19','name'=>'Vivacious Tester','gender'=>'male','email'=>'info@ahcul.com','password' => bcrypt('m!p@ssW0rd'),'mobilePhone'=>'+256414751506','alternativePhone'=>'+256414751506','team_id'=>1,'level_id'=>3,'reportsTo'=>'Edgart Katarahweire','userStatus'=>'Active','title_id'=>'1','created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10'],
            ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
