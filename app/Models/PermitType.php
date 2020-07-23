<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermitType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'east_african_cost', 'foreign_resident_cost', 'non_resident_cost', 'ugandan_cost'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:D, d M Y',
        'updated_at' => 'datetime:D, d M Y',
    ];
}
