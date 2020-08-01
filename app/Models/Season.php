<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use UsesUuid;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name', 'lodge_id', 'from_date', 'to_date'
    ];
}
