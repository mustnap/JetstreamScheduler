<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendarUserRequest;
use App\Http\Requests\UpdateCalendarUserRequest;
use App\Models\CalendarUser;

use App\Models\User;
use App\Models\DayoffUser;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarUserController extends Controller
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

        return redirect(route('calendar.ym', [$now->year, $now->month]));
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
     * @param  \App\Http\Requests\StoreCalendarUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalendarUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarUser  $calendarUser
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarUser $calendarUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarUser  $calendarUser
     * @return \Illuminate\Http\Response
     */
    public function edit($year, $month)
    {
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
            'calendar.edit',
            [
                'calendarusers' => User::paginate(10),
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
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalendarUserRequest  $request
     * @param  \App\Models\CalendarUser  $calendarUser
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateCalendarUserRequest $request, CalendarUser $calendarUser)
    public function update(Request $request, $year, $month)
    {
        //
        // dd("calendar.update");
        $employees = DB::table('dayoff_users')
            ->whereMonth('date_booked', $month)
            ->whereYear('date_booked', $year)
            ->get();

        $empDayoff = $request->dayoff;

        foreach ($empDayoff as $userId => $empDates) {

            //delete existing entry for the month, before re-inserting
            DayoffUser::where('user_id', $userId)->whereMonth('date_booked', $month)->delete();
            foreach ($empDates['date_booked'] as $dateKey => $dateValue) {
                $newDayOff = DayoffUser::create([
                    'user_id' => $userId,
                    'date_booked' => $dateValue
                ]);
            }
        }

        return redirect()->route('calendar.ym', [$year, $month]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarUser  $calendarUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarUser $calendarUser)
    {
        //
    }
}
