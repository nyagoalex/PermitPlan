<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use UsesUuid;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'booking_id','user_id','amount', 'date'
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
       'created_at' => 'datetime:D, d M Y',
       'updated_at' => 'datetime:D, d M Y',
   ];
}
