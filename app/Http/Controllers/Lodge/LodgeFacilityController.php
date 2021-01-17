<?php

namespace App\Http\Controllers\Lodge;

use App\Http\Resources\LodgeFacilityResource;
use App\Models\Lodge;
use App\Models\LodgeFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LodgeFacilityController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lodge_id)
    {
        $activity = LodgeFacility::whereLodgeId($lodge_id)->get();
        return LodgeFacilityResource::collection($activity);
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
        $activity = LodgeFacility::create($data);
        DB::commit();
        return new LodgeFacilityResource($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LodgeFacility  $activity
     * @return \Illuminate\Http\Response
     */
    public function show($lodge_id, $id)
    {
        $activity = LodgeFacility::whereLodgeId($lodge_id)->findOrFail($id);
        return new LodgeFacilityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LodgeFacility  $activity
     * @return \Illuminate\Http\Response
     */
    public function update($lodge_id, $id)
    {
        DB::beginTransaction();
        $activity = LodgeFacility::whereLodgeId($lodge_id)->findOrFail($id);
        $data = $this->validateData();
        $activity->update($data);
        DB::commit();
        return new LodgeFacilityResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LodgeFacility  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy($lodge_id, $id)
    {
        DB::beginTransaction();
        $activity = LodgeFacility::whereLodgeId($lodge_id)->findOrFail($id);
        $activity->delete();
        DB::commit();
        return new LodgeFacilityResource($activity);
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
