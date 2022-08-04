<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupUserRequest;
use App\Http\Requests\UpdateGroupUserRequest;
use App\Models\GroupUser;

use App\Models\Group;
use App\Models\User;

class GroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view(
            'groupusers.index',
            [
                'groupusers' => User::all(),
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

        return view(
            'groupusers.edit',
            [
                'groupusers' => User::all(),
                'grouplist' => Group::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupUser  $groupUser
     * @return \Illuminate\Http\Response
     */
    public function show(GroupUser $groupUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupUser  $groupUser
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupUser $groupUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupUserRequest  $request
     * @param  \App\Models\GroupUser  $groupUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupUserRequest $request, GroupUser $groupUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupUser  $groupUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupUser $groupUser)
    {
        //
    }
}
