<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{

    public function insertForMonth(int $month)
    {

        $todayDate = Carbon::now()->addMonth($month);
        $maxDay = $todayDate->format('t');
        $month = $todayDate->format('m');
        $year = $todayDate->format('Y');

        $groups = Group::all();
        $arrGroups = [];

        //create dynamic var for every group
        for ($j = 1; $j <= $groups->count(); $j++) {
            $arrGroups[$j] =  Group::where('id', $j)->first();
        }

        // foreach ($arrGroups as $key => $group) {
        //     foreach ($group->users as $user) {
        //         echo $user->name;
        //     }
        // }

        for ($i = 1; $i <= $maxDay; $i++) {
            $dateGenerated = Carbon::createFromDate($year, $month, $i);

            foreach ($arrGroups as $key => $group) {

                $thisGroup = $arrGroups[$key];
                $usersFromGroups = $thisGroup->users;

                DB::table('schedules')->insert([
                    'date_scheduled' => $dateGenerated,
                    'user_id' =>  $usersFromGroups->random(1)->pluck('id')[0],
                    'for_group_id' => $thisGroup->id,
                ]);
            }
        }
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertForMonth(0);
        $this->insertForMonth(1);
        $this->insertForMonth(2);
        $this->insertForMonth(-1);
        $this->insertForMonth(-2);
    }
}
