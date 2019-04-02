<?php

use Illuminate\Database\Seeder;
use App\Holiday;
use App\User;
class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::getCreator();
        $holidays = [
            ['id' => 1, 'created_by' => $user,'holiday' => 'New Years Day', 'holiday_date' => date('2019-01-01')],
            ['id' => 2, 'created_by' => $user,'holiday' => 'NRM Liberation day', 'holiday_date' => date('2019-01-26')],
            ['id' => 3, 'created_by' => $user,'holiday' => 'Janan Luwum Day', 'holiday_date' => date('2019-02-16')],
            ['id' => 4, 'created_by' => $user,'holiday' => 'International Womens Day', 'holiday_date' => date('2019-03-8')],
            ['id' => 5, 'created_by' => $user,'holiday' => 'Good Friday', 'holiday_date' => date('2019-03-30')],
            ['id' => 6, 'created_by' => $user,'holiday' => 'Easter Monday', 'holiday_date' => date('2019-04-02')],
            ['id' => 7, 'created_by' => $user,'holiday' => 'International labour Day', 'holiday_date' => date('2019-05-03')],
            ['id' => 8, 'created_by' => $user,'holiday' => 'Martyrs Day', 'holiday_date' => date('2019-06-03')],
            ['id' => 9, 'created_by' => $user,'holiday' => 'Heroes Day', 'holiday_date' => date('2019-06-9')],
            ['id' => 10, 'created_by' => $user,'holiday' => 'Independence Day', 'holiday_date' => date('2019-10-9')],
            ['id' => 11, 'created_by' => $user,'holiday' => 'Christmas Day', 'holiday_date' => date('2019-12-25')],
            ['id' => 12, 'created_by' => $user,'holiday' => 'Boxing Day', 'holiday_date' => date('2019-12-26')],
        ];
        foreach($holidays as $holiday){
            Holiday::create($holiday);
        }
    }
}
