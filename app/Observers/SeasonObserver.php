<?php

namespace App\Observers;

use App\Models\Room;
use App\Models\Season;
use App\Models\SeasonalRoomCost;

class SeasonObserver
{
    /**
     * Handle the season "created" event.
     *
     * @param  \App\Season  $season
     * @return void
     */
    public function created(Season $season)
    {
        $rooms = Room::all('id');
        foreach ($rooms as $room) {
            SeasonalRoomCost::create([
                'amount' => 0, 
                'season_id' => $season->id, 
                'room_id' => $room->id
            ]);
        }
    }
}
