<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class SeasonalRoomCost extends Model
{
    use UsesUuid;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'amount', 'season_id', 'room_id'
    ];
}
