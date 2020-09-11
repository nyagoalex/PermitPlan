<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use UsesUuid;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'booking_id','first_name','last_name', 'dob', 'passport', 'nationality'
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

   public function getFullNameAttribute()
    {
        return  ucwords($this->first_name. ' '. $this->last_name);
    }

    /**
     * Get all of the post's comments.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
