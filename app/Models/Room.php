<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use UsesUuid;

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lodge_id'
    ];


    public function costs()
    {
        return $this->hasMany(SeasonalRoomCost::class)->with('season:id,name');
    }
}
