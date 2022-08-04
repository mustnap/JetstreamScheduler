<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class UserScheduleController extends Controller
{

    public function getMaxDay($year, $month)
    {
        $date = Carbon::createFromDate($year, $month, 1);
        $maxDay = $date->format('t');
        return $maxDay;
    }

    function getWeekday($date)
    {
        return date('w', strtotime($date));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = Carbon::now();

        $month = $now->month;
        $year = $now->year;

        $prevDate = Carbon::create($year, $month)->subMonth();
        $nextDate = Carbon::create($year, $month)->addMonth();

        $carbonYearMonth = Carbon::create($year, $month);
        $monthName = $carbonYearMonth->translatedFormat('F');

        $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->endOfMonth();


        $dateRange = CarbonPeriod::create($startDate, $endDate);
        $dateRangeArr = $dateRange->toArray();

        $schedules = Schedule::whereBetween('date_scheduled', [$startDate, $endDate])->orderBy('date_scheduled', 'ASC')->orderBy('for_group_id', 'ASC')->get();

        //generate key pair for each date for Blade to loop
        $schedulesArr = array();

        foreach ($dateRange as $onedate) {
            // dd($onedate);
            $a = array();
            foreach ($schedules as $sched) {

                if (strtotime($sched->date_scheduled) > strtotime($onedate->toDateString())) {
                    break;    /* You could also write 'break 1;' here. */
                } else if (strtotime($sched->date_scheduled) == strtotime($onedate->toDateString())) {
                    array_push($a, $sched);
                }
            }
            $schedulesArr[$onedate->toDateString()] = $a;
        }


        $carbonYearMonth = Carbon::create($year, $month);
        $monthName = $carbonYearMonth->translatedFormat('F');

        $prevDate = Carbon::create($year, $month)->subMonth();
        $nextDate = Carbon::create($year, $month)->addMonth();

        //        get the following by passing function parameter
        $columnNum = $this->getMaxDay($year, $month);

        //        generate the period of that month
        $period = CarbonPeriod::create($year . '-' . $month . '-' . '01', $year . '-' . $month . '-' . $columnNum);

        // Iterate over the period
        //        foreach ($period as &$date) {
        //            $date = $date->format('Y-m-d');
        //        }

        // Convert the period to an array of dates, along with the array of Day for the date
        $dates = $period->toArray();
        $daysNameArr = array('S', 'M', 'T', 'W', 'Th', 'F', 'S'); //this is the days per week, Sunday is Day 0, Saturday is Day 6
        $daysNamePerMonth = array(); //empty array

        for ($i = 0; $i < sizeof($dates); $i++) {
            $temp = $dates[$i];
            $dates[$i] = $temp->toDateString();

            //            populate the dayname array corresponding to the array of dates
            array_push($daysNamePerMonth, $daysNameArr[$this->getWeekday($dates[$i])]);
        }


        return view(
            'userschedule.index',
            [

                'calendarusers' => User::paginate(20),
                'colNum' => $columnNum,
                'dates' => $dates,
                'month' => $month,
                'monthName' => $monthName,
                'year' => $year,
                'nextyear' => $nextDate->year,
                'nextmonth' => $nextDate->month,
                'prevyear' => $prevDate->year,
                'prevmonth' => $prevDate->month,
                'daysNamePerMonth' => $daysNamePerMonth,
                'schedules' => $schedules,
                'schedulesArr' => $schedulesArr,
                'dateRange' => $dateRange,
                'grouplist' => Group::all(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($year, $month)
    {

        $prevDate = Carbon::create($year, $month)->subMonth();
        $nextDate = Carbon::create($year, $month)->addMonth();

        $carbonYearMonth = Carbon::create($year, $month);
        $monthName = $carbonYearMonth->translatedFormat('F');

        $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->endOfMonth();

        $dateRange = CarbonPeriod::create($startDate, $endDate);

        $schedules = Schedule::whereBetween('date_scheduled', [$startDate, $endDate])->orderBy('date_scheduled', 'ASC')->orderBy('for_group_id', 'ASC')->get();

        //generate key pair for each date for Blade to loop
        $schedulesArr = array();

        foreach ($dateRange as $onedate) {
            $a = array();
            foreach ($schedules as $sched) {

                if (strtotime($sched->date_scheduled) > strtotime($onedate->toDateString())) {
                    break;    /* You could also write 'break 1;' here. */
                } else if (strtotime($sched->date_scheduled) == strtotime($onedate->toDateString())) {
                    array_push($a, $sched);
                }
            }
            $schedulesArr[$onedate->toDateString()] = $a;
        }

        return view(
            'userschedule.index',
            [
                'schedules' => $schedules,
                'schedulesArr' => $schedulesArr,
                'dateRange' => $dateRange,
                'grouplist' => Group::all(),
                'month' => $month,
                'monthName' => $monthName,
                'nextyear' => $nextDate->year,
                'nextmonth' => $nextDate->month,
                'prevyear' => $prevDate->year,
                'prevmonth' => $prevDate->month,
                'year' => $year,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
