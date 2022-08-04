<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Group;
use App\Models\User;

class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::all();

        User::all()->each(function ($user) use ($groups) {
            $user->groups()->attach(
                $groups->random(1)->pluck('id')
            );
        });

    }
}
