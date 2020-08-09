<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'name','national_park', 'tracking_activity'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "national_park","tracking_activity"
    ];
}
