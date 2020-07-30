<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class RoadTransfer extends Model
{
    use UsesUuid;

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'starting_point', 'destination', 'vehicle_id', 'cost_per_person', 'est_time'
    ];
}
