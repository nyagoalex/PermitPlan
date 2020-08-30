<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class DepartureTourPermit extends Model
{
    use UsesUuid;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_tour_id','permit_type_id','sector_id', 'number', 'cost', 'tracking_date', 'rescheduled_from'
    ];

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
    public function allocatedTo()
    {
        return $this->belongsTo(Permit::class, 'allocated_permit_id');
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
    public function getAllocatedAttribute()
    {
        return !is_null($this->allocated_permit_id);
    }
}
