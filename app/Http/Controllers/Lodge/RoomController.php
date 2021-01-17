<?php

namespace App\Http\Controllers\Lodge;

use App\Http\Resources\RoomResource;
use App\Models\Lodge;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lodge_id)
    {
        $rooms = Room::whereLodgeId($lodge_id)->get();
        return RoomResource::collection($rooms);
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
        $room = Room::create($data);
        DB::commit();
        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($lodge_id, $id)
    {
        $room = Room::whereLodgeId($lodge_id)->findOrFail($id);
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update($lodge_id, $id)
    {
        DB::beginTransaction();
        $room = Room::whereLodgeId($lodge_id)->findOrFail($id);
        $data = $this->validateData();
        $room->update($data);
        DB::commit();
        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($lodge_id, $id)
    {
        DB::beginTransaction();
        $room = Room::whereLodgeId($lodge_id)->findOrFail($id);
        $room->delete();
        DB::commit();
        return new RoomResource($room);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:3|max:250"
        ]);
    }
}
