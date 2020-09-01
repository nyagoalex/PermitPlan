<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
    /**
     * Get all of the post's comments.
     */
    public function permitType()
    {
        return $this->belongsTo(PermitType::class);
    }
    /**
     * Get all of the post's comments.
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    /**
     * Get all of the post's comments.
     */
    public function Booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function getRescheduledAttribute()
    {
        return !is_null($this->rescheduled_from);
    }
    /**
     * Get all of the post's comments.
     */
    public function getExpiredAttribute()
    {
        return is_null($this->expired_date) ? false : Carbon::parse($this->expired_date)->isPast();
    }
    /**
     * Get all of the post's comments.
     */
    public function getPaidAttribute()
    {
        return round($this->payments->sum('amount'), 2);
    }
    /**
     * Get all of the post's comments.
     */
    public function getBalanceAttribute()
    {
        return round(($this->cost - $this->paid), 2);
    }
    /**
     * Get all of the post's comments.
     */
    public function getPaymentStatusAttribute()
    {
        if ($this->balance <= 0) {
            return 'Cleared';
        }
        if ($this->paid > 0) {
            if($this->expired) {
                return 'Deposit Expired';
            }
            return 'Deposited';
        }
        return 'Tentative';
    }

}
