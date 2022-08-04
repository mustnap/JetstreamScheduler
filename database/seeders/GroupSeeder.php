<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'descr' => 'First',
           'long_descr' => 'First'
        ]);
        DB::table('groups')->insert([
            'descr' => 'Second',
           'long_descr' => 'Second'
        ]);
        DB::table('groups')->insert([
            'descr' => 'Third',
            'long_descr' => 'Third'
        ]);
        DB::table('groups')->insert([
            'descr' => 'Fourth',
           'long_descr' => 'Fourth'
        ]);
    }
}
