<?php

namespace App\Http\Controllers\Lodge;

use App\Http\Resources\RoomResource;
use App\Http\Resources\SeasonalRoomCostResource;
use App\Models\Room;
use App\Models\SeasonalRoomCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonalRoomCostController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($room_id)
    {
        $costs = SeasonalRoomCost::whereRoomId($room_id)->get();
        return SeasonalRoomCostResource::collection($costs);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     #insert new user
    //     DB::beginTransaction();
    //     $data = $this->validateData();
    //     $cost = SeasonalRoomCost::create($data);
    //     DB::commit();
    //     return new SeasonalRoomCostResource($cost);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\SeasonalRoomCost  $cost
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $cost = SeasonalRoomCost::findOrFail($id);
    //     return new SeasonalRoomCostResource($cost);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeasonalRoomCost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update($room_id)
    {
        DB::beginTransaction();
        $room = Room::findOrFail($room_id);
        $costs_array = $this->validateUpdateData();
        // dd($costs_array);
        foreach($costs_array['costs'] as $item) {
            $cost = SeasonalRoomCost::whereRoomId($room_id)->findOrFail($item['id']);
            $cost->amount = $item['amount'];
            $cost->save();
        }
        DB::commit();
        return new RoomResource($room->load('costs'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\SeasonalRoomCost  $cost
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     DB::beginTransaction();
    //     $cost = SeasonalRoomCost::findOrFail($id);
    //     $cost->delete();
    //     DB::commit();
    //     return new SeasonalRoomCostResource($cost);
    // }

    // private function validateData()
    // {
    //     $request = Request();
    //     return $request->validate([
    //         'amount' => ['required', 'numeric', 'min:0', 'max:100000000000000'],
    //         'season_id' => "required|exists:seasons,id",
    //         'room_id' => "required|exists:rooms,id",
    //     ]);
    // }
    private function validateUpdateData()
    {
        $request = Request();
        return $request->validate([
            'costs' => ['required', 'array', 'min:0'],
            'costs.*.id' => ['required', 'string', 'exists:seasonal_room_costs,id', 'distinct'],
            'costs.*.amount' => ['required', 'numeric', 'min:0', 'max:100000000000000']
        ]);
    }
}