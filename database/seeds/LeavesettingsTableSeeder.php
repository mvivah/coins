<?php

use Illuminate\Database\Seeder;
use App\Leavesetting;
use App\User;
class LeavesettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::getCreator();
        $leavesettings = [
            ['id' => 1,'leave_type' =>'Annual','annual_lot'=>21,'bookable_days'=>7,'created_by' => $user],
            ['id' => 2,'leave_type' =>'Compassionate','annual_lot'=>5,'bookable_days'=>5,'created_by' => $user],
            ['id' => 3,'leave_type' =>'Maternity','annual_lot'=>90,'bookable_days'=>90,'created_by' => $user,],
            ['id' => 4,'leave_type' =>'Paternity','annual_lot'=>5,'bookable_days'=>5,'created_by' => $user,],
            ['id' => 5,'leave_type' =>'Sick','annual_lot'=>NULL,'bookable_days'=>NULL,'created_by' => $user,],
            ['id' => 6,'leave_type' =>'Study','annual_lot'=>NULL,'bookable_days'=>NULL,'created_by' => $user,],
        ];
        foreach($leavesettings as $leavesetting){
            Leavesetting::create($leavesetting);
        }
    }
}
