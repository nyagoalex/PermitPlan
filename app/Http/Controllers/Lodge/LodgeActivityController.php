<?php

namespace App\Http\Controllers\Lodge;

use App\Http\Resources\LodgeActivityResource;
use App\Models\Lodge;
use App\Models\LodgeActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LodgeActivityController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lodge_id)
    {
        $activity = LodgeActivity::whereLodgeId($lodge_id)->get();
        return LodgeActivityResource::collection($activity);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lodge_id)
    {
        #insert new user
        DB::beginTransaction();
        Lodge::findOrFail($lodge_id);
        $data = $this->validateData();
        $data['lodge_id'] = $lodge_id;
        $activity = LodgeActivity::create($data);
        DB::commit();
        return new LodgeActivityResource($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LodgeActivity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show($lodge_id, $id)
    {
        $activity = LodgeActivity::whereLodgeId($lodge_id)->findOrFail($id);
        return new LodgeActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LodgeActivity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update($lodge_id, $id)
    {
        DB::beginTransaction();
        $activity = LodgeActivity::whereLodgeId($lodge_id)->findOrFail($id);
        $data = $this->validateData();
        $activity->update($data);
        DB::commit();
        return new LodgeActivityResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LodgeActivity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy($lodge_id, $id)
    {
        DB::beginTransaction();
        $activity = LodgeActivity::whereLodgeId($lodge_id)->findOrFail($id);
        $activity->delete();
        DB::commit();
        return new LodgeActivityResource($activity);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:3|max:250",
            'cost_per_person' => ['required', 'numeric', 'min:0', 'max:999999999999999999999'],
        ]);
    }
}
