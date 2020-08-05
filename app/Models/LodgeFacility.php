<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class LodgeFacility extends Model
{
    use UsesUuid;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name', 'lodge_id', 'cost_per_person'
    ];
}
