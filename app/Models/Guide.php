<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Guide extends Model
{
    use UsesUuid;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'code', 'dob', 'experience_since', 'email', "phone", 'contract_basis', 'status', 'cost_per_day', 'parks_experience', 'vehicle_types_experience'
    ];

    public function getFullNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }

        /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setParksExperienceAttribute($value)
    {
        $this->attributes['parks_experience'] = !is_null($value) ? json_encode($value) : $value;
    }
        /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setVehicleTypesExperienceAttribute($value)
    {
        $this->attributes['vehicle_types_experience'] = !is_null($value) ? json_encode($value) : $value;
    }
   
           /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function getVehicleTypesExperienceAttribute($value)
    {
        return !is_null($value) ? json_decode($value) : [];
    }

           /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function getParksExperienceAttribute($value)
    {
        return !is_null($value) ? json_decode($value) : [];
    }
}
