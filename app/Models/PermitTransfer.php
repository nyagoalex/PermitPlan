<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class PermitTransfer extends Model
{
    use UsesUuid;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'from_booking_id','to_booking_id','permit_id'
   ];

}