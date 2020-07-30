<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use UsesUuid;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'code', 'dob', 'experience_since', 'email', "phone", 'contract_basis', 'status', 'cost_per_day', 'parks_experience', 'vehicle_types_expiience'
    ];
}
