<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDayoffUserRequest;
use App\Http\Requests\UpdateDayoffUserRequest;
use App\Models\DayoffUser;

class DayoffUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDayoffUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDayoffUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DayoffUser  $dayoffUser
     * @return \Illuminate\Http\Response
     */
    public function show(DayoffUser $dayoffUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DayoffUser  $dayoffUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DayoffUser $dayoffUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDayoffUserRequest  $request
     * @param  \App\Models\DayoffUser  $dayoffUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDayoffUserRequest $request, DayoffUser $dayoffUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DayoffUser  $dayoffUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DayoffUser $dayoffUser)
    {
        //
    }
}
