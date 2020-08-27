<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use UsesUuid;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id','permit_type_id','sector_id', 'number', 'cost', 'tracking_date', 'rescheduled_from'
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
    public function payments()
    {
        return $this->morphMany(ItemPayment::class, 'paymentable');
    }
}
