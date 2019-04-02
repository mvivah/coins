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
            ['id' => 1, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Business Solutions & Engineering Division', 'team_code' => 'BDS','team_leader'=>12],
            ['id' => 2, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Corporate Support Services', 'team_code' => 'CSS','team_leader'=>6],
            ['id' => 3, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Corporate Finance Services', 'team_code' => 'CFS','team_leader'=>6],
            ['id' => 4, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Development Consulting Services', 'team_code' => 'DCS','team_leader'=>36],
            ['id' => 5, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Management Consulting Services', 'team_code' => 'MCS','team_leader'=>30],
            ['id' => 6, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Human Capital Management', 'team_code' => 'HCM','team_leader'=>46],
            ['id' => 7, 'created_by' => 'fdf3cda0-13f0-11e9-9a86-ab5a0fb32b10', 'team_name' => 'Hanningtone Training Academy', 'team_code' => 'HTA','team_leader'=>39],
        ];
        foreach($teams as $team){
            Team::create($team);
        }
    }
}
