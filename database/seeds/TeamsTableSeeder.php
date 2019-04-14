<?php

use Illuminate\Database\Seeder;
use App\Team;
class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['id' => 1, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Business Solutions & Engineering Division', 'team_code' => 'BDS'],
            ['id' => 2, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Corporate Support Services', 'team_code' => 'CSS'],
            ['id' => 3, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Corporate Finance Services', 'team_code' => 'CFS'],
            ['id' => 4, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Development Consulting Services', 'team_code' => 'DCS'],
            ['id' => 5, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Management Consulting Services', 'team_code' => 'MCS'],
            ['id' => 6, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Human Capital Management', 'team_code' => 'HCM'],
            ['id' => 7, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Hanningtone Training Academy', 'team_code' => 'HTA'],
        ];
        foreach($teams as $team){
            Team::create($team);
        }
    }
}
