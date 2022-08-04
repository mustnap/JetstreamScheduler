<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DayoffUserSeeder extends Seeder
{

    public function insertForMonth(int $month)
    {
        $users = User::all();

        $todayDate = Carbon::now()->addMonth($month);
        $maxDay = $todayDate->format('t');
        $month = $todayDate->format('m');
        $year = $todayDate->format('Y');
        $randDay = rand(1, $maxDay);
        $randLoop = rand(1, 2);

        foreach ($users as $user) {
            $randDay = rand(1, $maxDay);
            $randLoop = rand(1, 3);
            for ($i = 0; $i < $randLoop; $i++) {
                $randDay = rand(1, $maxDay);
                $dateGenerated = Carbon::createFromDate($year, $month, $randDay);
                DB::table('dayoff_users')->insert([
                    'user_id' => $user->id,
                    'date_booked' =>  $dateGenerated,
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

