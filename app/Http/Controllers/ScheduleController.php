<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;

use App\Models\Group;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\Actions\DateLogicAction;
use App\Services\ScheduleLogic;

class ScheduleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $dtlgcActions = new DateLogicAction;

        $now = Carbon::now();

        $month = $now->month;
        $year = $now->year;

        $prevDate = Carbon::create($year, $month)->subMonth();
        $nextDate = Carbon::create($year, $month)->addMonth();

        $carbonYearMonth = Carbon::create($year, $month);
        $monthName = $carbonYearMonth->translatedFormat('F');

        // $startDate = Carbon::createFromFormat('Y-m-d', '2022-03-01');
        // $endDate = Carbon::createFromFormat('Y-m-d', '2022-03-31');

        $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->endOfMonth();


        // $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->toDateString();
        // $lastDayofPreviousMonth = Carbon::now()->endOfMonth()->toDateString();
        // dd($endDate);

        $dateRange = CarbonPeriod::create($startDate, $endDate);
        // dd($dateRange->toArray());
        $dateRangeArr = $dateRange->toArray();

        // $startDate = Carbon::createFromFormat('Y-m-d', '2022-03-01')->startOfDay();
        // $endDate = Carbon::createFromFormat('Y-m-d', '2022-03-31')->endOfDay();

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

        return view(
            'schedule.index',
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
            'schedule.index',
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


    public function listall()
    {
        $month = 0;
        $groups = Group::all();
        $arrGroups = [];

        // $groupone = Group::where('id', 1)->first();
        // $groupone = Group::find(1);

        // dd($groupone);
        // dd($groupone->users);

        //create dynamic var for every group
        for ($j = 1; $j <= $groups->count(); $j++) {
            $arrGroups[$j] =  Group::where('id', $j)->first();
        }

        foreach ($arrGroups as $key => $group) {

            // dd($group->users);

            foreach ($group->users as $user) {
                echo $user->name;
            }
        }

        // dd($arrGroups);

        $todayDate = Carbon::now()->addMonth($month);
        $maxDay = $todayDate->format('t');
        $month = $todayDate->format('m');
        $year = $todayDate->format('Y');
    }

    public function generateSchedule(StoreScheduleRequest $request, ScheduleLogic $scheduleLogic)
    {
        // $validated = $request->validate([
        //     'document' => 'required|mimetypes:text/plain,application/pdf'
        // ]);

        // $scheduleLogic->execute($request->toArray());
        $scheduleLogic->execute(3);

        return redirect(route('schedule.index'));
    }


    public function test()
    {
        $scheduleLogic = new ScheduleLogic();
        $scheduleLogic->execute(1);
    }

    public function test2()
    {
        $scheduleLogic = new ScheduleLogic();
        $scheduleLogic->execute2(1);
    }
}
