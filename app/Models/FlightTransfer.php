<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class FlightTransfer extends Model
{
    use UsesUuid;

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'starting_point', 'destination', 'airline_operator', 'cost_per_person', 'distance', 'est_time', 'departure_time', 'arrival_time', 'flight_type'
    ];

    public function getEstTimeAttribute($value)
    {
        return substr($value,0,-3); // remove micro second from time
    }

    public function getArrivalTimeAttribute($value)
    {
        return substr($value,0,-3); // remove micro second from time
    }

    public function getDepartureTimeAttribute($value)
    {
        return substr($value,0,-3); // remove micro second from time
    }
}
