<?php

use Illuminate\Database\Seeder;
use App\Expertise;
use App\User;
class ExpertisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::getCreator();
        $expertises = [
            ['id' => 1, 'created_by' => $user,'field_name' => 'Education', 'field_description'=> 'Learning Experts'],
            ['id' => 2, 'created_by' => $user,'field_name' => 'Economics', 'field_description'=> 'Economics Experts'],
            ['id' => 3, 'created_by' => $user,'field_name' => 'Public Health', 'field_description'=> 'Health Experts'],
            ['id' => 4, 'created_by' => $user,'field_name' => 'Agriculture', 'field_description'=> 'Farming Experts'],
            ['id' => 5, 'created_by' => $user,'field_name' => 'Statistics', 'field_description'=> 'Statistics Experts'],
            ['id' => 6, 'created_by' => $user,'field_name' => 'Socialogy', 'field_description'=> 'Socialogy Experts'],
            ['id' => 7, 'created_by' => $user,'field_name' => 'Natural Resources', 'field_description'=> 'Natural Resources Experts'],
            ['id' => 8, 'created_by' => $user,'field_name' => 'Trade and Industry', 'field_description'=> 'Trade Experts'],
            ['id' => 9, 'created_by' => $user,'field_name' => 'Gender', 'field_description'=> 'Gender Experts'],
            ['id' => 10, 'created_by' => $user,'field_name' => 'Human Resource Management', 'field_description'=> 'Human Resource Experts'],
            ['id' => 11, 'created_by' => $user,'field_name' => 'Procurement', 'field_description'=> 'Procurement Experts'],
            ['id' => 12, 'created_by' => $user,'field_name' => 'Engineering', 'field_description'=> 'Engineering Experts'],
            ['id' => 13, 'created_by' => $user,'field_name' => 'Information Technology', 'field_description'=> 'Information Technology Experts'],
            ['id' => 14, 'created_by' => $user,'field_name' => 'Monitoring & Evaluation', 'field_description'=> 'Monitoring & Evaluation Experts'],
            ['id' => 15, 'created_by' => $user,'field_name' => 'Public Private Partnerships', 'field_description'=> 'Public Private Partnerships Experts'],
            ['id' => 16, 'created_by' => $user,'field_name' => 'Local Governance', 'field_description'=> 'Local Governance Experts'],
            ['id' => 17, 'created_by' => $user,'field_name' => 'Accounting & Finance', 'field_description'=> 'Accounting & Finance Experts'],
            ['id' => 18, 'created_by' => $user,'field_name' => 'Sales & Marketing', 'field_description'=> 'Sales & Marketing Experts'],
            ['id' => 19, 'created_by' => $user,'field_name' => 'Public Relations', 'field_description'=> 'Public Relations Experts'],
        ];
        foreach($expertises as $expertise){
            Expertise::create($expertise);
        }
    }
}
