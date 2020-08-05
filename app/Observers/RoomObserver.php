<?php

namespace App\Observers;

use App\Models\Room;
use App\Models\Season;
use App\Models\SeasonalRoomCost;

class RoomObserver
{
    /**
     * Handle the room "created" event.
     *
     * @param  \App\Room  $room
     * @return void
     */
    public function created(Room $room)
    {
        $seasons = Season::all('id');
        foreach ($seasons as $season) {
            SeasonalRoomCost::create([
                'amount' => 0, 
                'season_id' => $season->id, 
                'room_id' => $room->id
            ]);
        }
    }
}
