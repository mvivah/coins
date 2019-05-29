<?php

use Illuminate\Database\Seeder;
use App\Title;
class TitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            ['id' => 1, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Managing Director', 'description' => 'Reporting to the Board of Directors'],
            ['id' => 3, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Group Chief Executive Officer', 'description' => 'Reporting to the Managing Director'],
            ['id' => 4, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Executive Consultant', 'description' => 'Reporting to the Group Chief Executive Officer'],
            ['id' => 5, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Director', 'description' => 'Reporting to the Group Chief Executive Officer'],
            ['id' => 6, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'General Operations Manager', 'description' => 'Reporting to the Groupe Chief Executive Officer'],
            ['id' => 7, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Director of Operations', 'description' => 'Reporting to Groupe Chief Executive Officer'],
            ['id' => 8, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Divisional Director', 'description' => 'Reporting to Director of Operations'],
            ['id' => 9, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Assistant Director', 'description' => 'Reporting to Director'],
            ['id' => 10, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Manager', 'description' => 'Reporting to Assistant Director'],
            ['id' => 11, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Assistant Manager', 'description' => 'Reporting to Manager'],
            ['id' => 12, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Consultant I', 'description' => 'Reporting to Assistant Manager'],
            ['id' => 13, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Consultant II', 'description' => 'Reporting to Consultant I'],
            ['id' => 14, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Consultant III', 'description' => 'Reporting toConsultant II'],
            ['id' => 15, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'name' => 'Intern', 'description' => 'Reporting to Consultant III'],
        ];
        foreach($titles as $title){
            Title::create($title);
        }
    }
}
