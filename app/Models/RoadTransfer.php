<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class RoadTransfer extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'name','destination', 'starting_point', 'vehicle.type'
    ];

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'starting_point', 'destination', 'vehicle_id', 'cost_per_person', 'est_time', 'distance'
    ];

    public function vehicle() 
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getEstTimeAttribute($value)
    {
        return substr($value,0,-3); // remove micro second from time
    }
}
