<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Group;
use App\Models\Calendar;
use App\Models\DayoffUser;
use App\Services\PriorityQueue;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;


class ScheduleLogic
{
    public function execute(int $monthToSchedule): bool

    {
        $s = new \SplObjectStorage();
        $colGroups = Group::all();

        foreach ($colGroups as $group) {
            $s->attach($group);
        }

        for ($i = 0; $i < $colGroups->count(); $i++) {

            $temp = $colGroups->get($i);
        }

        $group1 = Group::find(1);

        var_dump($s->contains($group1));
        var_dump($s->contains($temp));
        var_dump("temp");
        dd($temp);


        // $o1 = new StdClass;
        // $o2 = new StdClass;
        // $o3 = new StdClass;

        // $s->attach($o1);
        // $s->attach($o2);

        // var_dump($s->contains($o1));
        // var_dump($s->contains($o2));
        // var_dump($s->contains($o3));

        // $s->detach($o2);

        // var_dump($s->contains($o1));
        // var_dump($s->contains($o2));
        // var_dump($s->contains($o3));

        // Create an object of priority queue
        $obj = new PriorityQueue();

        // Insert elements into the queue
        $obj->insert("Geeks", 2);
        $obj->insert("GFG", 1);
        $obj->insert("G4G", 3);
        $obj->insert('G', 4);
        $obj->insert('M', 5);

        $obj->insert('X', 2);


        dd($obj);

        $todayDate = Carbon::now()->addMonth($monthToSchedule);
        $maxDay = $todayDate->format('t');
        $month = $todayDate->format('m');
        $year = $todayDate->format('Y');

        $groups = Group::all();
        $arrGroups = [];

        //create dynamic var for every group
        // for ($j = 1; $j <= $groups->count(); $j++) {
        //     $arrGroups[$j] =  Group::where('id', $j)->first();
        // }

        // foreach ($arrGroups as $key => $group) {
        //     foreach ($group->users as $user) {
        //         echo $user->name;
        //     }
        // }

        // for ($i = 1; $i <= $maxDay; $i++) {
        //     $dateGenerated = Carbon::createFromDate($year, $month, $i);

        //     foreach ($arrGroups as $key => $group) {

        //         $thisGroup = $arrGroups[$key];
        //         $usersFromGroups = $thisGroup->users;

        //         DB::table('schedules')->insert([
        //             'date_scheduled' => $dateGenerated,
        //             'user_id' =>  $usersFromGroups->random(1)->pluck('id')[0],
        //             'for_group_id' => $thisGroup->id,
        //         ]);
        //     }
        // }

        return true;
    }


    public function execute2(int $monthToSchedule): bool

    {
        $s = new \SplObjectStorage();
        $colGroups = Group::all();

        foreach ($colGroups as $group) {
            $s->attach($group);
        }

        for ($i = 0; $i < $colGroups->count(); $i++) {

            $temp = $colGroups->get($i);
        }

        $group4 = Group::find(4);

        var_dump($s->contains($group4));
        var_dump($s->contains($temp));
        var_dump("group4");
        dd($group4);
 
        // Create an object of priority queue
        $obj = new PriorityQueue();

        // Insert elements into the queue
        $obj->insert("Geeks", 2);
        $obj->insert("GFG", 1);
        $obj->insert("G4G", 3);
        $obj->insert('G', 4);
        $obj->insert('M', 5);

        $obj->insert('X', 2);


        dd($obj);

        $todayDate = Carbon::now()->addMonth($monthToSchedule);
        $maxDay = $todayDate->format('t');
        $month = $todayDate->format('m');
        $year = $todayDate->format('Y');

        $groups = Group::all();
        $arrGroups = [];

        //create dynamic var for every group
        // for ($j = 1; $j <= $groups->count(); $j++) {
        //     $arrGroups[$j] =  Group::where('id', $j)->first();
        // }

        // foreach ($arrGroups as $key => $group) {
        //     foreach ($group->users as $user) {
        //         echo $user->name;
        //     }
        // }

        // for ($i = 1; $i <= $maxDay; $i++) {
        //     $dateGenerated = Carbon::createFromDate($year, $month, $i);

        //     foreach ($arrGroups as $key => $group) {

        //         $thisGroup = $arrGroups[$key];
        //         $usersFromGroups = $thisGroup->users;

        //         DB::table('schedules')->insert([
        //             'date_scheduled' => $dateGenerated,
        //             'user_id' =>  $usersFromGroups->random(1)->pluck('id')[0],
        //             'for_group_id' => $thisGroup->id,
        //         ]);
        //     }
        // }

        return true;
    }




    public function execute3(array $userData): bool
    {
        // Create an object of priority queue
        $obj = new PriorityQueue();

        // Insert elements into the queue
        $obj->insert("Geeks", 2);
        $obj->insert("GFG", 1);
        $obj->insert("G4G", 3);
        $obj->insert('G', 4);

        // Display the priority queue elements
        var_dump($obj);

        $uploadedFile = $userData['document'];

        $file = $uploadedFile->store('documents');

        if (!$userData['filename']) {
            $originalFilename = basename($uploadedFile->getClientOriginalName(), '.' . $uploadedFile->getClientOriginalExtension());
        }

        $class = config('filereader.' . $userData['document']->getMimeType());

        $reader = new $class;


        $document = new Schedule();

        $document->filename = $originalFilename ?? $userData['filename'];
        $document->location = $file;

        $document->body = $reader->getContents($userData['document']);
        $document->user_id = auth()->user()->id;

        $document->save();

        return true;
    }
}
