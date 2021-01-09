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
       'booking_id','user_id','amount', 'date', 'cheque_no','ref_no','method'
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

   /**
     * Get all of the post's comments.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   /**
     * Get all of the post's comments.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
