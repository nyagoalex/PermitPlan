<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use UsesUuid;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reg_no', 'color', 'no_of_seats', 'type', 'status', 'ownership', 'cost_per_day', 'code'
    ]; 
}
