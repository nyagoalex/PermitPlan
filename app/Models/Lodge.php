<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Lodge extends Model
{
    use UsesUuid;

          /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'star_rating', 'contracted_rating', 'email', "phone", 'address', 'country', 'location', 'code'
    ];

}
