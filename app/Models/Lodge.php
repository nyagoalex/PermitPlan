<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Lodge extends Model
{
    use UsesUuid;

          /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'star_rating', 'contracted_rating', 'email', "phone", 'address', 'country', 'location', 'code'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'star_rating' => 'float',
        'contracted_rating' => 'float',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function activities()
    {
        return $this->hasMany(LodgeActivity::class)->orderBy('name');
    }

    public function facilities()
    {
        return $this->hasMany(LodgeFacility::class)->orderBy('name');
    }
    public function roomCosts()
    {
        return $this->hasManyThrough(SeasonalRoomCost::class, Room::class);
    }
}
