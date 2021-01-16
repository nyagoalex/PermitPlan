<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeasonResource;
use App\Models\Lodge;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lodge_id)
    {
        $seasons = Season::whereLodgeId($lodge_id)->get();
        return SeasonResource::collection($seasons);
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
        $season = Season::create($data);
        DB::commit();
        return new SeasonResource($season);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show($lodge_id, $id)
    {
        $season = Season::whereLodgeId($lodge_id)->findOrFail($id);
        return new SeasonResource($season);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update($lodge_id, $id)
    {
        DB::beginTransaction();
        $season = Season::whereLodgeId($lodge_id)->findOrFail($id);
        $data = $this->validateData();
        $season->update($data);
        DB::commit();
        return new SeasonResource($season);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy($lodge_id, $id)
    {
        DB::beginTransaction();
        $season = Season::whereLodgeId($lodge_id)->findOrFail($id);
        $season->delete();
        DB::commit();
        return new SeasonResource($season);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:3|max:250",
            'from_date' => "required|date_format:Y-m-d",
            'to_date' => "required|date_format:Y-m-d",
        ]);
    }
}