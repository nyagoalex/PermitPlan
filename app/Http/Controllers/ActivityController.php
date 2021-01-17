<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort = $this->getSort();
        $per_page = $this->getPerPage();
        $order_column = $this->getOrderColumn("name");
        $query  = Activity::query();
        $query->search(request('search'));
        $activitys = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return ActivityResource::collection($activitys);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $activity = Activity::create($data);
        DB::commit();
        return new ActivityResource($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // select a specific user of given id with the specified branch name and roles
        $activity = Activity::findOrFail($id);
        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, $id)
    {
        DB::beginTransaction();
        $activity = Activity::findOrFail($id);
        $data = $request->validated();
        $activity->update($data);
        DB::commit();
        return new ActivityResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $activity = Activity::findOrFail($id);
        $activity->delete();
        DB::commit();
        return new ActivityResource($activity);
    }
}
